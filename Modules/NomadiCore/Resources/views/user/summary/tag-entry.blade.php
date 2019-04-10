<div class='entry'>
    對
    <?php
      $id=$cafeTag['entity_id'];
      $en= Modules\NomadiCore\Entity::find($id);
      //echo("find is:$en->name");
    ?>
    <a href='/entity/{{$cafeTag['entity_id']}}'><span style='font-weight: bold;'>{{$en->name }}</span></a>
    加上標籤：
    {{$cafeTag->tag->name}}

    <span class="timestamp">{{$cafeTag->created_at->format('Y-m-d H:i')}}</span>

</div>
