<?php

use Castor\Attribute\AsTask;
use phpseclib3\Net\SFTP;

require_once __DIR__ . '/vendor/autoload.php';

#[AsTask]
function sftp(): void
{
    $sftp = new SFTP('127.0.0.1');
    dd(get_class($sftp));
}