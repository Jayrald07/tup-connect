<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['groups'] = "lobby";
$route["lobby/create"] = "lobby/create";
$route["lobby/submit"] = "lobby/submit";

$route['fw'] = "freedom_wall";
$route["fw/post"] = "freedom_wall/post";
$route["fw/submit"] = "freedom_wall/submit";

$route["organizations"] = "organization";

$route['forum'] = "forum";
$route["forum/(:any)"] = "forum/forum/$1";
$route["frm/post"] = "forum/post";

$route['groups/edit/(:any)'] = "lobby/edit/$1";
$route['fw/edit/(:any)'] = "freedom_wall/edit/$1";
$route['forum/edit/(:any)'] = "forum/edit/$1";

$route["remove/(:any)"] = "lobby/remove/$1";

$route["login"] = "login";
$route["login/authenticate"] = "login/authenticate";
$route["login/forgotPass"] = "login/forgotPass";

$route["register"] = "register";
$route["register/validation"] = "register/validation";

$route["verify"] = "register/verify";
$route["verify_email"] = "register/verify_email";

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route["groups/(:any)"] = "lobby/groups/$1";
$route["organizations/(:any)"] = "organization/org/$1";

$route['post'] = "lobby/post";
$route["comment/insert"] = "lobby/insert_comment";
$route["comment/get"] = "lobby/get_comments";

$route["post/vote"] = "post_controller/vote";

$route["post/report"] = "post_controller/report";
$route["post/user_report"] = "post_controller/user_report";
$route["post/block_user"] = "post_controller/block_user";


$route["post/delete"] = "post_controller/delete_post";
$route["post/is_delete"] = "post_controller/is_allowed_deletion";

$route["post/getone"] = "post_controller/get_post";
$route["post/update"] = "post_controller/update_post";

$route["org/post"] = "organization/post";
$route["signout"] = "login/signout";


$route["add_group"] = "lobby/add_group";

$route["search_group"] = "lobby/search_group";
$route["join_group"] = "lobby/join_group";
$route["cancel_group_request"] = "lobby/cancel_group_request";
$route["member/delete"] = "lobby/remove_group_user";

$route["groups/admin/(:any)"] = "lobby/admin/$1";

$route["group/update_status"] = "lobby/group_user_update_status";
$route["report/update_status"] = "lobby/update_post_reported";
$route["group/add_role"] = "lobby/add_role";
$route["role/delete_role"] = "lobby/delete_role";
$route["role/members"] = "lobby/get_group_user_roles";
$route["role/no_roles"] = "lobby/get_group_user_hasno_roles";
$route["role/add_member_role"] = "lobby/get_group_user_hasno_roles";
$route["role/update_member_role"] = "lobby/update_group_user_role";
$route["role/get_permission"] = "lobby/get_permission";
$route["role/toggle_permission"] = "lobby/toggle_permission";
$route["role/clear_permission"] = "lobby/clear_permission";
$route["account"] = "account";
$route["settings"] = "account/settings";
$route["activities"] = "account/activities";
$route["update_profile"] = "account/update";
$route["delete_comment"] = "post_controller/delete_comment";
$route["update_comment"] = "post_controller/update_comment";