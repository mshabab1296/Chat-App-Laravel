var baseUrl = $("#base_url").val();
var user_id = $("#user_id").val();

var month = new Array();
  month[0] = "Jan";
  month[1] = "Feb";
  month[2] = "Mar";
  month[3] = "Apr";
  month[4] = "May";
  month[5] = "Jun";
  month[6] = "Jul";
  month[7] = "Aug";
  month[8] = "Sep";
  month[9] = "Oct";
  month[10] = "Nov";
  month[11] = "Dec";

Pusher.logToConsole = true;
         
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: '0c74618027cbcbbd3b2a',
  cluster: 'ap2',
  encrypted: true,
  logToConsole: true
});

Echo.private('user.'+user_id)
.listen('NewMessageNotification', (e) => {
   // alert(e.message.from);
    // console.log(e);
   var dateTime = new Date(parseInt(e.message.time+"000", 10));
   // alert(dateTime);
   var hr = dateTime.getHours();
   var min = dateTime.getMinutes();
   var amPm = hr >= 12 ? 'PM' : 'AM';
   hr = hr % 12;
   hr = hr ? hr : 12; // the hour '0' should be '12'
   min = min < 10 ? '0'+min : min;
   var htm = '<div class="incoming_msg">'+
                '<div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">'+
                '</div>'+
                '<div class="received_msg">'+
                  '<div class="received_withd_msg">'+
                    '<p>'+e.message.message+'</p>'+
                    '<span class="time_date"> '+hr+':'+min+' '+amPm+' | '+month[dateTime.getMonth()]+' '+dateTime.getDate()+'</span></div>'+
                '</div>'+
             '</div>';
   $("#msg_history"+e.message.from).append(htm);
   $('#msg_history'+e.message.from).scrollTop($('#msg_history'+e.message.from).prop("scrollHeight"));
});

$(document).ready(function() {

   $(".chat_list").on('click', function() {
      var senred_id = $(this).attr('id').substring(6);
      // console.log(senred_id);
      $(".chat_list").removeClass("active_chat");
      $(this).addClass("active_chat");
      $(".mesgs").css('display', 'none');
      $("#from"+senred_id).css('display', 'block');

      $('.msg_history').scrollTop($('.msg_history').prop("scrollHeight"));
   });

   $(".msg_send_btn").on('click', function() {

      var to_id = $(this).parent().children('input')[0].value;
      var message = $(this).parent().children('input')[1].value.trim();
      if(message.length==0){
         return;
      }
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      var ampm = h >= 12 ? 'PM' : 'AM';
      h = h % 12;
      h = h ? h : 12; // the hour '0' should be '12'
      m = m < 10 ? '0'+m : m;
      var html =  '<div class="outgoing_msg">'+
                     '<div class="sent_msg">'+
                        '<p>'+message+'</p>'+
                        '<span class="time_date"> '+h+':'+m+' '+ampm+' |    '+month[today.getMonth()]+' '+today.getDate()+'</span>'+
                     '</div>'+
                  '</div>';
      $("#msg_history"+to_id).append(html);
      $(this).parent().children('input')[1].value = "";
      $('#msg_history'+to_id).scrollTop($('#msg_history'+to_id).prop("scrollHeight"));
      // return;
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
         type    : "POST",
         url     : baseUrl+'/user/chat/message/send',
         data    : {
            "to_id" :to_id,
            "message" :message
         },

         beforeSend: function(){
            
         },
         success: function(data){
            console.log(data);
         },
         error: function (data){
            console.log(data);
         }
      });
   });
});
