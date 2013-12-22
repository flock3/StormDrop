<?php require('includes/header.php'); ?>

    <div class="col-xs-12">
        <div class="col-6 col-sm-6 col-lg-4">
            <h3>Hosts</h3>
            <p>We have found <?php echo count($hosts); ?> <a href="/hosts/">hosts</a></p>
            <?php

            if(!empty($hosts))
            {
                echo '<ul>';
                foreach($hosts as $host)
                {
                    echo '<li>' . $host['ipAddress'] . '</li>';
                }
                echo '</ul>';
            }

            ?>
        </div>
        <div class="col-6 col-sm-6 col-lg-4">
            <h3>Scans</h3>
            <?php

            if(empty($scans))
            {
                echo "<p>There aren't any scans running yet - be patient, they will start when host collection finishes.</p>";
            }

            foreach($scans as $scan)
            {
                echo '<p>Task: ' . substr($scan['taskId'], 0,5) . ', is ' . $scan['percentComplete'] . '% completed.</p>';
            }

            ?>
        </div>
        <div class="col-6 col-sm-6 col-lg-4">
            <h3>Reports</h3>
            <?php

            if(empty($reports))
            {
                echo '<p>Sorry, there aren\'t any reports finshed yet, they won\'t show here until the full scan finishes</p>';
            }

            foreach($reports as $report)
            {
                echo '<p>Report ' . substr($report['reportId'], 0, 5) . ' is finished, you can <a href="/reports/' . $report['reportId'] . '">view it</a>.</p>';
            }
            ?>
        </div>
    </div>

<?php require('includes/footer.php'); ?>