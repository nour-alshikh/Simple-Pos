<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    /**
     * Show the form for creating a new resource.
     */
    public function create(Client $client)
    {
        $categories = Category::with('products')->get();

        $orders = $client->orders()->with('products')->paginate(5);

        return view('dashboard.clients.orders.create', compact("client", 'categories', 'orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Client $client)
    {

        $request->validate([
            'products' => "required|array",
        ]);

        $this->attach_order($request, $client);


        return redirect()->back();
    }


    public function edit(Client $client, Order $order)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);

        return view('dashboard.clients.orders.edit', compact("client", 'categories', 'order', 'orders'));
    }

    public function update(Request $request, Client $client, Order $order)
    {
        $request->validate([
            'products' => "required|array",
        ]);



        $this->detach_order($order);

        $this->attach_order($request, $client);

        $orders = Order::when($request->search, function ($query) use ($request) {

            $query->whereHas('client', function ($que) use ($request) {
                return $que->where("name", "like", "%{$request->search}%");
            });
        })->latest()->paginate(5);

        return view("dashboard.orders.index", compact("orders"));
    }


    private function attach_order($request, $client)
    {
        $order = $client->orders()->create();

        $order->products()->sync($request->products);
        // $order->products()->attach($request->products);

        $total_price = 0;

        foreach ($request->products as $id => $quantity) {

            $product = Product::findOrFail($id);

            $total_price += $product->sell_price * $quantity['quantity'];

            $product->update([
                'stock' => $product->stock - $quantity['quantity']
            ]);
        }

        $order->update([
            'total_price' => $total_price,
        ]);
    }
    private function detach_order($order)
    {

        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }

        $order->delete();
    }
}
