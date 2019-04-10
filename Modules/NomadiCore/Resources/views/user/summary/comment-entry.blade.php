<div class='entry'>
    <img src="{{$comment->user->profile->avatar}}" style="border-radius: 50%;">
    <span style='color: darkgreen; '>{{ $comment->user->name }}</span>
    <?php
        ///var_dump($comment->user->profile->avatar);
        ///var_dump($comment->entity['name']);
        ///var_dump($comment->entity['id']);
        ///var_dump($comment);
  
    ?>
    對
    
    <a href='/entity/{{$comment->entity['id']}}'><span style='font-weight: bold;'>{{ $comment->entity['name'] }}</span></a>
    
    留言：

    <span class="timestamp">{{$comment->created_at->format('Y-m-d H:i')}}</span>

    {{$comment->body}}
</div>
