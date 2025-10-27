<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'mid_name',
        'last_name',
        'group_id',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function individualMessages(): HasMany
    {
        return $this->hasMany(IndividualMessage::class);
    }

    public function fullNameShortened(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->last_name . " " . mb_substr($this->first_name, 0, 1) . ". " . mb_substr($this->mid_name, 0, 1) . ".",
        );
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->last_name . " " . $this->first_name . " " . $this->mid_name,
        );
    }
}
