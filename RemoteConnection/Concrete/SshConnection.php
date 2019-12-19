<?php

namespace App\Medianova\RemoteConnection\Concrete;

use App\Medianova\RemoteConnection\Abstraction\AbstractRemoteConnection;
use App\Medianova\RemoteConnection\Abstraction\ISshConnection;

class SshConnection extends AbstractRemoteConnection implements ISshConnection
{
    protected $shell;

    public function __construct(string $address = "", int $port = 22, string $userName = "", string $password = "")
    {
        $this->usePublicKey = false;

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


        return $connectionResponse;
    }

    public function doCommand(string $command, bool $isNeedSudo = false): bool
    {

        if (!$this->connect())
            return false;

        if ($isNeedSudo) {
            $command = "sudo " . $command;
        }

        $this->shell = ssh2_shell($this->connection);

        fwrite($this->shell, $command . PHP_EOL);

        sleep(1);

        if ($isNeedSudo) {
            fwrite($this->shell, $this->password . PHP_EOL);
            sleep(1);
        }

        $commandResult = "";

        while ($buffer = fgets($this->shell)) {
            flush();
            $commandResult .= $buffer;
        }

        return true;
    }
}
