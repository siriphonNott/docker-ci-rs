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
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'lead/leadView';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

//Users
$route['login'] = 'users/login';
$route['users/authen'] = 'users/authen';
$route['users/change_password'] = 'users/change_password';
$route['users/logout'] = 'users/logout';

$route['users/delete'] = 'users/delete';
$route['users/password_update'] = 'users/updatePassword';
$route['users/insert'] = 'users/insert';
$route['users/update'] = 'users/update';
$route['users/getDataTable'] = 'users/usersTable/getDataTable';

//Manage
$route['manage/users'] = 'users/dataTable';
$route['manage/users/create'] = 'users/create';
$route['manage/users/delete'] = 'users/delete';
$route['manage/users/edit/(:num)'] = 'users/edit';

//Lead
$route['lead/leadManage'] = "lead/leadManage";
$route['lead/getDataNotAllocate'] = "lead/leadManage/getTableNotAllocate";
$route['lead/transferToAgent'] = "lead/leadManage/transferToAgent";
$route['lead/allocate'] = "lead/leadManage/allocate";
$route['lead/delete'] = "lead/leadManage/deleteLead";

//Expired
$route['lead/expiredLead'] = "lead/leadManage/expiredLead";
$route['lead/getDataTableLeadExpire'] = "lead/leadManage/getDataExpireDate";
$route['lead/reallocate'] = "lead/leadManage/reAllowcation";

//PhoneBlockList
$route['lead/phoneBlockList'] = "lead/leadManage/phoneBlockList";
$route['lead/getDataPhoneBlockList'] = 'lead/LeadManage/getDataPhoneBlockList';
$route['lead/postPhoneBlockList'] = 'lead/LeadManage/postPhoneBlockList';
$route['lead/deletePhoneBlockList'] = 'lead/LeadManage/deletePhoneBlockList';

//leadView
$route['lead/getDropdrow'] = "lead/leadView/getDataDropdrow";
$route['lead/getDetailLead'] = "lead/leadView/getDetailLead";
$route['lead/edit/(:num)'] = "lead/leadView/edit";
$route['lead/updateDetail'] = "lead/leadView/updateDetail";
$route['lead/leadView'] = "lead/leadView";
$route['lead/api'] = "lead/leadView/api";
$route['lead/getDataTable/leadView'] = "lead/leadView/getDataTable";
$route['lead/getDashBoard'] = "lead/leadView/getDashBoard";
$route['lead/historicalCall'] = "lead/leadView/historicalCall";

//loadLead
$route['lead/loadlead'] = "lead/loadLead";
$route['upload/do_uploadt'] = "upload/do_upload";
$route['lead_submit'] = "lead/loadLead/lead_submit";

//leadreport
$route['lead/leadreport'] = "lead/leadReport";
$route['lead/getDataReport'] = "lead/LeadReport/getDataReport";

//Role Manage
$route['manage/roles'] = "manage/role_manage";
$route['manage/setpermission'] = "manage/role_manage/setpermission";


$route['manage/masterdata'] = "manage/masterdata_manage";
$route['manage/getDataMasterdataList'] = 'manage/masterdata_manage/getDataMasterdataList';
$route['manage/postMasterdataList'] = 'manage/masterdata_manage/postMasterdataList';
$route['manage/deleteMasterdataList'] = 'manage/masterdata_manage/deleteMasterdataList';
$route['manage/getDataMasterdataManage'] = 'manage/masterdata_manage/getDataMasterdataManage';
$route['manage/postMasterdataManage'] = 'manage/masterdata_manage/postMasterdataManage';
$route['manage/deleteMasterdataManage'] = 'manage/masterdata_manage/deleteMasterdataManage';

$route['manage/dropdowns'] = "manage/dropdown_manage";
$route['manage/agentmanage'] = "manage/agent_manage";
$route['manage/getAgentdataList'] = "manage/agent_manage/getAgentdataList";
$route['manage/postAgentdata'] = "manage/agent_manage/postAgentdata";
$route['manage/deleteAgentdata'] = "manage/agent_manage/deleteAgentdata";

//API

//Page Not Fond
$route['404'] = 'template/pageNotFound';
//$route['(.*)'] = 'template/pageNotFound';