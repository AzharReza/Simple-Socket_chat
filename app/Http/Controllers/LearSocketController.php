<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPSocketIO\SocketIO;
use Workerman\Worker;

class LearSocketController extends Controller
{
    public function msg()
    {
        // Listen port 2021 for socket.io client
        $io = new SocketIO(8000);
        $io->on('connection', function ($socket) use ($io) {
            $socket->on('chat message', function ($msg) use ($io) {
                $io->emit('chat message', $msg);
            });
        });

        Worker::runAll();
    }
}
