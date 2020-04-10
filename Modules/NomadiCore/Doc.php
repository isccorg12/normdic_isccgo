<?php



/*namespace App\Models;*/
namespace Modules\NomadiCore;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Doc extends Model
{
    protected $table = 'doc';
    //protected $guarded = ['id'];


    public function docs($id)
    {
        $target= Doc::where('id',$id)->first();
        return $target;

       // return $this->morphMany('viewable');
    }
/*
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

*/
}

