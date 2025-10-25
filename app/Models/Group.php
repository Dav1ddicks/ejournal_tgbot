<?php

namespace App\Models;

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
}
