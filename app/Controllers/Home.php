<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-kfuj6oM444zRYcz-enhAT29t';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => time(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => 'zdna',
                'last_name' => 'zz',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $data['token'] = $snapToken;
        return view('home', $data);

    }
}
