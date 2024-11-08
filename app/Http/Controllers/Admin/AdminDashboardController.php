<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $totalRevenue = Bill::where('status', 4)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total');

        $ordersCount = Bill::where('status', 4)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $productCount = Product::count();
        
        $usersCount = User::where('role', '0')->count();
        
        return view('admin.dashboard', compact('usersCount', 'productCount', 'ordersCount', 'totalRevenue'));
    }
}
