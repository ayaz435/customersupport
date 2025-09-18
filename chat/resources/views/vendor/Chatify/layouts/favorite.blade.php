<div class="favorite-list-item">
    @if($user)
  
  
        @if(Auth::user()->role === 'team')
            <div data-id="{{ $user->id }}" data-chat-count="0"  data-action="0" class="avatar av-m"
                style="background-image: url('{{ Chatify::getUserWithAvatar($user)->avatar }}');">
            </div>

         
            <p>{{ strlen($user->cname) > 5 ? substr($user->cname,0,6).'..' : $user->cname }}</p>
        @elseif(Auth::user()->role === 'user')
            <div data-id="{{ $user->id }}" data-chat-count="{{ $user->active_chats_count }}"  data-action="0" class="avatar av-m"
                style="background-image: url('{{ Chatify::getUserWithAvatar($user)->avatar }}');">
            </div>
        
            <p>{{ strlen($user->name) > 5 ? substr($user->name,0,6).'..' : $user->name }}</p>
            
            {{-- Progress bar --}}
        @php
            $chatCount = $user->active_chats_count ?? 0;
            $progressPercent = min(($chatCount / 3) * 100, 100);
        @endphp

        <div style="background-color: #e0e0e0; width: 100%; height: 5px; border-radius: 3px; margin-top: 5px;">
            <div style="background-color: #4caf50; width: {{ $progressPercent }}%; height: 100%; border-radius: 3px;"></div>
        </div>
        @endif
    @endif
</div>

