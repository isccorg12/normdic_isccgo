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

class CityController2 extends BaseController
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
        session(['mode' => 'list']);

        session(['city' => $city]);

        Layout::setCity($city);

        CafeNomad::setMode('list');

        $fields = City::getFields($city);

        $entities = Entity::where('city', $city)->where('status', 10)->get();

        $agent = new \Jenssegers\Agent\Agent();

        return view($this->getView($city), ['entities' => $entities, 'fields' => $fields]);
    }

    function createMapPage($city)
    {
        session(['mode' => 'map']);

        session(['city' => $city]);

        Layout::setCity($city);

        Layout::setIsMap(true);

        CafeNomad::setMode('map');

        $fields = City::getFields($city);

        $cafes = Entity::where('city', $city)->where('status', 10)
            ->where('latitude', '!=', '0')
            ->where('longitude', '!=', '0')
            ->get();

        return view('nomadicore::map', ['cafes' => $cafes, 'fields' => $fields,
            'center' => City::getMapCenter($city)]);
    }

    function getList($city)
    {
        return $this->createListPage($city);
    }

    function getMap()
    {
        $city='level1';
        return $this->createMapPage($city);
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
