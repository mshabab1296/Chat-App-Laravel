@extends('layouts.app')

@section('content')

<div class="container">
   <div class="row">
      <div class="col-md-12">
         <!-- <h3 class=" text-center">Chart room</h3> -->
         <div class="messaging">
            <div class="inbox_msg">
               <div class="inbox_people mobile-hide">
                  <div class="headind_srch">
                     <div class="recent_heading">
                        <h4>Recent</h4>
                     </div>
                     <div class="srch_bar">
                        <div class="stylish-input-group">
                           <input type="text" class="search-bar" id="chat-search"  placeholder="Search" >
                           <span class="input-group-addon">
                           <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                           </span>
                        </div>
                     </div>
                  </div>
                  <div class="inbox_chat">
                     @foreach($senders as $sndr)
                     <div class="chat_list" id="{{'sender'.$sndr->id}}"> <!-- active_chat -->
                        <div class="chat_people">
                           <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                           </div>
                           <div class="chat_ib">
                              <h5>{{ $sndr->name }}<span class="chat_date">Dec 25</span></h5>
                              <p>@if(App\Message::getChatBetween(Auth::user()->id,$sndr->id)->count()){{ App\Message::getChatBetween(Auth::user()->id,$sndr->id)->first()->message }}@endif</p>
                           </div>
                        </div>
                     </div>
                   @endforeach
                  </div>
               </div>
               @foreach($senders as $sender)
                  <div class="mesgs" id="{{'from'.$sender->id}}" style="display: none;">
                     <div class="msg_history" id="{{'msg_history'.$sender->id}}">
                        @foreach(App\Message::getChatBetween(Auth::user()->id,$sender->id)->get() as $message)
                           @if($message->to == Auth::user()->id)
                              <div class="incoming_msg">
                                 <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                 <div class="received_msg">
                                   <div class="received_withd_msg">
                                     <p>{{ $message->message }}</p>
                                     <span class="time_date"> {{ date('h:i A', $message->time) }}  | {{ date('M d', $message->time) }}</span></div>
                                 </div>
                              </div>
                           @else
                              <div class="outgoing_msg">
                                 <div class="sent_msg">
                                   <p>{{ $message->message }}</p>
                                   <span class="time_date"> {{ date('h:i A', $message->time) }}  | {{ date('M d', $message->time) }}</span> 
                                 </div>
                              </div>
                           @endif
                        @endforeach
                     </div>
                     <div class="type_msg">
                        <div class="input_msg_write">
                           <input type="hidden" name="to" value="{{$sender->id}}" id="to_id">
                           <input type="text" id="msg_to_send" class="write_msg" placeholder="Type a message" />
                           <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
              <!-- <p class="text-center top_spac"> Design by <a target="_blank" href="#">Sunil Rajput</a></p> -->
         </div>
      </div>
   </div>
</div>
@section('js')
 <script src="{{ asset('js/echo.js') }}"></script>
 <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
 <script src="{{ asset('js/chat.js') }}"></script>
@endsection
@endsection