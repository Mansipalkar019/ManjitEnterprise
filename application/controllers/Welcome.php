<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit", "-1");
require APPPATH . '/libraries/REST_Controller.php';
class Welcome extends REST_Controller {
	public function __construct()
    {
        parent::__construct();
		header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Content-Type: text/html; charset=utf-8');
        header('Content-Type: application/json; charset=utf-8'); 
        $this->load->model("Supermodel");
    }


	public function index() {
        $response = array('status' => false, 'msg' => 'Oops! Please try again later.', 'code' => 200);
        echo json_encode($response);
    }

	/**===========================================================Login & Registrations apis================================================================= */

	public function login_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$username=$this->input->post('username');
			$password=$this->input->post('password');
			//$role_id=$this->input->post('role_id');

			if(empty($username))
			{
				$response['code'] = 201;
				$response['message'] = 'Username is Required'; 
			}else if(empty($password))
			{
				$response['code'] = 201;
				$response['message'] = 'Password is Required'; 
			}else{
				$login_info=array(
					'username'=>$username,
					"password" => dec_enc('encrypt',$password),
				);
				$check_login=$this->model->selectWhereData('login',$login_info,'*');
				if(!empty($check_login)){

					$response['code'] = REST_Controller::HTTP_OK;
					$response['status'] = true;
					$response['message'] = 'Login Successfull'; 
				}
				else{
					$response['code'] = 201;
					$response['status'] = true;
					$response['message'] = 'Login Failed'; 
				}
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}

	public function owner_info_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$owner_name=$this->input->post('owner_name');
			$email=$this->input->post('email');
			$contact=$this->input->post('contact');
			$address=$this->input->post('address');
			$pancard=$this->input->post('pancard');
			$password=$this->input->post('password');
			
			if(empty($owner_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Name is Required'; 
			}else if(empty($email))
			{
				$response['code'] = 201;
				$response['message'] = 'Email is Required'; 
			}else if(empty($contact))
			{
				$response['code'] = 201;
				$response['message'] = 'Contact is Required'; 
			}else if(empty($address))
			{
				$response['code'] = 201;
				$response['message'] = 'Address is Required'; 
			}else if(empty($pancard))
			{
				$response['code'] = 201;
				$response['message'] = 'Pancard is Required'; 
			}else if(empty($password))
			{
				$response['code'] = 201;
				$response['message'] = 'Password is Required'; 
			}else{
				
				$check_owner_exist = $this->model->selectWhereData('owner', array('owner_name'=>$owner_name,'email'=>$email,'contact'=>$contact),array('id'));
				$check_login_exist = $this->model->selectWhereData('login', array('username'=>$owner_name,'email'=>$email,'contact'=>$contact,'roles'=>1),array('id'));
					
				if(empty($check_owner_exist) && empty($check_login_exist)){
					$owner_info=array(
						'owner_name'=>$owner_name,
						'email'=>$email,
						'contact'=>$contact,
						'address'=>$address,
						'pancard'=>$pancard,
					);
					$inserted_id=$this->model->insertData('owner',$owner_info);
					$login_info=array(
						'username'=>$owner_name,
						'fk_id'=>$inserted_id,
						'password'=>dec_enc('encrypt',$password),
						'email'=>$email,
						'contact'=>$contact,
						'roles'=>1,
					);
					$inserted_id1=$this->model->insertData('login',$login_info);
					
					$response['code'] = REST_Controller::HTTP_OK;
					$response['status'] = true;
					$response['message'] = 'Registration Successfull'; 
				}
				else{
					$response['code'] = 201;
					$response['status'] = false;
					$response['message'] = 'Owner Already Exist'; 
				}
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}

	public function supervisor_info_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$name=$this->input->post('name');
			$email=$this->input->post('email');
			$contact=$this->input->post('contact');
			$address=$this->input->post('address');
			$pancard=$this->input->post('pancard');
			$password=$this->input->post('password');
			
			if(empty($name))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Name is Required'; 
			}else if(empty($email))
			{
				$response['code'] = 201;
				$response['message'] = 'Email is Required'; 
			}else if(empty($contact))
			{
				$response['code'] = 201;
				$response['message'] = 'Contact is Required'; 
			}else if(empty($address))
			{
				$response['code'] = 201;
				$response['message'] = 'Address is Required'; 
			}else if(empty($pancard))
			{
				$response['code'] = 201;
				$response['message'] = 'Pancard is Required'; 
			}else if(empty($password))
			{
				$response['code'] = 201;
				$response['message'] = 'Password is Required'; 
			}else{
			
				$check_supervisor_exist = $this->model->selectWhereData('supervisor', array('name'=>$name,'email'=>$email,'contact'=>$contact),array('id'));
				$check_login_exist = $this->model->selectWhereData('login', array('username'=>$name,'email'=>$email,'contact'=>$contact,'roles'=>2),array('id'));
					
				if(empty($check_supervisor_exist) && empty($check_login_exist)){
					$supervisor_info=array(
						'name'=>$name,
						'email'=>$email,
						'contact'=>$contact,
						'address'=>$address,
						'pancard'=>$pancard,
					);
					$inserted_id=$this->model->insertData('supervisor',$supervisor_info);
					$login_info=array(
						'username'=>$name,
						'fk_id'=>$inserted_id,
						'password'=>dec_enc('encrypt',$password),
						'email'=>$email,
						'contact'=>$contact,
						'roles'=>2,
					);
				
					$inserted_id1=$this->model->insertData('login',$login_info);
				
					$response['code'] = REST_Controller::HTTP_OK;
					$response['status'] = true;
					$response['message'] = 'Registration Successfull'; 
				}
				else{
					$response['code'] = 201;
					$response['status'] = false;
					$response['message'] = 'Supervisor Already Exist'; 
				}
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}


