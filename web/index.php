<?php
/**
 * piv description
 * 
 * @author Thomas Gray <thomas.gray@randomstorm.com>
 * @package 
 * @subpackage 
 */
$config = require(__DIR__ .'/../config.php');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/lib/autoload.php';

$app = new \Slim\Slim(array(
    'templates.path' => './views',
));

$pdo = new PDO('mysql:dbname=' . $config['db']['database'], $config['db']['username'], $config['db']['password']);
$serviceLoader = new \Service\ServiceLoader($pdo, $config);


$app->pdo = $pdo;
$app->serviceLoader = $serviceLoader;

$app->get('/', function() use($app)
{
    $hostService = $app->serviceLoader->get('Hosts'); /* @var Service\Hosts */
    $scanService = $app->serviceLoader->get('Scans'); /* @var Service\Scans */
    $reportService = $app->serviceLoader->get('Reports'); /* @var Service\Reports */

    $hosts = $hostService->getHosts();
    $scans = $scanService->getScans();
    $reports = $reportService->getAvailableReports();

    $nav = 'home';

    $app->render('index.php', compact('hosts', 'scans', 'reports', 'nav'));
});

$app->get('/hosts/', function() use($app)
{
    $hostService = $app->serviceLoader->get('Hosts'); /* @var Service\Hosts */

    $hosts = $hostService->getHosts();
    $nav = 'hosts';

    $app->render('hosts.php', compact('hosts', 'nav'));
});

$app->get('/reports/', function() use($app)
{
    $reportService = $app->serviceLoader->get('Reports'); /* @var Service\Reports */

    $reports = $reportService->getAvailableReports();
    $nav = 'reports';

    $app->render('reports.php', compact('reports', 'nav'));
});


$app->get('/reports/:reportId', function($reportId) use($app)
{
    $reportService = $app->serviceLoader->get('Reports'); /* @var Service\Reports */

    $report = $reportService->getReport($reportId);
    $nav = 'reports';

    $app->render('report_read.php', compact('report', 'nav'));
});

$app->get('/reset/', function() use($app)
{
    $app->render('reset.php', array('nav' => 'reset'));
});

$app->post('/reset/', function() use($app, $pdo)
{
    $pdo->exec('truncate table hosts');
    $pdo->exec('truncate table reports');
    $pdo->exec('truncate table scans');

    $app->redirect('/');
});

$app->run();