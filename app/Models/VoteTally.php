<?php

namespace App\Models;

use Database\Factories\VoteTallyFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoteTally extends Model
{
    /** @use HasFactory<VoteTallyFactory> */
    use HasFactory, HasUuids;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'candidate_id',
        'vote_count',
        'last_updated',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'vote_count' => 'integer',
            'last_updated' => 'datetime',
        ];
    }

    /**
     * Candidate this tally tracks.
     *
     * @return BelongsTo<Candidate, $this>
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }
}
