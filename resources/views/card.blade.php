@extends('layouts.main')

@section('content')
    <h1>{{$card->name}}</h1>
    <table class="table">
        <thead>
        <th>Date</th>
        <th>Low Price</th>
        <th>Single Price</th>
        <th>Single Price Low</th>
        <th>Price</th>
        <th>Sell</th>
        <th>Tour</th>
        <th>Tour Diff</th>
        <th>Articles</th>
        <th>Articles total</th>


        </thead>
        @foreach($card->getMovementData() as $price)
            <tr>
                <td>{{$price['date']}}</td>
                <td>{{$price['lowprice']}}</td>
                <td>{{$price['singleprice']}}</td>
                <td>{{$price['lowsingleprice']}}</td>
                <td>{{$price['price']}}</td>
                <td>{{$price['sell']}}</td>
                <td>{{$price['tour']}}</td>
                <td>{{$price['tourdiff']}}</td>
                <td>{{$price['art']}}</td>
                <td>{{$price['arttot']}}</td>
            </tr>
        @endforeach
    </table>
    <div id="price_plot" style="height: 300px;"> </div>


    <table class="table">
        <thead>
        <th>Date</th>
        <th>Copies</th>
        <th>Place</th>
        <th>Event</th>

        </thead>
        @foreach($card->decklistAppearances as $appearance)
            <tr>
                <td>{{$appearance->event->date}}</td>
                <td>{{$appearance->number}}</td>
                <td>{{$appearance->place}}</td>
                <td>{{$appearance->event->name}}</td>
            </tr>
        @endforeach
    </table>
    <script type="text/javascript">

        $(function() {
            var prices={!!$card->getMovement() !!}
            priceData = [];
            for (var prop in prices) {
                if(prop=="sell"){
                    axis=1;
                }
                else{
                    axis=2;
                }
                priceData.push({label: prop,yaxis:axis, data:$.map(prices[prop], function(i,j){
                    return [[new Date(i[0],i[1]-1,i[2]).getTime(), i[3]]];
                })});
            }

            $.plot("#price_plot", priceData, {
                xaxis: { mode: "time", timeformat: "%d. %m. %Y" },
                yaxes: [  {
                    // align if we are to the right
                    alignTicksWithAxis:1,
                    position: "right",
                } ],
            });

        });
        $(document).ready(function() {
            $('.table').DataTable({
                "bPaginate": false
            });
        } );

    </script>
@endsection