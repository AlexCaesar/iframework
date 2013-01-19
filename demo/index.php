<?php
error_reporting(E_ALL);

include_once(dirname(__FILE__) . "/../OO.php");
$conf = include(dirname(__FILE__) . "/iconf.php");
OO::createApp($conf)->go();

/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */
