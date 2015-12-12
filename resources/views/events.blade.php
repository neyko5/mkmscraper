@extends('layouts.main')

@section('content')
    <h1>Sets</h1>
    <table class="table">
        <thead>
        <th>ID</th>
        <th>Date</th>
        <th>Name</th>
        <th>Rank</th>
        </thead>
        @foreach(\MkmScraper\Event::orderBy("date","ASC")->get() as $event)
            <tr>
                <td>{{$event->id}}</td>
                <td><a href="/event/{{$event->id}}">{{$event->name}}</a></td>
                <td>{{$event->date}}</td>
                <td>{{$event->rank}}</td>
            </tr>
        @endforeach
    </table>
@endsection