@foreach($conversations as $conv)
    @php($user= $conv->sender_type == 'admin' ? $conv->receiver :  $conv->sender)
    @if ($user)
    @php($unchecked=($conv->last_message->sender_id == $user->id) ? $conv->unread_message_count : 0)
        <div
            class="chat-user-info d-flex border-bottom p-3 align-items-center customer-list {{$unchecked ? 'new-msg ' : ''}} {{$unchecked ? 'conv-active' : ''}}"
            onclick="viewConvs('{{route('admin.message.view',['conversation_id'=>$conv->id,'user_id'=>$user->id])}}','customer-{{$user->id}}','{{ $conv->id }}','{{ $user->id }}')"
            id="customer-{{$user->id}}">
            <div class="chat-user-info-img d-none d-md-block">
                <img class="avatar-img"
                        src="{{asset('storage/app/public/profile/'.$user['image'])}}"
                        onerror="this.src='{{asset('public/assets/admin')}}/img/160x160/img1.jpg'"
                        alt="Image Description">
            </div>
            <div class="chat-user-info-content">
                <h5 class="mb-0 d-flex justify-content-between">
                    <span class=" mr-3">{{$user['f_name'].' '.$user['l_name']}}</span> <span
                        class="{{$unchecked ? 'badge badge-info' : ''}}">{{$unchecked ? $unchecked : ''}}</span>
                        <small>{{date(config('timeformat'),strtotime($conv->last_message->created_at))}}</small>
                </h5>
                <small>{{ $user['phone'] }}</small>
                <div class="text-title">{{ Str::limit($conv->last_message->message ??'', 35, '...') }}</div>
            </div>
        </div>
    @else
        <div
            class="chat-user-info d-flex border-bottom p-3 align-items-center customer-list">
            <div class="chat-user-info-img d-none d-md-block">
                <img class="avatar-img"
                        src='{{asset('public/assets/admin')}}/img/160x160/img1.jpg'
                        alt="Image Description">
            </div>
            <div class="chat-user-info-content">
                <h5 class="mb-0 d-flex justify-content-between">
                    <span class=" mr-3">{{translate('messages.user_not_found')}}</span>
                </h5>
            </div>
        </div>
    @endif
@endforeach

