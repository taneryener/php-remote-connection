<?php


namespace App\Medianova\RemoteConnection\Abstraction;


interface ITelnetConnection extends IRemoteConnection
{
    function setConnectionAddress(string $address):bool;
    function setUserName(string $userName):bool;
    function setPassword(string $password):bool;
}
