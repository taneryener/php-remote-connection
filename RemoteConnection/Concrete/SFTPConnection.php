<?php


namespace App\Medianova\RemoteConnection\Concrete;

use App\Medianova\RemoteConnection\Abstraction\AbstractRemoteConnection;
use App\Medianova\RemoteConnection\Abstraction\ISFTPConnection;

class SFTPConnection extends AbstractRemoteConnection implements ISFTPConnection
{
    public function __construct(string $address = "", int $port = 22, string $userName = "", string $password = "")
    {
        parent::__construct($address, $port, $userName, $password);
    }

    public function connect(): bool
    {
        $this->connection = ssh2_connect($this->address, $this->port);

        switch (env('SSH_AUTH_TYPE')) {
            case "password":
                $connectionResponse = ssh2_auth_password($this->connection, $this->userName, $this->password);
                break;
            case "key":
                $connectionResponse = ssh2_auth_pubkey_file($this->connection, $this->userName, env('SSH_PUBLICKEYFILE_PATH'), env('SSH_PRIVATEKEYFILE_PATH'));
                break;
        }

        return (!$connectionResponse);
    }

    public function uploadFile($local_file, $remote_file): bool
    {
        $connectionResponse = $this->connect();

        $sftp = ssh2_sftp($this->connection);

        $stream = fopen("ssh2.sftp://$sftp" . "$remote_file", 'w');

        if (!$stream)
            throw new \Exception("Could not open file: $remote_file");

        $data_to_send = @file_get_contents($local_file);

        if ($data_to_send === false)
            throw new \Exception("Could not open local file: $local_file.");

        if (@fwrite($stream, $data_to_send) === false)
            throw new \Exception("Could not send data from file: $local_file.");

        @fclose($stream);

        return true;
    }
}
