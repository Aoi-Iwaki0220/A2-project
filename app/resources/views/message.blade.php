@extends('layouts.app')
@section('content')
    <main>
        <h4>メッセージを送る</h4>
        <nav class="card mt-5">
            <form action="{{route('send.message')}}" method="post">
                @csrf
                @if ($child)
                    <label for="to_user_id">送り先</label>
                        <p>{{ $child->name }}</p>
                        <input type="hidden" class='form-control' name="to_user_id" value="{{ $child->id }}" />
                    <label for='message' class='mt-2'>メッセージ</label>
                        <textarea class='form-control' name='message' required></textarea>
                @else
                    <p>送る相手がいません</p>
                @endif

                <button type="submit">送る</button>
            </form>
        </nav>
            <p>これまでに送ったメッセージ</p>
                @foreach ($messages as $message)
                    <p>〇日付：{{ $message->created_at->format('Y-m-d H:i') }}:<{{ $message->message }}</p>
                    @php
                       $childId = $child->id ?? null; // 念のため nullチェック
                        $read = $message->getReadInfoByUser($childId);
                    @endphp
                    @if ($message->isReadByUser($childId))
                        <span style="color: green;">既読</span>
                    @else
                        <span style="color: red;">未読</span>
                    @endif
                @endforeach
    </main>
@endsection