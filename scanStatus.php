<?php

require(__DIR__ . '/Scanning/CheckMyPid.php');

require(__DIR__ . '/autoloader.php');
require(__DIR__ . '/database.php');


$scans = $pdo->query('SELECT * from scans WHERE completed=0')->fetchAll(PDO::FETCH_ASSOC);


$thereAreTasksActive = true;
if(empty($scans))
{
    $thereAreTasksActive = false;
}

$update = $pdo->prepare('UPDATE scans SET percentComplete=? WHERE id=?');
while($thereAreTasksActive)
{
    foreach($scans as $key => $scan)
    {
        $statusResponse = exec('omp -X \'<get_tasks task_id="' . $scan['taskId'] . '" />\'');

        if('<' != substr($statusResponse, 0, 1))
        {
            continue;
        }

        $response = simplexml_load_string($statusResponse);

        $progress = (string)$response->task->progress;

        if($progress >= 0)
        {
            $update->execute(array($progress, $scan['id']));
        }

        if($progress < 0)
        {
            $pdo->exec('update scans set completed=1, percentComplete=100 WHERE id=' . $scan['id']);
            unset($scans[$key]);

            if(empty($scans))
            {
                $thereAreTasksActive = false;
            }

            $reportId = (string)$response->task->last_report->attributes()->id;

            $pdo->exec('UPDATE scans set reportId=' . $pdo->quote($reportId) . ' WHERE id=' . $scan['id']);
        }

    }

    sleep(20);
}


