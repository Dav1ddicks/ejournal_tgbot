<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndividualMessage extends Model
{
    protected $fillable = [
        "content",
        "student_id",
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
