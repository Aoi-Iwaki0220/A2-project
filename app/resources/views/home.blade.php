@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <h3>もくひょう</h3>

                    @if  (!empty($goals))
                        <ul>
                                <p>
                                    {{ \Carbon\Carbon::parse($goals['date'])->format('Yねん nがつ j にち') }}までに
                                     <br>{{ $goals['amount'] }} 円ためる！
                                </p>
                        </ul>
                        <a href="{{ route('edit.goal', ['id' => $goals['id']]) }}">
                            <button type="button" class="btn btn-primary">へんしゅうする</button>
                        </a>
                    @else
                        <p>目標がまだ登録されていません</p>
                        <a href="{{ route('create.goal') }}">
                            <button type="button" class="btn btn-primary">きめる</button>
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
