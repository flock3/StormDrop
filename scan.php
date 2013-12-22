<?php
/**
 * Scan file will go off and fetch target hosts and create them within OpenVas, it will put ID's into DB
 *
 * Scan will create a task including all of the target hosts (excluding localhost)
 *
 * Scan will put task id into database
 *
 * Scan will start scan
 */

require(__DIR__ . '/Scanning/CheckMyPid.php');

require(__DIR__ . '/autoloader.php');
require(__DIR__ . '/database.php');

$hosts = $pdo->query('select * from hosts')->fetchAll(PDO::FETCH_ASSOC);

if(empty($hosts))
{
    echo 'There are not any hosts yet, I won\'t scan just yet..' . PHP_EOL;
    exit;
}

$foundHosts = array();
foreach($hosts as &$host)
{
    $foundHosts[] = $host['ipAddress'];
}

$xml = 'omp -X \'<create_target><name>Found Targets (' . date('d/m/Y') . ')</name><hosts>' . implode(',', $foundHosts) . '</hosts></create_target>\'';

echo 'Running: ' . $xml . PHP_EOL;

$response = exec($xml);

echo 'Response: ' . $response . PHP_EOL;

$xml = simplexml_load_string($response);

if(!isset($xml->attributes()->id))
{
    throw new RuntimeException('Target creation failed!');
}

$targetId = (string)$xml->attributes()->id;

$query = 'UPDATE hosts SET targetId=' . $pdo->quote($targetId);

$pdo->exec($query);

$taskXml = '<create_task>
  <name>Scan Found hosts (' . date('d/m/Y') . ')</name>
  <comment>Scan for hosts found inside network</comment>
  <config id="' . $config['openvas']['scanId'] . '"/>
  <target id="' . $targetId .'"/>
</create_task>';

echo 'Running: ' . $taskXml . PHP_EOL;

$taskResponse = exec('omp -X \'' . $taskXml . '\'');

$xml = simplexml_load_string($taskResponse);

if(!isset($xml->attributes()->id))
{
    throw new RuntimeException('Task creation failed!');
}

$taskId = (string)$xml->attributes()->id;

$pdo->exec('INSERT INTO scans (taskId,targetId) VALUES(' . $pdo->quote($taskId) . ',' . $pdo->quote($targetId) . ')');

$taskStartXml = '<resume_or_start_task task_id="' . $taskId . '" />';

echo 'Running: ' . $taskStartXml . PHP_EOL;

$taskStartResponse = exec('omp -X \'' . $taskStartXml . '\'');

echo 'Returned: ' . $taskStartResponse . PHP_EOL;

$xml = simplexml_load_string($taskStartResponse);

if(!isset($xml->attributes()->status))
{
    throw new RuntimeException('Task starting creation failed!');
}

$taskStartStatus = (string) $xml->attributes()->status;

if(substr($taskStartStatus, 0, 1) != 2)
{
    throw new RuntimeException('Could not start the scan task');
}
