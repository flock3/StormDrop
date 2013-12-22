<?php require('includes/header.php'); ?>

    <div class="col-xs-12">

            <h3>Reports</h3>
            <p>We have found <?php echo count($reports); ?> reports</p>

            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Hosts</td>
                        <td>View</td>
                    </tr>
                </thead>
                <tbody>
                <?php

                foreach($reports as $report)
                {
                    echo '<tr><td>' . $report['reportId'] . '</td><td>' . $report['hostCount'] . '</td><td><a href="/reports/' . $report['reportId'] . '">View</a></td>';
                }

                ?>
                </tbody>
            </table>

    </div>

<?php require('includes/footer.php'); ?>