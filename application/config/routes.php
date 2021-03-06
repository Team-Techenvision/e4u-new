<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//define(SITE_ADMIN_URI,'SITE_ADMIN_URI');
$route['default_controller'] = 'home/';
$route['404_override'] = 'page_not_found/';
$route['translate_uri_dashes'] = FALSE;

$route['dashboard/(:num)'] = 'dashboard/index/$1';
$route['privacy'] = 'contact_us/privacy';
$route['about_us'] = 'contact_us/about_us';


$route[SITE_ADMIN_URI] = 'admin/index';
$route[SITE_ADMIN_URI.'/logout'] = 'admin/logout';
$route[SITE_ADMIN_URI.'/forgotpassword'] = 'admin/forgot_password';
$route[SITE_ADMIN_URI.'/resetpassword/(:any)'] = 'admin/reset_password/$1';
$route[SITE_ADMIN_URI.'/changepassword'] = 'admin/change_password';
$route[SITE_ADMIN_URI.'/dashboard'] = 'admin/dashboard';
$route['/subscribe'] = 'subscribe/index';
$default_controller="home";
$controller_exceptions = array('admin','home','dashboard','subscribe','create_tests','leaderboard','profile','login','tests','webservice','certificates','alerts','faq','contact_us','subjective','cron','page_not_found', 'meeting'); 
$route["^((?!\b".implode('\b|\b', $controller_exceptions)."\b).*)$"] = $default_controller.'/index/$1'; 
$route[SITE_ADMIN_URI.'/email_templates'] = 'admin/email_templates/index';
$route[SITE_ADMIN_URI.'/email_templates/(:num)'] = 'admin/email_templates/index/$1';
$route[SITE_ADMIN_URI.'/email_templates/edit/(:num)'] = 'admin/email_templates/edit/$1';
