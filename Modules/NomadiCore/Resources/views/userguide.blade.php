@extends('nomadicore::layout')
@section('head')

@endsection
@section('content')

<div class='container'>

    <div class='row'>
            <h3>關於本站ISCC</h3>
            ISCC是International Salty Crispy Chicken, 國際鹽酥雞的簡稱<br>
            主要宗旨是讓可以帶給大家幸福的鹽酥雞，這個台灣的寶物，能夠更加的美好，帶給世界更多的幸福<br>
            目前這個網站提供<br>
            一，哪裡有好吃的鹽酥雞<br>
            二，集合大家的力量，<a href="https://www.isccgo.org/community">發表研究論文</a> ，讓鹽酥雞一直進步，帶給世界愈來愈多的幸福<br>
            <a href="mailto:isccorg12@gmail.com">有建議請寄信到這裡isccorg12@gmail.com</a>
    </div>

    <div class='row'>
            <h3>如何使用本站</h3>
            在<a href="https://www.isccgo.org/">地圖模式中</a>，點選有興趣的地點，可以查詢附近的鹽酥雞店家資料<br>
    </div>

    <div class='row'>
        <h3>隱私權政策</h3>
        使用登入會透過 Facebook API 取得授權，只會取得您公開的fb代號、Email與fb的公開大頭貼照片。<br>
        並不會存取其他私人資料。<br>
        使用者如果想分享給大家曾到哪些店家消費，可以利用打卡記錄功能。<br>
        <br>
    </div>

    <div class='row'>
        <h3>特別感謝工程師尤川豪 <a href="https://job.turn.tw"> LINK </a></h3>
        本站使用了他的開源程式為骨幹  <br>
        https://github.com/howtomakeaturn/cafenomad.tw  <br>
        <br>


        <?php 
           $doc= new Modules\NomadiCore\Doc() ;
           $tmp=$doc->docs(2);

           $cc=visits($tmp)->count();
//           echo($cc) ;

 ?>
    </div>




//@include('nomadicore::partial/_footer')


<?php
 $docs = new Modules\NomadiCore\Doc();
 $all = $docs->all();
 
?>


<div class='row'>
        <h3>目前熱門店家(每小時更新)  </h3>
    <div id='table-wrapper'>

        <!--
        <input class="search form-control" placeholder="Search" />
        <br />
        -->
        <div class="table-responsive">
            <table class='table table-hover table-condensed'>
                <thead>
                    <tr>
                    <th>店名</th>
                    <th>點擊次數</th>
                    <th>店家地址</th>
                    <th>世界排名</th>

                    </tr>
                </thead>
                <tbody class="list">
                    <?php 



  
                          // $entity10=list("");

                           $t1=visits('Modules\NomadiCore\Entity')->low(3,false);
 $entityies = new Modules\NomadiCore\Entity();
 $entity10 = $entityies->all();


$ay_tmp= array();
foreach($entity10 as $elm)
    array_push($ay_tmp,$elm);


//print_r($ay_tmp);
//var_dump($entity10);
                            //$tt = collect($entity10)->take(5);
                            //$tt = $entity10->take(5);
              //              $dd= usort($entity10, "iusort");
//function  acmp(Modules\NomadiCore\Entity $a, Modules\NomadiCore\Entity $b)
//{
//      $aa=$a->visits()->count();
//     return $aa;
//     //return $a->visits()->count() < $b->visits()->count() ;
//}

//print_r($ay_tmp[1]);
//$gg=acmp($ay_tmp[1],$ay_tmp[2]);
//print_r($gg) ;


///////////////
usort($ay_tmp,array('Modules\NomadiCore\Entity','acmp'));
$top10=collect($ay_tmp)->take(10);
///////////////




//usort($ay_tmp,array($this,'cmp'));
//usort($ay_tmp,fn($a,$b) => ($a->visits()->count()) - ($b->visits()->count())) ;
//usort($ay_tmp,'cmp');

//usort($entity10,function($a,$b)
//{
//     return ($a->visits()->count() < $b->visits()->count()) ;
//
//});
//                            $tt= $dd->take(5)  ;
                            //$tt->visits()->count();
$tt=$entity10;
        //                    echo(gettype($entity10));
                            //echo(var_dump($entity10));
                            //echo(var_dump($entity10->name));
//$top10=$t1
$entities=$top10;
$fields=array();

                    ?>
                    @foreach( $top10 as $entity)


                <tr id='{{$entity->id}}' class='c12' onclick="openModalByUuid('{{$entity->id}}', 'list')">
                    <td class="c0 -large">
                        <a href='/{{Config::get('nomadic.global.unit-url')}}/{{$entity->id}}' onclick="return false;" class="seo-link">{{$entity->name}}</a>
                        @if($entity->note!=='')
                            <br />
                            <div class='minor grey note' style='display: none;'>{{$entity->note}} - {{$entity->who}}</div>
                        @endif
                    </td>





                        <td class="c1">
                          
                                {{$entity->visits()->count()}}
                         </td>

                        <td class="c1">
                            <div style='text-overflow: ellipsis; max-width: 300px; overflow: hidden;'>
                                {{$entity->address}}
                            </div>
                        </td>
                        <td class="c1">
                            <div style='text-overflow: ellipsis; max-width: 90px; overflow: hidden;'>
                                <?php
                                if ($entity->rank > 9999 ) {
                                 echo("資料不足");
                                } else { 
                                echo($entity->rank);
                                }
                                ?>
                            </div>
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@include('nomadicore::_open-modal')



<script type="text/javascript">
    var options = {
        valueNames: [ 'c0', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16', 'c17' ]
    };
    new List('table-wrapper', options);
</script>

<script>
    $(document).ready(function(){
        $('.search').change(function(e){
            $.get('/track/search?keyword=' + e.target.value);
        });
    })
</script>

</div>

@include('nomadicore::partial/_footer')

<style>
    .user-a:hover {
        text-decoration: none;
    }
</style>

<script>
    $(document).ready(function(){
        @if(isset($targetEntity))
        openModalByUuid('{{ $targetEntity->id }}', 'list');
        @endif
    });
</script>


@endsection
