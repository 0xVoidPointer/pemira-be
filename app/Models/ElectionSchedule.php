<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElectionSchedule extends Model
{
    use HasUuids;

    protected $casts = [
        'vote_start_at' => 'datetime',
        'vote_end_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<ElectionPeriod, $this>
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(ElectionPeriod::class, 'period_id');
    }

    /**
     * @return BelongsTo<Faculty, $this>
     */
    public function scopeFaculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'scope_faculty_id');
    }
}
