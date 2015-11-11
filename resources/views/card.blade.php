@extends('layouts.main')

@section('content')
    <h1>{{$card->name}}</h1>
    <table class="table">
        <thead>
        <th>ID</th>
        <th>Sell</th>
        <th>Date</th>
        <th>Percentage</th>
        <th>Last Week</th>
        <th>Last Two Week</th>
        <th>Last Three Week</th>
        <th>Article Percentage</th>
        <th>Article Last Week</th>
        <th>Article Last Two Week</th>
        <th>Article Last Three Week</th>
        <th>Change set 1 day</th>
        <th>Change set 1 week</th>
        <th>Boosters open</th>
        </thead>
        @foreach($card->graphPrices as $price)
            <tr>
                <td>{{$price->id}}</td>
                <td>{{$price->sell}}</td>
                <td>{{$price->date}}</td>
                <td>{{$price->tournamentPercentage()}}</td>
                <td>{{$price->tournamentLastWeek()}}</td>
                <td>{{$price->tournamentLastTwoWeek()}}</td>
                <td>{{$price->tournamentLastThreeWeek()}}</td>
                <td>{{$price->articles()}}</td>
                <td>{{$price->articlesLastWeek()}}</td>
                <td>{{$price->articlesLastTwoWeek()}}</td>
                <td>{{$price->articlesLastThreeWeek()}}</td>
                <td>{{$price->otherCardMovementDay()}}</td>
                <td>{{$price->otherCardMovementWeek()}}</td>
                <td>{{$price->boostersOpen()}}</td>
            </tr>
        @endforeach
    </table>
    <div id="price_plot" style="height: 300px;"> </div>
    <script type="text/javascript">

        $(function() {
            var prices={!!$card->getChart() !!}
            priceData = [];
            for (var prop in prices) {
                if(prop=="sellers"){
                    axis=2;
                }
                else{
                    axis=1;
                }
                priceData.push({label: prop,yaxis:axis, data:$.map(prices[prop], function(i,j){
                    return [[new Date(i[0],i[1]-1,i[2]).getTime(), i[3]]];
                })});
            }

            $.plot("#price_plot", priceData, {
                xaxis: { mode: "time", timeformat: "%d. %m. %Y" },
                yaxes: [ { min: 0 }, {
                    // align if we are to the right
                    alignTicksWithAxis:1,
                    position: "right",
                } ],
            });

        });

    </script>
@endsection