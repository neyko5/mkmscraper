@extends('layouts.main')

@section('content')
    <h2>Wizards decklist scraping</h2>
    {!! \Form::open(array("action"=>"ScrapeController@processWizards","method"=>"POST")) !!}
    <div class="form-group">
        <label>Urls</label>
        @for($i=1;$i<9;$i++)
            <input type="text" name="url_{{$i}}" class="form-control" placeholder="URL {{$i}}">
        @endfor
    </div>
    <div class="form-group">
        <label for="date">Name of the event</label>
        <input type="text" name="name" class="form-control" placeholder="Name of the event">
    </div>
    <div class="form-group">
        <label for="date">Date</label>
        <input type="text" name="date" class="form-control" placeholder="Date of the event">
    </div>
    <div class="form-group">
        <label for="date">Rank</label>
        <select name="rank"  class="form-control">
            <option value="1">1 - Pro Tours</option>
            <option value="2">2 - Grand Prix</option>
            <option value="3">3 - SCG Open,RPTQ</option>
            <option value="4">4 - PPTQ,IQ,GPT</option>
        </select>
    </div>
    <button type="submit">Submit!</button>
@endsection                                                                                                                                                                                                                                                                                                             