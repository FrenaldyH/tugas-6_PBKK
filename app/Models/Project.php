<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An Agentic AI proposal idea owned by one user.
 */
class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    /**
     * Columns that may be mass assigned.
     * user_id is left out on purpose: it is set through $user->projects()->create(),
     * so a request can never assign a project to someone else.
     *
     * @var list<string>
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'tema_agent',
        'api_key_secure',
    ];

    /**
     * Never leak the API key when the model is turned into an array or JSON.
     *
     * @var list<string>
     */
    protected $hidden = [
        'api_key_secure',
    ];

    /**
     * Encrypt the API key at rest using APP_KEY.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'api_key_secure' => 'encrypted',
        ];
    }

    /**
     * The student who owns this project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
