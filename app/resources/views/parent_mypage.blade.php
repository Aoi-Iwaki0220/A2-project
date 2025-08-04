@extends('layouts.app')
@section('content')
    <div class=profile style="display: flex; align-items: center;">
        <div style="border-radius: 50%; background-color: #ccc; width: 80px; height: 80px; "></div>
        <div>
            <h4>ユーザー名</h4>
                <span style="color:#eee;">未登録</span>
            <h4>ニックネーム</h4>
                <span style="color:#eee;">未登録</span>
        </div>
        <div>
            <h4>プロフィール</h4>
                <span style="color:#eee;">未登録</span>
        </div>
    </div>
        <div>
            <a href="">
                <button type="button">編集する</button>
            </a>
        </div>
        <div>
            <a href="">
                <button type="button">メッセージを送る</button>
            </a>
            <button type="button" onclick="location.href='{{route('invitation')}}'">
                招待コード入力
            </button>
        </div>
@endsection


