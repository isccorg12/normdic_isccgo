<div style='margin-top: 15px;' id='like-box-{{$entity->id}}'>
</div>

<script>
    (function() {
        var $e = $('#like-box-{{$entity->id}}');

        var store = {
            count: 0,
            visits: [],
            visited: false,
            userAvatar: '',
            userLogined: false,
            cafeId: '{{$entity->id}}',
            token: '{{csrf_token()}}'
        };

        store.count = {{$entity->recommendations->count()}};

        @foreach($entity->recommendations as $rec)
            store.visits.push('{{$rec->user->profile->avatar}}');
        @endforeach

        @if(Auth::check())
            store.userLogined = true;
            store.userAvatar = '{{Auth::user()->profile->avatar}}';
        @endif

        @if(Auth::check() && is_cafe_recommended_by_user($entity->id, Auth::user()->id))
            store.visited = true;
        @endif

        function render() {
            $e.empty();
            store.visits.map(function(v){
                $img = new $("<img src='" + v +"' style='border-radius: 50%; width: 40px; margin-right: 2px; margin-bottom: 2px;'>");
                $e.append($img);
            });

            $e.append("{{trans('util.text.num-of-visit_')}} " + store.count + " {{Config::get('nomadic.info-modal.num-of-visit')}} ");

            if (store.userLogined) {
                if (store.visited) {
                    $button = new $("<button class='btn btn-default btn-sm'>（{{Config::get('nomadic.info-modal.check-in')}}）</button>");
                    $button.click(function(){
                        store.visited = false;
                        store.count -= 1;
                        index = store.visits.indexOf(store.userAvatar);
                        store.visits.splice(index, 1);
                        render();
                        $.post('/ajax/cancel-visit', {entity_id: store.cafeId, _token: store.token});
                    });
                    $e.append($button);
                } else {
                    $button = new $("<button class='btn btn-info btn-sm'><i class='fa fa-map-marker'></i>&nbsp;{{Config::get('nomadic.info-modal.check-in')}}</button>");
                    $button.click(function(){
                        store.visited = true;
                        store.count += 1;
                        store.visits.push(store.userAvatar);
                        render();
                        $.post('/ajax/visit', {entity_id: store.cafeId, _token: store.token});
                    });
                    $e.append($button);
                }
            } else {
                $link = new $("<a href='/login?cafe_id={{$entity->id}}&path=/shop/{{$entity->id}}&action=recommend' class='btn btn-info btn-sm'><i class='fa fa-map-marker'></i>&nbsp;{{Config::get('nomadic.info-modal.check-in')}}</a>");
                $e.append($link);
            }
        }

        $(document).ready(function(){
            render();
        });
    })();
</script>
