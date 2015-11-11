@extends('layouts.main')

@section('content')
    <h1>Set</h1>
    <a href="/export/set/{{$set->id}}">Export</a>
    <table class="table">
        <thead>
        <th>ID</th>
        <th>Set title</th>
        <th>Export</th>
        <th>Percentage</th>
        <th>Last Week</th>
        <th>Last Two Week</th>
        <th>Last Three Week</th>
        <th>Article Percentage</th>
        <th>Article Last Week</th>
        <th>Article Last Two Week</th>
        <th>Article Last Three Week</th>
        </thead>
        @foreach($cards as $card)
            <tr>
                <td>{{$card->id}}</td>
                <td><a href="/card/{{$card->id}}">{{$card->name}}</a></td>
                <td><a href="/export/card/{{$card->id}}">Export card</a></td>
                <td>{{$card->tournamentPercentage()}}</td>
                <td>{{$card->tournamentLastWeek()}}</td>
                <td>{{$card->tournamentLastTwoWeek()}}</td>
                <td>{{$card->tournamentLastThreeWeek()}}</td>
                <td>{{$card->articles()}}</td>
                <td>{{$card->articlesLastWeek()}}</td>
                <td>{{$card->articlesLastTwoWeek()}}</td>
                <td>{{$card->articlesLastThreeWeek()}}</td>
            </tr>
        @endforeach
    </table>
@endsection