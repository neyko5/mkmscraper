@extends('layouts.main')

@section('content')
    <h1>Set</h1>
    <div>Price: {{$set->averageBooster()}}</div>
    <table class="table">
        <thead>
        <th>ID</th>
        <th>Set title</th>
        </thead>
        @foreach($cards as $card)
            <tr>
                <td>{{$card->id}}</td>
                <td><a href="/card/{{$card->id}}">{{$card->name}}</a></td>
            </tr>
        @endforeach
    </table>
@endsection