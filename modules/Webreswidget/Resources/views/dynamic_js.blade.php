function loadHTML(myDivId) {
   (document.getElementById(myDivId).innerHTML = htmlText); 
}

function makeReservation(){
    var name = document.getElementById('name').value;
    var phone = document.getElementById('phone').value;
    var date = document.getElementById('date').value;
    var time = document.getElementById('time').value;
    var people = document.getElementById('people').value;
    var note = document.getElementById('note').value;
  
    var sendDate={
        name:name,
        phone:phone,
        date:date,
        time:time,
        people:people,
        note:note,
        widget_id:'{{$widget_id}}'
    }

    console.log(sendDate);

    //Disable the reservationSubmitButton
    document.getElementById('reservationSubmitButton').disabled = true;
    //Opaciity to 0.5
    document.getElementById('reservationSubmitButton').style.opacity = 0.5;
    //Hide it
    document.getElementById('reservationSubmitButton').style.display = 'none';

    //Hide the form
    document.getElementById('form').style.display = 'none';

    

    //Make the request
    var reservation_url='{{$app_url}}/api/submit_reservation';
    console.log(reservation_url);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", reservation_url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify(sendDate));
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            //Get the response
            var response = JSON.parse(xhr.responseText);
            console.log(response);
            if(response.status=='success'){
                //Show success message
                document.getElementById('extraMessages').innerHTML += makingReservationMessage;
            }else{
                //Show error message
                document.getElementById('extraMessages').innerHTML += makingReservationMessageError;
            }
        }
    }



}

