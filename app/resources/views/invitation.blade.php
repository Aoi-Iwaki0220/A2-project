@extends('layouts.app')
@section('content')
    <main>
        <h4>こどもと繋がる</h4>
        <h4>こどもと繋ぐための招待コードを入力してください。</h4>
        <h5>招待コードはこどものマイページから発行できます。</h5>
        <form action="{{route('invitation')}}" method="POST" >
            @csrf
            <label for="text" name="invite_code">招待コードを入力</label>
                <input type='text' class='form-control' name='invite_code' />
                @if ($errors->has('invite_code'))
                    <div class="alert alert-danger">
                        {{ $errors->first('invite_code') }}
                    </div>
                @endif
            <button type="submit">繋ぐ</button>
        </form>
    </main>
@endsection
