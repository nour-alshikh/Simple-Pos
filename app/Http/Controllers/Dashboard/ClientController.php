<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::when($request->search, function ($query) use ($request) {
            $query->where("name", "like", "%{$request->search}%");
        })->latest()->paginate(5);

        return view("dashboard.clients.index", compact("clients"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.clients.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:clients,name',
            'phone' => 'required',
            'phone.0' => 'required',
            'phone.1' => 'nullable',
            'address' => 'required',
        ]);

        Client::create($request->all());


        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('clients.index');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view("dashboard.clients.edit", compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|unique:clients,name,' . $client->id,
            'phone' => 'required',
            'phone.0' => 'required',
            'phone.1' => 'nullable',
            'address' => 'required',
        ]);

        $request_data = $request->all();

        $request_data['phone'] = array_filter($request_data['phone']);


        $client->update($request_data);


        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->back();
    }
}
