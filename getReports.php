<?php

require(__DIR__ . '/autoloader.php');
require(__DIR__ . '/database.php');


$scans = $pdo->query('SELECT scans.* from scans LEFT JOIN reports on scans.taskId=reports.taskId WHERE reports.id IS NULL AND scans.completed=1 AND scans.reportId IS NOT NULL')->fetchAll(PDO::FETCH_ASSOC);


$thereAreReportsToRetrieve = true;
if(empty($scans))
{
    $thereAreReportsToRetrieve = false;
}

$update = $pdo->prepare('INSERT INTO reports (taskId, reportId, report) VALUES(?,?,?)');
while($thereAreReportsToRetrieve)
{
    foreach($scans as $key => $scan)
    {
//        $command = 'omp -X \'<get_reports report_id="' . $scan['reportId'] . '" format_id="' . $config['openvas']['reportOutputId'] . '" />\'';
//
//        $results = exec($command);

//        $data = simplexml_load_string($results);

//        unset($results);

        $data = simplexml_load_file(__DIR__ . '/web/report2.xml');

        $reportArray = xmlToArray($data);

        $results = serialize($reportArray);

        $update->execute(array(
            $scan['taskId'],
            $scan['reportId'],
            $results
        ));

        unset($scans[$key]);

        if(empty($scans))
        {
            $thereAreReportsToRetrieve = false;
        }
    }
}



/**
 * Convert a SimpleXML object into an array (last resort).
 *
 * @access public
 * @param object $xml
 * @param boolean $root - Should we append the root node into the array
 * @return array
 */
function xmlToArray($xml, $root = true) {

    if (!$xml->children()) {
        return (string)$xml;
    }

    $array = array();
    foreach ($xml->children() as $element => $node) {
        $totalElement = count($xml->{$element});

        if (!isset($array[$element])) {
            $array[$element] = "";
        }

        // Has attributes
        if ($attributes = $node->attributes()) {
            $data = array(
                'attributes' => array(),
                'value' => (count($node) > 0) ? xmlToArray($node, false) : (string)$node
                // 'value' => (string)$node (old code)
            );

            foreach ($attributes as $attr => $value) {
                $data['attributes'][$attr] = (string)$value;
            }

            if ($totalElement > 1) {
                $array[$element][] = $data;
            } else {
                $array[$element] = $data;
            }

            // Just a value
        } else {
            if ($totalElement > 1) {
                $array[$element][] = xmlToArray($node, false);
            } else {
                $array[$element] = xmlToArray($node, false);
            }
        }
    }

    if ($root) {
        return array($xml->getName() => $array);
    } else {
        return $array;
    }
}