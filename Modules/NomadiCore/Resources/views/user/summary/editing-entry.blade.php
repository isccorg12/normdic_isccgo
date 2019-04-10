<div class='entry'>
    <?php
      //var_dump($editing);
      //var_dump($editing->entity['id']);

    ?>
    對
    <a href='/entity/{{$editing->entity['id']}}'><span style='font-weight: bold;'>{{ $editing->entity['name'] }}</span></a>
    編修

    <span class='timestamp'>{{$editing->created_at->format('Y-m-d H:i')}}</span>

</div>
