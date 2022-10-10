<div class="py-2 px-4 border-bottom d-none d-lg-block">
    <div class="d-flex align-items-center py-1">
        <div class="position-relative">
            <img src="https://ui-avatars.com/api/?name={{ $mail }}" class="rounded-circle mr-1" alt="{{ $mail }}" width="40" height="40">
        </div>
        <div class="flex-grow-1 pl-3">
            <strong>{{ $mail }}</strong>
        </div>
    </div>
</div>

<div class="position-relative">
    <div class="chat-messages p-4">
        @foreach($charts as $chart)
            @php($sms = nl2br($chart->TextBody))
            @php($sms = trim(str_replace('\\r\\n',"     <br />",$sms)))
            @if($chart->MessageStream == "inbound" && $sms != null)
                <div class="chat-message-left mb-4">
                    <div>
                        <img src="https://ui-avatars.com/api/?name={{ $chart->OriginalMail }}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                        <div class="text-muted small text-nowrap mt-2">{{ $chart->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                        <div class="font-weight-bold mb-1">{{ $chart->OriginalMail }}</div>
                        <h4> <b>{!! $chart->Subject !!}</b></h4>
                        {!! $sms !!}
                    </div>
                </div>
            @endif
            @if($chart->MessageStream == "outbound" && $sms != null)
                <div class="chat-message-right pb-4">
                    <div>
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                        <div class="text-muted small text-nowrap mt-2">{{ $chart->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                        <div class="font-weight-bold mb-1">You</div>
                        <h4> <b>{!! $chart->Subject !!}</b></h4>
                        {!! $sms !!}
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<div class="flex-grow-0 py-3 px-4 border-top">
    <div class="input-group">
        <textarea type="text" class="form-control message" placeholder="Type your message ..." rows="4"></textarea>
        <input type="hidden" value="{{ $mail }}" class="mail">
        <button class="btn btn-primary sendMessage">Send</button>
    </div>
</div>