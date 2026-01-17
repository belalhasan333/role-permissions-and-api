<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $stats = [
            'sales' => [
                'count' => 150,
                'growth' => 12,
                'label' => 'This Month'
            ],
            'revenue' => [
                'amount' => 5000,
                'growth' => 8,
                'label' => 'This Month'
            ],
            'customers' => [
                'count' => 120,
                'growth' => 5,
                'label' => 'This Month'
            ]
        ];


        return view('home', compact('stats'));
    }
}
