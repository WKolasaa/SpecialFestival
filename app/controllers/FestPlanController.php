<?php

namespace App\Controllers;

use App\Models\UserTicket;
use App\Services\TicketService;
use App\Services\UserTicketService;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Invoice;
use Stripe\InvoiceItem;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;
use Stripe\StripeClient;

class FestPlanController
{
    private StripeClient $stripe;
    private UserTicketService $userTicketService;
    private TicketService $ticketService;
    private String $serverUrl;
    private int $userId;

    public function __construct()
    {
        $this->userTicketService = new UserTicketService();
        $this->ticketService = new TicketService();
        $this->serverUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        session_start();
        $this->userId = $_SESSION['userId'] ?? 0;
        // TODO: use a .env file
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

        include '../views/festplan.php';
    }

    public function checkoutSuccess(): void
    {
        $items = $this->stripe->checkout->sessions->allLineItems(
            $_GET['session_id'], ['expand' => ['data.price.product']] );

        $tickets = [];

        // Create or retrieve the customer
        $customer = $this->stripe->customers->create([
            'email' => $_SESSION['user']->getEmail()
        ]);

        // Create UserTicket objects and Invoice Items from the Stripe session
        foreach ($items->data as $item) {
            $userTicket = new UserTicket();
            $userTicket->ticket = $this->ticketService->getTicketById($item->price->product->metadata->ticketId);
            $userTicket->quantity = $item->quantity;
            $userTicket->paid = true;

            $tickets[] = $userTicket;

            // Create or retrieve the product
            $product = $this->stripe->products->create([
                'name' => $item->price->product->name,
            ]);

            // Create or retrieve the price
            $price = $this->stripe->prices->create([
                'unit_amount' => $item->price->unit_amount, // Stripe expects amount in cents
                'currency' => 'eur',
                'product' => $product->id,
            ]);

            // Create an Invoice Item
            $this->stripe->invoiceItems->create([
                'customer' => $customer->id,
                'price' => $price->id,
                'quantity' => $item->quantity,
            ]);
        }

        // Mark tickets as paid
        $this->userTicketService->markTicketsAsPaid($this->userId, $tickets);

        // Update ticket availability
        foreach ($tickets as $userTicket) {
            $ticket = $userTicket->ticket;
            $this->ticketService->updateTicketAvailability($ticket->getTicketId(), -$userTicket->quantity);
        }

        // Create an Invoice
        $invoice = $this->stripe->invoices->create([
            'customer' => $customer->id,
            'collection_method' => 'send_invoice',
            'days_until_due' => 30,
            'auto_advance' => true,
        ]);

        $invoice->finalizeInvoice();
        $invoice->sendInvoice();

        header("Location: $this->serverUrl/FestPlan");
    }

    public function checkoutCancel(): void
    {
        header("Location: $this->serverUrl/FestPlan");
    }

    public function checkout(): void
    {
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

        foreach ($userTickets as $userTicket) {
            $ticket = $userTicket->ticket;
            $description = $ticket->getDescription();
            if (empty($description)) {
                $description = "No description available"; // Default description
            }
            $item = [
                "quantity" => $userTicket->quantity,
                "price_data" => [
                    "currency" => "eur",
                    "unit_amount" => $ticket->getPrice() * 100, // Stripe expects amount in cents
                    "product_data" => [
                        "name" => $ticket->getTicketName(),
                        "description" => $description,
                        "metadata" => [
                            "ticketId" => $ticket->getTicketId()
                        ],
                    ],
                ],
            ];
            $line_items[] = $item;
        }

        $checkout_session = $this->stripe->checkout->sessions->create([
            "mode" => "payment",
            "success_url" => "$this->serverUrl/FestPlan/checkoutSuccess?session_id={CHECKOUT_SESSION_ID}",
            "cancel_url" => "$this->serverUrl/FestPlan/checkoutCancel",
            "locale" => "auto",
            "line_items" => $line_items,
        ]);

        header("Location: " . $checkout_session->url);
    }
}