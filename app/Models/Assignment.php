<?php

namespace App\Models;

use Database\Factories\AssignmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One entry in a student's course assignment history.
 */
class Assignment extends Model
{
    /** @use HasFactory<AssignmentFactory> */
    use HasFactory;

    /**
     * Columns that may be mass assigned; user_id is set through $user->assignments().
     *
     * @var list<string>
     */
    protected $fillable = [
        'mata_kuliah',
        'judul',
        'deskripsi',
        'link_repo',
        'dikumpulkan_pada',
    ];

    /**
     * Turn the submission date into a Carbon instance.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dikumpulkan_pada' => 'date',
        ];
    }

    /**
     * The student who submitted this assignment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
