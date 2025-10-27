<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMessage extends Model
{
    protected $fillable = [
        "content",
        "group_id",
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function tgMessage(): Attribute
    {
        return Attribute::make(
            get: fn() => "Для " . $this->group->title . ": " . $this->content,
        );
    }
}
