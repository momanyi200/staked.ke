@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Journal Calendar</h1>
    <div id="calendar"></div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            @foreach($journals as $journal)
            {
                title: @json(Str::limit($journal->summary, 20)),
                start: @json($journal->date),
                url: "{{ route('journals.show', $journal->id) }}",
            },
            @endforeach
        ]
    });

    calendar.render();
});
</script>
@endsection
