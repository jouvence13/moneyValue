<?php

namespace Database\Seeders;

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
        // On vide les tables pour éviter les doublons
        Pair::truncate();
        Currency::truncate();

        $currencies = ['USD', 'EUR', 'GBP', 'JPY', 'CAD', 'AUD'];

        // Créer les devises (ou récupérer celles qui existent déjà)
        foreach ($currencies as $code) {
            Currency::firstOrCreate(['code' => $code]);
        }

        // Les paires avec les codes directement (pas les ID)
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
                'devise_from_code' => $from,
                'devise_to_code' => $to,
                'rate' => $rate,
                'conversion_count' => rand(0, 100),
            ]);
        }
    }
}
