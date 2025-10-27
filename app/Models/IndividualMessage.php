<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function tgMessage(): Attribute
    {
        return Attribute::make(
            get: fn() => "Для " . $this->student->full_name_shortened . ": " . $this->content,
        );
    }
}
