<?php

require(__DIR__ . '/Scanning/CheckMyPid.php');

/**
 * Scan network to retrieve hosts and services information.
 */

require(__DIR__ . '/autoloader.php');
require(__DIR__ . '/database.php');

$network = exec('hostname --all-ip-addresses');

if(empty($network))
{
    throw new RuntimeException('Could not a network hostname.');
}

$network = explode(' ', $network);

$network = $network[0];


$addressParts = explode('.', $network);

if(4 !== count($addressParts))
{
    throw new RuntimeException('Address format after exploding was in the wrong format!');
}

$addressParts[3] = '0/24';

$network = implode('.', $addressParts);
//Define the target to scan
$target = array($network);

$namp = new Scanning\Nmap();

$activeHosts = $namp->getActiveHosts($target);

$hosts = array();
$prepared = $pdo->prepare('INSERT INTO hosts (ipAddress, os) VALUES(?, ?)');

foreach($activeHosts as $host) /* @var Net_Nmap_Host $host */
{
    $executeOkay = $prepared->execute(array(
        $host->getAddress('ipv4'),
        $host->getOS()
    ));

    if(!$executeOkay)
    {
        throw new RuntimeException('Could not add IPv4 address and OS into hosts table.');
    }
}