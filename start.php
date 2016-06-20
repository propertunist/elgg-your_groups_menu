<?php
/**
 * Dropdown menu for access to groups and invitations - refreshes via ajax
 *
 */

 elgg_register_event_handler('init', 'system', 'yourgroups_init');

/**
 * Initialize the plugin
 *
 * @return void
 */
function yourgroups_init () {
    if (elgg_is_logged_in())
    {
        elgg_extend_view('elgg.css', 'yourgroups/css');
        // Add hidden popup module to topbar
        elgg_extend_view('page/elements/topbar', 'yourgroups/popup');
        elgg_require_js('yourgroups/yourgroups');
        elgg_register_page_handler('yourgroups', 'yourgroups_page_handler');
        elgg_register_plugin_hook_handler('register', 'menu:topbar', 'yourgroups_topbar_menu_setup');
    }
}

/**
 * Add group menu icon to topbar menu
 *
 * The menu item opens a popup module defined in view yourgroups/popup
 *
 * @param string         $hook   Hook name
 * @param string         $type   Hook type
 * @param ElggMenuItem[] $return Array of menu items
 * @param array          $params Hook parameters
 * @return ElggMenuItem[] $return
 */
function yourgroups_topbar_menu_setup ($hook, $type, $return, $params) {

    $viewer = elgg_get_logged_in_user_entity();
    $groups = $viewer->getGroups(array('limit'=>0),0);
    $invitation_count = count(groups_get_invited_groups($viewer->guid, true));
    $count = count($groups);
    $tooltip = elgg_echo("yourgroups:tooltip", array($count));
    if ($invitation_count > 0)
    {
        if ($invitation_count > 99) {
            // Don't allow the counter to grow endlessly
            $invitation_count = '99+';
        }
        $text = "<span id=\"groups-new\" $hidden>$invitation_count</span>";
    }
    else
        $text = '';

    $text = '<span class="elgg-icon fa fa-group">' . $text . '</span>';

    $item = ElggMenuItem::factory(array(
        'name' => 'yourgroups',
        'href' => '#groups-popup',
        'text' => $text,
        'priority' => 250,
        'title' => $tooltip,
        'rel' => 'popup',
        'id' => 'groups-popup-link'
    ));

    $return[] = $item;
    return $return;
}

/**
 * Make the groups list for the groups popup menu
 *
 * @return String or false;
 */

function get_alpha_group_list($viewer) {
    if (!$viewer)
        $viewer = elgg_get_logged_in_user_entity();
    $groups = $viewer->getGroups(array('limit'=>0),0);
    if ($groups)
    {
        $count = count($groups);
        if ($count > 1)
            $groups = casort($groups, "name");

        return $groups;
    }
    else
        return false;
}

/**
 * sorts an array alphabetically
 *
 * @return String or false;
 */

function casort($arr, $var) {
   $tarr = array();
   $rarr = array();
   for($i = 0; $i < count($arr); $i++) {
      $element = $arr[$i];
      $tarr[] = strtolower($element->{$var});
   }

   reset($tarr);
   asort($tarr);
   $karr = array_keys($tarr);
   for($i = 0; $i < count($tarr); $i++) {
      $rarr[] = $arr[intval($karr[$i])];
   }

   return $rarr;
}

/**
 * page handler for yourgroups menu
 *
 *
 * @param array $page Array of URL segments
 * @return bool Was the page handled successfully
 */

function yourgroups_page_handler ($page) {
    gatekeeper();

    if (empty($page[0])) {
        $page[0] = 'popup';
    }

    $path = elgg_get_plugins_path() . 'yourgroups_menu/pages/yourgroups/';

    switch ($page[0]) {
        case 'popup':
        default:
            include_once($path . 'popup.php');
            break;
    }

    return true;
}
