<div class='entry'>
    對
    {{$cafeTag}}
    {{$cafeTag->entity_id}}
    <a href='/shop/{{$cafeTag->entitytags['id']}}'><span style='font-weight: bold;'>{{ $cafeTag->entitytags['name'] }}</span></a>
    加上標籤：
    {{$cafeTag->tag->name}}

    <span class="timestamp">{{$cafeTag->created_at->format('Y-m-d H:i')}}</span>

</div>
