<div class='entry'>
    對
    <a href='/entity/{{$review->entity['id']}}'><span style='font-weight: bold;'>{{ $review->entity['name'] }}</span></a>
    評分：
    {{ $review->presentSummary() }}
    <span class='timestamp'>{{$review->created_at->format('Y-m-d H:i')}}</span>
</div>
