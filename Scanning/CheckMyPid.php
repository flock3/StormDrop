<?php

$pidLocation = '/tmp/stormdrop.' . basename($_SERVER['PHP_SELF']) . '.pid';

$pid = getmypid();

if(file_exists($pidLocation))
{
    $pid = trim(file_get_contents($pidLocation));

    if(posix_kill($pid, 0))
    {
        die('Another process is running already in: ' . $pidLocation . PHP_EOL);
    }
}

file_put_contents($pidLocation, $pid);