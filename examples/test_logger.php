<?php

include '../classes/logger.class.php';

$log = new Logger('log', 'log');
$log2 = new Logger('log2', 'log');

$log->log('This is a log message 1');
$log->debug('This is a debug message 1');
$log->warn('This is a warn message 1');
$log->error('This is a error message 1');



$log2->log('This is a log message 2');
$log2->debug('This is a debug message 2');
$log2->warn('This is a warn message 2');
$log2->error('This is a error message 2');