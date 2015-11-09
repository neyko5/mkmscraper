@extends('layouts.main')

@section('content')
    <h1>Enter Article</h1>
    {!! \Form::open(array("action"=>"EnterController@processArticle","method"=>"POST")) !!}
    <div class="form-group">
        <label for="url">URL</label>
        <input type="text" name="url" class="form-control" placeholder="URL">
    </div>
    <div class="form-group">
        <label for="date">Rank</label>
        <select name="popularity"  class="form-control">
            <option value="1">1 - Very popular</option>
            <option value="2">2 - Popular</option>
            <option value="3">3 - Semi-popular</option>
            <option value="4">4 - Not very popular</option>
        </select>
    </div>
    <div class="form-group">
        <label for="date">Publisher</label>
        <select name="publisher"  class="form-control">
            <option value="1">1 - StarCityGames</option>
            <option value="2">2 - ChannelFireball</option>
            <option value="3">3 - BlackBorder</option>
            <option value="4">4 - Wizards</option>
            <option value="5">5 - TCG Player</option>
        </select>
    </div>
    <button type="submit">Submit!</button>
    </div>

    <h2>Entered Articles</h2>
    <table class="table">
        <thead>
        <th>ID</th>
        <th>Title</th>
        <th>Date</th>
        <th>Popularity</th>
        <th>Publisher</th>
        </thead>
        @foreach(\MkmScraper\Article::all() as $article)
            <tr>
                <td>{{$article->id}}</td>
                <td>{{$article->title}}</td>
                <td>{{$article->date}}</td>
                <td>{{$article->popularity}}</td>
                <td>{{$article->publisher()}}</td>
            </tr>
        @endforeach
    </table>
@endsection