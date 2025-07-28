@extends('layouts.app')
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
            <button type="button">しょうたいコードをつくる</button>
        </a>
        <a href="">
            <button type="button">へんしゅうする</button>
        </a>
    </div>
    <div style="background-color: #ccc; width: 200px; height: 200px; "></div>
    <div>
        <a href="{{route('create.spend')}}">
            <button type="button">つかったお金を <br>とうろくする</button>
        </a>
        <a href="{{route('create.income')}}">
            <button type="button">もらったお金を <br>とうろくする</button>
        </a>
    </div>


