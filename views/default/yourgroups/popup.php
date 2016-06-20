<?php

$title = elgg_echo('yourgroups:title');
$header = "<h3 class=\"float\">$title</h3>";

$body = '';
$vars = array(
    'class' => 'elgg-groups-popup hidden',
    'id' => 'groups-popup',
    'header' => $header
);

echo elgg_view_module('popup', '', $body, $vars);
