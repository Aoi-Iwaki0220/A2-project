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

                    @if (count($goals) > 0)
                        <ul>
                            @foreach ($goals as $goal)
                                <p>
                                    {{ $goal['date'] }}までに
                                     <br>{{ $goal['amount'] }} 円ためる！
                                </p>
                            @endforeach
                        </ul>
                    @else
                        <p>目標がまだ登録されていません。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
