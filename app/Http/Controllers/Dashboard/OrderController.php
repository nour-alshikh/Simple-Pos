<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::when($request->search, function ($query) use ($request) {

            $query->whereHas('client', function ($que) use ($request) {
                return $que->where("name", "like", "%{$request->search}%");
            });
        })->latest()->paginate(5);

        return view("dashboard.orders.index", compact("orders"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {

        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }

        $order->delete();
        return redirect()->back();
    }

    public function getProducts(Order $order)
    {

        $products =  $order->products;


        return view('dashboard/orders/partials/_products', compact('order', 'products'));
    }
}
