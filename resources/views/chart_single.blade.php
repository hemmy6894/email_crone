@foreach($charts as $chart)
    <div class="row">
        @if($chart->MessageStream == "inbound")
            <div class="col-6"></div>
        @endif
            <div class="col-6 {{ $chart->MessageStream }}">{{ $chart->TextBody }}</div>
        @if($chart->MessageStream == "outbound")
            <div class="col-6"></div>
        @endif
    </div>
@endforeach