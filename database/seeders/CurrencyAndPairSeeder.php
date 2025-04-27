<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use App\Models\Pair;
class CurrencyAndPairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $currencies = ['USD', 'EUR', 'GBP', 'JPY', 'CAD', 'AUD'];

    $currencyIds = [];

    foreach ($currencies as $code) {
        $currency = Currency::create(['code' => $code]);
        $currencyIds[$code] = $currency->id;
    }

    $pairs = [
        ['USD', 'EUR', 0.92],
        ['EUR', 'USD', 1.08],
        ['USD', 'GBP', 0.80],
        ['GBP', 'USD', 1.25],
        ['EUR', 'JPY', 130],
        ['JPY', 'EUR', 0.0077],
        ['CAD', 'USD', 0.75],
        ['USD', 'CAD', 1.33],
    ];

    foreach ($pairs as [$from, $to, $rate]) {
        Pair::create([
            'devise_from_id' => $currencyIds[$from],
            'devise_to_id' => $currencyIds[$to],
            'rate' => $rate,
            'conversion_count' => rand(0, 100),
        ]);
    }
}
}
