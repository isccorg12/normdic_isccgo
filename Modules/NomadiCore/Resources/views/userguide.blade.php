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
        使用登入會透過 Facebook API 授權使用您的名字、Email與照片。<br>
        使用者可以利用「打卡紀錄」分享給大家曾到哪些店家消費。<br>
        <br>
    </div>

    <div class='row'>
        <h3>特別感謝工程師尤川豪 <a href="https://job.turn.tw"> LINK </a>  </h3>
        本站使用了他的開源程式為骨幹  <br>
        https://github.com/howtomakeaturn/cafenomad.tw  <br>
        <br>



        {{ $pg_count }}
    </div>



</div>

@include('nomadicore::partial/_footer')

<style>
    .user-a:hover {
        text-decoration: none;
    }
</style>

@endsection
