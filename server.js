const express = require('express');
const app = express();
const server = require('http').createServer(app);

const io = require('socket.io')(server,{
    cors: {origin:"*"}
});

io.on('connection',(socket)=>{
    console.log('connection');
    //socket on mean receiving something
    socket.on('sendChatToServer',(message)=>{
        console.log(message);
        // io.sockets.emit('sendChatToClient',message);
        // socket.broadcast.emit('sendChatToClient',message);
    });

    //socket emit mean sending something
    // socket.emit();

    socket.on('disconnect',(socket)=>{
        console.log('Disconnect');
    });
});

server.listen(8000,()=>{
    console.log('server is running');
});
