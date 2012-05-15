<?php

include '../classes/logger.class.php';

$log = Logger::new_log('log1', 'log');
$log->log('This is a log message 1');
$log->debug('This is a debug message 1');
$log->warn('This is a warn message 1');
$log->error('This is a error message 1');