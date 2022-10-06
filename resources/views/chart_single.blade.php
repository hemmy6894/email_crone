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
            @if($chart->MessageStream == "inbound")
                <div class="chat-message-right mb-4">
                    <div>
                        <img src="https://ui-avatars.com/api/?name={{ $chart->OriginalMail }}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                        <div class="text-muted small text-nowrap mt-2">{{ $chart->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                        <div class="font-weight-bold mb-1">You</div>
                        {!! nl2br($chart->TextBody) !!}
                    </div>
                </div>
            @endif
            @if($chart->MessageStream == "outbound")
                <div class="chat-message-left pb-4">
                    <div>
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                        <div class="text-muted small text-nowrap mt-2">{{ $chart->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                        <div class="font-weight-bold mb-1">{{ $chart->OriginalMail }}</div>
                        {!! nl2br($chart->TextBody) !!}
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<div class="flex-grow-0 py-3 px-4 border-top">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Type your message">
        <button class="btn btn-primary">Send</button>
    </div>
</div>