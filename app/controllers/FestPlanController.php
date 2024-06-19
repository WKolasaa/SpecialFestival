<?php

namespace App\Controllers;

use App\Models\UserTicket;
use App\Services\EmailService;
use App\Services\OrderService;
use App\Services\TicketService;
use App\Services\UserTicketService;
use Exception;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class FestPlanController
{
    private StripeClient $stripe;
    private UserTicketService $userTicketService;
    private TicketService $ticketService;
    private OrderService $orderService;
    private EmailService $emailService;
    private string $serverUrl;
    private int $userId;

    public function __construct()
    {
        $this->userTicketService = new UserTicketService();
        $this->ticketService = new TicketService();
        $this->orderService = new OrderService();
        $this->emailService = new EmailService();
        $this->serverUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        session_start();
        $this->userId = $_SESSION['userId'] ?? -1;
        $this->stripe = new StripeClient('sk_test_51P46xi02pSwboFFFHCzZPrJ2AGGq89X0xCx8kXYXIJxbukQ2cRjSGL6KMKtJEk8MjIBMhA7qnS5qnCbnJIwhirUU00mKu76Ybk');
    }

    public function index(): void
    {
        $userTickets = 0;
        if (isset($_GET["token"])) {
            $sharedUserId = $this->userTicketService->getUserIdByShareToken($_GET["token"]);
            $userTickets = $this->userTicketService->getAllUserTicketsByUserId($sharedUserId, true);
        } else {
            $userTickets = $this->userTicketService->getAllUserTicketsByUserId($this->userId, false);
        }

        $userId = $this->userId;

        include '../views/festplan.php';
    }

    public function checkoutSuccess(): void
    {
        try {
            $session = $this->stripe->checkout->sessions->retrieve($_GET['session_id'], []);

            $items = $this->stripe->checkout->sessions->allLineItems(
                $session->id, ['expand' => ['data.price.product']]);

            $tickets = [];

            // Create UserTicket objects from the Stripe session
            foreach ($items->data as $item) {
                $userTicket = new UserTicket();
                $userTicket->ticket = $this->ticketService->getTicketById($item->price->product->metadata->ticketId);
                $userTicket->quantity = $item->quantity;
                $userTicket->paid = true;

                $tickets[] = $userTicket;
            }

            // Mark tickets as paid
            $this->userTicketService->markTicketsAsPaid($this->userId, $tickets);

            // Update ticket availability
            foreach ($tickets as $userTicket) {
                $ticket = $userTicket->ticket;
                $this->ticketService->updateTicketAvailability($ticket->getTicketId(), -$userTicket->quantity);
            }

            header("Location: $this->serverUrl/FestPlan");

            sleep(20); // Wait for Stripe to create the invoice (not ideal, but it works for now)

            // Re receive the session to get the invoice URL
            $session = $this->stripe->checkout->sessions->retrieve($session->id, []);
            $invoice_url = $this->stripe->invoices->retrieve($session->invoice)->invoice_pdf;

            // Send invoice and tickets to user
            $this->emailService->sendInvoice($invoice_url);
            $this->emailService->sendTickets();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            echo "Stack trace: " . $e->getTraceAsString();
        }
    }

    public function checkoutCancel(): void
    {
        header("Location: $this->serverUrl/FestPlan");
    }

    /**
     * @throws ApiErrorException
     */
    public function checkout(): void
    {
        try {
            $userTickets = $this->userTicketService->getAllUserTicketsByUserId($this->userId, false);

            // if user has no tickets, redirect to FestPlan
            if (empty($userTickets)) {
                $_SESSION['error'] = "No tickets selected.";
                header("Location: $this->serverUrl/FestPlan");
                return;
            }

            // Check availability of tickets
            foreach ($userTickets as $userTicket) {
                $ticket = $userTicket->ticket;
                if ($ticket->getAvailability() < $userTicket->quantity) {
                    $_SESSION['error'] = "Requested quantity exceeds available tickets.";
                    header("Location: $this->serverUrl/FestPlan");
                    return;
                }
            }

            $line_items = [];

            $tax_rate = $this->stripe->taxRates->create([
                'display_name' => 'VAT',
                'description' => 'VAT Netherlands',
                'percentage' => 9,
                'jurisdiction' => 'NL',
                'country' => 'NL',
                'inclusive' => true,
            ]);

            foreach ($userTickets as $userTicket) {
                $ticket = $userTicket->ticket;
                $description = $ticket->getDescription();
                if (empty($description)) {
                    $description = "No description available"; // Default description
                }
                $unit_amount = $ticket->getPrice() * 100; // Stripe expects amount in cents
                $quantity = $userTicket->quantity;
                $item = [
                    "quantity" => $quantity,
                    "price_data" => [
                        "currency" => "eur",
                        "unit_amount" => $unit_amount,
                        "product_data" => [
                            "name" => $ticket->getTicketName(),
                            "description" => $description,
                            "metadata" => [
                                "ticketId" => $ticket->getTicketId()
                            ],
                        ],
                    ],
                    "tax_rates" => [$tax_rate->id],
                ];
                $line_items[] = $item;
                $totalAmount = $ticket->getPrice() * $quantity;
                $this->orderService->addOrder($ticket->getTicketId(), $totalAmount);
            }

            $user = $_SESSION['user'];

            $customer = $this->stripe->customers->create([
                'name' => $user->getFirstName() . " " . $user->getLastName(),
                'email' => $user->getEmail(),
                'phone' => $user->getPhoneNumber(),
            ]);

            $checkout_session = $this->stripe->checkout->sessions->create([
                "payment_method_types" => ["ideal", "card"],
                "customer" => $customer->id,
                "mode" => "payment",
                "success_url" => "$this->serverUrl/FestPlan/checkoutSuccess?session_id={CHECKOUT_SESSION_ID}",
                "cancel_url" => "$this->serverUrl/FestPlan/checkoutCancel",
                "locale" => "auto",
                "line_items" => $line_items,
                "invoice_creation" => [
                    "enabled" => true,
                ]
            ]);

            header("Location: " . $checkout_session->url);
        } catch (Exception $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: $this->serverUrl/FestPlan");
        }
    }
}