@extends('layouts.main')

@section('content')
    <h1>Enter tournament</h1>
    {!! \Form::open(array("action"=>"EnterController@processTournament","method"=>"POST")) !!}
        <div class="form-group">
            <label for="name">Name of the event</label>
            <input type="text" name="name" class="form-control" placeholder="Name of the event">
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="text" name="date" class="form-control" placeholder="Date of the event">
        </div>
        <div class="checkbox">
            <label for="limited">
                <input type="checkbox" name="limited" > Limited
            </label>
        </div>
        <div class="form-group">
            <label for="date">Rank</label>
            <select name="rank"  class="form-control">
                <option value="1">1 - Pro Tours</option>
                <option value="2">2 - Grand Prix,Invitational</option>
                <option value="3">3 - SCG Open,RPTQ</option>
                <option value="4">4 - PPTQ,IQ,GPT</option>
            </select>
        </div>
        <button type="submit">Submit!</button>
    </div>

    <h2>Entered Tournaments</h2>
    <table class="table">
        <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Date</th>
        <th>Rank</th>
        <th>Limited</th>
        </thead>
        @foreach(\MkmScraper\Tournament::all() as $tournament)
            <tr>
                <td>{{$tournament->id}}</td>
                <td>{{$tournament->name}}</td>
                <td>{{$tournament->date}}</td>
                <td>{{$tournament->rank}}</td>
                <td><i class="glyphicon @if($tournament->limited) glyphicon-ok @else glyphicon-remove @endif"></i></td>
            </tr>
        @endforeach
    </table>
@endsection