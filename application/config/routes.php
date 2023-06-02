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
$route['default_controller'] = 'frontend';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['blogs'] = "frontend/blogs";
// $route['blog/blog-detail'] = "frontend/blog_details";
$route['blog-details/(:any)'] = "frontend/blog_details/$1";
$route['symptomchecker'] = 'speciality/symptomchecker';
$route['symptomchecker/questionsAndanswers'] = 'speciality/symptomcheckerQuestionsAndAnswers';
$route['symptomchecker/addquestionanswer'] = 'speciality/addquestionanswer';
$route['symptomchecker/editquestionsAndanswers/(:num)'] = 'speciality/editsymptomcheckerQuestionsAndAnswers/$1';
$route['talk'] = 'frontend/talkmessenger';
$route['drive'] = 'frontend/drive';
$route['docshare'] = 'frontend/docshare';
$route['health-welness'] = 'frontend/healthandwellness';
$route['learn-medical'] = 'frontend/learnmedical';
$route['community'] = 'frontend/community';
$route['lab-test'] = 'frontend/labtest';


