#!/bin/bash

#Run the scanner
openvassd
#Run the manager
openvasmd -p 9390 -a 127.0.0.1
#Run the administrator
openvasad -a 127.0.0.1 -p 9393
#Run the web back end
gsad --http-only -p 9392

PHP=`which php`

$PHP ../start.php
$PHP ../scan.php
$PHP ../report.php