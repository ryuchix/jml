<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['reports'] = 'reports/reportscontroller/index';
$route['reports/clients'] = 'reports/ClientReportController/index';
$route['reports/leads'] = 'reports/LeadReportController/index';
$route['reports/client/filter'] = 'reports/ClientReportController/filters';
$route['reports/bin-liner-management'] = 'reports/Bin_liner_management_controller/pdf';
$route['reports/bin-liner-management/filter'] = 'reports/Bin_liner_management_controller';
$route['reports/suppliers/pdf'] = 'reports/suppliers_controller';
$route['reports/councils/pdf'] = 'reports/council_controller';
$route['reports/properties/keys'] = 'reports/property_key_controller/pdf';
$route['reports/properties/bins'] = 'reports/property_bin_controller/pdf';
$route['reports/properties/services'] = 'reports/Property_services_controller/index';
$route['reports/daily-income'] = 'reports/Daily_income_controller/filter';
$route['reports/daily-income/filter'] = 'reports/Daily_income_controller/index';
$route['schedules/list'] = 'reports/Schedule_controller/index';
$route['schedules/map'] = 'reports/Schedule_controller/map';
$route['schedules/weekly'] = 'reports/Schedule_controller/weekly';
$route['schedules/weekly-visits'] = 'reports/Schedule_controller/weeklyPost';
$route['schedules/costing'] = 'reports/Schedule_controller/costing';
$route['schedules/costing-filter'] = 'reports/Schedule_controller/costingFilter';


$route['clients/(:num)/marketing/save_note'] = 'Client_marketing_controller/save_note/$1';
$route['clients/(:num)/marketing/save_note/(:num)'] = 'Client_marketing_controller/save_note/$1/$2';
$route['clients-credentails'] = 'client/send_credentails';
$route['client/change-password'] = 'client/change_password';
$route['client/login'] = 'Client_login_controller/login';

$route['client/dashboard'] = 'clients/dashboard/index';
// $route['clients/properties'] = 'clients/properties/index';



$route['clients-marketing/(:num)/logs'] = 'Client_marketing_controller/index/$1';

$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/user/login'] = 'api/user/login'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
 


$route['tasks'] = 'Tasks_controller/index';
$route['tasks/create'] = 'Tasks_controller/create';
$route['tasks/store'] = 'Tasks_controller/store';
$route['tasks/(:num)/edit'] = 'Tasks_controller/$1/edit';
$route['tasks/(:num)/update'] = 'Tasks_controller/$1/update';


$route['bin-cleaning-costing'] = 'BinCleaningCostingController/index';
$route['bin-cleaning-costing/create'] = 'BinCleaningCostingController/create';
$route['bin-cleaning-costing/store'] = 'BinCleaningCostingController/store';
$route['bin-cleaning-costing/(:num)/edit'] = 'BinCleaningCostingController/edit/$1';
$route['bin-cleaning-costing/(:num)/update'] = 'BinCleaningCostingController/update/$1';
$route['bin-cleaning-costing/(:num)/delete'] = 'BinCleaningCostingController/destroy/$1';

$route['ciqb-integrator'] = 'Qb_oauth_endpoint/index';