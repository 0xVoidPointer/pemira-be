<?php

namespace App\Models;

use Database\Factories\BallotFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ballot extends Model
{
    /** @use HasFactory<BallotFactory> */
    use HasFactory, HasUuids;

    public const UPDATED_AT = null;

    public const CREATED_AT = 'voted_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'student_id',
        'voted_at',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'voted_at' => 'datetime',
        ];
    }

    /**
     * Category in which the ballot was cast.
     *
     * @return BelongsTo<ElectionCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ElectionCategory::class, 'category_id');
    }

    /**
     * Student who cast the ballot.
     *
     * @return BelongsTo<Student, $this>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
