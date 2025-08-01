@extends('layouts.app')

@section('content')
<div id="calendar" style="max-width: 55%; "></div>
<h4>あかは「つかったお金」/あおは「もらったおかね」</h4>

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
                    @if  (!empty($goal))
                        <ul>
                            <p>
                                {{ \Carbon\Carbon::parse($goal->date)->format('Y年 n月 j 日') }}までに
                                <br>{{ $goal->amount }} 円ためる！
                            </p>
                        </ul>
                        <a href="{{ route('edit.goal', ['id' => $goal->id]) }}">
                            <button type="button">へんしゅうする</button>
                        </a>
                    @else
                        <p>もくひょうは まだ きめていないよ</p>
                        <a href="{{ route('create.goal') }}">
                            <button type="button" >きめる</button>
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('index.global.min.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var events = @json($events);  // コントローラーから渡されたイベントデータ

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ja',
            buttonText: { today: '今日(きょう)' },

             headerToolbar: {
            left: 'title',
            center: 'addEventButton',
  },

            customButtons: {
                addEventButton: {
                    text: 'くわしく見る',
                    click: function() {
                    window.location.href = "{{ route('calendar.index') }}";
                    }
                }
            },
            events: events,
        });
        

        calendar.render();
    });
    </script>
@endsection

