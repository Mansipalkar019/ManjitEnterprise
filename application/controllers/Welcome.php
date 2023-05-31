<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("memory_limit", "-1");
require APPPATH . '/libraries/REST_Controller.php';
class Welcome extends REST_Controller {


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
}
