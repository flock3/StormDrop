<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/images/favicon.png">

    <title>StormDrop</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <?php if($nav == 'reports'): echo '<link href="/css/report.css" rel="stylesheet">'; endif; ?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">StormDrop</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li<?php if($nav == 'home') echo ' class="active"'; ?>><a href="/">Home</a></li>
                <li<?php if($nav == 'hosts') echo ' class="active"'; ?>><a href="/hosts/">Hosts</a></li>
                <li<?php if($nav == 'reports') echo ' class="active"'; ?>><a href="/reports/">Reports</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li<?php if($nav == 'reset') echo ' class="active"'; ?>><a href="/reset/">Reset Data</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>

<div class="container">
