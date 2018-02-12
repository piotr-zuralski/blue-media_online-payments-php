<?php

$phpversion = phpversion();
$phpversionArray = explode('-', $phpversion);
$phpversion = ((is_array($phpversionArray) && isset($phpversionArray['0'])) ? $phpversionArray['0'] : $phpversionArray);
echo $phpversion;
