<?php require('includes/header.php'); ?>

<div class="col-xs-12">

    <h2>Report</h2>
    <p>This report has been run across: <?php echo $report['hostCount']; ?> hosts.</p>

    <?php


    $reportData = unserialize($report['report']);

    ?>


        <?php

        foreach($reportData['asset-report-collection']['reports']['report'] as $report)
        {
            $report = $report['value']['content']['host']['result'];

            $container = md5($report[0]['value']['host']);

            echo '<h3 class="assetHeader" data-container="' . $container . '">Report for: ' . $report[0]['value']['host']. '</h3>';

            echo '<div id="' . $container . '" class="hide">';
            echo '<h4>Vulnerabilities</h4>';


            echo '<table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <td>Short Description</td>
            <td>CVSS</td>
            <td>Risk Level</td>
            <td>Port</td>
            <td>Description</td>
        </tr>
        </thead>
        <tbody>';
            $ports = array();
            foreach($report as $vulnerability)
            {
//                echo '<pre>';var_dump($vulnerability);die();

                $nvt = $vulnerability['value']['nvt']['value'];


                $port = $vulnerability['value']['port'];
                $cvss = (array_key_exists('cvss_base', $nvt) ? $nvt['cvss_base'] : 'Unknown');
                $riskBase = (array_key_exists('risk_factor', $nvt) ? $nvt['risk_factor'] : 'Unknown');
                $name = (array_key_exists('name', $nvt) ? $nvt['name'] : 'Unknown');
                $description = $vulnerability['value']['description'];

                $ports[] = $port;

                $trClasses = array();
                if(empty($name))
                {
                    $trClasses[] = 'noDescription';
                }

                if($riskBase == 'None')
                {
                    $trClasses[] = 'lowInterest';
                }

                if($cvss == '0.0')
                {
                    $trClasses[] = 'lowInterest';
                }

                if($description == 'Open port.')
                {
                    $trClasses[] = 'portOnly';
                }

                echo '<tr class="' . implode(' ', array_unique($trClasses)) . '">
                <td>' . $name . '</td>
                <td>' . $cvss . '</td>
                <td>' . $riskBase . '</td>
                <td>' . $port . '</td>
                <td class="descriptionTd" data-description="' . $description . '">' . substr($description, 0, 20) . '...</td>
                </tr>';
            }

            echo '
        </tbody>
    </table>';


            echo '<h4>Ports</h4>';
            echo '<table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <td>Service</td>
            <td>Port</td>
            <td>Protocol</td>
        </tr>
        </thead>
        <tbody>';

            $ports = array_unique($ports);
            foreach($ports as $port)
            {
                preg_match('/(\w+)\s\((\d+)\/(\w+)\)/', $port, $matches);

                if(empty($matches))
                {
                    continue;
                }

                echo '<tr><td>' . $matches[1] . '</td><td>' . $matches[2] . '</td><td>' . $matches[3] . '</td></tr>';
            }
            echo '</tbody></table>';

            echo '</div>';

        }

        ?>
</div>

<?php require('includes/footer.php'); ?>