<?php

namespace App\Models;

use App\Enums\ElectionCategoryType;
use Database\Factories\ElectionCategoryFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElectionCategory extends Model
{
    /** @use HasFactory<ElectionCategoryFactory> */
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'period_id',
        'scope_faculty_id',
        'type',
        'title',
        'description',
        'vote_start_at',
        'vote_end_at',
        'max_winners',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => ElectionCategoryType::class,
            'vote_start_at' => 'datetime',
            'vote_end_at' => 'datetime',
            'max_winners' => 'integer',
        ];
    }

    /**
     * Period this category belongs to.
     *
     * @return BelongsTo<ElectionPeriod, $this>
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(ElectionPeriod::class, 'period_id');
    }

    /**
     * Faculty scope (only for FACULTY_GOVERNOR).
     *
     * @return BelongsTo<Faculty, $this>
     */
    public function scopeFaculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'scope_faculty_id');
    }

    /**
     * Candidates running in this category.
     *
     * @return HasMany<Candidate, $this>
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class, 'category_id');
    }

    /**
     * Ballots cast within this category.
     *
     * @return HasMany<Ballot, $this>
     */
    public function ballots(): HasMany
    {
        return $this->hasMany(Ballot::class, 'category_id');
    }
}
