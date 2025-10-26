<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TradingPair extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'name',
        'category',
        'subcategory',
        'is_active',
        'sort_order',
        'decimal_precision',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'decimal_precision' => 'integer',
    ];

    // Category constants
    const CATEGORY_FOREX = 'forex';
    const CATEGORY_STOCK_INDICES = 'stock_indices';
    const CATEGORY_CRYPTOCURRENCY = 'cryptocurrency';
    const CATEGORY_COMMODITIES = 'commodities';
    const CATEGORY_CUSTOM = 'custom';

    // Subcategory constants
    const SUBCATEGORY_MAJOR_FOREX = 'major_forex';
    const SUBCATEGORY_MINOR_FOREX = 'minor_forex';
    const SUBCATEGORY_CRYPTO = 'crypto';
    const SUBCATEGORY_PRECIOUS_METALS = 'precious_metals';
    const SUBCATEGORY_ENERGY = 'energy';

    /**
     * Get all categories.
     */
    public static function getCategories(): array
    {
        return [
            self::CATEGORY_FOREX => 'Forex',
            self::CATEGORY_STOCK_INDICES => 'Stock Indices',
            self::CATEGORY_CRYPTOCURRENCY => 'Cryptocurrency',
            self::CATEGORY_COMMODITIES => 'Commodities',
            self::CATEGORY_CUSTOM => 'Custom',
        ];
    }

    /**
     * Get all subcategories.
     */
    public static function getSubcategories(): array
    {
        return [
            self::SUBCATEGORY_MAJOR_FOREX => 'Major Forex',
            self::SUBCATEGORY_MINOR_FOREX => 'Minor Forex',
            self::SUBCATEGORY_CRYPTO => 'Cryptocurrency',
            self::SUBCATEGORY_PRECIOUS_METALS => 'Precious Metals',
            self::SUBCATEGORY_ENERGY => 'Energy',
        ];
    }

    /**
     * Scope to get active trading pairs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get trading pairs by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get trading pairs grouped by category for dropdowns.
     */
    public static function getGroupedForDropdown(): array
    {
        $pairs = self::active()
            ->orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        $grouped = [];
        foreach ($pairs as $category => $categoryPairs) {
            $categoryName = self::getCategories()[$category] ?? ucfirst($category);
            $grouped[$categoryName] = $categoryPairs->pluck('symbol', 'symbol')->toArray();
        }

        return $grouped;
    }

    /**
     * Get trading pairs for a specific category.
     */
    public static function getForCategory($category): array
    {
        return self::active()
            ->byCategory($category)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name', 'symbol')
            ->toArray();
    }

    /**
     * Get decimal precision for a trading pair symbol.
     */
    public static function getDecimalPrecision($symbol): int
    {
        $pair = self::where('symbol', $symbol)->first();
        return $pair ? $pair->decimal_precision : 4; // Default to 4 decimals
    }

    /**
     * Format price with appropriate decimal precision for this trading pair.
     */
    public function formatPrice($price): string
    {
        return number_format($price, $this->decimal_precision);
    }
}
