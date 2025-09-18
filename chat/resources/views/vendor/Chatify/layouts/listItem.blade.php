{{-- -------------------- Saved Messages -------------------- --}}
@if($get == 'saved')
    <table class="messenger-list-item" data-contact="{{ Auth::user()->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td>
                <div class="saved-messages avatar av-m">
                    <span class="far fa-bookmark"></span>
                </div>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ Auth::user()->id }}" data-type="user">Saved Messages <span>You</span></p>
                <span>Save messages secretly</span>
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- Contact list -------------------- --}}

@if($get == 'users' && !!$lastMessage)
    <?php
    $lastMessageBody = mb_convert_encoding($lastMessage->body, 'UTF-8', 'UTF-8');
    $lastMessageBody = strlen($lastMessageBody) > 30 ? mb_substr($lastMessageBody, 0, 30, 'UTF-8').'..' : $lastMessageBody;
    ?>
    <table class="messenger-list-item" data-contact="{{ $user->id }}">
        <tr data-action="0">

            {{-- Avatar side --}}
            <td style="position: relative">
                @if($user->active_status)
                    <span class="activeStatus"></span>
                @endif
                <div class="avatar av-m" style="background-image: url('{{ $user->avatar }}');"></div>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ $user->id }}" data-type="user">
             @if(Auth::user()->role === 'team')
            {{ strlen($user->cname) > 12 ? trim(substr($user->cname,0,12)).'..' : $user->cname }}
            @elseif(Auth::user()->role === 'user')
            {{ strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name }}
            @endif
                    
                    <span style="font-size:10px;" class=" text-danger" data-time="{{$lastMessage->created_at}}">@php
    $datetime = $lastMessage->created_at;
   $date = \Carbon\Carbon::parse($datetime)->setTimezone('Asia/Karachi')->format('Y-m-d');
    $time = \Carbon\Carbon::parse($datetime)->setTimezone('Asia/Karachi')->format('h:i:s A');
@endphp

{{ $date }}<br>
{{ $time }}</span>
                </p>
                <span>
                    {{-- Last Message user indicator --}}
                    {!! $lastMessage->from_id == Auth::user()->id ? '<span class="lastMessageIndicator">You :</span>' : '' !!}
                    {{-- Last message body --}}
                    @if($lastMessage->attachment == null)
                        {!! $lastMessageBody !!}
                    @else
                        <span class="fas fa-file"></span> Attachment
                    @endif
                </span>
                {{-- New messages counter --}}
                {!! $unseenCounter > 0 ? '<b class="bg-danger">' . $unseenCounter . '</b>' : '' !!}
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- Search Item -------------------- --}}
@if($get == 'search_item')
    <table class="messenger-list-item" data-contact="{{ $user->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td>
                <div class="avatar av-m" style="background-image: url('{{ $user->avatar }}');"></div>
            </td>
            {{-- center side --}}
            <td>
             @if(Auth::user()->role === 'team')
            <p data-id="{{ $user->id }}" data-type="user">
                    {{ strlen($user->cname) > 12 ? trim(substr($user->cname,0,12)).'..' : $user->cname }}
                </p>
        @elseif(Auth::user()->role === 'user')
            <p data-id="{{ $user->id }}" data-type="user">
                    {{ strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name }}
                </p>
        @endif
                
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- Shared photos Item -------------------- --}}
@if($get == 'sharedPhoto')
    <div class="shared-photo chat-image" style="background-image: url('{{ $image }}')"></div>
@endif

