<?php
namespace App\Console\Commands\Socket;
use Illuminate\Support\Facades\Log;

class SocketHelper {
    public function CreateServerSocket($host, $port) {
        $socket =   socket_create(AF_INET, SOCK_STREAM, 0);
                    socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 2, 'usec' => 0));
                    socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 2, 'usec' => 0));
                    socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
                    socket_bind($socket, $host, $port);

        return $socket;
    }

    public function CreateClientSocket($host, $port) {
        $socket =   socket_create(AF_INET, SOCK_STREAM, 0);
                    socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 2, 'usec' => 0));
                    socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array('sec' => 2, 'usec' => 0));
                    @socket_connect($socket, $host, $port);

        return $socket;
    }

    public function Listen($socket, $requestLimit = 10) {
        return socket_listen($socket, $requestLimit);
    }

    public function AcceptData($socket) {
        $accept = socket_accept($socket);

        return $accept;
    }

    public function ReadData($accept, $maxLength = 102400) {
        @$fromClient = socket_read($accept, $maxLength, PHP_BINARY_READ);

        return $fromClient;
    }

    public function ReadClientData($accept, $maxLength = 102400) {
        //$fromClient = socket_read($accept, $maxLength, PHP_BINARY_READ);

        $fromClient = "";
        $startTime = time();
        while(true)
        {
            @$fromClient .= socket_read($accept, $maxLength, PHP_BINARY_READ);

            if (substr($fromClient, -4) == "\\END") { break; }
            //if ((time() - $startTime) > 2 && $fromClient = "") { break; }
            //if ((time() - $startTime) > 5) { break; }

            if ($fromClient == false) { return false; }
        }

        return $fromClient;
    }

    public function WriteData($accept, $data) {
        @$toClient = socket_write($accept, $data, strlen($data));

        return $toClient;
    }

    public function Close($SocketConn) {
        socket_close($SocketConn);
    }
}