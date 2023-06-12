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

	public function login_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$username=$this->input->post('username');
			$password=$this->input->post('password');

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
					'password'=>$password
				);
				$check_login=$this->model->selectWhereData('login',$login_info,'*');
				//echo "<pre>";print_r($check_login);die();
				if(!empty($check_login)){
				}
				$response['code'] = REST_Controller::HTTP_OK;
				$response['status'] = true;
				$response['message'] = 'Registration Successfull'; 
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
			$material_type_id=$this->input->post('material_type_id');
			$material_name=$this->input->post('material_name');
			
			if(empty($material_type_id))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Type Id is Required'; 
			}else if(empty($material_name))
			{
				$response['code'] = 201;
				$response['message'] = 'Material Name is Required'; 
			}else{
				$check_material_exist = $this->model->selectWhereData('add_materials', array('material_type_id'=>$material_type_id,'material_name'=>$material_name),array('id'));
	
				if(empty($check_material_exist)){
				$material_info=array(
					// 'project_id'=>$project_id,
					// 'supervisor_id'=>$supervisor_id,
					'material_type_id'=>$material_type_id,
					'material_name'=>$material_name,
					'created_at'=>date('Y-m-d H:i:s')
				);
				$this->model->insertData('add_materials',$material_info);
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

	public function material_list_post()
	{
		$response = array('code' => - 1, 'status' => false, 'message' => '');
		$validate = validateToken();
		if ($validate) {
			$get_material_list= $this->Supermodel->get_material_list();
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
					);
				}
				foreach($mappedarray as $mapped_key =>$mappedvalue)
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
					);
					$this->model->insertData('material_received_inventory',$material_info);
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
			$get_material_list= $this->Supermodel->get_material_details($project_id,$company_id,$supervisor_id,$owner_id);
			if(!empty($get_material_list))
			{
				foreach($get_material_list as $get_material_key =>$get_material_val)
				{
					if($get_material_val['deduct_qty'] == '')
					{
						$get_material_list[$get_material_key]['deduct_qty']='';
					}
					else{
						$get_material_list[$get_material_key]['deduct_qty']=$get_material_val['deduct_qty'];
					}
				}
			}else{
				$get_material_list=[];
			}
			$response['code'] = REST_Controller::HTTP_OK;
			$response['status'] = true;
			$response['message'] = $get_material_list; 
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
			else if(empty($sourcePath))
			{
				$response['code'] = 201;
				$response['message'] = 'Image is Required'; 
			}else{
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
	
}

