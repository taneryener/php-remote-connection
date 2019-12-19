<?php


namespace App\Medianova\RemoteConnection\Concrete;

use App\Medianova\RemoteConnection\Abstraction\AbstractRemoteConnection;
use App\Medianova\RemoteConnection\Abstraction\ITelnetConnection;

class TelnetConnection extends AbstractRemoteConnection implements ITelnetConnection
{
    public function connect(): bool
    {
        // TODO: Implement connect() method.
        return false;
    }
}
