<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    const STATUS_SCHEDULED = 1;
    const STATUS_CANCELED = 2;
    const STATUS_NOSHOW = 3;
    const STATUS_COMPLETE = 4;

    public function scopeNoShows(Builder $query)
    {
        return $query->where('status', '=', self::STATUS_NOSHOW);
    }

    public function scopeCanceled(Builder $query)
    {
        return $query->where('status', '=', self::STATUS_CANCELED);
    }

    public function scopeComplete(Builder $query)
    {
        return $query->where('status', '=', self::STATUS_COMPLETE);
    }
}
