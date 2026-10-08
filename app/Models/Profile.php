<?php

namespace App\Models;

use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Academic biodata of one student (one-to-one with User).
 */
class Profile extends Model
{
    /** @use HasFactory<ProfileFactory> */
    use HasFactory;

    /**
     * Columns that may be mass assigned; user_id is set through $user->profile().
     *
     * @var list<string>
     */
    protected $fillable = [
        'nrp',
        'departemen',
        'angkatan',
        'bio',
        'github',
        'linkedin',
        'keahlian',
    ];

    /**
     * Store keahlian as JSON, read it back as a PHP array.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'keahlian' => 'array',
        ];
    }

    /**
     * The student this profile belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
