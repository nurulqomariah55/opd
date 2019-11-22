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
//GENERAL PAGE
$route['default_controller'] = 'Auth';
$route['forget'] = 'auth/reset_password';
$route['logout'] = 'auth/logout';
$route['dashboard'] = 'C_User';

$route['route/search/([A-Za-z])'] = 'C_User/search/$1';

// //MANAGE DATA PATROL
 $route['data/chart/?([A-Za-z])?/']= 'C_User/dataChart/$1/';
 $route['data/chart/([A-Za-z])/?(:any)?'] = 'C_User/dataChart/$1/$2'; 
 $route['data/standard/([A-Za-z])'] = 'C_User/dataStandard/$1';
 $route['data/show'] = 'C_User/showData';
 $route['data/save'] = 'C_User/save';

//MANAGE LOCATION
$route['location'] = 'C_Location/location';
$route['location/?([A-Za-z])?/']= 'C_Location/detail/$1/';
 $route['location/([A-Z])/?(:any)?'] = 'C_Location/detail/$1/$2';
 $route['location/([A-Za-z])/?(:any)?/([0-9])'] = 'C_Location/detail/$1/$2/$3';
$route['location/list'] = 'C_Location/add';
$route['location/delete/(:any)'] = 'C_Location/delete/$1';
$route['location/edit/(:any)'] = 'C_Location/edit/$1';
$route['location/data'] = 'C_Location/dataLoc';

$route['404_override'] = 'C_Location/error';
$route['translate_uri_dashes'] = FALSE;
