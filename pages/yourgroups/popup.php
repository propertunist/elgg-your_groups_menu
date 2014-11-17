<?php

$groups = get_alpha_group_list(null);
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

$invitation_count = count(groups_get_invited_groups(elgg_get_logged_in_user_guid(), true));

if ($invitation_count > 0)
{
    if ($invitation_count > 99999) {
        // Don't allow the counter to grow endlessly
        $invitation_count = '99999+';
    }
    $invite_text = elgg_echo('groups:invitations:pending',array($invitation_count)) . ' ' .  elgg_view_icon('mail'); 
    $user = elgg_get_logged_in_user_entity();
    $username = $user->username;
    $body .= '<hr>';
    $body .= elgg_view('output/url', array('text' => $invite_text,
                                           'href' => 'groups/invitations/' . $username,
                                           'id' => 'yourgroups-invites',
                                           'is_trusted' => true,));
}
echo $body; 