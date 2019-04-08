<?php

namespace Modules\NomadiCore;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{

    public $timestamps = false;

    function user()
    {
        return $this->belongsTo('Modules\NomadiCore\User');
    }

}
