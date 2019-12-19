<?php


namespace App\Medianova\RemoteConnection\Abstraction;


interface IRemoteConnection
{
    public function connect(): bool;

    function setConnectionAddress(string $address): bool;

    function setPort(string $port): bool;

    function setUserName(string $userName): bool;

    function setPassword(string $password): bool;
}