	public function worker_info_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$name=$this->input->post('name');
			$contact=$this->input->post('contact');
			$address=$this->input->post('address');
			$pancard=$this->input->post('pancard');
			$password=$this->input->post('password');
			
			if(empty($name))
			{
				$response['code'] = 201;
				$response['message'] = 'Worker Name is Required'; 
			}
			else if(empty($contact))
			{
				$response['code'] = 201;
				$response['message'] = 'Contact is Required'; 
			}else if(empty($address))
			{
				$response['code'] = 201;
				$response['message'] = 'Address is Required'; 
			}else if(empty($pancard))
			{
				$response['code'] = 201;
				$response['message'] = 'Pancard is Required'; 
			}else if(empty($password))
			{
				$response['code'] = 201;
				$response['message'] = 'Password is Required'; 
			}else{
				$workers_info=array(
					'name'=>$name,
					'contact'=>$contact,
					'address'=>$address,
					'pancard'=>$pancard,
				);
				$check_worker_exist = $this->model->selectWhereData('workers', array('name'=>$name,'contact'=>$contact),array('id'));
				$check_login_exist = $this->model->selectWhereData('login', array('username'=>$name,'contact'=>$contact,'roles'=>3),array('id'));
					
				if(empty($check_worker_exist)  && empty($check_login_exist)){
					$inserted_id=$this->model->insertData('workers',$workers_info);
					$login_info=array(
						'username'=>$name,
						'fk_id'=>$inserted_id,
						'password'=>dec_enc('encrypt',$password),
						'contact'=>$contact,
						'roles'=>3,
					);
					
					$inserted_id1=$this->model->insertData('login',$login_info);
					
					$response['code'] = REST_Controller::HTTP_OK;
					$response['status'] = true;
					$response['message'] = 'Registration Successfull'; 
				}
				else{
					$response['code'] = 201;
					$response['status'] = false;
					$response['message'] = 'Worker Already Exist'; 
				}
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}

	public function add_company_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$company_name=$this->input->post('company_name');
			$owner_name=$this->input->post('owner_name');
			$company_created_at=$this->input->post('company_created_at');
			$gst_no=$this->input->post('gst_no');
			$address=$this->input->post('address');
			
			if(empty($company_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Name is Required'; 
			}
			else if(empty($owner_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Name is Required'; 
			}else if(empty($company_created_at))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Created At is Required'; 
			}else if(empty($gst_no))
			{
				$response['code'] = 201;
				$response['message'] = 'Gst No is Required'; 
			}else if(empty($address))
			{
				$response['code'] = 201;
				$response['message'] = 'Address is Required'; 
			}else{
			
				$check_company_exist = $this->model->selectWhereData('company_list', array('company_name'=>$company_name,'owner_name'=>$owner_name),array('id'));
				
				if(empty($check_company_exist)){
					$company_list_info=array(
						'company_name'=>$company_name,
						'owner_name'=>$owner_name,
						'company_created_at'=>$company_created_at,
						'gst_no'=>$gst_no,
						'address'=>$address,
						'created_at'=>date('Y-m-d H:i:s'),
					);
					$inserted_id=$this->model->insertData('company_list',$company_list_info);
					$response['code'] = REST_Controller::HTTP_OK;
					$response['status'] = true;
					$response['message'] = 'Company Added Successfull'; 
				}
				else{
					$response['code'] = 201;
					$response['status'] = false;
					$response['message'] = 'Company Name Already Exist'; 
				}
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}


	public function company_list_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$get_company_list= $this->model->selectWhereData('company_list',array('status'=>'0'),array('*'),false);
			if(!empty($get_company_list))
			{
				$get_company_list=$get_company_list;
			}else{
				$get_company_list=[];
			}
			$response['code'] = REST_Controller::HTTP_OK;
			$response['status'] = true;
			$response['company_list'] = $get_company_list;
			
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}


	public function update_company_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$company_id=$this->input->post('company_id');
			$company_name=$this->input->post('company_name');
			$owner_name=$this->input->post('owner_name');
			$company_created_at=$this->input->post('company_created_at');
			$gst_no=$this->input->post('gst_no');
			$address=$this->input->post('address');
			
			if(empty($company_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Name is Required'; 
			}
			else if(empty($owner_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Name is Required'; 
			}else if(empty($company_created_at))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Created At is Required'; 
			}else if(empty($gst_no))
			{
				$response['code'] = 201;
				$response['message'] = 'Gst No is Required'; 
			}else if(empty($address))
			{
				$response['code'] = 201;
				$response['message'] = 'Address is Required'; 
			}else{
				$company_list_info=array(
					'company_name'=>$company_name,
					'owner_name'=>$owner_name,
					'company_created_at'=>$company_created_at,
					'gst_no'=>$gst_no,
					'address'=>$address,
					'updated_at'=>date('Y-m-d H:i:s'),
				);
				$check_company_exist = $this->model->updateData('company_list',$company_list_info,array('id'=>$company_id));
			
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = 'Company Updated Successfull'; 
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}


	public function delete_company_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$company_id=$this->input->post('company_id');
			
			if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company ID is Required'; 
			}
			else{
				$company_list_info=array(
					'status'=>1,
				);
				$check_company_exist = $this->model->updateData('company_list',$company_list_info,array('id'=>$company_id));
			
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = 'Company Deleted Successfull'; 
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}

	public function add_project_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$client_name=$this->input->post('client_name');
			$address=$this->input->post('address');
			$project_name=$this->input->post('project_name');
			$company_id=$this->input->post('company_id');
			$supervisor_id=$this->input->post('supervisor_id');
			$worker_id=$this->input->post('worker_id');
			
