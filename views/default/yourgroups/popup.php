<?php

$title = elgg_echo('yourgroups:title');
$header = "<h3 class=\"float\">$title</h3>";
/*
$groups = yourgroups_get_group_list();
if ($groups)
{
    //create HTML code out of array
    $body = '<ul class="elgg-list elgg-list-entity topbar-mygroups-list">';
    foreach ($groups as $group) {
        $group_GUID = $group->getGUID();
        $body .= '<li onClick="window.location.href=\''. elgg_get_site_url() .'groups/profile/' . $group_GUID . '\';">'.elgg_view('output/url', array('href' => "groups/profile/$group_GUID",'text' => $group->name,   'is_trusted' => true,)).'</a></li>';
    }   
    $body .= '</ul>';
}
else
{
    $body = elgg_echo('yourgroups:none');
}
*/
$body = '';
$vars = array(
    'class' => 'elgg-groups-popup hidden',
    'id' => 'groups-popup',
    'header' => $header
);

echo elgg_view_module('popup', '', $body, $vars);
