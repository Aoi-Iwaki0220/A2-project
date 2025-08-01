@extends('layouts.app')

<!-- カレンダー表示用のdiv -->
<div id="calendar" style="max-width: 70%; margin: 0 auto;"></div>

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
  });
</script>
@endsection