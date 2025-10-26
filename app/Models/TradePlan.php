<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TradePlan extends Model
{
    use HasFactory;

        protected $fillable = [
            'user_id',
            'title',
            'trading_pair',
            'strategy',
            'pattern_type',
            'status',
            'entry_price',
            'exit_price',
            'stop_loss',
            'take_profit',
            'trade_type',
            'position_size',
            'notes',
            'chart_image',
            'planned_entry_time',
            'planned_exit_time',
            'actual_entry_time',
            'actual_exit_time',
            'risk_reward_ratio',
            'risk_percentage',
        ];

    protected $casts = [
        'entry_price' => 'decimal:8',
        'exit_price' => 'decimal:8',
        'stop_loss' => 'decimal:8',
        'take_profit' => 'decimal:8',
        'position_size' => 'decimal:8',
        'risk_reward_ratio' => 'decimal:4',
        'risk_percentage' => 'decimal:2',
        'planned_entry_time' => 'datetime',
        'planned_exit_time' => 'datetime',
        'actual_entry_time' => 'datetime',
        'actual_exit_time' => 'datetime',
    ];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED = 'expired';

    // Trade type constants
    const TRADE_TYPE_LONG = 'long';
    const TRADE_TYPE_SHORT = 'short';

    // Strategy constants
    const STRATEGY_SCALPING = 'scalping';
    const STRATEGY_DAY_TRADING = 'day_trading';
    const STRATEGY_SWING_TRADING = 'swing_trading';
    const STRATEGY_POSITION_TRADING = 'position_trading';
    const STRATEGY_BREAKOUT = 'breakout';
    const STRATEGY_REVERSAL = 'reversal';
    const STRATEGY_TREND_FOLLOWING = 'trend_following';
    const STRATEGY_MEAN_REVERSION = 'mean_reversion';
    const STRATEGY_MOMENTUM = 'momentum';
    const STRATEGY_ARBITRAGE = 'arbitrage';
    const STRATEGY_GRID = 'grid';
    const STRATEGY_DCA = 'dca';
    const STRATEGY_CUSTOM = 'custom';

    // Pattern type constants
    const PATTERN_HEAD_AND_SHOULDERS = 'head_and_shoulders';
    const PATTERN_DOUBLE_TOP = 'double_top';
    const PATTERN_DOUBLE_BOTTOM = 'double_bottom';
    const PATTERN_TRIPLE_TOP = 'triple_top';
    const PATTERN_TRIPLE_BOTTOM = 'triple_bottom';
    const PATTERN_ASCENDING_TRIANGLE = 'ascending_triangle';
    const PATTERN_DESCENDING_TRIANGLE = 'descending_triangle';
    const PATTERN_SYMMETRICAL_TRIANGLE = 'symmetrical_triangle';
    const PATTERN_WEDGE = 'wedge';
    const PATTERN_FLAG = 'flag';
    const PATTERN_PENNANT = 'pennant';
    const PATTERN_CHANNEL = 'channel';
    const PATTERN_RECTANGLE = 'rectangle';
    const PATTERN_CUP_AND_HANDLE = 'cup_and_handle';
    const PATTERN_INVERSE_CUP_AND_HANDLE = 'inverse_cup_and_handle';
    const PATTERN_DIAMOND = 'diamond';
    const PATTERN_WEDGE_ASCENDING = 'wedge_ascending';
    const PATTERN_WEDGE_DESCENDING = 'wedge_descending';
    const PATTERN_BROADENING = 'broadening';
    const PATTERN_CONVERGENCE = 'convergence';
    const PATTERN_DIVERGENCE = 'divergence';
    const PATTERN_SUPPORT_RESISTANCE = 'support_resistance';
    const PATTERN_TREND_LINE = 'trend_line';
    const PATTERN_FIBONACCI = 'fibonacci';
    const PATTERN_ICHIMOKU = 'ichimoku';
    const PATTERN_CUSTOM = 'custom';

    /**
     * Get the user that owns the trade plan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all possible statuses.
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_EXPIRED => 'Expired',
        ];
    }

    /**
     * Get all possible trade types.
     */
    public static function getTradeTypes(): array
    {
        return [
            self::TRADE_TYPE_LONG => 'Long',
            self::TRADE_TYPE_SHORT => 'Short',
        ];
    }

    /**
     * Get all possible strategies.
     */
    public static function getStrategies(): array
    {
        return [
            self::STRATEGY_SCALPING => 'Scalping',
            self::STRATEGY_DAY_TRADING => 'Day Trading',
            self::STRATEGY_SWING_TRADING => 'Swing Trading',
            self::STRATEGY_POSITION_TRADING => 'Position Trading',
            self::STRATEGY_BREAKOUT => 'Breakout',
            self::STRATEGY_REVERSAL => 'Reversal',
            self::STRATEGY_TREND_FOLLOWING => 'Trend Following',
            self::STRATEGY_MEAN_REVERSION => 'Mean Reversion',
            self::STRATEGY_MOMENTUM => 'Momentum',
            self::STRATEGY_ARBITRAGE => 'Arbitrage',
            self::STRATEGY_GRID => 'Grid Trading',
            self::STRATEGY_DCA => 'Dollar Cost Averaging (DCA)',
            self::STRATEGY_CUSTOM => 'Custom Strategy',
        ];
    }

    /**
     * Get all possible pattern types.
     */
    public static function getPatternTypes(): array
    {
        return [
            // Reversal Patterns
            self::PATTERN_HEAD_AND_SHOULDERS => 'Head and Shoulders',
            self::PATTERN_DOUBLE_TOP => 'Double Top',
            self::PATTERN_DOUBLE_BOTTOM => 'Double Bottom',
            self::PATTERN_TRIPLE_TOP => 'Triple Top',
            self::PATTERN_TRIPLE_BOTTOM => 'Triple Bottom',
            self::PATTERN_CUP_AND_HANDLE => 'Cup and Handle',
            self::PATTERN_INVERSE_CUP_AND_HANDLE => 'Inverse Cup and Handle',
            self::PATTERN_DIAMOND => 'Diamond',
            
            // Continuation Patterns
            self::PATTERN_ASCENDING_TRIANGLE => 'Ascending Triangle',
            self::PATTERN_DESCENDING_TRIANGLE => 'Descending Triangle',
            self::PATTERN_SYMMETRICAL_TRIANGLE => 'Symmetrical Triangle',
            self::PATTERN_WEDGE => 'Wedge',
            self::PATTERN_WEDGE_ASCENDING => 'Ascending Wedge',
            self::PATTERN_WEDGE_DESCENDING => 'Descending Wedge',
            self::PATTERN_FLAG => 'Flag',
            self::PATTERN_PENNANT => 'Pennant',
            self::PATTERN_RECTANGLE => 'Rectangle',
            
            // Channel Patterns
            self::PATTERN_CHANNEL => 'Channel',
            self::PATTERN_BROADENING => 'Broadening',
            
            // Technical Analysis Patterns
            self::PATTERN_SUPPORT_RESISTANCE => 'Support/Resistance',
            self::PATTERN_TREND_LINE => 'Trend Line',
            self::PATTERN_FIBONACCI => 'Fibonacci',
            self::PATTERN_ICHIMOKU => 'Ichimoku',
            self::PATTERN_CONVERGENCE => 'Convergence',
            self::PATTERN_DIVERGENCE => 'Divergence',
            
            // Custom
            self::PATTERN_CUSTOM => 'Custom Pattern',
        ];
    }

    /**
     * Check if the trade plan is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if the trade plan is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if the trade plan is draft.
     */
    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * Calculate the profit/loss percentage.
     */
    public function getProfitLossPercentage(): ?float
    {
        if (!$this->entry_price || !$this->exit_price) {
            return null;
        }

        if ($this->trade_type === self::TRADE_TYPE_LONG) {
            return (($this->exit_price - $this->entry_price) / $this->entry_price) * 100;
        } else {
            return (($this->entry_price - $this->exit_price) / $this->entry_price) * 100;
        }
    }

    /**
     * Calculate the profit/loss amount.
     */
    public function getProfitLossAmount(): ?float
    {
        if (!$this->entry_price || !$this->exit_price || !$this->position_size) {
            return null;
        }

        if ($this->trade_type === self::TRADE_TYPE_LONG) {
            return ($this->exit_price - $this->entry_price) * $this->position_size;
        } else {
            return ($this->entry_price - $this->exit_price) * $this->position_size;
        }
    }

    /**
     * Get the decimal precision for this trade plan's trading pair.
     */
    public function getDecimalPrecision(): int
    {
        return \App\Models\TradingPair::getDecimalPrecision($this->trading_pair);
    }

    /**
     * Format a price with the correct decimal precision for this trading pair.
     */
    public function formatPrice($price): string
    {
        return number_format($price, $this->getDecimalPrecision());
    }

    /**
     * Get the chart image URL.
     */
    public function getChartImageUrl(): ?string
    {
        if (!$this->chart_image) {
            return null;
        }
        
        return asset('storage/charts/' . $this->chart_image);
    }

    /**
     * Check if the trade plan has a chart image.
     */
    public function hasChartImage(): bool
    {
        return !empty($this->chart_image);
    }
}
