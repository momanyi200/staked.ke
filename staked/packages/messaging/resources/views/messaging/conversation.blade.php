@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Conversation</h4>

    <div id="messages-box" class="border rounded p-3 mb-1 bg-light" style="height:300px; overflow-y:auto;"></div>

    <div id="typing-indicator" class="text-muted mb-2" style="display:none; font-size:14px;">
        Someone is typing...
    </div>

    <form id="message-form" method="POST" action="{{ route('messaging.store', $conversation) }}">
        @csrf
        <div class="input-group">
            <input type="text" name="body" id="message-input" class="form-control" placeholder="Type a message..." required>
            <button class="btn btn-success" type="submit">Send</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .message-avatars img {
        margin-left: -8px;
        border: 2px solid #fff;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
    let fetchUrl = "{{ route('messaging.fetch', $conversation) }}";
    let storeUrl = "{{ route('messaging.store', $conversation) }}";
    let typingUrl = "{{ route('messaging.typing', $conversation) }}";
    let typingStatusUrl = "{{ route('messaging.typing.status', $conversation) }}";

    let messagesBox = $("#messages-box");
    let typingIndicator = $("#typing-indicator");

    function loadMessages() {
        $.get(fetchUrl, function (data) {
            messagesBox.html("");
            data.forEach(msg => {
                let isMine = msg.user_id === {{ auth()->id() }};
                let alignClass = isMine ? "text-end" : "text-start";
                let badgeClass = isMine ? "bg-primary" : "bg-secondary";
                let readReceipt = "";

                if (isMine) {
                    let readers = msg.readers.filter(r => r.id !== {{ auth()->id() }});
                    if (readers.length > 0) {
                        let avatars = readers.map(r => 
                            `<img src="${r.avatar_url}" class="rounded-circle" width="18" height="18" title="${r.name}">`
                        ).join(" ");
                        readReceipt = `<span class="ms-2 message-avatars">${avatars}</span>`;
                    } else {
                        readReceipt = `<span class="text-muted small">✓ Sent</span>`;
                    }
                }

                messagesBox.append(`
                    <div class="mb-2 ${alignClass}">
                        <strong>${msg.sender.name}</strong>: 
                        <span class="badge ${badgeClass}">${msg.body}</span>
                        ${readReceipt}
                    </div>
                `);
            });
            messagesBox.scrollTop(messagesBox[0].scrollHeight);
        });
    }

    function checkTyping() {
        $.get(typingStatusUrl, function (users) {
            if (users.length > 0) {
                typingIndicator.text(users.join(", ") + " is typing...").show();
            } else {
                typingIndicator.hide();
            }
        });
    }

    // Polling
    setInterval(loadMessages, 3000);
    setInterval(checkTyping, 2000);
    loadMessages();

    // Send message
    $("#message-form").submit(function (e) {
        e.preventDefault();
        $.post(storeUrl, $(this).serialize(), function () {
            $("#message-input").val("");
            loadMessages();
        });
    });

    // Typing event
    $("#message-input").on("input", function () {
        $.post(typingUrl, {_token: "{{ csrf_token() }}"});
    });
});
</script>
@endpush
