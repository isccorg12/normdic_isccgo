<?php

namespace Modules\NomadiCore\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Request;
use DB;
use Layout;
use Config;
use Modules\NomadiCore\Cafe;
use Modules\NomadiCore\Entity;
use Modules\NomadiCore\City;
use CafeNomad;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CityController extends BaseController
{

    private function getView($city)
    {
        if (Layout::isMobile()) {
            return 'nomadicore::list-mobile';
        } else {
            return 'nomadicore::list-desktop';
        }
    }

    function createListPage($city)
    {
        if($city=="top50"){
            $city='taipei';
            session(['mode' => 'list']);
            session(['city' => $city]);
            Layout::setCity($city);
            CafeNomad::setMode('list');

            $fields = City::getFields($city);
            //$entities = Entity::where('city', $city)->where('status', 10)->get();
            //$entities = Entity::where('status', 10)
                        //->orderBy('review_no','desc')
            $entities = Entity::orderBy('rank','asc')
                        ->take(50)
                        ->get();

            $agent = new \Jenssegers\Agent\Agent();
            return view($this->getView($city), ['entities' => $entities, 'fields' =>        $fields]);

        
        } else {
            session(['mode' => 'list']);
            session(['city' => $city]);
            Layout::setCity($city);
            CafeNomad::setMode('list');

            $fields = City::getFields($city);
            //$entities = Entity::where('city', $city)->where('status', 10)->get();
            //$entities = Entity::where('city', $city)->where('status', 10)
            $entities = Entity::where('city', $city)
                        //->orderBy('review_no','desc')
                        ->orderBy('rank','asc')
                        ->get();

            $agent = new \Jenssegers\Agent\Agent();
            return view($this->getView($city), ['entities' => $entities, 'fields' => $fields]);
        }
    }

    function createMapPage($city)
    {
        session(['mode' => 'map']);

        session(['city' => $city]);

        Layout::setCity($city);

        Layout::setIsMap(true);

        CafeNomad::setMode('map');

        $fields = City::getFields($city);


         
        $center =  City::getMapCenter($city) ;

        $lat2=$center['lat'];
        $lng2=$center['lng'];


        $range=0.1 ;
        $lat_upper=$lat2+$range;
        $lat_lower=$lat2-$range;
        $lng_upper=$lng2+$range;
        $lng_lower=$lng2-$range;


        //// gogo12 modify 
        //$cafes = Entity::whereBetween('latitude', [$lat_lower, $lat_upper])
        //     ->whereBetween('longitude', [$lng_lower, $lng_upper])
        //     ->where('level', '>=', '0')
        //     ->orderBy('rank','asc')
        //     ->take(10)
        //     ->get();


        $cafes = Entity::where('city', $city)->where('status', 10)
            ->where('latitude', '!=', '0')
            ->where('longitude', '!=', '0')
             ->orderBy('rank','asc')
             ->get();


        return view('nomadicore::map', ['cafes' => $cafes, 'fields' => $fields,
            'center' => City::getMapCenter($city)]);
    }
    function createL1MapPage($lat, $lng)
    {

$redis=app('redis.connection');
$redis->rpush('map_query',"$lat,$lng");
#$all=$redis->lrange('mapxy',0,-1);
#$echo($all);

#$process = new Process(['/home/Dean/12.get_xy_update.csv.py', "$lat", "$lng" ]);
#
#try {
#    $process->mustRun();
#
#    echo $process->getOutput();
#} catch (ProcessFailedException $exception) {
#    echo $exception->getMessage();
#}


#$process->start();


        $city='nantou';
        session(['mode' => 'map']);

        session(['city' => $city]);

        Layout::setCity($city);

        Layout::setIsMap(true);

        CafeNomad::setMode('map');

        $fields = City::getFields($city);

$range=0.1 ;
//$tmp=Config::get('nomadic.global.rank');
//$range=float($tmp);
if($lat&&$lng){
        $lat_upper=$lat+$range;
        $lat_lower=$lat-$range;
        $lng_upper=$lng+$range;
        $lng_lower=$lng-$range;

        $lat2=$lat;
        $lng2=$lng;
}else{
        $user_ip = getenv('REMOTE_ADDR');
        $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
        $country = $geo["geoplugin_countryName"];
        $city_ = $geo["geoplugin_city"];
        $lat2 = $geo["geoplugin_latitude"];
        $lng2 = $geo["geoplugin_longitude"];
        
        echo "city is $lat2, $lng2";
                // gogo12 modify
        //$cafes = Entity::where('city', $city)->where('status', 10)
        //echo '<script language="javascript">';
        //echo 'alert("搜尋附近十公里的鹽酥雞 ");';
           //x_y is 24.8912735, 121.1163089 
           //echo '      document.cookie = escape(\'lat\') + "=" + escape(24);';
           //echo '      document.cookie = escape(\'lng\') + "=" + escape(121);';
        //echo '</script>';
        $_COOKIE['lat']=$lat2;
        $_COOKIE['lng']=$lng2;
        $lat_upper=$_COOKIE['lat']+$range;
        $lat_lower=$_COOKIE['lat']-$range;
        $lng_upper=$_COOKIE['lng']+$range;
        $lng_lower=$_COOKIE['lng']-$range;
        echo "x_y is $lat_upper, $lng_upper";
}
        $cafes = Entity::whereBetween('latitude', [$lat_lower, $lat_upper])
             ->whereBetween('longitude', [$lng_lower, $lng_upper])
             ->where('level', '>=', '0')
             ->orderBy('rank','asc')
             ->get();

             #->take(10)
             #->orderBy('level','asc')

        //$cafes->sortBy(function(array $item){
         //       return json_decode($item->review_fields)->review-field-5;
       // });

#        var_dump($cafes);

             //->orderBy('review_fields->review-field-5','asc')





        #echo "$cafes";
        //$cafes = Entity::where('status', 10)
         //   ->where('latitude', '!=', '0')
          //  ->where('longitude', '!=', '0')
           // ->where('level', '=', '2')
            //->get();
      ##############################################
      # prepare location to sent to initMap in the map php 
      # use the php location 
      ################################################
      $center =  City::getMapCenter($city) ;
      $center['lat']=$lat2;
      $center['lng']=$lng2;
   

 //      echo "$center";

        //return view('nomadicore::map', ['cafes' => $cafes, 'fields' => $fields, 'center' => City::getMapCenter($city)]);
        return view('nomadicore::map', ['cafes' => $cafes, 'fields' => $fields,  'center' => $center ]);
    }


    function getList($city)
    {
        return $this->createListPage($city);
    }

//    function getMap()
//    {
//        $city='level1';
//        return $this->createMapPage($city);
//    }

    function getL1Map($lat=null, $lng=null) 
    {


if($lat){

 echo "passed is $lat, $lng";
} 
          //$city='*' ;
//echo '<script language="javascript">';
//echo ' document.cookie =escape(\'lat\') + "=" + escape(\'24\');';
//echo ' document.cookie =escape(\'lng\') + "=" + escape(\'121\');';

//echo '          navigator.geolocation.getCurrentPosition(function(position) {　';
//echo '            var pos = {　';
//echo '              lat: position.coords.latitude,　';
//echo '              lng: position.coords.longitude　';
//echo '            };　';
//echo '            };　';
//echo '            );　';

//echo ' document.cookie =escape(\'lat\') + "=" + escape(pos.lat);';
//echo ' document.cookie =escape(\'lng\') + "=" + escape(pos.lng);';
//echo "             console.log('go here log'); " ;
//echo "</script> " ;
          $city='hsinchu';
          $city='taipei';
          //return $this->createL1MapPage($city);
          return $this->createL1MapPage($lat,$lng);
    }
    function getMap($city)
    {
        return $this->createMapPage($city);
          //return $this->createL1MapPage($lat,$lng);
    }

    function getShop($id)
    {
        $targetEntity = Entity::find($id);

        session(['mode' => 'map']);

        $city = $targetEntity->city;

        session(['city' => $city]);

        Layout::setCity($city);

        Layout::setIsMap(true);

        CafeNomad::setMode('map');

        $fields = City::getFields($city);

        $cafes = Entity::where('city', $city)->where('status', 10)
            ->where('latitude', '!=', '0')
            ->where('longitude', '!=', '0')
            ->get();

        return view('nomadicore::map', ['cafes' => $cafes, 'fields' => $fields, 'targetCafe' => $targetEntity,
            'center' => City::getMapCenter($city)]);
    }

    function getDiscovery($city)
    {
        Layout::setDisplayNavbar(false);

        Layout::setOpenGraphTitle('Cafe Nomad ' . Config::get('city')[$city]['zh'] . ' - 網友們一起寫的咖啡廳食記&評鑑');

        Layout::setOpenGraphImage(url('/img/marketing/mm.png'));

        $cafes = \Modules\NomadiCore\Cafe::where('city', $city)->where('status', 10)
            ->where('latitude', '!=', '0')
            ->where('longitude', '!=', '0')
            ->get();

        $cafes = $cafes->filter(function($cafe){
            if ($cafe->photos->count() === 0) return false;

            return true;
        });

        return view('nomadicore::discovery', compact('cafes'));
    }

    function getHomepage($city)
    {
        Layout::setOpenGraphTitle(Config::get('nomadic.global.app') . ' - ' . Config::get('city')[$city]['zh']);

        Layout::setCity($city);

        $displayNumber = 4;

        if (Layout::isMobile()) $displayNumber = 3;

        $comments = City::getLatestComments($city, $displayNumber);

        $reviews = City::getLatestReviews($city, $displayNumber);

        $photos = City::getLatestPhotos($city, $displayNumber);

        return view('nomadicore::city-homepage', compact('city', 'comments', 'reviews', 'photos'));
    }

    function getFlaneur($city)
    {
        Layout::setOpenGraphTitle('Cafe Nomad - ' . Config::get('city')[$city]['zh'] . '咖啡廳 Facebook 最新動態');

        Layout::setOpenGraphImage(url('/android-chrome-384x384.png'));

        Layout::setCity($city);

        CafeNomad::setMode('flaneur');

        $feeds = $this->flaneurPagination($city, 1);

        return view('nomadicore::flaneur', compact('feeds', 'city'));
    }

    function getFlaneurAjax()
    {
        $feeds = $this->flaneurPagination(Request::get('city'), Request::get('page'));

        foreach ($feeds as $feed) {
            echo view('nomadicore::flaneur/_fb-posts', compact('feed'));
        }
    }

    function flaneurPagination($city, $page)
    {
        $rows = DB::table('fb_feeds')
                    ->join('fb_fan_pages', 'fb_feeds.fb_fan_page_id', '=', 'fb_fan_pages.id')
                    ->join('cafes', 'fb_fan_pages.cafe_id', '=', 'cafes.id')
                    ->select('fb_feeds.id')
                    ->where('cafes.city', $city)
                    ->orderby('fb_feeds.published_at', 'desc')
                    ->offset(($page - 1) * 25)
                    ->limit(25)
                    ->get();

        $ids = [];

        foreach ($rows as $row) {
            $ids[] = $row->id;
        }

        $feeds = \Modules\NomadiCore\Facebook\Feed::findMany($ids);

        $feeds = $feeds->sortByDesc('published_at');

        return $feeds;
    }

    function tag($city, $tagStr)
    {
        $tagId = explode('-', $tagStr)[0];

        $tag = \Modules\NomadiCore\Tag::find($tagId);

        $rows = \Modules\NomadiCore\EntityTag::where('tag_id', $tagId)->get();

        $cafeIds = [];

        foreach ($rows as $row) {
            $cafe = Entity::find($row->entity_id);

            if ($cafe->city !== $city) continue;

            if (in_array($cafe->id, $cafeIds)) continue;

            $cafeIds[] = $cafe->id;
        }

        $cafes = Entity::findMany($cafeIds);

        $latArr = [];
        $lngArr = [];

        foreach($cafes as $cafe) {
            if ($cafe->latitude != 0) {
                $latArr[] = $cafe->latitude;
                $lngArr[] = $cafe->longitude;
            }
        }

        if (count($latArr) > 0) {
            $center = ['lat' => calculate_median($latArr), 'lng' => calculate_median($lngArr), 'zoom' => 13];
        } else {
            $center = ['lat' => 24.042571, 'lng' => 120.9472711, 'zoom' => 8];
        }

        Layout::setOpenGraphTitle( config('nomadic.global.app'). ' - ' . Config::get('city')[$city]['zh'] . $tag->name . '的' . config('nomadic.global.subject') . '清單：共收錄' . $cafes->count() . '間網友推薦的店');

        return view('nomadicore::tag', compact('cafes', 'city', 'tag', 'center'));
    }

}
