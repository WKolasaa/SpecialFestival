<?php

namespace App\Controllers;

use App\Services\UserTicketService;
use App\Services\OrderService;
use Stripe\Checkout\Session;
use Stripe\Stripe;


class FestPlanController
{
    private UserTicketService $userTicketService;
    private OrderService $orderService;
    private String $serverUrl;
    private int $userId;

    public function __construct()
    {
        $this->userTicketService = new UserTicketService();
        $this->orderService = new OrderService();
        $this->serverUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        // TODO: use a .env file
        Stripe::setApiKey("sk_test_51P46xi02pSwboFFFHCzZPrJ2AGGq89X0xCx8kXYXIJxbukQ2cRjSGL6KMKtJEk8MjIBMhA7qnS5qnCbnJIwhirUU00mKu76Ybk");
        session_start();
        $this->userId=$_SESSION['userId'];
    }

    public function index(): void
    {
       
        $userTickets = $this->userTicketService->getAllUserTicketsByUserId($this->userId, false);
        include '../views/festplan.php';
    }

    public function checkoutSuccess(): void
    {
        $userTickets = $this->userTicketService->getAllUserTicketsByUserId($this->userId, false);

        $this->userTicketService->markTicketsAsPaid($this->userId);

        header("Location: $this->serverUrl/FestPlan");
    }

    public function checkoutCancel(): void
    {
        echo "Checkout cancelled";
    }

    public function checkout(): void
    {
        $userTickets = $this->userTicketService->getAllUserTicketsByUserId($this->userId, false);

        $line_items = [];
        $totalAmount = 0;

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
                            "event name" => $ticket->getEventName(),
                            "location" => $ticket->getLocation(),
                            "start date" => $ticket->getStartDate()->format('Y-m-d H:i:s'),
                            "end date" => $ticket->getEndDate()->format('Y-m-d H:i:s'),
                        ],
                    ],
                ],
            ];
            $line_items[] = $item;
            $totalAmount = $ticket->getPrice() * $quantity;
             $this->orderService->addOrder($ticket->getTicketId(), $totalAmount);

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
