var WebSocketServer = new require('C:\\Program Files\\nodejs\\node_modules\\ws');

var mysql = require('C:\\Program Files\\nodejs\\node_modules\\mysql');

var crypto = require('crypto');

var clients = require("./clients");

var utilities = require("./utilities");

var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : 'admin',
  database : 'sn_base'
});

var g_clients = Array();

var num_clients = 0;

var webSocketServer = new WebSocketServer.Server({ port: 8081 });

webSocketServer.on('connection', function(ws) {
   
    ws.id = null;
    
    DispatchClientData = {
        event: "identification"                              
    };

    ws.send(JSON.stringify(DispatchClientData));
   
    ws.on('message', function(message) {

        try {

            var ReceptionClientData = JSON.parse(message);
       
        }catch (err) {

            ReceptionClientData = null;

        }
       
        if(!ReceptionClientData){
            
            return;
            
        }
       
        if(ReceptionClientData.event === "identification"){
            
            var temp_id = Number(ReceptionClientData.id);  
            
            if(temp_id === 'NaN'){
                
                return;
                
            }
              
            connection.query('SELECT * FROM `users_token` WHERE id_user = "' + temp_id +'"', function(error, result, fields){
                  
                    if (error){
                        
                        throw error;
                        
                    }else if (result.length > 0) {
                    
                        if(ReceptionClientData.token === null || result[0].date === null){
                            
                            return;
                            
                        }
                        
                        if(ReceptionClientData.token !== result[0].token){
                            
                            return;
                            
                        }
                     
                        var temp_date = result[0].date;
                        temp_date.setDate(temp_date.getDate() + 2);
                     
                        var temp_now = new Date();
                        
                        if(temp_date > temp_now){
                            
                            if(typeof g_clients[Number(ReceptionClientData.id)] !=="undefined"){
                                
                                ws.id = num_clients++;
                                ws.id_client = Number(ReceptionClientData.id);
                                
                                console.log("новое соединение: " + ws.id);  
                                
                                g_clients[Number(ReceptionClientData.id)].ws[ws.id] = { ws: ws, focus: false };
                                
                                g_clients[Number(ReceptionClientData.id)].ws_length++;
                                
                            }else{                                                                
                                
                                g_clients[Number(ReceptionClientData.id)] = new clients;
                                
                                ws.id = num_clients++;
                                ws.id_client = Number(ReceptionClientData.id);
                                
                                console.log("new новое соединение: " + ws.id);  
                                
                                g_clients[Number(ReceptionClientData.id)].ws[ws.id] = { ws: ws, focus: false };
                                
                                g_clients[Number(ReceptionClientData.id)].ws_length++;
                                
                            }
                            
                            DispatchClientData = {
                                event: "focus"                              
                            };

                            ws.send(JSON.stringify(DispatchClientData));
                          
                            return;
                                                                                     
                        }else{
                            
                            return; 
                            
                        }                    
                     
                    }else {                       

                      return; 

                    }
                  
            });
            
        }
                    
      if(ws.id === null){
          
          return;
          
      }
                  
      if(ReceptionClientData.event === "focus"){
         
          if(typeof g_clients[ws.id_client] ==="undefined"){
              
              return;
              
          }
          
          if(typeof g_clients[ws.id_client].ws[ws.id].focus ==="undefined"){
              
              return;
              
          }
         
          g_clients[ws.id_client].ws[ws.id].focus = ReceptionClientData.focus;
          
      }
      
      if(ReceptionClientData.event === "connect user"){
                              
          if(typeof g_clients[Number(ReceptionClientData.id)] ==="undefined"){
              
              return;
              
          }
          
          if(g_clients[ws.id_client].video_connect === true || g_clients[Number(ReceptionClientData.id)].video_connect === true){
              
              return;
              
          }
          
          g_clients[ws.id_client].video_connect = true;
          g_clients[ws.id_client].id_connect = ws.id;
          
          g_clients[Number(ReceptionClientData.id)].video_connect = true;
          
          g_clients[Number(ReceptionClientData.id)].firend_connect = ws;
          
          for (var key in g_clients[Number(ReceptionClientData.id)].ws) {
              
              if(g_clients[Number(ReceptionClientData.id)].ws[key].focus){
                  
                  g_clients[ws.id_client].firend_connect = g_clients[Number(ReceptionClientData.id)].ws[key].ws;
                  
                  g_clients[Number(ReceptionClientData.id)].id_connect = g_clients[Number(ReceptionClientData.id)].ws[key].ws.id;
                  
                  DispatchClientData = {
                        event: "request connect user",
                        name: ReceptionClientData.name,
                        surname: ReceptionClientData.surname
                  };

                  g_clients[Number(ReceptionClientData.id)].ws[key].ws.send(JSON.stringify(DispatchClientData));
                  
                  return;
              }
              
          }
          
         for (var key in g_clients[Number(ReceptionClientData.id)].ws) {
          
            g_clients[ws.id_client].firend_connect = g_clients[Number(ReceptionClientData.id)].ws[key].ws;

            g_clients[Number(ReceptionClientData.id)].id_connect = g_clients[Number(ReceptionClientData.id)].ws[key].ws.id;

            DispatchClientData = {
                  event: "request connect user",
                  name: ReceptionClientData.name,
                  surname: ReceptionClientData.surname
            };

            g_clients[Number(ReceptionClientData.id)].ws[key].ws.send(JSON.stringify(DispatchClientData));

            return;
        
         }

      }
      
      if(ReceptionClientData.event === "connect user no"){
          
          g_clients[ws.id_client].video_connect = false;
          
          g_clients[ws.id_client].id_connect = null;
          
          var temp_id_client = g_clients[ws.id_client].firend_connect.id_client;
          
          g_clients[ws.id_client].firend_connect = null;
          
          if(typeof g_clients[temp_id_client] ==="undefined"){
              
              return;
              
          }
          
          g_clients[temp_id_client].video_connect = false;
          
          g_clients[temp_id_client].firend_connect = null;
          
          g_clients[temp_id_client].id_connect = null;
          
          return;
                   
      }
      
      if(ReceptionClientData.event === "connect user yes"){
          
            DispatchClientData = {
                 event: "connect user yes"          
            };

            g_clients[ws.id_client].firend_connect.send(JSON.stringify(DispatchClientData));                     

      }
      
      if(ReceptionClientData.event === "connect cose"){
                          
           DispatchClientData = {
                event: "connect close"          
           };

           g_clients[ws.id_client].firend_connect.send(JSON.stringify(DispatchClientData));   
           
            g_clients[ws.id_client].video_connect = false;

            g_clients[ws.id_client].id_connect = null;

            var temp_id_client = g_clients[ws.id_client].firend_connect.id_client;

            g_clients[ws.id_client].firend_connect = null;

            if(typeof g_clients[temp_id_client] ==="undefined"){

                return;

            }

            g_clients[temp_id_client].video_connect = false;

            g_clients[temp_id_client].firend_connect = null;

            g_clients[temp_id_client].id_connect = null;

            return;
            
      }
      
      if(ReceptionClientData.type  === 'offer'){
            
            g_clients[ws.id_client].firend_connect.send(JSON.stringify(ReceptionClientData));
            
        }
        
        if (ReceptionClientData.type  === 'answer') {
         
            g_clients[ws.id_client].firend_connect.send(JSON.stringify(ReceptionClientData));
         
        } 
        
        if (ReceptionClientData.candidate) {
        
            g_clients[ws.id_client].firend_connect.send(JSON.stringify(ReceptionClientData));
        
        }
      
        if(ReceptionClientData.event  === 'message user'){
            
            DispatchClientData = {
                event: "message user",
                message: ReceptionClientData.message
            };
            
            g_clients[ws.id_client].firend_connect.send(JSON.stringify(ReceptionClientData));
            
        }       
     
    });
  
    ws.on('close', function() {

      console.log("соединение закрыто: " + ws.id); 
      
      if(typeof g_clients[ws.id_client] !=="undefined"){
      
            if(g_clients[ws.id_client].video_connect && g_clients[ws.id_client].id_connect === ws.id ){

                g_clients[ws.id_client].video_connect = false;

                var temp_id_client = g_clients[ws.id_client].firend_connect.id_client;

                g_clients[ws.id_client].firend_connect = null;

                if(typeof g_clients[temp_id_client] !=="undefined"){

                    g_clients[temp_id_client].video_connect = false;

                    g_clients[temp_id_client].firend_connect = null;

                    g_clients[temp_id_client].id_connect = null;

                }

            }
      
      }
   
      delete g_clients[ws.id_client].ws[ws.id];
     
      g_clients[ws.id_client].ws_length--;
     
      if(g_clients[ws.id_client].ws_length === 0){
          
          delete g_clients[ws.id_client];
          
      }

    });

});