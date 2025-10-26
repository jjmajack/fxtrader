<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TradingPair;

class TradingPairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tradingPairs = [
            // Major Forex Pairs (4-5 decimals)
            ['symbol' => 'EUR/USD', 'name' => 'Euro/US Dollar', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MAJOR_FOREX, 'sort_order' => 1, 'decimal_precision' => 4],
            ['symbol' => 'GBP/USD', 'name' => 'British Pound/US Dollar', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MAJOR_FOREX, 'sort_order' => 2, 'decimal_precision' => 4],
            ['symbol' => 'USD/JPY', 'name' => 'US Dollar/Japanese Yen', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MAJOR_FOREX, 'sort_order' => 3, 'decimal_precision' => 3],
            ['symbol' => 'USD/CHF', 'name' => 'US Dollar/Swiss Franc', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MAJOR_FOREX, 'sort_order' => 4, 'decimal_precision' => 4],
            ['symbol' => 'AUD/USD', 'name' => 'Australian Dollar/US Dollar', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MAJOR_FOREX, 'sort_order' => 5, 'decimal_precision' => 4],
            ['symbol' => 'USD/CAD', 'name' => 'US Dollar/Canadian Dollar', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MAJOR_FOREX, 'sort_order' => 6, 'decimal_precision' => 4],
            ['symbol' => 'NZD/USD', 'name' => 'New Zealand Dollar/US Dollar', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MAJOR_FOREX, 'sort_order' => 7, 'decimal_precision' => 4],

            // Minor Forex Pairs (4-5 decimals)
            ['symbol' => 'EUR/GBP', 'name' => 'Euro/British Pound', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MINOR_FOREX, 'sort_order' => 1, 'decimal_precision' => 4],
            ['symbol' => 'EUR/JPY', 'name' => 'Euro/Japanese Yen', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MINOR_FOREX, 'sort_order' => 2, 'decimal_precision' => 3],
            ['symbol' => 'GBP/JPY', 'name' => 'British Pound/Japanese Yen', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MINOR_FOREX, 'sort_order' => 3, 'decimal_precision' => 3],
            ['symbol' => 'EUR/CHF', 'name' => 'Euro/Swiss Franc', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MINOR_FOREX, 'sort_order' => 4, 'decimal_precision' => 4],
            ['symbol' => 'AUD/JPY', 'name' => 'Australian Dollar/Japanese Yen', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MINOR_FOREX, 'sort_order' => 5, 'decimal_precision' => 3],
            ['symbol' => 'GBP/CHF', 'name' => 'British Pound/Swiss Franc', 'category' => TradingPair::CATEGORY_FOREX, 'subcategory' => TradingPair::SUBCATEGORY_MINOR_FOREX, 'sort_order' => 6, 'decimal_precision' => 4],

            // Stock Indices (2 decimals)
            ['symbol' => 'US30', 'name' => 'US30 (Dow Jones)', 'category' => TradingPair::CATEGORY_STOCK_INDICES, 'subcategory' => null, 'sort_order' => 1, 'decimal_precision' => 2],
            ['symbol' => 'NAS100', 'name' => 'NAS100 (Nasdaq 100)', 'category' => TradingPair::CATEGORY_STOCK_INDICES, 'subcategory' => null, 'sort_order' => 2, 'decimal_precision' => 2],
            ['symbol' => 'SPX500', 'name' => 'SPX500 (S&P 500)', 'category' => TradingPair::CATEGORY_STOCK_INDICES, 'subcategory' => null, 'sort_order' => 3, 'decimal_precision' => 2],
            ['symbol' => 'UK100', 'name' => 'UK100 (FTSE 100)', 'category' => TradingPair::CATEGORY_STOCK_INDICES, 'subcategory' => null, 'sort_order' => 4, 'decimal_precision' => 2],
            ['symbol' => 'GER30', 'name' => 'GER30 (DAX)', 'category' => TradingPair::CATEGORY_STOCK_INDICES, 'subcategory' => null, 'sort_order' => 5, 'decimal_precision' => 2],
            ['symbol' => 'FRA40', 'name' => 'FRA40 (CAC 40)', 'category' => TradingPair::CATEGORY_STOCK_INDICES, 'subcategory' => null, 'sort_order' => 6, 'decimal_precision' => 2],
            ['symbol' => 'JPN225', 'name' => 'JPN225 (Nikkei 225)', 'category' => TradingPair::CATEGORY_STOCK_INDICES, 'subcategory' => null, 'sort_order' => 7, 'decimal_precision' => 2],
            ['symbol' => 'AUS200', 'name' => 'AUS200 (ASX 200)', 'category' => TradingPair::CATEGORY_STOCK_INDICES, 'subcategory' => null, 'sort_order' => 8, 'decimal_precision' => 2],

            // Cryptocurrency (2-8 decimals)
            ['symbol' => 'BTC/USD', 'name' => 'Bitcoin/US Dollar', 'category' => TradingPair::CATEGORY_CRYPTOCURRENCY, 'subcategory' => TradingPair::SUBCATEGORY_CRYPTO, 'sort_order' => 1, 'decimal_precision' => 2],
            ['symbol' => 'ETH/USD', 'name' => 'Ethereum/US Dollar', 'category' => TradingPair::CATEGORY_CRYPTOCURRENCY, 'subcategory' => TradingPair::SUBCATEGORY_CRYPTO, 'sort_order' => 2, 'decimal_precision' => 2],
            ['symbol' => 'BTC/EUR', 'name' => 'Bitcoin/Euro', 'category' => TradingPair::CATEGORY_CRYPTOCURRENCY, 'subcategory' => TradingPair::SUBCATEGORY_CRYPTO, 'sort_order' => 3, 'decimal_precision' => 2],
            ['symbol' => 'ETH/EUR', 'name' => 'Ethereum/Euro', 'category' => TradingPair::CATEGORY_CRYPTOCURRENCY, 'subcategory' => TradingPair::SUBCATEGORY_CRYPTO, 'sort_order' => 4, 'decimal_precision' => 2],

            // Commodities (2-3 decimals)
            ['symbol' => 'GOLD/USD', 'name' => 'Gold/US Dollar', 'category' => TradingPair::CATEGORY_COMMODITIES, 'subcategory' => TradingPair::SUBCATEGORY_PRECIOUS_METALS, 'sort_order' => 1, 'decimal_precision' => 2],
            ['symbol' => 'SILVER/USD', 'name' => 'Silver/US Dollar', 'category' => TradingPair::CATEGORY_COMMODITIES, 'subcategory' => TradingPair::SUBCATEGORY_PRECIOUS_METALS, 'sort_order' => 2, 'decimal_precision' => 2],
            ['symbol' => 'OIL/USD', 'name' => 'Oil/US Dollar', 'category' => TradingPair::CATEGORY_COMMODITIES, 'subcategory' => TradingPair::SUBCATEGORY_ENERGY, 'sort_order' => 3, 'decimal_precision' => 2],
        ];

        foreach ($tradingPairs as $pair) {
            TradingPair::updateOrCreate(
                ['symbol' => $pair['symbol']],
                $pair
            );
        }
    }
}
