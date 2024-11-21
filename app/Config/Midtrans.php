<?php

namespace App\Config;

class MidtransConfig
{
    public static function configure()
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-kfuj6oM444zRYcz-enhAT29t'; // Ganti dengan server key Anda
        \Midtrans\Config::$isProduction = false; // true untuk mode produksi
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }
}
