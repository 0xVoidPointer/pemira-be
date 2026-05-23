<?php

namespace App\Models;

use App\Enums\ElectionPeriodStatus;
use Database\Factories\ElectionPeriodFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElectionPeriod extends Model
{
    /** @use HasFactory<ElectionPeriodFactory> */
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'year',
        'theme_config',
        'reg_start_at',
        'reg_end_at',
        'vote_start_at',
        'vote_end_at',
        'status',
        'created_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'theme_config' => 'array',
            'reg_start_at' => 'datetime',
            'reg_end_at' => 'datetime',
            'vote_start_at' => 'datetime',
            'vote_end_at' => 'datetime',
            'status' => ElectionPeriodStatus::class,
        ];
    }

    /**
     * Admin who created this period.
     *
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Categories belonging to this election period.
     *
     * @return HasMany<ElectionCategory, $this>
     */
    public function categories(): HasMany
    {
        return $this->hasMany(ElectionCategory::class, 'period_id');
    }
}
