<?php

namespace App\Controllers;

class EmployeeController
{
    public function index()
    {
        include __DIR__ . '/../views/employeeView.php';
    }
}