<?php
use yii\helpers\Html;
Html::csrfMetaTags();
?>

<script language="javascript" type="text/javascript">
    
    var id_chat_user;
    var size_chat_user = 0;
    
    function JumpUserChat(id){
        
        id_chat_user = id;
        
        document.querySelector('#set_message').innerHTML = '';
        
        $.ajax({
            async: false,
            type: "POST",
            cache: false,
            url: "<?= Yii::$app->urlManager->createUrl(['/site/user_chat']); ?>",
            data: {id: id, message: '', size: 0, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
            success: function(data) {
            
                var chat_data = $.parseJSON(data);
                           
                size_chat_user = chat_data.chat_data.length;
             
                document.querySelector('#chat_header').innerHTML = "<button class='close' data-dismiss='modal' onclick = 'DeleteMessageTimeOut()'>x</button>";
                
                document.querySelector('#chat_header').innerHTML += "<div style='float: left; width: 50px; height: 50px; background: url(" + chat_data.user_avatar.avatar + ") no-repeat center/cover;'></div>";
                
                document.querySelector('#chat_header').innerHTML += "<h4 style='float: left; margin-top: 10px; margin-left: 10px;' class='modal-title'>"+chat_data.user_name.name + " " + chat_data.user_name.surname+"</h4>";
                
                for(var i = chat_data.chat_data.length - 1; i >= 0; --i){
                                                                                
                    document.querySelector('#set_message').innerHTML += "<div width: 100%;><div style='margin-right: 10px; float: left; width: 30px; height: 30px; background: url(" + chat_data.chat_data[i].users_avatar.avatar + ") no-repeat center/cover;'></div>"
                    +"<h5 style='' class='modal-title'>"+chat_data.chat_data[i].users_info.name + " " + chat_data.chat_data[i].users_info.surname+"</h5></div><br>";
                
                    document.querySelector('#set_message').innerHTML += '<p>' + chat_data.chat_data[i].message + ' </p>';
                    
                    document.querySelector('#set_message').innerHTML += '<hr style="height:1px;border:none;color:lightgray;background-color:lightgray;" />';
                                                          
                }
            }                                 
        });
        
        MessageTimeOut();
        
        setTimeout(ChatScroll, 1000);
        
    }
    
    function ChatScroll()
    {
        document.getElementById("set_message").scrollTop=document.getElementById("set_message").scrollHeight;
    }
    
    function SetUserChat(){
             
        var chat_text = document.getElementById('chat_input_text').value;  
        
        document.getElementById('chat_input_text').value = '';
         
        $.ajax({
            async: false,
            type: "POST",
            cache: false,
            url: "<?= Yii::$app->urlManager->createUrl(['/site/user_chat']); ?>",
            data: {id: id_chat_user, message: chat_text, size: size_chat_user, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
            success: function(data) {                          
            
            }                                 
        });
        
    }
    
    function GetMessageChat(){
            
        $.ajax({
            async: false,
            type: "POST",
            cache: false,
            url: "<?= Yii::$app->urlManager->createUrl(['/site/user_chat']); ?>",
            data: {id: id_chat_user, message: '', size: size_chat_user, _csrf:" <?= Yii::$app->request->csrfToken ?>"},
            success: function(data) {
            
                var chat_data = $.parseJSON(data);
                           
                size_chat_user += chat_data.chat_data.length;
                
                for(var i = chat_data.chat_data.length - 1; i >= 0; --i){
                    
                     document.querySelector('#set_message').innerHTML += "<div width: 100%;><div style='margin-right: 10px; float: left; width: 30px; height: 30px; background: url(" + chat_data.chat_data[i].users_avatar.avatar + ") no-repeat center/cover;'></div>"
                    +"<h5 style='' class='modal-title'>"+chat_data.chat_data[i].users_info.name + " " + chat_data.chat_data[i].users_info.surname+"</h5></div><br>";
                
                    document.querySelector('#set_message').innerHTML += '<p>' + chat_data.chat_data[i].message + ' </p>';
                    
                    document.querySelector('#set_message').innerHTML += '<hr style="height:1px;border:none;color:lightgray;background-color:lightgray;" />';
                    
                    document.getElementById("set_message").scrollTop = document.getElementById("set_message").scrollHeight;
                    
                }
            }                                 
        });
        
    }
    
    var timerId;
                
    function MessageTimeOut()
    {       
        GetMessageChat();

        timerId = setTimeout(MessageTimeOut, 1000);
    }

    function DeleteMessageTimeOut()
    {               
        clearTimeout(timerId);        
    }
       
    window.onload = function() {
        
        var div = document.getElementById("modal_user_chat");
       
        div.onclick = function (e) {
            
            var e = e || window.event;

            var target = e.target || e.srcElement;

            if (this == target){
                
                DeleteMessageTimeOut(); 
                
            }
          
        };
        
    }
   
</script>

<div id='modal_user_chat' class='modal fade'>

    <div class='modal-dialog'>

        <div class='modal-content'>

            <div id='chat_header' class='modal-header'>

            </div>

            <br />

            <div class='media-body' style="padding-left: 20px; padding-right: 20px;">                                             

                <div id='set_message' style="width: 100%; height: calc(100vh - 400px); word-break:break-all; overflow-y: scroll; ">

                </div>
                
                <textarea id="chat_input_text" class="form-control" rows="6"></textarea>
                                
                <button onclick='SetUserChat()' style="float: right; margin-top: 10px;" type="button" class="btn btn-primary">Отправить</button>

            </div>    

            <br />

            <div class='modal-footer'>

            </div>

        </div>

    </div>

</div>