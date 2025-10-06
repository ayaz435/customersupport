<?php
$seenIcon = (!!$seen ? 'check-double' : 'check');
$timeAndSeen = "<span data-time='$created_at' class='message-time'>
        ".($isSender ? "<span class='fas fa-$seenIcon' seen'></span>" : '' )." <span class='time'>$timeAgo</span>
    </span>";
    $dummyMessageContent = "Please wait for a while"; // Adjust content as needed

    $asdf=$created_at;
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<!-- Include jsPDF -->

<div  class="message-card @if($isSender) mc-sender @endif" data-id="{{ $id }}">

    @php
    $uid=$id
    @endphp<input id="uid" type="text" value="{{$uid}}" hidden>
    {{-- Delete Message Button --}}
    @if ($isSender)
        <div class="actions">
           
        </div>
    @endif
    {{-- Card --}}
    <div class="message-card-content" >
        
        @if (@$attachment->type != 'image' && @$attachment->type != 'video' || $message)
    @if(Auth::user()->role === 'team' || Auth::user()->role === 'service')
    @if ($message !== "We’re still connecting you with one of our support team members. Thank you for your patience, and we’ll be with you shortly!" && $message !== "We sincerely apologize for the delay. Our team is currently assisting other customers, but you’re important to us and we’ll respond as soon as possible. Thank you for waiting." && $message !== "We truly appreciate your patience. Our support team is still working to get to your query. If you’d prefer, you can leave your message and contact details — we’ll get back to you as soon as we can.")
            <div class="message" >

{!! ($message == null && $attachment != null && @$attachment->type != 'file') ? $attachment->title : nl2br($message) !!} 
                {!! $timeAndSeen !!}
                @if ($message == 'Do you want to end chat')
             
                <button class="btn btn-danger" style="font-size:10px" onclick="confirmEndChat()">Yes</button>
                <button class="btn btn-secondary" style="font-size:10px">No</button>
                @endif
                {{-- If attachment is a file --}}
                @if(@$attachment->type == 'file')
                    <a href="{{ route(config('chatify.attachments.download_route_name'), ['fileName'=>$attachment->file]) }}" class="file-download">
                        <span class="fas fa-file"></span> {{$attachment->title}}</a>
                @endif
            </div>
              @endif
               @elseif(Auth::user()->role === 'user') 
                 <div class="message" >
   
                {!! ($message == null && $attachment != null && @$attachment->type != 'file') ? $attachment->title : nl2br($message) !!}
                {!! $timeAndSeen !!}
                {{-- If attachment is a file --}}
                @if(@$attachment->type == 'file')
                    <a href="{{ route(config('chatify.attachments.download_route_name'), ['fileName'=>$attachment->file]) }}" class="file-download">
                        <span class="fas fa-file"></span> {{$attachment->title}}</a>
                @endif
            </div>
                @endif
        @endif
        @if(@$attachment->type == 'image')
            <div class="image-wrapper" style="text-align: {{$isSender ? 'end' : 'start'}}">
                <div class="image-file chat-image" style="background-image: url('{{ 'https://xlserp.com/customersupport/chat/storage/app/public/attachments/' . $attachment->file }}')">
                    <div>{{ $attachment->title }}</div>
                </div>
                <div style="margin-bottom:5px">
                    {!! $timeAndSeen !!}
                </div>
            </div>
        @endif
        @if(@$attachment->type == 'video')
            <div class="video-wrapper" style="text-align: {{$isSender ? 'end' : 'start'}}">
                <video width="320" height="240" controls>
                    <source src="{{ Chatify::getAttachmentUrl($attachment->file) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div style="margin-bottom:5px">
                    {!! $timeAndSeen !!}
                </div>
            </div>
        @endif
    </div>
</div>


<input id="startdate" type="text" value="{{$asdf}}" hidden>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>
    async function captureAndSendPDF() {
        
        
    // const { jsPDF } = window.jspdf; // Access jsPDF from the module
    // const messagesDiv = document.querySelector('.messages');
    // const createdAt = document.getElementById("startdate").value;
    // const uid = document.getElementById("uid").value;
    


    // Use html2canvas to take a screenshot of the messages div
    // html2canvas(messagesDiv).then(async (canvas) => {
    //     const imgData = canvas.toDataURL('image/png');
    //     const pdf = new jsPDF();

    //     // Add the image to the PDF (full page)
    //     const imgWidth = pdf.internal.pageSize.getWidth();
    //     const imgHeight = (canvas.height * imgWidth) / canvas.width;
    //     pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

    //     // Convert PDF to Blob
    //     const pdfBlob = pdf.output('blob');

    //     // Prepare FormData
    //     const formData = new FormData();
    //     formData.append('pdf', pdfBlob, 'chat.pdf');
    //     formData.append('created_at', createdAt); // Start date
    //     formData.append('current_date', new Date().toISOString());
    //     formData.append('uid', uid); // Team value
      
        // Current date and time
         const formData = new FormData();
        const customerId = getMessengerId();
        formData.append('client_id',customerId);

        // Send the PDF to the backend
       fetch('{{ route('chatsummary') }}',  {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        title: '✔ Chat summary sent successfully!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } else {
                    Swal.fire({
                        title: '❌ Failed to send chat!',
                        text: data.message,
                        icon: 'error',
                    });
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                Swal.fire({
                    title: '❌ Error occurred!',
                    text: 'Could not send the chat summary.',
                    icon: 'error',
                });
            });
    // });
}

function confirmEndChat() {
    // Show the confirmation alert
    Swal.fire({
        title: 'Are you sure?',
        text: 'It will remove the whole chat. Please confirm do you want to end the chat.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // If 'Yes' is clicked, capture the screenshot and send the PDF
            captureAndSendPDF();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // If 'No' is clicked
            Swal.close();
        }
    });
}

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var message = "<?php echo $message; ?>"; // Get the message from PHP
        var messageContainer = document.querySelector(".message");

        if (message === 'Please wait, a team member is busy. You will receive a reply soon.') {
            messageContainer.remove(); // Remove the message container
        }
    });
</script>