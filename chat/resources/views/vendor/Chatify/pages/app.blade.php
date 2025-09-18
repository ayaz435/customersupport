@include('Chatify::layouts.headLinks') 
<style>.toaster {
    position: fixed;
    top: 20px; /* Adjust position as needed */
    right: -100%; /* Initially, it is hidden off the screen */
    background-color: #4CAF50;
    color: white;
    padding: 15px;
    border-radius: 5px;
    z-index: 9999;
    transition: right 0.5s ease; /* Smooth transition when showing/hiding */
    }

    .toaster.visible {
        right: 20px; /* Adjust position as needed */
    }
</style>


    {{-- Add this before closing body --}}
    <script>
        window.addEventListener("beforeunload", function () {
            navigator.sendBeacon("/chatify/user-leaving", JSON.stringify({
                _token: document.querySelector('meta[name="csrf-token']").getAttribute('content')
            }));
        });

        document.addEventListener("visibilitychange", function () {
            if (document.hidden) {
                navigator.sendBeacon("/chatify/user-leaving", JSON.stringify({
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }));
            } else {
                navigator.sendBeacon("/chatify/user-active", JSON.stringify({
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }));
            }
        });
    </script>
<div class="messenger">
   
    {{-- ----------------------Users/Groups lists side---------------------- --}}
    <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
        {{-- Header and search bar --}}
        <div class="m-header">
            <nav>
                <a href="#"><img  class="mx-2" src="{{asset('img/logo.png')}}" width="40%" alt="" > </a>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav><div id="toaster" class="toaster hidden">
    <p id="toasterMessage"></p>
</div>
            {{-- Search input --}}
            <input type="text" class="messenger-search" placeholder="Search" />
            {{-- Tabs --}}
            {{-- <div class="messenger-listView-tabs">
                <a href="#" class="active-tab" data-view="users">
                    <span class="far fa-user"></span> Contacts</a>
            </div> --}}
        </div>
        {{-- tabs and lists --}}
        <div class="m-body contacts-container">
           {{-- Lists [Users/Group] --}}
           {{-- ---------------- [ User Tab ] ---------------- --}}
           <div class="show messenger-tab users-tab app-scroll" data-view="users">
               {{-- Favorites --}}
               <div class="favorites-section">
                <p class="messenger-title mt-3 "><span>
                 @if(Auth::user()->role === 'team')
            Company Name
        @elseif(Auth::user()->role === 'user')
          Team Members
        @endif
               </span></p>
                <div class="messenger-favorites app-scroll-hidden"></div>
               </div>
               {{-- Saved Messages --}}
               <p class="messenger-title"><span>Your Space</span></p>
               {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
               {{-- Contact --}}
               <p class="messenger-title"><span>All Messages</span></p>
               <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;"></div>
           </div>
             {{-- ---------------- [ Search Tab ] ---------------- --}}
           <div class="messenger-tab search-tab app-scroll" data-view="search">
                {{-- items --}}
                <p class="messenger-title"><span>Search</span></p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Type to search..</span></p>
                </div>
             </div>
        </div>
    </div>

    {{-- ----------------------Messaging side---------------------- --}}
    <div class="messenger-messagingView">
        {{-- header title [conversation name] amd buttons --}}
        <div class="m-header m-header-messaging">
            <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                {{-- header back button, avatar and user name --}}
                <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                    @if(Auth::user()->role === 'team')
          <a href="#" >Customer Service</a>
        @elseif(Auth::user()->role === 'user')
          <a href="#" ><span class="text-success mx-2 fs-5">{{ auth()->user()->cname }}:  <span></a> <span class="mt-1">Connects with CustomerService</span>
        @endif
                   
                </div>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    <a href="/"><i class="fas fa-home"></i></a>
                    <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                    <form class="mt-3" method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Logout') }}
                        </x-responsive-nav-link>
                    </form>
                </nav>
            </nav>
            {{-- Internet connection --}}
            <div class="internet-connection">
                <span class="ic-connected">Connected</span>
                <span class="ic-connecting">Connecting...</span>
                <span class="ic-noInternet">No internet access</span>
            </div>
        </div>

        {{-- Messaging area --}}
        <div class="m-body messages-container app-scroll">
            <div class="messages">
           
                <p class="message-hint center-el"><span>
         @if(Auth::user()->role === 'team')
             Hi Welcome to CustomerSupport Chat <br>
                Plz Click on Clients Icon To start Chat
        @elseif(Auth::user()->role === 'user')
         Hi Welcome to CustomerSupport Chat <br>
                Plz Click on Team Member Icon To start Chat
        @endif
               
            </span></p>
            </div>
            {{-- Typing indicator --}}
            <div class="typing-indicator">
                <div class="message-card typing">
                    <div class="message">
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        {{-- Send Message Form --}}
        @include('Chatify::layouts.sendForm')
    </div>
    {{-- ---------------------- Info side ---------------------- --}}
    <div class="messenger-infoView app-scroll">
        {{-- nav actions --}}
        <nav>
            <p>User Details</p>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        {!! view('Chatify::layouts.info')->render() !!}
    </div>
</div>
    
{{--  <div>
    <button id="startRecording">Start Recording</button>
    <button id="stopRecording" disabled>Stop Recording</button>
    <button id="playRecording" disabled>Play Recording</button>
</div>  --}}
{{--
<audio id="audioPlayer" controls></audio>  --}}

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.js"></script>
<script>
    // Include Laravel Echo configuration
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
});

