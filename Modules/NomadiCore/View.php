<?php

/*namespace App\Models;*/
namespace Modules\NomadiCore;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class View extends Model
{
    protected $table = 'views';
    protected $guarded = ['id'];


/*
#### add counter here
*/
    public function views()
    {
        $this->increment('id');
        return $this->morphMany(View::class, 'viewable');
       // return $this->morphMany('viewable');
    }

    /**
     * Get the total number of views.
     *
     * @return int
     */
    public function getViewsCount()
    {
        return $this->views()->count();
    }

    
    public function getCount()
    {
        return $this->count();
    }

    public function getViewsCountSince($sinceDateTime)
    {
        return $this->views()->where('created_at', '>', $sinceDateTime)->count();
    }
}