			if(empty($client_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Client Name is Required'; 
			}
			else if(empty($address))
			{
				$response['code'] = 201;
				$response['message'] = 'Address is Required'; 
			}else if(empty($project_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Project Name is Required'; 
			}else if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Id is Required'; 
			}else if(empty($supervisor_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Id is Required'; 
			}else if(empty($worker_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Worker Id is Required'; 
			}else{
			
				$check_company_exist = $this->model->selectWhereData('project_list', array('client_name'=>$client_name,'project_name'=>$project_name),array('id'));
				
				if(empty($check_company_exist)){
					$company_list_info=array(
						'client_name'=>$client_name,
						'address'=>$address,
						'project_name'=>$project_name,
						'company_id'=>$company_id,
						'supervisor_id'=>$supervisor_id,
						'worker_id'=>$worker_id,
						'created_at'=>date('Y-m-d H:i:s')
					);
					$inserted_id=$this->model->insertData('project_list',$company_list_info);
					$response['code'] = REST_Controller::HTTP_OK;
					$response['status'] = true;
					$response['message'] = 'Project Added Successfull'; 
				}
				else{
					$response['code'] = 201;
					$response['status'] = false;
					$response['message'] = 'Project Already Exist'; 
				}
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}


	public function project_list_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$get_project_list= $this->model->selectWhereData('project_list',array('status'=>'0'),array('*'),false);
			if(!empty($get_project_list))
			{
				$get_project_list=$get_project_list;
			}else{
				$get_project_list=[];
			}
			$response['code'] = REST_Controller::HTTP_OK;
			$response['status'] = true;
			$response['project_list'] = $get_project_list;
		
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}


	public function update_project_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$project_id=$this->input->post('project_id');
			$client_name=$this->input->post('client_name');
			$address=$this->input->post('address');
			$project_name=$this->input->post('project_name');
			$company_id=$this->input->post('company_id');
			$supervisor_id=$this->input->post('supervisor_id');
			$worker_id=$this->input->post('worker_id');
			
			if(empty($client_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Client Name is Required'; 
			}
			else if(empty($address))
			{
				$response['code'] = 201;
				$response['message'] = 'Address is Required'; 
			}else if(empty($project_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Project Name is Required'; 
			}else if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Id is Required'; 
			}else if(empty($supervisor_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Id is Required'; 
			}else if(empty($worker_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Worker Id is Required'; 
			}else{
				$company_list_info=array(
					'client_name'=>$client_name,
					'address'=>$address,
					'project_name'=>$project_name,
					'company_id'=>$company_id,
					'supervisor_id'=>$supervisor_id,
					'worker_id'=>$worker_id,
					'updated_at'=>date('Y-m-d H:i:s')
				);
				$check_projet_exist = $this->model->updateData('project_list',$company_list_info,array('id'=>$project_id));
			
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = 'Project Updated Successfull'; 
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}

	public function delete_project_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$project_id=$this->input->post('project_id');
			
			if(empty($project_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Project id is Required'; 
			}
			else{
				$company_list_info=array(
					'status'=>1,
				);
				$check_company_exist = $this->model->updateData('project_list',$company_list_info,array('id'=>$project_id));
			
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = 'Project Deleted Successfull'; 
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}

	/**===========================================================Materials apis================================================================= */

	public function add_new_material_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			
			// $project_id=$this->input->post('project_id');
			// $supervisor_id=$this->input->post('supervisor_id');
			$material_unit=$this->input->post('material_unit');
			$material_name=$this->input->post('material_name');
			$trade_name=$this->input->post('trade_name');
			if(empty($material_unit))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Unit is Required'; 
			}else if(empty($material_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Name is Required'; 
			}else if(empty($trade_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Trade Name is Required'; 
			}else{
				$check_material_exist = $this->model->selectWhereData('add_materials', array('material_type_id'=>$material_unit,'material_name'=>$material_name),array('id'));
	
				if(empty($check_material_exist)){
				$material_info=array(
					'material_name'=>$material_name,
					'created_at'=>date('Y-m-d H:i:s')
				);

				$add_material_id=$this->model->insertData('add_materials',$material_info);
					$material_unit_info=array(
					'add_material_id'=>$add_material_id,
					'material_unit'=>$material_unit,
					'created_at'=>date('Y-m-d H:i:s')
				);
				$this->model->insertData('add_material_unit',$material_unit_info);

				$trade_info=array(
					'add_material_id'=>$add_material_id,
					'trade_name'=>$trade_name,
					'created_at'=>date('Y-m-d H:i:s')
				);
				$this->model->insertData('add_trade',$trade_info);

					$response['code'] = REST_Controller::HTTP_OK;
					$response['status'] = true;
					$response['message'] = 'Material Added Successfull'; 
				}else{
					$response['code'] = 201;
					$response['status'] = false;
					$response['message'] = 'Material Already Exist'; 
				}
				
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	

	public function all_material_list_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$get_material_list= $this->Supermodel->get_material_list();
			// foreach($get_material_list as $get_material_key =>$get_material_val)
			// {
			// 	$get_material_list=$get_material_val;
			// 	$get_material_list[$get_material_key]['trade_name']=$get_material_val['trade_name'];
			// }
			if(!empty($get_material_list))
			{
				$get_material_list=$get_material_list;
			}else{
				$get_material_list=[];
			}
			$response['code'] = REST_Controller::HTTP_OK;
			$response['status'] = true;
			$response['material_list'] = $get_material_list;
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	

	public function material_type_list_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$get_material_type_list= $this->model->selectWhereData('add_materials_type',array('status'=>'0'),array('*'),false);
			if(!empty($get_material_type_list))
			{
				$get_material_type_list=$get_material_type_list;
			}else{
				$get_material_type_list=[];
			}
			$response['code'] = REST_Controller::HTTP_OK;
			$response['status'] = true;
			$response['material_list'] = $get_material_type_list;
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}
	
	public function material_unit_list_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$get_material_type_list= $this->model->selectWhereData('add_material_unit',array('status'=>'0'),array('id','material_unit','created_at'),false);
			if(!empty($get_material_type_list))
			{
				$get_material_type_list=$get_material_type_list;
			}else{
				$get_material_type_list=[];
			}
			$response['code'] = REST_Controller::HTTP_OK;
			$response['status'] = true;
			$response['material_list'] = $get_material_type_list;
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}


	public function add_material_type_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			
			$material_type=$this->input->post('material_type');
			
			if(empty($material_type))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Type is Required'; 
			}else{
				$check_material_exist = $this->model->selectWhereData('add_materials_type', array('material_type'=>$material_type),array('id'));
				
				if(empty($check_material_exist)){
				$material_info=array(
					'material_type'=>$material_type,
					'created_at'=>date('Y-m-d H:i:s')
				);
				$this->model->insertData('add_materials_type',$material_info);
					$response['code'] = REST_Controller::HTTP_OK;
					$response['status'] = true;
					$response['message'] = 'Material Type Added Successfully'; 
				}
				else{
					$response['code'] = 201;
					$response['status'] = false;
					$response['message'] = 'Material Type Already Exist'; 
				}
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	

public function add_material_received_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			
			$project_id=$this->input->post('project_id');
			$company_id=$this->input->post('company_id');
			$supervisor_id=$this->input->post('supervisor_id');
			$owner_id=$this->input->post('owner_id');
			$party_name=$this->input->post('party_name');
			$received_date=$this->input->post('received_date');
			$material_name=json_decode($this->input->post('material_name'));
			$qty=json_decode($this->input->post('qty'));
			$unit=json_decode($this->input->post('unit'));
			$total_amount=json_decode($this->input->post('total_amount'));
			$notes=$this->input->post('notes');
			$sourcePath = $_FILES['image']['tmp_name']; 
			if(empty($project_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Project Id is Required'; 
			}else if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Id is Required'; 
			}else if(empty($supervisor_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Id is Required'; 
			}else if(empty($owner_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Id is Required'; 
			}else if(empty($party_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Party Name is Required'; 
			}else if(empty($received_date))
			{
				$response['code'] = 201;
				$response['message'] = 'Received Date is Required'; 
			}else if(empty($material_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Name is Required'; 
			}else if(empty($qty))
			{
				$response['code'] = 201;
				$response['message'] = 'Qty is Required'; 
			}else if(empty($notes))
			{
				$response['code'] = 201;
				$response['message'] = 'Notes is Required'; 
			}else if(empty($unit))
			{
				$response['code'] = 201;
				$response['message'] = 'Unit is Required'; 
			}
			else if(empty($sourcePath))
			{
				$response['code'] = 201;
				$response['message'] = 'Image is Required'; 
			}else{
				if(!empty($sourcePath))
				{
					$destinationPath = 'material_received/'; 
					
					$filename = $_FILES['image']['name'];
					$destination = $destinationPath . $filename;
					$img_url=base_url().$destination;
					
					if (move_uploaded_file($sourcePath, $destination)) {
						$response['code'] = 201;
						$response['status'] = false;
						$response['message'] = 'Image moved successfully'; 
					} else {
						$response['code'] = 201;
						$response['status'] = false;
						$response['message'] = 'Failed to move Image'; 
					}
				}
				$mappedarray=array();
				$count=count($material_name);
				for($i=0;$i<$count;$i++)
				{
					$mappedarray[]=array(
						'material'=>$material_name[$i],
						'qty'=>$qty[$i],
						'unit'=>$unit[$i],
						'total_amount'=>$total_amount[$i],
					);
				}
			
				foreach($mappedarray as $mapped_key =>$mappedvalue)
				{
				    $getexistrecord=$this->model->selectWhereData('material_received', array('project_id'=>$project_id,'company_id'=>$company_id,'supervisor_id'=>$supervisor_id,'owner_id'=>$owner_id,'material_name'=>$mappedvalue['material']),array('id','qty'));
				 	if(empty($getexistrecord))
				    {
    				        $material_info=array(
    						'project_id'=>$project_id,
    						'supervisor_id'=>$supervisor_id,
    						'company_id'=>$company_id,
    						'owner_id'=>$owner_id,
    						'party_name'=>$party_name,
    						'received_date'=>$received_date,
    						'notes'=>$notes,
    						'image_url'=>$img_url,
    						'created_at'=>date('Y-m-d H:i:s'),
    						'updated_at'=>date('Y-m-d H:i:s'),
    						'material_name'=>$mappedvalue['material'],
    						'qty'=>$mappedvalue['qty'],
    						'unit'=>$mappedvalue['unit'],
    					);
    					$material_id=$this->model->insertData('material_received',$material_info);
    					$deduct_qty=0;
    					$material_info=array(
    						'material_id'=>$material_id,
    						'add_qty'=>$mappedvalue['qty'],
    						'deduct_qty'=>$deduct_qty,
    						'total_qty'=>$mappedvalue['qty']+$deduct_qty,
    						'created_at'=>date('Y-m-d H:i:s'),
    						'updated_at'=>date('Y-m-d H:i:s'),
    						'total_amount'=>$mappedvalue['total_amount'],
    						'used_status'=>1,
    					);
    					$material_inventory_id=$this->model->insertData('material_received_inventory',$material_info);
						$deduct_amt=0;
						$transaction_history=array(
    						'project_id'=>$project_id,
    						'supervisor_id'=>$supervisor_id,
    						'company_id'=>$company_id,
    						'owner_id'=>$owner_id,
    						'party_name'=>$party_name,
    						'material_id'=>$material_id,
							'material_inventory_id'=>$material_inventory_id,
							'deduct_amount'=>$deduct_amt,
							'add_amount'=>$mappedvalue['total_amount'],
    						'total_amount'=>$mappedvalue['total_amount']+$deduct_amt,
    						'created_at'=>date('Y-m-d H:i:s'),
    						'updated_at'=>date('Y-m-d H:i:s'),
    						'material_received_status'=>1,
							'used_status'=>1
    					);
    					$this->model->insertData('transaction_history',$transaction_history);
				    }else{
				         $material_info=array(
    						'qty'=>$mappedvalue['qty'] + $getexistrecord['qty'],
    					);
				        $this->model->updateData('material_received',$material_info,array('id'=>$getexistrecord['id']));
				        $get_material_list_inventory= $this->Supermodel->update_inventory($getexistrecord['id']);
				        //print_r($get_material_list_inventory);die();
						$material_info1=array(
    						'material_id'=>$get_material_list_inventory[0]['material_id'],
    						'add_qty'=>$mappedvalue['qty'],
    						'deduct_qty'=>0,
    						'total_qty'=>$mappedvalue['qty']+$get_material_list_inventory[0]['total_qty'],
    						'created_at'=>date('Y-m-d H:i:s'),
    						'updated_at'=>date('Y-m-d H:i:s'),
    						'total_amount'=>0,
							'used_status'=>1
    					);
						$this->model->updateData('material_received_inventory',array('used_status'=>0),array('material_id'=>$get_material_list_inventory[0]['material_id']));
    					$material_inventory_id=$this->model->insertData('material_received_inventory',$material_info1);
						//echo $material_inventory_id;die();
						$get_transaction_history= $this->Supermodel->get_transaction_history($project_id,$company_id,$supervisor_id,$owner_id,$party_name,$getexistrecord['id']);
						if($get_transaction_history[0]['total_amount']!=$mappedvalue['total_amount'])
						{ $add_amount=$mappedvalue['total_amount']; $total_amt=$add_amount+$get_transaction_history[0]['total_amount']; $deduct_amount=0; }else{  $add_amount=$mappedvalue['total_amount']; $total_amt=$add_amount+$get_transaction_history[0]['total_amount']; $deduct_amount=0; }
						$transaction_history=array(
    						'project_id'=>$project_id,
    						'supervisor_id'=>$supervisor_id,
    						'company_id'=>$company_id,
    						'owner_id'=>$owner_id,
    						'party_name'=>$party_name,
    						'material_id'=>$get_transaction_history[0]['material_id'],
							'material_inventory_id'=>$material_inventory_id,
							'add_amount'=>$add_amount,
							'deduct_amount'=>$deduct_amount,
    						'total_amount'=>$total_amt,
    						'created_at'=>date('Y-m-d H:i:s'),
    						'updated_at'=>date('Y-m-d H:i:s'),
    						'material_received_status'=>1,
							'used_status'=>1
    					);
						//print_r($transaction_history);die();
						$this->model->updateData('transaction_history',array('used_status'=>0),array('id'=>$get_transaction_history[0]['id']));
    					$this->model->insertData('transaction_history',$transaction_history);
				    }
				
				}
				
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = 'Material Received Successfully'; 
			}
			
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	

	public function material_received_list_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			
			$project_id=$this->input->post('project_id');
			$company_id=$this->input->post('company_id');
			$supervisor_id=$this->input->post('supervisor_id');
			$owner_id=$this->input->post('owner_id');
			if(empty($project_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Project Id is Required'; 
			}else if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Id is Required'; 
			}else if(empty($supervisor_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Id is Required'; 
			}else if(empty($owner_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Id is Required'; 
			}else{
				$get_receive= $this->Supermodel->get_received_list($project_id,$company_id,$supervisor_id,$owner_id);
				foreach($get_receive as $get_receive_key => $get_receive_val)
				{
					$get_material_list[$get_receive_key]['trade_name']=$get_receive_val['trade_name'];
					$get_material_list[$get_receive_key]['received_material_list']= $this->Supermodel->get_material_details($project_id,$company_id,$supervisor_id,$owner_id,$get_receive_val['material_name']);
					
				}
				if(empty($get_material_list))
				{
					$get_material_list='';
				}
			$response['code'] = REST_Controller::HTTP_OK;
			$response['status'] = true;
			$response['message'] = $get_material_list; 
			}
		
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	

public function material_received_list_details_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			
			$project_id=$this->input->post('project_id');
			$company_id=$this->input->post('company_id');
			$supervisor_id=$this->input->post('supervisor_id');
			$owner_id=$this->input->post('owner_id');
			$material_id=$this->input->post('material_id');
			$array=array();
			if(empty($project_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Project Id is Required'; 
			}else if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Id is Required'; 
			}else if(empty($supervisor_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Id is Required'; 
			}else if(empty($owner_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Id is Required'; 
			}else if(empty($material_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Id is Required'; 
			}else{
				$get_material_list= $this->Supermodel->get_material_details_by_id($project_id,$company_id,$supervisor_id,$owner_id,$material_id);
				if(!empty($get_material_list))
				{
					$array['total_count']=$get_material_list;
				}else{
					$array['total_count']=[];
				}
				$get_inventory_list= $this->Supermodel->get_material_inventory_by_id($project_id,$company_id,$supervisor_id,$owner_id,$material_id);
				if(!empty($get_inventory_list))
				{
					$array['stock_details']=$get_inventory_list;
				}else{
					$array['stock_details']=[];
				}
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = $array; 
			}
			
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	
	public function add_material_purchase_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$project_id=$this->input->post('project_id');
			$company_id=$this->input->post('company_id');
			$supervisor_id=$this->input->post('supervisor_id');
			$owner_id=$this->input->post('owner_id');
			$party_name=$this->input->post('party_name');
			$purchase_date=$this->input->post('purchase_date');
			$material_type_id=$this->input->post('material_type_id');
			$material_name=json_decode($this->input->post('material_name'));
			$qty=json_decode($this->input->post('qty'));
			$unit=json_decode($this->input->post('unit'));
			$notes=$this->input->post('notes');
			$sourcePath = $_FILES['image']['tmp_name']; 
			$total_amount=$this->input->post('total_amount');
			if(empty($project_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Project Id is Required'; 
			}else if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Id is Required'; 
			}else if(empty($supervisor_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Id is Required'; 
			}else if(empty($owner_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Id is Required'; 
			}else if(empty($party_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Party Name is Required'; 
			}else if(empty($purchase_date))
			{
				$response['code'] = 201;
				$response['message'] = 'Purchase Date is Required'; 
			}else if(empty($material_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Name is Required'; 
			}else if(empty($qty))
			{
				$response['code'] = 201;
				$response['message'] = 'Qty is Required'; 
			}else if(empty($notes))
			{
				$response['code'] = 201;
				$response['message'] = 'Notes is Required'; 
			}else if(empty($unit))
			{
				$response['code'] = 201;
				$response['message'] = 'Unit is Required'; 
			}
			else if(empty($total_amount))
			{
				$response['code'] = 201;
				$response['message'] = 'Total Amount is Required'; 
			}
			else if(empty($material_type_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Type is Required'; 
			}
// 			else if(empty($sourcePath))
// 			{
// 				$response['code'] = 201;
// 				$response['message'] = 'Image is Required'; 
// 			}
			else{
				if(!empty($sourcePath))
				{
					$destinationPath = 'material_purchased/'; 
					
					$filename = $_FILES['image']['name'];
					$destination = $destinationPath . $filename;
					$img_url=base_url().$destination;
					
					if (move_uploaded_file($sourcePath, $destination)) {
						$response['code'] = 201;
						$response['status'] = false;
						$response['message'] = 'Image moved successfully'; 
					} else {
						$response['code'] = 201;
						$response['status'] = false;
						$response['message'] = 'Failed to move Image'; 
					}
				}
				$mappedarray=array();
				$count=count($material_name);
				for($i=0;$i<$count;$i++)
				{
					$mappedarray[]=array(
						'material'=>$material_name[$i],
						'qty'=>$qty[$i],
						'unit'=>$unit[$i],
					);
				}
				foreach($mappedarray as $mapped_key =>$mappedvalue)
				{
					// $get_material_list= $this->model->selectWhereData('material_received',array('project_id'=>$project_id,'supervisor_id'=>$supervisor_id,'company_id'=>$company_id,'owner_id'=>$owner_id,'material_name'=>$mappedvalue['material'],'status'=>'0'),array('*'),false);
					// if(empty($get_material_list))
					// {
						$material_info=array(
							'project_id'=>$project_id,
							'supervisor_id'=>$supervisor_id,
							'company_id'=>$company_id,
							'owner_id'=>$owner_id,
							'material_type_id'=>$material_type_id,
							'party_name'=>$party_name,
							'purchase_date'=>$purchase_date,
							'notes'=>$notes,
							'image_url'=>$img_url,
							'created_at'=>date('Y-m-d H:i:s'),
							'updated_at'=>date('Y-m-d H:i:s'),
							'material_name'=>$mappedvalue['material'],
							'qty'=>$mappedvalue['qty'],
							'unit'=>$mappedvalue['unit'],
						);
						$material_id=$this->model->insertData('material_purchased',$material_info);
					//}
					
				}
				
				
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = 'Material Purchased Successfully'; 

			}	
			
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	

	public function add_unit_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			
			$unit_name=$this->input->post('unit_name');
			
			if(empty($unit_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Unit is Required'; 
			}else{
				$check_material_exist = $this->model->selectWhereData('add_unit', array('unit_name'=>$unit_name),array('id'));
				
				if(empty($check_material_exist)){
				$material_info=array(
					'unit_name'=>$unit_name,
					'created_at'=>date('Y-m-d H:i:s')
				);
				$this->model->insertData('add_unit',$material_info);
					$response['code'] = REST_Controller::HTTP_OK;
					$response['status'] = true;
					$response['message'] = 'Material Unit Added Successfully'; 
				}
				else{
					$response['code'] = 201;
					$response['status'] = false;
					$response['message'] = 'Material Unit Already Exist'; 
				}
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	



	public function add_material_used_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$project_id=$this->input->post('project_id');
			$company_id=$this->input->post('company_id');
			$supervisor_id=$this->input->post('supervisor_id');
			$owner_id=$this->input->post('owner_id');
			$party_name=$this->input->post('party_name');
			$used_date=$this->input->post('used_date');
			$material_name=json_decode($this->input->post('material_name'));
			$qty=json_decode($this->input->post('qty'));
			$notes=$this->input->post('notes');
			$sourcePath = $_FILES['image']['tmp_name']; 
			if(empty($project_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Project Id is Required'; 
			}else if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Id is Required'; 
			}else if(empty($supervisor_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Id is Required'; 
			}else if(empty($owner_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Id is Required'; 
			}else if(empty($party_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Party Name is Required'; 
			}else if(empty($material_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Name is Required'; 
			}else if(empty($qty))
			{
				$response['code'] = 201;
				$response['message'] = 'Qty is Required'; 
			}else if(empty($notes))
			{
				$response['code'] = 201;
				$response['message'] = 'Notes is Required'; 
			}
			
		    else{
				if(!empty($sourcePath))
				{
					$destinationPath = 'material_received/'; 
					
					$filename = $_FILES['image']['name'];
					$destination = $destinationPath . $filename;
					$img_url=base_url().$destination;
					
					if (move_uploaded_file($sourcePath, $destination)) {
						$response['code'] = 201;
						$response['status'] = false;
						$response['message'] = 'Image moved successfully'; 
					} else {
						$response['code'] = 201;
						$response['status'] = false;
						$response['message'] = 'Failed to move Image'; 
					}
				}
				$mappedarray=array();
				$count=count($material_name);
				for($i=0;$i<$count;$i++)
				{
					$mappedarray[]=array(
						'material'=>$material_name[$i],
						'qty'=>$qty[$i],
					);
				}
				foreach($mappedarray as $mapped_key =>$mappedvalue)
				{
					$get_material_list= $this->model->selectWhereData('material_received_inventory',array('material_id'=>$mappedvalue['material'],'used_status'=>'1'),array('*'),false);
					$total_deduct_amt=$get_material_list[0]['total_qty']-$mappedvalue['qty'];
					if(!empty($get_material_list))
					{
						$material_info=array(
        						'material_id'=>$mappedvalue['material'],
        						'add_qty'=>$get_material_list[0]['total_qty'],
        						'deduct_qty'=>$mappedvalue['qty'],
        						'total_qty'=>$total_deduct_amt,
        						'created_at'=>date('Y-m-d H:i:s'),
        						'updated_at'=>date('Y-m-d H:i:s'),
        						'total_amount'=>0,
								'used_status'=>1
        					);
						$this->model->updateData('material_received_inventory',array('used_status'=>0),array('material_id'=>$mappedvalue['material']));
						$this->model->insertData('material_received_inventory',$material_info);
						$response['code'] = REST_Controller::HTTP_OK;
						$response['status'] = true;
						$response['message'] = 'Total stock '. $total_deduct_amt; 
						//echo $this->db->last_query();die();
					}
					else{
						
						$response['code'] = 201;
						$response['status'] = false;
						$response['message'] = 'Total stock '. 0; 
					}

				}
				
			

			}	
			
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	
	
	public function add_payment_in_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$project_id=$this->input->post('project_id');
			$company_id=$this->input->post('company_id');
			$supervisor_id=$this->input->post('supervisor_id');
			$owner_id=$this->input->post('owner_id');
			$party_name=$this->input->post('party_name');
			$amount_received=$this->input->post('amount_received');
			$description=$this->input->post('description');
			$sourcePath = $_FILES['image']['tmp_name']; 
			if(empty($project_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Project Id is Required'; 
			}else if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Id is Required'; 
			}else if(empty($supervisor_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Id is Required'; 
			}else if(empty($owner_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Id is Required'; 
			}else if(empty($party_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Party Name is Required'; 
			}else if(empty($amount_received))
			{
				$response['code'] = 201;
				$response['message'] = 'Amount Received is Required'; 
			}
		    else{
				// if(!empty($sourcePath))
				// {
				// 	$destinationPath = 'material_received/'; 
					
				// 	$filename = $_FILES['image']['name'];
				// 	$destination = $destinationPath . $filename;
				// 	$img_url=base_url().$destination;
					
				// 	if (move_uploaded_file($sourcePath, $destination)) {
				// 		$response['code'] = 201;
				// 		$response['status'] = false;
				// 		$response['message'] = 'Image moved successfully'; 
				// 	} else {
				// 		$response['code'] = 201;
				// 		$response['status'] = false;
				// 		$response['message'] = 'Failed to move Image'; 
				// 	}
				// }
				
				$payment_in=array(
						'project_id'=>$project_id,
						'supervisor_id'=>$supervisor_id,
						'company_id'=>$company_id,
						'owner_id'=>$owner_id,
						'party_name'=>$party_name,
						'add_amount'=>$amount_received,
						'deduct_amount'=>0,
						'total_amount'=>$amount_received,
						'description'=>$description,
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>date('Y-m-d H:i:s'),
						'payment_in_status'=>1,
						'total_amount'=>$amount_received,
						'used_status'=>1
					);
				//$this->model->updateData('transaction_history',array('used_status'=>0),array('material_id'=>$mappedvalue['material']));
				$this->model->insertData('transaction_history',$payment_in);
					  
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = 'Payment In'; 

			}	
			
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	

	public function get_material_receive_by_partyname_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$project_id=$this->input->post('project_id');
			$company_id=$this->input->post('company_id');
			$supervisor_id=$this->input->post('supervisor_id');
			$owner_id=$this->input->post('owner_id');
			$party_name=$this->input->post('party_name');
			$sourcePath = $_FILES['image']['tmp_name']; 
			if(empty($project_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Project Id is Required'; 
			}else if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Id is Required'; 
			}else if(empty($supervisor_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Id is Required'; 
			}else if(empty($owner_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Id is Required'; 
			}else if(empty($party_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Party Name is Required'; 
			}
		    else{
				$get_material_purchase= $this->Supermodel->sum_material_purchase($project_id,$company_id,$supervisor_id,$owner_id,$party_name);
				if(!empty($get_material_purchase))
				{
					$get_material_purchase=$get_material_purchase;
				}else{
					$get_material_purchase=[];
				}
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = $get_material_purchase; 

			}	
			
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	

	public function add_payment_out_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$project_id=$this->input->post('project_id');
			$company_id=$this->input->post('company_id');
			$supervisor_id=$this->input->post('supervisor_id');
			$owner_id=$this->input->post('owner_id');
			$party_name=$this->input->post('party_name');
			$amount_received=$this->input->post('amount_received');
			$description=$this->input->post('description');
			$material_id=$this->input->post('material_id');
			$sourcePath = $_FILES['image']['tmp_name']; 
			if(empty($project_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Project Id is Required'; 
			}else if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Id is Required'; 
			}else if(empty($supervisor_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Id is Required'; 
			}else if(empty($owner_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Id is Required'; 
			}else if(empty($party_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Party Name is Required'; 
			}else if(empty($amount_received))
			{
				$response['code'] = 201;
				$response['message'] = 'Amount Received is Required'; 
			}
			else if(empty($material_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Id is Required'; 
			}
		    else{
				$get_material_purchase= $this->Supermodel->sum_material_purchase_by_id($project_id,$company_id,$supervisor_id,$owner_id,$party_name,$material_id);
				//echo "<pre>";print_r($get_material_purchase);die();
				if($get_material_purchase[0]['total_amount'] == $amount_received)
				{
					$paid_unpaid_status=1;
					$company_list_info=array(
						'paid_unpaid_status'=>$paid_unpaid_status,
					);
					$check_company_exist = $this->model->updateData('transaction_history',$company_list_info,array('project_id'=>$project_id,'company_id'=>$company_id,'supervisor_id'=>$supervisor_id,'owner_id'=>$owner_id,'material_id'=>$material_id,'material_received_status'=>1));
				}
				$payment_out=array(
						'project_id'=>$project_id,
						'supervisor_id'=>$supervisor_id,
						'company_id'=>$company_id,
						'owner_id'=>$owner_id,
						'material_id'=>$material_id,
						'party_name'=>$party_name,
						'add_amount'=>$amount_received,
						'deduct_amount'=>0,
						'total_amount'=>$amount_received,
						'description'=>$description,
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>date('Y-m-d H:i:s'),
						'payment_out_status'=>1,
						'total_amount'=>$amount_received,
						'used_status'=>1,
						
					);
				//$this->model->updateData('transaction_history',array('used_status'=>0),array('material_id'=>$mappedvalue['material']));
				$this->model->insertData('transaction_history',$payment_out);
					  
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = 'Payment Out'; 

			}	
			
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	


	public function get_transaction_list_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$project_id=$this->input->post('project_id');
			$company_id=$this->input->post('company_id');
			$supervisor_id=$this->input->post('supervisor_id');
			$owner_id=$this->input->post('owner_id');
			
			if(empty($project_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Project Id is Required'; 
			}else if(empty($company_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Company Id is Required'; 
			}else if(empty($supervisor_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Supervisor Id is Required'; 
			}else if(empty($owner_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Owner Id is Required'; 
			}
		    else{
				$fdata=array();
				$get_material_received= $this->Supermodel->get_material_received($project_id,$company_id,$supervisor_id,$owner_id);
				$fdata['material_received']=$get_material_received;
				$get_payment_in= $this->Supermodel->get_payment_in($project_id,$company_id,$supervisor_id,$owner_id);
				$get_payment_out= $this->Supermodel->get_payment_out($project_id,$company_id,$supervisor_id,$owner_id);
				$fdata['paymeny_in']=$get_payment_in;
				$fdata['paymeny_out']=$get_payment_out;
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = $fdata; 

			}	
			
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	


	public function add_party_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			
			$party_name=$this->input->post('party_name');
			$phone_no=$this->input->post('phone_no');
			$person_id=$this->input->post('person_id');
			
			if(empty($party_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Party Name is Required'; 
			}if(empty($phone_no))
			{
				$response['code'] = 201;
				$response['message'] = 'Phone No is Required'; 
			}if(empty($person_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Person is Required'; 
			}else{
				$check_material_exist = $this->model->selectWhereData('add_party', array('party_name'=>$party_name),array('id'));
				
				if(empty($check_material_exist)){
				$add_party_info=array(
					'party_name'=>$party_name,
					'phone_no'=>$phone_no,
					'person_id'=>$person_id,
					'created_at'=>date('Y-m-d H:i:s')
				);
				$this->model->insertData('add_party',$add_party_info);
					$response['code'] = REST_Controller::HTTP_OK;
					$response['status'] = true;
					$response['message'] = 'Party Details Added Successfully'; 
				}
				else{
					$response['code'] = 201;
					$response['status'] = false;
					$response['message'] = 'Party Name Already Exist'; 
				}
			
			}
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}	

	public function party_list_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$get_party_list= $this->model->selectWhereData('add_party',array('status'=>'0'),array('*'),false);
			if(!empty($get_party_list))
			{
				$get_party_list=$get_party_list;
			}else{
				$get_party_list=[];
			}
			$response['code'] = REST_Controller::HTTP_OK;
			$response['status'] = true;
			$response['party_list'] = $get_party_list;
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}

	public function staff_list_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$get_person_list= $this->model->selectWhereData('person',array('status'=>'0'),array('*'),false);
			if(!empty($get_person_list))
			{
				$get_person_list=$get_person_list;
			}else{
				$get_person_list=[];
			}
			$response['code'] = REST_Controller::HTTP_OK;
			$response['status'] = true;
			$response['person_list'] = $get_person_list;
		}else{
			$response['code'] = REST_Controller::HTTP_UNAUTHORIZED;
            $response['message'] = 'Unauthorised';
		}
		
		echo json_encode($response);
	}



}