var injectDiv = "embed-webreswidget",
    injectDivElement,
    htmlText ='';
    widgetType='{{$widget_type}}';
    form='<br /><form id="form" class="whatsAppChatMessage"><label for="name">Name:</label><input type="text" id="name" name="name" required><label for="phone">Phone:</label><input type="tel" id="phone" name="phone" required><label for="date">Date:</label><input type="date" id="date" name="date" required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}"><label for="time">Time:</label><input type="time" id="time" name="time" required><label for="people">Number of People:</label><input type="number" id="people" name="people" required value="2" min="1"><label for="note">Note:</label><input type="text" id="note" name="note"></form>';
    formStyles='input[type="text"], input[type="tel"], input[type="date"], input[type="time"], input[type="number"] { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; }';
    root=':root { --chat-opened-bg-color: {{$button_color}}; --chat-wrapper-bg-color: ##e2e8f0; --chat-head-bg-color: {{ $header_color }}; --chat-button-bg-color: {{$button_color}}; --chat-vendor-bubble-bg-color: #FFFFFF; --chat-text-color: #515365; --chat-box-shadow-color: rgba(0, 0, 0, 0.1); --chat-border-color: lightgray; --chat-border-radius: 16px; --chat-wrapper-bg-img: url(\'{{$url}}bg-chat.png\') ; }'
    rules='#whatsAppChatOpener::after,#whatsAppChatOpener::before{background-color:var(--chat-button-bg-color);background-repeat:no-repeat;border-radius:50px}.mobidonia_whatsapp_popup{font:400 14px/18px system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";text-rendering:optimizeLegibility;position:relative;z-index:9999}#whatsAppChatOpener{position:fixed;right:30px;bottom:20px;height:64px;width:64px;text-align:center;border-radius:50px;font-size:30px;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;padding-top:0;z-index:2}#whatsAppChatOpener::before{position:absolute;content:"";width:100%;height:100%;inset:0;background-size:cover;z-index:0;transform:scale(1);transition:.2s}#whatsAppChatOpener::after,.whatsAppChatWrapper::after{position:absolute;width:100%;height:100%;background-size:cover;z-index:-1;content:"";inset:0}#whatsAppChatOpener:hover::before{filter:brightness(.94);mix-blend-mode:overlay}#whatsAppChatOpener::after{transform:scale(1.2);filter:blur(10px) brightness(1);opacity:.3}#whatsAppChatOpener:hover::after{mix-blend-mode:overlay;filter:blur(8px) brightness(.94);opacity:.4}.whatsAppChatBadge{width:10px;height:10px;position:absolute;z-index:1;border-radius:50%;right:5px;top:5px;border-width:none}#whatsAppChatOpener i{position:absolute;top:50%;left:52%;transform:translate(-50%,-50%) rotate(0);transition:transform .2s linear}#whatsAppChatOpener i.mob_whats_opened{opacity:0;pointer-events:none;transition:transform .2s linear,opacity .1s}#whatsAppChatOpener svg{display:block;object-fit:contain}#whatsAppChatClick:checked~#whatsAppChatOpener i.mob_whats_opened{opacity:1;pointer-events:auto;transform:translate(-50%,-50%) rotate(90deg)}#whatsAppChatClick:checked~#whatsAppChatOpener i.mob_whats_closed{opacity:0;pointer-events:none;transform:translate(-50%,-50%) rotate(0)}.whatsAppChatWrapper{position:fixed;right:30px;bottom:0;max-width:360px;margin-bottom:32px;background-color:var(--chat-wrapper-bg-color);border-radius:var(--chat-border-radius);box-shadow:0 0 16px var(--chat-box-shadow-color),1px 2px 4px var(--chat-box-shadow-color),2px 4px 32px var(--chat-box-shadow-color);opacity:0;pointer-events:none;transition:.2s cubic-bezier(.68, -.55, .265, 1.55);overflow:hidden}.whatsAppChatWrapper::after{background-image:"{{$url}}/bg-chat.png";filter:invert(1);mix-blend-mode:overlay;opacity:.8}#whatsAppChatClick:checked~.whatsAppChatWrapper{opacity:1;bottom:85px;pointer-events:auto}.whatsAppChatHeader{display:flex;gap:10px;border-bottom-color:rgba(48,52,54,.1);background:var(--chat-head-bg-color);padding:20px}.whatsAppChatButton span,.whatsAppChatButton svg,.whatsAppChatVendor{position:relative;z-index:1}.whatsAppChatVendorLogo{width:52px;height:52px;transition:opacity 1s ease-out;background-color:#d2d2d2;box-shadow:rgba(13,14,14,.1) 0 0 2px inset;border-radius:50%;overflow:hidden;display:block}.whatsAppChatStatus{content:"";bottom:0;right:0;width:12px;height:12px;box-sizing:border-box;position:absolute;z-index:4;border-radius:50%;border:2px solid}.whatsAppChatOnline{background-color:#3baa03;border-color:#00d9b2}.whatsAppChatBadge,.whatsAppChatBusy{background-color:#ff2800;border-color:#ff8f00}.whatsAppChatOffline{background-color:#9e9e9e;border-color:#616161}.whatsAppChatVendorLogo img{object-fit:cover;width:inherit;height:inherit}.whatsAppChatName{line-height:1.64;color:#fff;font-weight:500;font-size:20px}.whatsAppChatStatusText{font-size:13px;font-weight:300;line-height:1.5;color:#fff}.whatsAppChatWrapper .whatsapp-chat-box{padding:20px;width:100%}.whatsAppChatBox{display:flex;z-index:1;transition:opacity .3s;position:relative;padding:20px 20px 12px;overflow:auto;max-height:382px}.whatsAppChatBubble{display:flex;align-items:flex-end;height:100%;padding:6px 14px;position:relative;transform-origin:center top;z-index:2;color:var(--chat-text-color);font-size:15px;line-height:1.39;max-width:calc(100% - 66px);border-radius:0 16px 16px;background-color:var(--chat-vendor-bubble-bg-color);opacity:1;hyphens:auto;box-shadow:rgba(0,0,0,.15) 0 1px 0 0}.whatsAppChatBubble svg{position:absolute;top:0;left:-9px;fill:var(--chat-vendor-bubble-bg-color)}.whatsAppChatMessageTime{text-align:right;margin-left:12px;font-size:12px;line-height:14px;opacity:.5}.whatsAppChatFooter{display:flex;justify-content:center}.whatsAppChatButton{position:relative;display:flex;justify-content:center;align-items:center;gap:10px;border-radius:24px;width:100%;border:none;background-color:var(--chat-button-bg-color);padding:12px 27px;margin:20px;max-width:100%;box-shadow:rgba(0,0,0,.25) 0 1px 0 0;pointer-events:all;transition:.3s;cursor:pointer}.whatsAppChatButton span{font-size:16px;color:#fff;font-family:inherit;font-weight:700}.whatsAppChatButton::before{position:absolute;content:"";inset:0;width:100%;height:100%;background-color:transparent;border-radius:24px;overflow:hidden;z-index:0;transition:.3s}.whatsAppChatButton:hover::before{background-color:rgba(0,0,0,.2);mix-blend-mode:overlay}.whatsAppChatFooter.whatsAppChatMessageFieldContainer{display:flex;padding:12px 20px;border-top:1px solid rgba(17,17,17,.1);background-color:#fff}.whatsAppChatMessageField{display:flex;gap:4px;width:100%;align-items:flex-end}.whatsAppChatMessageField textarea{height:28px;max-height:280px;overflow:scroll;flex:1 0 auto;font-style:inherit;font-variant:inherit;font-weight:inherit;font-size:inherit;line-height:1.4;font-family:inherit;color:inherit;letter-spacing:inherit;text-transform:inherit;box-sizing:border-box;margin:0;padding:0;border:none;outline:0;box-shadow:none;background:0 0;transform:translate3d(0,0,0);resize:none}.whatsAppChatMessageField textarea::placeholder{opacity:.65;line-height:1.4}.whatsAppChatMessageField button{position:relative;border:none;height:32px;width:32px;border-radius:100%;pointer-events:all;cursor:pointer;overflow:hidden}.whatsAppChatMessageField button::before{position:absolute;content:"";inset:0;width:100%;height:100%;background-color:var(--chat-head-bg-color);transition:.2s;filter:brightness(1);z-index:0}.whatsAppChatMessageField button:hover::before{filter:brightness(1.5)}.whatsAppChatMessageField button svg{position:relative;right:-1px;bottom:-1px;fill:#FFFFFF;object-fit:contain;z-index:1}#whatsAppChatClick{display:none}';
    style='<style>'+root+rules+formStyles+'</style>';

    makingReservationMessage='<div class="whatsAppChatBox"> <div class="whatsAppChatBubble"  style="color:green">{{ __("We have received your request. You will get SMS when reservation is confirmed.")}}</div></div>';
    makingReservationMessageError='<div class="whatsAppChatBox"> <div class="whatsAppChatBubble" style="color:#f00">{{ __("There was an error, please refresh, and submit again.")}}</div></div>';

    
   
    button='<button id="reservationSubmitButton" onclick="makeReservation()" class="whatsAppChatButton"><div class="whatsAppChatButtonIcon"> <img src="{{ $url }}whatsapp.svg"> </div> <span> {{$button_text}}</span> </button>';
    if(widgetType=='2'){
        //Call button
        button='<button onclick="window.open(\'{{$calllink}}\')" class="whatsAppChatButton"><div class="whatsAppChatButtonIcon"> <img src="{{ $url }}call.svg"> </div> <span> {{$button_text}}</span> </button>';
        
        //Set form to be empty
        form='';
    }
    body='<div class="mobidonia_whatsapp_popup"> <input type="checkbox" id="whatsAppChatClick"> <label for="whatsAppChatClick" id="whatsAppChatOpener"> <div class="whatsAppChatBadge"></div> <i class="mob_whats_closed"> <img src="{{ $url}}mob_whats_closed.svg"> </i> <i class="mob_whats_opened"> <img src="{{ $url }}mob_whats_open.svg"> </i> </label> <div class="whatsAppChatWrapper"> <div class="whatsAppChatHeader"> <div class="whatsAppChatVendor"> <div class="whatsAppChatVendorLogo"> <img src="{{$logo}}" alt="Vendor Logo"> </div> <div class="whatsAppChatStatus whatsAppChatOnline"></div> </div> <div class="whatsAppChatTitle"> <div class="whatsAppChatName">{{ $header_text }}</div> <div class="whatsAppChatStatusText">{{ $header_subtext }}</div> </div> </div> <div class="whatsAppChatBox"> <div class="whatsAppChatBubble"> <svg xmlns="http://www.w3.org/2000/svg" width="9" height="17" viewBox="0 0 9 17"><path d="M0.772965 3.01404C-0.0113096 1.68077 0.950002 0 2.49683 0H9V17L0.772965 3.01404Z"></path></svg> <div class="whatsAppChatMessage"><div id="theMessage"></div>'+form+'  </div><br /> <div class="whatsAppChatMessageTime" id="currentTime"></div>  </div>  </div> <div id="extraMessages"></div> <div class="whatsAppChatFooter">'+button+' </div> </div> </div>';
    htmlText += style+body;
   

    document.addEventListener("DOMContentLoaded", function (t) {
        (injectDivElement = document.getElementById(injectDiv)),
        loadHTML(injectDiv);
        //Set the content of theMessage to be message
        var message= `{{ json_encode($message) }}`;
        message = message.replace(/\n/g, "<br />");
        message = message.replace(/&quot;/g, "");
        
        document.getElementById('theMessage').innerHTML = message;
        
    });