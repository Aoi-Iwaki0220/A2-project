@extends('layouts.app')

@section('content')
    <a href="{{route('calendar.index')}}">
        <button type="button">もどる</button>
    </a>
    <h3>【つかったお金】</h3>
    @forelse ($spend as $item)
        <div style="margin-bottom: 20px;">
            <p>いつ：{{ $item->date }}</p>
            <p>いくら：{{ number_format($item->amount) }}円</p>
            <p>なにを：{{ $item->type->name ?? '不明' }}</p>
            <p>メモ：{{ $item->comment ?? '-' }}</p>
        </div>
        <a href="{{ route('edit.spend', ['id' => $item->id]) }}">
            <button type="button">へんしゅうする</button>
        </a>
        <form action="{{route('delete.spend', ['id' =>$item['id']])}}" method="POST" onsubmit="return confirm('ほんとうに けしていい？')">
            @method('DELETE')
            @csrf
            <button type="submit">けす</button>
        </form>
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
        <a href="{{ route('edit.income', ['id' => $item->id]) }}">
            <button type="button">へんしゅうする</button>
        </a>
        <form action="{{route('delete.income', ['id' =>$item->id])}}" method="POST" onsubmit="return confirm('ほんとうに けしていい？')">
            @method('DELETE')
            @csrf
            <button type="submit">けす</button>
        </form>
    @empty
        <p>この日はお金をもらっていないよ</p>
    @endforelse
@endsection