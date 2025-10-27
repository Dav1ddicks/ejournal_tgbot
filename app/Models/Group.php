<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Group extends Model
{
    protected $fillable = [
        'grade',
        'sign',
        'occupation',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function subscriptions(): HasManyThrough
    {
        return $this->hasManyThrough(Subscription::class, Student::class);
    }

    public function groupMessages():HasMany
    {
        return $this->hasMany(GroupMessage::class);
    }

    public function title(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->grade . "-" . $this->sign,
        );
    }
}
