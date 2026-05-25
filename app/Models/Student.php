<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Student extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory, HasUuids, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'faculty_id',
        'nim',
        'full_name',
        'email',
        'password',
        'is_eligible',
        'enrollment_year',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_eligible' => 'boolean',
            'enrollment_year' => 'integer',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array<string, mixed>
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'role' => UserRole::Mahasiswa->value,
        ];
    }

    /**
     * Faculty this student belongs to.
     *
     * @return BelongsTo<Faculty, $this>
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Candidate memberships of this student.
     *
     * @return HasMany<CandidateMember, $this>
     */
    public function candidateMemberships(): HasMany
    {
        return $this->hasMany(CandidateMember::class);
    }

    /**
     * Ballots cast by this student.
     *
     * @return HasMany<Ballot, $this>
     */
    public function ballots(): HasMany
    {
        return $this->hasMany(Ballot::class);
    }
}
