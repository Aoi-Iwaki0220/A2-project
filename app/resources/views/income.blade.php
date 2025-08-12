@extends('layouts.app')
@section('content')
    <main>
        <h4>もらったお金</h4>
            <div class="card">
                @if($errors->any())  
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $message)
                            <li>{{ $message}}</li>
                        @endforeach
                    </div>
                @endif
            </div>
        <form action="{{route('create.income')}}" method="post">
            @csrf
            <label for="date">いつ？</label>
                <input type='date' class='form-control' name='date' value="{{old('date')}}"/>
            <label for="amount">何円(なんえん)？</label>
                <input type='text' class='form-control' name='amount' value="{{old('amount')}}"/>
            <label for="type">もらった りゆうは？</label>
                <select name='type_id' class='form-control'>
                    <option value='' hidden>カテゴリ</option>
                    @foreach($types as $type)
                        <option value="{{ $type['id'] }}" {{ old('type_id') == $type['id'] ? 'selected' : '' }}>{{ $type['name'] }}</option>
                    @endforeach
                </select>
            <label for='comment' class='mt-2'>メモ</label>
                <textarea class='form-control' name='comment' >{{old('comment')}}"</textarea>

            <button type="submit">とうろくする</button>
        </form>
    </main>
@endsection
