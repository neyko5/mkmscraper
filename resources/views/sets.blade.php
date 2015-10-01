@extends('layouts.main')

@section('content')
    <h1>Sets</h1>
    <table class="table">
        <thead>
            <th>ID</th>
            <th>Set title</th>
            <th>Release</th>
        </thead>
        @foreach(\MkmScraper\Set::all() as $set)
        <tr>
            <td>{{$set->id}}</td>
            <td><a href="/set/{{$set->id}}">{{$set->name}}</a></td>
            <td>{{$set->release}}</td>
        </tr>
        @endforeach
    </table>
@endsection