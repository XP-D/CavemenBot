<?php

function formattedDate($timestamp) {
    return date('Y-n-j-H:i:s', $timestamp);
}

function setLog($logName, $message) {
    $logName = strtoupper($logName);
    $message = ucfirst(strtolower($message));
    $logTime = formattedDate(time());
    echo "[$logTime : $logName]: $message", PHP_EOL;
};