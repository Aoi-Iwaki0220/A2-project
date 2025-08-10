@extends('layouts.app')
@section('content')
    <main>
        <button type="button" onclick="location.href='{{ route('child.mypage')}}'">
            とじる
        </button>
        <h4>とどいた メッセージ</h4>
        <nav class="card mt-5">
            @foreach ($messages as $message)
                <p>〇{{ $message->fromUser->nickname ?? '不明' }}:<{{ $message->message }}</p>
                <p>日にち：{{ $message->created_at->format('Y-m-d H:i') }}</p>
                @if (!($message->reads))
                    <form method="POST" action="{{ route('message.read', $message->id) }}">
                    @csrf
                        <button type="submit">よんだ！</button>
                    </form>
                @else
                    <span style="color: green;">よんだ</span>
                @endif
            @endforeach

        </nav>
    </main>
@endsection