@extends('layouts.app')

@section('content')
<style>
  /* カレンダーの日付のリンクに対してスタイルを適用 */
  .fc-daygrid-day a {
    color: inherit !important;
    text-decoration: none !important;
    height: 100%;
  }

  .fc-col-header-cell-cushion {
    cursor: default !important;
    color:rgb(0, 0, 0) !important; 
    font-weight: bold;
}

  .fc-col-header-cell a,
  .fc-col-header-cell[role="link"] {
    text-decoration: none !important;
    cursor: default !important;
    color: inherit !important;
  }
</style>
    @if (session('user_type') === 'child')
        @if (!empty($unread) && $unread > 0)
            <div class="alert alert-warning text-center mt-3">
                <a href="{{ route('message.list') }}" class="text-dark fw-bold" style="text-decoration: none;">
                    メッセージがとどいているよ！
                </a>
            </div>
        @else
            <p>よんでいないメッセージはないよ</p>
        @endif
    @endif
    <div id="calendar" style="max-width: 55%; "></div>
    <h4>あかは「つかったお金」/あおは「もらったおかね」</h4>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                        <h3>もくひょう</h3>
                            @if  (!empty($goal))
                                <ul>
                                    <p>
                                        {{ \Carbon\Carbon::parse($goal->date)->format('Y年 n月 j 日') }}までに
                                        <br>{{ $goal->amount }} 円ためる！
                                    </p>
                                    @if ($goal)
                                        @if ($remaining === 0)
                                            <p style="color: green; font-weight: bold; font-size: 20px;">
                                                🎉 もくひょうたっせい！おめでとう！ 🎉
                                            </p>
                                        @else
                                            <p>いまは {{ $nowAmount }} 円たまっているよ！</p>
                                            <p>もくひょうまで あと {{ $remaining }} 円だよ！</p>
                                        @endif
                                    @endif
                                </ul>
                                @if (session('user_type') === 'child')
                                    <button type="button" onclick="location.href='{{ route('edit.goal', ['id' => $goal->id])}}'">
                                        へんしゅうする
                                    </button>
                                 @endif
                            @else
                                <p>もくひょうは まだ きめていないよ</p>
                                @if (session('user_type') === 'child')
                                    <button type="button" onclick="location.href='{{ route('create.goal')}}'">
                                        きめる
                                    </button>
                                @endif
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

