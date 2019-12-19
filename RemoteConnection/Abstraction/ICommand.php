<?php


namespace App\Medianova\RemoteConnection\Abstraction;


interface ICommand
{
    function execute():bool;
}
