@extends('nomadicore::layout')

@section('head')
    @include('nomadicore::partial/business-hours-form-head', ['inputName' => 'business-hours'])
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>推薦新增{{ config('nomadic.global.subject') }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <form method="post" action="/contribute" style="padding-left: 0;">
                <p>
                    所在{{Config::get('nomadic.global.category')}}：
                    <select name="city">
                        <option value="">請選擇</option>
                    @foreach(Config::get('city') as $key => $value)
                        <option value="{{ $key }}">{{ $value['zh'] }}</option>
                    @endforeach
                    </select>
                </p>
                <p>
                    名稱
                    <input name="name" type="text" required>
                </p>

                @if(config('nomadic.map-enabled'))
                <p>
                地址
                <input name='address' type='text' style="width: calc(100% - 50px);" required>
                </p>
                @endif

                <p>
                    <button class="btn btn-default" type="button" onclick="$('.details-info').slideToggle();">我要提供更完整的評分與資訊</button>
                </p>
                <div class="details-info">
                @foreach(config('review-fields') as $field)
                    <p>
                        {{ $field['label'] }}（選填）
                        <input name="review_{{ $field['key'] }}" type="number" step="1"  max="5" value="0"> / 5.0 ★
                    </p>
                @endforeach

                @foreach(config('info-fields') as $field)
                    <p>
                        {{ $field['label'] }}（選填）
                        <input name="info_{{$field['key']}}" type="text">
                    </p>
                @endforeach

                @if(config('nomadic.business-hours-enabled'))
                    營業時間（選填）<br>
                    <br>
                    @include('nomadicore::partial/business-hours-form', ['inputName' => 'business-hours'])

                    <br>
                    <br>
                    <br>
                @endif

                </div>

                <p>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary btn-lg btn-block">送出{{ config('nomadic.global.subject') }}資料</button>
                </p>
            </form>
        </div>
    </div>
</div>

<br>
<br>

@include('nomadicore::partial/_footer')

<style>
    .details-info {
        display: none;
    }
</style>
@endsection
