@php($i = 0)
@foreach($charts as $chart)
    @if($chart->OriginalMail)
        @php($i++)
        @php($url = route("single_mail",["mail" => $chart->OriginalMail]))
        <a href="#" class="list-group-item list-group-item-action border-0 {{ $i == 1? 'first_convo' : '' }} class_{{ $chart->OriginalMail }}"  onclick="clicked('{{ $url }}')">
            <!-- <div class="badge bg-success float-right">{{ $chart->total_mail }}</div> -->
            <div class="d-flex align-items-start">
                <img src="https://ui-avatars.com/api/?name={{ $chart->OriginalMail }}" class="rounded-circle" alt="Vanessa Tucker" width="40" height="40">
                <div class="flex-grow-1 ml-3">
                   &nbsp;{{ $chart->OriginalMail }}
                    <!-- <div class="small"><span class="fas fa-circle chat-online"></span> Online</div> -->
                </div>
            </div>
        </a>
    @endif
@endforeach