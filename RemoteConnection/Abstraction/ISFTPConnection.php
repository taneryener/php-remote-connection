<?php


namespace App\Medianova\RemoteConnection\Abstraction;


interface ISFTPConnection extends IRemoteConnection
{
    function uploadFile($localfile, $remotefile): bool;
}