window.Echo.channel('chat')
    .listen('VoiceMessageSent', (event) => {
        console.log(event.voiceMessage);
        // Handle voice message on the front end
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/recorder-js/dist/recorder.js"></script>
    <script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
<script>
 let countdownTimer; // Variable to hold the countdown timer
let secondsLeft = 30; // Initial value for the countdown timer
let alertShown = false; // Variable to track if the alert has been shown
var messageShown = false;

function startCountdown() {
    countdownTimer = setInterval(() => {
        if (secondsLeft === 0) {
            clearInterval(countdownTimer);
            if (!alertShown) {
                // Automatically send the message when the countdown reaches zero
                sendMessage("Please wait, a team member is busy. You will receive a reply soon.");
                alertShown = true;
            }
            return;
        }
        secondsLeft--;
    }, 1000);
}
function showToaster(message) {
    const toaster = document.getElementById("toaster");
    const toasterMessage = document.getElementById("toasterMessage");
    toasterMessage.textContent = message;
    toaster.classList.add("visible");

    // Automatically hide the toaster after 10 seconds
    setTimeout(() => {
        toaster.classList.remove("visible");
    }, 10000); // 10 seconds

    // Optionally, you can also clear the timeout if the toaster is manually dismissed
    // This ensures that if the user closes the toaster before the timeout, it won't hide automatically
    toaster.addEventListener("click", () => {
        clearTimeout(timeoutId);
        toaster.classList.remove("visible");
    });
}

function resetCountdown() {
    clearInterval(countdownTimer);
    secondsLeft = 30;
    alertShown = false; // Reset the alertShown variable
}

function sendMessage() {
    temporaryMsgId += 1;
    let tempID = `temp_${temporaryMsgId}`;
    let hasFile = !!$(".upload-attachment").val();
    const inputValue = $.trim(messageInput.val());

    const formData = new FormData($("#message-form")[0]);
    formData.append("id", getMessengerId());
    formData.append("temporaryMsgId", tempID);
    formData.append("_token", csrfToken);

    const handleSuccess = (data) => {
       console.log(data) 
        if (data.error.status > 0) {
            alert(data.error.message); // Display error message
            errorMessageCard(tempID);
            console.error(data.error.message);
        } else {
            updateContactItem(getMessengerId());

            const tempMsgCardElement = messagesContainer.find(`.message-card[data-id=${tempID}]`);

            if (data.message) {
                tempMsgCardElement.before(data.message);
            }
            tempMsgCardElement.remove();

            scrollToBottom(messagesContainer);
            sendContactItemUpdates(true);

            // Handle countdown based on roles
            if (data.userRole === "team") {
                resetCountdown();
            } else if (data.userRole === "user") {
                resetCountdown();
                startCountdown();
            }

            // Display formatted time difference (if provided)
            if (data.formatted_time) {
                console.log(`Time difference: ${data.formatted_time}`);
            }
        }
    };

    const handleError = () => {
        errorMessageCard(tempID);
        console.error("Failed sending the message! Please, check your server response.");
    };

    const beforeSend = () => {
        $(".messages").find(".message-hint").hide();

        if (hasFile) {
            messagesContainer.find(".messages").append(
                sendTempMessageCard(inputValue + "\n" + loadingSVG("28px"), tempID)
            );
        } else {
            messagesContainer.find(".messages").append(sendTempMessageCard(inputValue, tempID));
        }
        scrollToBottom(messagesContainer);
        messageInput.css({ height: "42px" });

        $("#message-form").trigger("reset");
        cancelAttachment();
        messageInput.focus();
    };

    const ajaxOptions = {
        url: $("#message-form").attr("action"),
        method: "POST",
        data: formData,
        dataType: "JSON",
        processData: false,
        contentType: false,
        beforeSend: beforeSend,
        success: handleSuccess,
        error: handleError,
    };

    // Check countdown timer logic
    if (secondsLeft === 0) {
        formData.append("message", "Please wait, a team member is busy. You will receive a reply soon.");
    }

    $.ajax(ajaxOptions);

    return false;
}




$(document).ready(function() {
    fetchContacts();

    function fetchContacts() {
        $.ajax({
            url: url + "/getContactsitems", // Update this to your actual endpoint
            method: "GET",
            dataType: "JSON",
            success: (data) => {
                $(".listOfContacts").empty(); // Clear existing contacts
                if (data.contacts && data.contacts.length > 0) {
                    data.contacts.forEach(contact => {
                        $(".listOfContacts").prepend(contact.contact_item);
                    });
                    $(".listOfContacts").find(".message-hint").hide();
                } else {
                    $(".listOfContacts").find(".message-hint").show();
                }
                cssMediaQueries(); // Update responsive design
            },
            error: (error) => {
                console.error(error);
            },
        });
    }
});



</script>
 