@foreach($charts as $chart)
    @if($chart->OriginalMail)
        @php($url = route("single_mail",["mail" => $chart->OriginalMail]))
        <a href="#" class="list-group-item list-group-item-action border-0" onclick="clicked('{{ $url }}')">
            <!-- <div class="badge bg-success float-right">{{ $chart->total_mail }}</div> -->
            <div class="d-flex align-items-start">
                <img src="https://ui-avatars.com/api/?name={{ $chart->OriginalMail }}" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">&nbsp;&nbsp;
                <div class="flex-grow-1 ml-3">
                    {{ $chart->OriginalMail }}
                    <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                </div>
            </div>
        </a>
    @endif
@endforeach