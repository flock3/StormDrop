<?php

$config = require(__DIR__ . '/config.php');

$pdo = new PDO('mysql:dbname=' . $config['db']['database'], $config['db']['username'], $config['db']['password']);