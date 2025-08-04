@extends('layouts.app')

@section('content')
    <button type="button" onclick="location.href='{{ route('calendar.index')}}'">
        もどる
    </button>

    <h3>【つかったお金】</h3>
    @forelse ($spend as $item)
        <div style="margin-bottom: 20px;">
            <p>いつ：{{ $item->date }}</p>
            <p>いくら：{{ number_format($item->amount) }}円</p>
            <p>なにを：{{ $item->type->name ?? '不明' }}</p>
            <p>メモ：{{ $item->comment ?? '-' }}</p>
        </div>

        @if (session('user_type') === 'child')
            <button type="button" onclick="location.href='{{ route('edit.spend', ['id' => $item->id])}}'">
            へんしゅうする
            </button>
            <form action="{{route('delete.spend', ['id' =>$item['id']])}}" method="POST" onsubmit="return confirm('ほんとうに けしていい？')">
                @method('DELETE')
                @csrf
                <button type="submit">けす</button>
            </form>
        @endif
    @empty
        <p>この日はお金をつかっていないよ</p>
    @endforelse

    <h3>【もらったお金】</h3>
    @forelse ($income as $item)
        <div style="margin-bottom: 20px;">
            <p>いつ：{{ $item->date }}</p>
            <p>いくら：{{ number_format($item->amount) }}円</p>
            <p>なにを：{{ $item->type->name ?? '不明' }}</p>
            <p>メモ：{{ $item->comment ?? '-' }}</p>
        </div>

        @if (session('user_type') === 'child')
            <button type="button" onclick="location.href='{{ route('edit.income', ['id' => $item->id])}}'">
            へんしゅうする
            </button>
            <form action="{{route('delete.income', ['id' =>$item->id])}}" method="POST" onsubmit="return confirm('ほんとうに けしていい？')">
                @method('DELETE')
                @csrf
                <button type="submit">けす</button>
            </form>
        @endif
    @empty
        <p>この日はお金をもらっていないよ</p>
    @endforelse
@endsection