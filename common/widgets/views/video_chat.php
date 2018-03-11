<?php if(!Yii::$app->user->isGuest ){ ?>

<style>
    #VideoChat{
    display: none;
    position: relative;   
    z-index: 1000;
    position: absolute;
    top: 0;
    left: 0;
    min-height: 100%;
    width: 100%;
    height: 100%;
     background-color: white; 
    position: fixed;
    background-size: 100% 100%;
}

#divVideo{
    width: 100%;
    height: 75%;
    background-color: #000; 
}

#localVideo{
    float: left;  
}

#divVideo1{
    float: left;
}

</style>

<div id="VideoChat">
    
    <div id="divVideo">
        <video id="localVideo" autoplay muted></video>  
        
        <div id="divVideo1">
        <video width="300" height="200" id="remoteVideo" autoplay></video>
        <button id="callButton" onclick="conectClose()">Завершить</button>
        </div>
    </div>
    
        
    <div id="VideoChatMessage" style="overflow-y: scroll; width: 700px; height: 120px;  border: 1px solid lightgray; margin:0 auto; margin-top: 5px;">

    </div>
    
    <div id="VideoChatInputMessage" style="width: 700px; height: 90px;  border: 1px solid lightgray; margin:0 auto; margin-top: 5px;">
  
        <textarea id="FormVideoChatMessage"  class="form-control" style="width: 590px; height: 88px; float: left; "></textarea>
        
        <button onclick="SendVideoChatMessage()" style="margin-top: 25px; margin-left: 5px; float: left;" type="button" class="btn btn-primary">Отправить</button>
        
    </div>
    
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/visibility.js/1.2.4/visibility.min.js"></script>

<script language="javascript" type="text/javascript">
           
    var socket = new WebSocket("ws://localhost:8081");

    socket.onopen = function(event) { };  
            
    socket.onerror = function(event) { /* alert('Произошла ошибка'); */ };

    socket.onclose = function(event){ /* alert('Соединение закрыто...'); */ socket.close(); };
   
   function JumpVideoChat(id, name, surname) { 
       
        DispatchServerData = {
            event: "connect user",
            id: id,
            name: name,
            surname: surname
         };

         socket.send(JSON.stringify(DispatchServerData));
       
    }
   
    function conectClose(){
   
        $("#VideoChat").hide("slow");                
        
         DispatchServerData = {
               event: "connect cose"                   
            };

        socket.send(JSON.stringify(DispatchServerData));
        
        CloseVideoChat();
    
    }
    
    function SendVideoChatMessage(){
        
        var text = document.getElementById('FormVideoChatMessage').value;  
        
        document.querySelector('#VideoChatMessage').innerHTML += '<p>' + text + ' </p>';
        
        document.getElementById("VideoChatMessage").scrollTop=document.getElementById("VideoChatMessage").scrollHeight;

        document.getElementById('FormVideoChatMessage').value = '';

         DispatchServerData = {
            event: "message user",
            message: text          
         };

         socket.send(JSON.stringify(DispatchServerData));       
        
    }
   
   socket.onmessage = function(event) {
       
        var ReceptionServertData = JSON.parse(event.data);
    
        if(ReceptionServertData.event === "identification"){

            DispatchServerData = {
               event: "identification",
               id: <?= Yii::$app->user->id ?>,
               token: "<?= $users_token->token ?>"
            };

            socket.send(JSON.stringify(DispatchServerData)); 

        }
   
        if(ReceptionServertData.event === "focus"){
            
            if('visible' == Visibility.state()){
                 
                DispatchServerData = {
                    event: "focus",
                    focus: true          
                 };

                 socket.send(JSON.stringify(DispatchServerData)); 

            }
            
            if('hidden' == Visibility.state()){
                 
                DispatchServerData = {
                    event: "focus",
                    focus: false          
                 };

                 socket.send(JSON.stringify(DispatchServerData)); 

            }

        }
        
        if(ReceptionServertData.event === "request connect user"){
        
            if(confirm('Вам звонит  ' + ReceptionServertData.name + ' ' + ReceptionServertData.surname)){ 
                                            
                var DispatchServerData = new Object();

                DispatchServerData = {
                   event: "connect user yes"                  
                };

                socket.send(JSON.stringify(DispatchServerData));     
                
                $("#VideoChat").show("slow");
                               
                startNavigator();
                
                setTimeout(createOffer, 2000);    

            }else{
                
                var DispatchServerData = new Object();

                 DispatchServerData = {
                    event: "connect user no"                   
                 };

                socket.send(JSON.stringify(DispatchServerData));
              
            }   
        
        }
        
        if(ReceptionServertData.event === "connect user yes"){
        
            $("#VideoChat").show("slow");
        
            startNavigator();
        
        }
      
        if(ReceptionServertData.event === "connect close"){                    
        
            $("#VideoChat").hide("slow");
            
            CloseVideoChat();
            
        }   
        
        if(ReceptionServertData.event === "message user"){
         
            document.querySelector('#VideoChatMessage').innerHTML += '<p>' + ReceptionServertData.message + ' </p>';
            
            document.getElementById("VideoChatMessage").scrollTop=document.getElementById("VideoChatMessage").scrollHeight;
         
         }
      
   };
 
    Visibility.change(function (e, state) {
                
       if ('visible' == state) {
           
            DispatchServerData = {
                event: "focus",
                focus: true          
             };

             socket.send(JSON.stringify(DispatchServerData)); 
          
       }
       
       if ('hidden' == state) {
           
            DispatchServerData = {
                event: "focus",
                focus: false          
             };

             socket.send(JSON.stringify(DispatchServerData)); 
           
       }
                
    });
  
    var PeerConnection = window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
    var IceCandidate = window.mozRTCIceCandidate || window.RTCIceCandidate;
    var SessionDescription = window.mozRTCSessionDescription || window.RTCSessionDescription;
    navigator.getUserMedia = navigator.getUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;

    var pc; 


    function startNavigator(){

        navigator.getUserMedia(
          { audio: true, video: true }, 
          gotStream, 
          function(error) { alert(error); }
        );
    
    }

    function gotStream(stream) {       
      document.getElementById("callButton").style.display = 'inline-block';
      document.getElementById("localVideo").src = URL.createObjectURL(stream);

      localStream = stream;

      pc = new PeerConnection(null);
      pc.addStream(stream);
      pc.onicecandidate = gotIceCandidate;
      pc.onaddstream = gotRemoteStream;
    }

    function createOffer() {      
      pc.createOffer(
        gotLocalDescription, 
        function(error) { alert(error) }, 
        { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
      );
    }

    function createAnswer() {
      pc.createAnswer(
        gotLocalDescription,
        function(error) { alert(error) }, 
        { 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
      );
    }

    function gotLocalDescription(description){

      pc.setLocalDescription(description);

      socket.send(JSON.stringify(description));

    }

    function gotIceCandidate(event){
      if (event.candidate) {
          
          socket.send(JSON.stringify(event.candidate));
     
      }
    }

    function gotRemoteStream(event){
      document.getElementById("remoteVideo").src = URL.createObjectURL(event.stream);
    }
    
    function CloseVideoChat() {
 
        document.getElementById("localVideo").src = "";

        localStream.getAudioTracks()[0].stop();

        localStream.getVideoTracks()[0].stop();

        document.getElementById("remoteVideo").src = "";

        pc.close();

        pc = null;

   }
    

    
    
    
</script>

<?php } ?>