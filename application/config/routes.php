<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'login';
$route['groups'] = "lobby";
$route["lobby/create"] = "lobby/create";
$route["lobby/submit"] = "lobby/submit";

$route['fw'] = "freedom_wall";
$route["fw/create"] = "freedom_wall/create";
$route["fw/submit"] = "freedom_wall/submit";

$route['forum'] = "forum";
$route["forum/create"] = "forum/create";
$route["forum/submit"] = "forum/submit";

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

$route["lobby/report/(:any)"] = "lobby/report/$1";
$route["fw/report/(:any)"] = "freedom_wall/report/$1";
$route["forum/report/(:any)"] = "forum/report/$1";

$route["lobby/user_report/(:any)"] = "lobby/user_report/$1";
$route["fw/user_report/(:any)"] = "freedom_wall/user_report/$1";
$route["forum/user_report/(:any)"] = "forum/user_report/$1";

$route["groups/(:any)"] = "lobby/groups/$1";

$route['post'] = "lobby/post";
