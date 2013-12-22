<?php require('includes/header.php'); ?>

    <div class="col-xs-12">

            <h3>Hosts</h3>
            <p>We have found <?php echo count($hosts); ?> hosts</p>

            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>IP Address</td>
                        <td>Operating System</td>
                    </tr>
                </thead>
                <tbody>
                <?php

                foreach($hosts as $host)
                {
                    echo '<tr><td>' . $host['id'] . '</td><td>' . $host['ipAddress'] . '</td><td>' . $host['os'] . '</td>';
                }

                ?>
                </tbody>
            </table>

    </div>

<?php require('includes/footer.php'); ?>