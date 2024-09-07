<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $products_count = Product::count();
        $users_count = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->count();
        $clients_count = Client::count();
        $categories_count = Category::count();
        $orders_count = Order::count();

        $sales_data = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as sum'),
        )->groupBy('month')->get();


        return view('dashboard.index', compact('products_count', 'users_count', 'categories_count', 'clients_count', 'orders_count'));
    }
}
