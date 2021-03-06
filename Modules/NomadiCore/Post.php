<?php

namespace Modules\NomadiCore;

use Illuminate\Database\Eloquent\Model;

/*##
# add here
*/
use Carbon\Carbon;

class Post extends Model
{

    function user()
    {
        return $this->belongsTo('Modules\NomadiCore\User');
    }

    function discussion()
    {
        return $this->belongsTo('Modules\NomadiCore\Discussion');
    }

    function comments()
    {
        return $this->hasMany('Modules\NomadiCore\PostComment');
    }

//#### add counter here
/*
    public function views()
    {
        $this->increment('id');
        return $this->morphMany(View::class, 'viewable');
       // return $this->morphMany('viewable');
    }

    
     * Get the total number of views.
     *
     * @return int
    
    public function getViewsCount()
    {
        return $this->views()->count();
    }

    public function getViewsCountSince($sinceDateTime)
    {
        return $this->views()->where('created_at', '>', $sinceDateTime)->count();
    }
*/
}
