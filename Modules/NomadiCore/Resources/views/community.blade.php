@extends('nomadicore::layout')
@section('head')

@endsection
@section('content')

<div class='container'>
    <div class='row'>
        <div class="col-md-12">
            <h3>Call for ISCC technology papers (鹽酥科技論文) deadline (2019/04/30)</h3>
            <h3>2019 ISCCC 會議地點/時間:<a href=" https://www.hiltonhawaiianvillage.com/">夏威夷 希爾頓 @ 2019/05/05</a>  </h3>
            <h3>題目: 什麼酒搭配什麼鹽酥雞，如何增進鹽酥雞產能?如何炸出基本分的鹽酥雞? </h3>
            <h3>請寄至isccorg12@gmail.com </h3>
            <h3><a href="https://www.ieee.org/content/dam/ieee-org/ieee/web/org/conferences/Conference-template-A4.doc">論文範本下載</a></h3>
            <h3><a href="/00.iscc.scoring.2018.pdf">2018 最佳論文(best paper award): 一種新的鹽酥雞評分標準</a></h3>
        </div>
    </div>

    <div class='row'>
        @foreach( $users as $user)
        <div class='col-md-3'>
            <a href='/user/{{ $user->id }}' class='user-a'>
                <div style='padding: 10px; border-bottom: 1px solid #E0E0E0;'>
                    <div style='display: inline-block;'>
                        <img src='{{ $user->profile->avatar }}' style='border-radius: 50%;'>
                    </div>
                    <div style='display: inline-block; width: calc(100% - 70px); vertical-align: top;'>
                        <div style='overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>
                        {{ $user->name }}
                        </div>
                        <div style="color: grey;">
                            <div class="row">
                                <div class="col-xs-6">
                                    新增 <span class="blue">{{ $user->cafes->count() }}</span>
                                </div>
                                <div class="col-xs-6">
                                    評分 <span class="blue">{{ $user->reviews->count() }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    編修 <span class="blue">{{ $user->editings->count() }}</span>
                                </div>
                                <div class="col-xs-6">
                                    留言 <span class="blue">{{ $user->comments->count() }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <!--
                                <div class="col-xs-6">
                                    拍照 <span class="blue">{{ $user->photos->count() }}</span>
                                </div>
                                -->
                                <div class="col-xs-6">
                                    打卡 <span class="blue">{{ $user->recommendations->count() }}</span>
                                </div>
                                <div class="col-xs-6">
                                    標籤 <span class="blue">{{ $user->cafeTags->count() }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="Page navigation" class='pull-right'>
              <ul class="pagination">
                  <!--
                <li>
                  <a href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
            -->

                @for ($i = 1; $i <= $totalPage; $i++)
                    <li @if($page == $i) class='active' @endif><a href="/community?page={{$i}}">{{$i}}</a></li>
                @endfor
                <!--
                <li>
                  <a href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
            -->
              </ul>
            </nav>
        </div>
    </div>
</div>

@include('nomadicore::partial/_footer')

<style>
    .user-a:hover {
        text-decoration: none;
    }
</style>

@endsection
