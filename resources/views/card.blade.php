@extends('layouts.main')

@section('content')
    <h1>{{$card->name}}</h1>
    <table class="table">
        <thead>
        <th>ID</th>
        <th>Sell</th>
        <th>Date</th>

        </thead>
        @foreach($card->graphPrices as $price)
            <tr>
                <td>{{$price->id}}</td>
                <td>{{$price->sell}}</td>
                <td>{{$price->date}}</td>

            </tr>
        @endforeach
    </table>
    <div id="price_plot" style="height: 300px;"> </div>
    <script type="text/javascript">

        $(function() {
            var prices={!!$card->getMovement() !!}
            priceData = [];
            for (var prop in prices) {
                if(prop=="low"){
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