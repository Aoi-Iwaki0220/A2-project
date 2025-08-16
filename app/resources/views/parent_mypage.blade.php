@extends('layouts.app')
@section('content')
    <div class=profile style="display: flex; align-items: center;">
        @if (!empty($parent->image))
            <img src="{{ asset($parent->image) }}" alt="アイコン" style="width:20%; height:20%; border-radius:50%;">
        @else
            <img src="character1.png"  style="width:20%; height:20%; border-radius:50%;">
        @endif
        @if (session('success'))
            <script>
                window.addEventListener('DOMContentLoaded', function () {
                    alert(@json(session('success')));
                });
            </script>
        @endif
        <div>
            <h4>ユーザー名</h4>
                <span>{{ $parent->name ?? '未登録'}}</span>
            <h4>ニックネーム</h4>
                <span>{{ $parent->nickname ?? '未登録'}}</span>
        </div>
        <div>
            <h4>プロフィール</h4>
                <span>{{ $parent->profile ?? '未登録'}}</span>
        </div>
    </div>
    @php
    $isAdmin = auth()->guard('admin')->check();
    @endphp
        @if(!$isAdmin)
        <button type="button" onclick="location.href='{{ route('edit.parent')}}'">
            編集する
        </button>
        <div>
            <button type="button" onclick="location.href='{{ route('send.message')}}'">
                メッセージを送る
            </button>
            <button type="button" onclick="location.href='{{route('invitation')}}'">
                招待コード入力
            </button>
        </div>
        @endif
        <nav class="card mt-4">
            <div class="card-body">
                <h3>こどもの情報</h3>
                @if (isset($child) && $child)
                    <img src="{{ $child->image ? asset($child->image) : asset('character1.png') }}" alt="アイコン" style="width:20%; height:20%; border-radius:50%;">
                    <p>ニックネーム: {{ $child->nickname }}</p>
                    <p>お小遣い合計: {{$nowAmount }}円</p>
                    @if(!$isAdmin)
                    <form action="{{route('unlink.child')}}" method="POST" onsubmit="return confirm('紐づけを解除しますか？');">
                        @csrf
                        <button type="submit">紐づけを解除する</button>
                    </form>
                    @endif
                @else
                    <p>紐づいた子どもはいません</p>
                @endif
            </div>
        </nav>
    

@endsection


