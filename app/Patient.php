<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    //

    public function scopeNewPatients(Builder $query) {
        return $query->where('created_at', '>', new \DateTime('-5 months'));
    }

    public function scopeExistingPatients(Builder $query) {
        return $query->where('created_at', '<=', new \DateTime('-5 months'));
    }
}
