@extends('layouts.main')

@section('content')
    <h1>Sets</h1>
    <table class="table">
        <thead>
            <th>ID</th>
            <th>Set title</th>
            <th>Release</th>
            <th>Days from release</th>
            <th>Days from rotation</th>
        </thead>
        @foreach(\MkmScraper\Set::all() as $set)
        <tr>
            <td>{{$set->id}}</td>
            <td><a href="/set/{{$set->id}}">{{$set->name}}</a></td>
            <td>{{$set->release}}</td>
            <td>{{$set->daysFromRelease()}}</td>
            <td>{{$set->daysFromRotation()}}</td>
        </tr>
        @endforeach
    </table>
@endsection