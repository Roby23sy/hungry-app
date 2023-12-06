<?php

namespace App\Http\Controllers;

use App\Models\Foods;
use Illuminate\Http\Request;
use function Psy\debug;

class BurgerHubController extends Controller
{
    public function index(): bool|string
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://burgers-hub.p.rapidapi.com/burgers",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: burgers-hub.p.rapidapi.com",
                "X-RapidAPI-Key: " . env('X_RAPIDAPI_KEY')
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $burgers = json_decode($response, true);

        foreach ($burgers as $burger)
        {
            $food = new Foods;
            $food->name = $burger['name'];
            $food->price = $burger['price'];
            $food->description = $burger['description'];
            $food->vegan = $burger['vegan'];

            if (isset($burger['images'][0]['sm'])) {
                $food->image_path = $burger['images'][0]['sm'];
            } else {
                $food->image_path = '';
            }
            $food->available = 0;
            $food->save();
        }

        return $response;
    }
}
