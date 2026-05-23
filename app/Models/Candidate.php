<?php

namespace App\Models;

use Database\Factories\CandidateFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Candidate extends Model
{
    /** @use HasFactory<CandidateFactory> */
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'number',
        'vision',
        'mission',
        'photo_url',
        'video_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'number' => 'integer',
        ];
    }

    /**
     * Category this candidate runs in.
     *
     * @return BelongsTo<ElectionCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ElectionCategory::class, 'category_id');
    }

    /**
     * Members representing this candidate.
     *
     * @return HasMany<CandidateMember, $this>
     */
    public function members(): HasMany
    {
        return $this->hasMany(CandidateMember::class);
    }

    /**
     * Vote tally for this candidate.
     *
     * @return HasOne<VoteTally, $this>
     */
    public function tally(): HasOne
    {
        return $this->hasOne(VoteTally::class);
    }
}
