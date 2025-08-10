@extends('layouts.app')
@section('content')
<style>
  /* カレンダーの日付のリンクに対してスタイルを適用 */
  .fc-daygrid-day a {
    color: inherit !important;
    text-decoration: none !important;
    cursor: pointer;
    display: block; /* セル全体をクリック可能に */
    height: 100%;
  }

  .fc-daygrid-day a:hover {
    background-color: #e0e0e0 !important;
    color: #000 !important;
    text-decoration: none !important;
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
        <button type="button" onclick="location.href='{{ route('home')}}'">
            もどる
        </button>
    <!-- カレンダー表示用のdiv -->
    <div id="calendar" style="max-width: 70%; margin: 0 auto;"></div>
    @php
        $now = now(); // 現在時刻取得
        $year = $now->year;
        $month = $now->month;
    @endphp
        <a id="graph-link" href="#">
            <button type="button" >グラフにする</button>
        </a>
@endsection

@section('scripts')
<!-- JavaScript -->
<script src="{{ asset('index.global.min.js') }}"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var events = @json($events);

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'ja',  //日本語
      buttonText:{
        today: '今日(きょう)',
      },
      events: events,

      dateClick: function(info) {
        const date = info.dateStr;
        window.location.href = `/detail_calendar/${date}`;
      }
    });

    calendar.render();

    function updateGraphLink() {
      const date = calendar.view.currentStart;
      const year = date.getFullYear();
      const month = date.getMonth() + 1;
      document.getElementById('graph-link').href = `/graph/${year}/${month}`;
    }
    updateGraphLink();
    calendar.on('datesSet', updateGraphLink);
  });
</script>
@endsection
