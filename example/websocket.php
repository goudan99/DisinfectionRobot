<?php


use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;

/*
|--------------------------------------------------------------------------
| Websocket Routes
|--------------------------------------------------------------------------
|
| Here is where you can register websocket events for your application.
|
*/

Websocket::on('connect', function ($websocket, Request $request) {
    // called while socket on connect
});

Websocket::on('disconnect', function ($websocket) {
    // called while socket on disconnect
    global $usernames, $numUsers;
    // remove the username from global usernames list
     if($websocket->addedUser) {
       unset($usernames[$websocket->username]);
       --$numUsers;
           // echo globally that this client has left
      $websocket->broadcast->emit('user left', [
        'username' => $websocket->username,
        'numUsers' => $numUsers
      ]);
    }
});

Websocket::on('example', function ($websocket, $data) {
    $websocket->emit('message', $data);
});

Websocket::on('add user', function ($websocket, $data) {
    global $usernames, $numUsers;
	$websocket->username = $data;
    //$usernames[$data] = $data;
    ++$numUsers;
    $websocket->addedUser = true;
	$websocket->emit('login', ['numUsers'=>$numUsers]);
    $websocket->broadcast()->emit('user joined', ['username'=>$websocket->username,'numUsers'=>$numUsers]);

});

Websocket::on('new message', function ($websocket, $data) {
    $websocket->broadcast()->emit('new message', ['username'=>$websocket->username,'message'=> $data]);
});

Websocket::on('typing', function ($websocket, $data) {
  $websocket->broadcast()->emit('typing', ['username' => $websocket->username]);
});

Websocket::on('stop typing', function ($websocket, $data) {
  $websocket->broadcast()->emit('stop typing', ['username' => $websocket->username]);
});