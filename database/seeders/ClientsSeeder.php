<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = ['client 1', 'client 2', 'client 3'];

        DB::table('clients')->delete();

        foreach ($clients as $client) {
            Client::create([

                'name' => $client,
                'phone' => "002145521",
                'address' => "mansoura"
            ]);
        }
    }
}
