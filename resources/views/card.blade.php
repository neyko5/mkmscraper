@extends('layouts.main')

@section('content')
    <h1>{{$card->name}}</h1>
    <table class="table">
        <thead>
        <th>ID</th>
        <th>Price</th>
        </thead>
        @foreach($card->prices as $price)
            <tr>
                <td>{{$price->updated_at}}</td>
                <td>{{$price->trend}}</td>
                <td>{{$price->sellers}}</td>
            </tr>
        @endforeach
    </table>
    <div id="price_plot" style="height: 300px;"> </div>
    <script type="text/javascript">

        $(function() {
            var prices={!!$card->getChart() !!}
            priceData = [];
            for (var prop in prices) {
                priceData.push({label: prop, data:$.map(prices[prop], function(i,j){
                    return [[new Date(i[0],i[1]-1,i[2]).getTime(), i[3]]];
                })});
            }

            $.plot("#price_plot", priceData, {
                xaxis: { mode: "time", timeformat: "%d. %m. %Y" }
            });

        });

    </script>
@endsection