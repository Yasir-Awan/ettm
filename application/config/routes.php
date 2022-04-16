<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['api/login'] = 'api/ApiLoginController/index';
// $route['api/site_inventory/(:any)'] = 'api/ApiSiteInventoryController/index/$1';
$route['api/filtered_site_inventory/(:any)/(:any)'] = 'api/ApiFilteredSiteInventoryController/index/$1/$2';
$route['api/item_detail/(:any)'] = 'api/ApiItemDetailController/index/$1';
$route['api/item_faulty/(:any)'] = 'api/ApiItemFaultyController/index/$1';
/** Routes for repairing items START */
$route['api/item_repair_warranty'] = 'api/ApiItemRepairWarrantyController/index';
$route['api/item_repair_standard/(:any)'] = 'api/ApiItemRepairStandardController/index/$1';
$route['api/admin_details/(:any)'] = 'api/ApiAdminDetailsController/index/$1';
$route['api/supervisor_details/(:any)'] = 'api/ApiSupervisorDetailsController/index/$1';
$route['api/member_details/(:any)'] = 'api/ApiMemberDetailsController/index/$1';
$route['api/tsp_company_details/(:any)'] = 'api/ApiTspCompanyDetailsController/index/$1';
/** Routes for repairing items END */
/** Reinstall Equipment Start */
$route['api/item_reinstall/(:any)'] = 'api/ApiItemReinstallController/index/$1';
/** Reinstall Equipment End */
/** Reinstall Equipment Start */
$route['api/item_retire/(:any)'] = 'api/ApiItemRetireController/index/$1';
/** Reinstall Equipment End */

/** UPS API START */
$route['api/upsdata_list'] = 'upsapi/ApiUpsDataListController/index';
$route['api/adminlogin'] = 'upsapi/ApiAdminLoginController/index';
/** UPS API END*/

/** API to write json data in file START */
$route['api/write_file'] = 'file_api/WriteDataToFileController/index';
/** API to write json data in file END */
