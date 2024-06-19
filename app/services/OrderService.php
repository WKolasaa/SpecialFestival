<?php

namespace App\Services;

use App\Repositories\OrderRepository;


class OrderService
{

    public $orderRepository;

    function __construct()
    {

        $this->orderRepository = new OrderRepository();
    }

    public function getAllOrders()
    {
        $orders = $this->orderRepository->getAllOrders();
        return $orders;
    }

    public function addOrder($ticketId, $totalAmount): void
    {
        $this->orderRepository->addOrder($ticketId, $totalAmount);
    }


}