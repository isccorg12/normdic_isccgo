<?php

namespace Modules\NomadiCore\Tests\Application;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Auth;
use Modules\NomadiCore\Entity;
use Modules\NomadiCore\User;
use Modules\NomadiCore\Profile;

class UsersVisitPageTest extends TestBase
{
    use DatabaseMigrations;

    function insertSomeEntities()
    {
        $this->insertEntity(md5(uniqid()));

        $this->insertEntity(md5(uniqid()));

        $this->insertEntity(md5(uniqid()));
    }

    function insertEntity($name)
    {
        $city = array_keys(config('city'))[0];

        $entity = new Entity();

        $entity->id = \Ramsey\Uuid\Uuid::uuid4()->toString();

        $entity->name = $name;

        $entity->city = $city;

        $entity->status = Entity::APPROVED_STATUS;

        $entity->save();

        return $entity;
    }

    function loginAsUser()
    {
        $user = new User();

        $user->created_at = '2017-08-06 23:50:00';

        $user->save();

        $profile = new Profile();

        $profile->user_id = $user->id;

        $profile->save();

        Auth::loginUsingId($user->id);
    }

    function setUp()
    {
        parent::setUp();

        $this->insertSomeEntities();

        $this->loginAsUser();
    }

    function test_homepage()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->status());
    }

    function test_contribute_page()
    {
        $response = $this->call('GET', '/contribute');

        $this->assertEquals(200, $response->status());
    }

    function test_list_page()
    {
        $city = array_keys(config('city'))[0];

        $name = md5(uniqid());

        $this->insertEntity($name);

        $this->visit("/$city/list")
            ->see($name);
    }

    function test_city_homepage()
    {
        $city = array_keys(config('city'))[0];

        $response = $this->call('GET', "/$city");

        $this->visit("/$city")
            ->see('<span class="green">3</span>');
    }

    function testBasicExample()
    {
        $name = md5(uniqid());

        $city = array_keys(config('city'))[0];

        config(['nomadic.map-enabled' => false]);

        $response = $this->call('POST', '/contribute', [
            'name' => $name,
            'city' => $city,
        ]);

        $this->assertEquals(200, $response->status());
    }

    function test_entity_ajax_modal_page()
    {
        $city = array_keys(config('city'))[0];

        $name = md5(uniqid());

        $entity = $this->insertEntity($name);

        $id = $entity->id;

        $this->visit("/ajax/modal/$id?mode=list")
            ->see($name);
    }

    function test_tag_page()
    {
      $city = array_keys(config('city'))[0];

      $name = md5(uniqid());

      $entity = $this->insertEntity($name);

      $id = $entity->id;

      $this->visit("/shop/$id/tag")
          ->see($name);
    }

    function test_review_page()
    {
      $city = array_keys(config('city'))[0];

      $name = md5(uniqid());

      $entity = $this->insertEntity($name);

      $id = $entity->id;

      $this->visit("/review/$id")
          ->see($name);
    }

    function test_editing_page()
    {
      $city = array_keys(config('city'))[0];

      $name = md5(uniqid());

      $entity = $this->insertEntity($name);

      $id = $entity->id;

      $this->visit("/editing/$id")
          ->see($name);
    }
}
