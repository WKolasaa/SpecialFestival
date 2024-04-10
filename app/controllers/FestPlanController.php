<?php

namespace App\Controllers;

use App\Services\UserTicketService;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class FestPlanController
{
    private UserTicketService $userTicketService;
    private String $serverUrl;

    public function __construct()
    {
        $this->userTicketService = new UserTicketService();
        $this->serverUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        // TODO: use a .env file
        Stripe::setApiKey("sk_test_51P46xi02pSwboFFFHCzZPrJ2AGGq89X0xCx8kXYXIJxbukQ2cRjSGL6KMKtJEk8MjIBMhA7qnS5qnCbnJIwhirUU00mKu76Ybk");
    }

    public function index(): void
    {
        // TODO: Get the actual user id
        $userTickets = $this->userTicketService->getAllUserTicketsByUserId(1, false);
        include '../views/festplan.php';
    }

    public function checkoutSuccess(): void
    {
        // TODO: Get the actual user
        //$user->paymentInProgress = false;

        // Do whatever you want to do after the payment is successful
        $userTickets = $this->userTicketService->getAllUserTicketsByUserId(1, false);

        $this->userTicketService->markTicketsAsPaid(1);

        header("Location: $this->serverUrl/FestPlan");
    }

    public function checkoutCancel(): void
    {
        echo "Checkout cancelled";
    }

    public function checkout(): void
    {
        // TODO: Get the actual user
        //$user->paymentInProgress = true;

        $userTickets = $this->userTicketService->getAllUserTicketsByUserId(1, false);

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
                            "event name" => $ticket->getEventName(),
                            "location" => $ticket->getLocation(),
                            "start date" => $ticket->getStartDate()->format('Y-m-d H:i:s'),
                            "end date" => $ticket->getEndDate()->format('Y-m-d H:i:s'),
                        ],
                    ],
                ],
            ];
            $line_items[] = $item;
        }

        $checkout_session = Session::create([
            "mode" => "payment",
            "success_url" => "$this->serverUrl/FestPlan/checkoutSuccess",
            "cancel_url" => "$this->serverUrl/FestPlan/checkoutCancel",
            "locale" => "auto",
            "line_items" => $line_items,
        ]);

        header("Location: " . $checkout_session->url);
    }
}