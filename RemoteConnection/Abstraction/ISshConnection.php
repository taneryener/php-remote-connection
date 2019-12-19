<?php


namespace App\Medianova\RemoteConnection\Abstraction;


interface ISshConnection extends IRemoteConnection
{
    function doCommand(string $command, bool $needSudo = false): bool;
}
