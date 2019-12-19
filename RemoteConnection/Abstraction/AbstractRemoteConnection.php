<?php


namespace App\Medianova\RemoteConnection\Abstraction;


abstract class AbstractRemoteConnection implements IRemoteConnection
{
    protected $connection;
    protected $address;
    protected $port;
    protected $userName;
    protected $password;

    protected function __construct(string $address,int $port,string $userName,string $password)
    {
        $this->address = $address;
        $this->userName = $userName;
        $this->password = $password;
        $this->port = $port;
    }

    public function setConnectionAddress(string $address): bool
    {
        $this->address = $address;
        return true;
    }

    public function setPort(string $port): bool
    {
        $this->port = $port;
        return true;
    }

    public function setUserName(string $userName): bool
    {
        $this->userName = $userName;
        return true;
    }

    public function setPassword(string $password): bool
    {
        $this->password = $password;
        return true;
    }
}
