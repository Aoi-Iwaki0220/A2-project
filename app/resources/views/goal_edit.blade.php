@extends('layouts.app')
@section('content')
    <main>
        <h4>もくひょうをかえる？けす？</h4>
            <div class="card">
                @if($errors->any())  
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $message)
                            <li>{{ $message}}</li>
                        @endforeach
                    </div>
                @endif
            </div>
        <form action="{{ route('edit.goal', ['id' => $result->id])}}" method="post">
            @csrf
            <label for="date">いつ？</label>
                <input type='date' class='form-control' name='date'  value="{{$result['date']}}"/>までに
            <label for="amount">何円(なんえん)？</label>
                <input type='text' class='form-control' name='amount' value="{{$result['amount']}}"/>円 ためる！

            <button type="submit">かえる</button>
        
        </form>
        <form action="{{route('delete.goal', ['id' =>$result['id']])}}" method="POST" onsubmit="return confirm('ほんとうに けしていい？')">
            @method('DELETE')
            @csrf
            <button type="submit">けす</button>
        </form>
    </main>
@endsection