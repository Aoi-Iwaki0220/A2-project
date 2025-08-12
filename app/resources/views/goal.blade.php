@extends('layouts.app')
@section('content')
    <main>
        <h4>もくひょうをきめよう</h4>
        
            <div class="card">
                @if($errors->any())  
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $message)
                            <li>{{ $message}}</li>
                        @endforeach
                    </div>
                @endif
            </div>
        <form action="{{ route('create.goal')}}" method="post">
            @csrf
            <label for="date">いつ？</label>
                <input type='date' class='form-control' name='date' />までに
            <label for="amount">何円(なんえん)？</label>
                <input type='text' class='form-control' name='amount' />円 ためる！

            <button type="submit">きめた</button>
        </form>
    </main>
@endsection
