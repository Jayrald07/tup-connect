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

$route["post/delete"] = "post_controller/delete_post";
$route["post/is_delete"] = "post_controller/is_allowed_deletion";

$route["post/getone"] = "post_controller/get_post";
$route["post/update"] = "post_controller/update_post";

$route["org/post"] = "organization/post";
