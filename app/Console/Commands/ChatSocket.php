<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PHPSocketIO\SocketIO;
use Workerman\Worker;

class ChatSocket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Listen port 2021 for socket.io client
        $io = new SocketIO(8001);
        $io->on('connection', function ($socket) use ($io) {
            $socket->on('chat message', function ($msg) use ($io) {
                $io->emit('chat message', [
                    'result' => 'success',
                    'message' => 'User Notifications '.$msg,
                ]);
            });
            $socket->on('typing', function () use ($socket) {
                $socket->broadcast->emit('typing', array(
                    'username' => $socket->username
                ));
            });
        });

        Worker::runAll();
    }
}
