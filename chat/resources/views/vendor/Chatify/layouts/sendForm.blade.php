<div class="messenger-sendCard">
<form id="message-form" method="POST" action="{{ route('send.message') }}" enctype="multipart/form-data">
    @csrf
    <label>
        <span class="fas fa-plus-circle"></span>
        <input disabled="disabled" type="file" class="upload-attachment" name="file" accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}}, .{{implode(', .',config('chatify.attachments.allowed_files'))}}" />
    </label>
    <button type="button" class="emoji-button"><span class="fas fa-smile"></span></button>
   
    @if(Auth::user()->role === 'team')
        <button type="submit" class="transferchat">  <img src="{{ asset('img/ic_chat_transfer.png') }}" alt="Chat transfer" width="25" height="25" /></span></button>
        <button type="submit" class="endchat"><span class="fas fa-exit"></span></button>
    @endif
    <textarea readonly="readonly" name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>
    <button disabled="disabled" type="submit" class="send-button"><span class="fas fa-paper-plane"></span></button>
</form>

<script src="{{ asset('js/chatify/chatify-sendform.js') }}?v={{ time() }}"></script>

</div>
