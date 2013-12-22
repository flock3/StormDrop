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

    $app->render('index.php', compact('hosts', 'scans', 'reports'));
});

$app->get('/hosts', function() use($app)
{
    $hostService = $app->serviceLoader->get('Hosts'); /* @var Service\Hosts */

    $hosts = $hostService->getHosts();

    $app->render('hosts.php', compact('hosts'));
});

$app->run();