@extends('layouts.main')

@section('content')
    <h1>Sets</h1>
    <table class="table">
        <thead>
            <th>ID</th>
            <th>Set title</th>
            <th>Release</th>
            <th>Average booster</th>
            <th>Average booster Rares</th>
        </thead>
        @foreach(\MkmScraper\Set::all() as $set)
        <tr>
            <td>{{$set->id}}</td>
            <td><a href="/set/{{$set->id}}">{{$set->name}}</a></td>
            <td>{{$set->release}}</td>
            <td>{{$set->averageBooster()}}</td>
            <td>{{$set->averageBoosterRare()}}</td>
        </tr>
        @endforeach
    </table>
@endsection