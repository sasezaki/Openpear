<?php
require_once dirname(__DIR__). '/__settings__.php';
import('org.openpear.flow.parts.Openpear');

$queue = C(OpenpearNewprojectQueue)->find_get(Q::lt('trial_count', 5), Q::order('id'));
$queue->create();
