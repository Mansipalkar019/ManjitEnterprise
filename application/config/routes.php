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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['register-user']='welcome/register_user';
$route['login']='welcome/login';
$route['owner-info']='welcome/owner_info';
$route['supervisor-info']='welcome/supervisor_info';
$route['worker-info']='welcome/worker_info';
$route['add-company']='welcome/add_company';
$route['company-list']='welcome/company_list';
$route['delete-company']='welcome/delete_company';
$route['update-company']='welcome/update_company';
$route['add-project']='welcome/add_project';
$route['project-list']='welcome/project_list';
$route['delete-project']='welcome/delete_project';
$route['update-project']='welcome/update_project';
$route['add-new-material']='welcome/add_new_material';
$route['add-material-type']='welcome/add_material_type';
$route['all-material-list']='welcome/all_material_list';
$route['material-type-list']='welcome/material_type_list';
$route['add-material-received']='welcome/add_material_received';
$route['material-received-list']='welcome/material_received_list';
$route['add-material-purchase']='welcome/add_material_purchase';
$route['material-received-list-details']='welcome/material_received_list_details';
$route['add-material-used']='welcome/add_material_used';
$route['add-payment-in']='welcome/add_payment_in';
$route['add-payment-out']='welcome/add_payment_out';
$route['get-transaction-list']='welcome/get_transaction_list';
$route['get-material-receive-by-partyname']='welcome/get_material_receive_by_partyname';
$route['add-unit']='welcome/add_unit';
$route['add-party']='welcome/add_party';
$route['party-list']='welcome/party_list';
$route['staff-list']='welcome/staff_list';