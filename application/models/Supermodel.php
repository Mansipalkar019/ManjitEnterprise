<?php
class Supermodel extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

    public function get_user_data($rfid)
    {
        $this->db->select('tbl_user.*,tbl_user_wallet.*');
		$this->db->from('tbl_user');
		$this->db->join('tbl_user_wallet','tbl_user_wallet.fk_user_id=tbl_user.id','left');
		
		$this->db->where('tbl_user.rfid_card_no',$rfid);
		$this->db->order_by('tbl_user.id','DESC');
		$query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    


      public function get_material_details($project_id,$company_id,$supervisor_id,$owner_id,$material_name)
    {
		$this->db->select('mr.id, MAX(mri.id) AS max_id,mri.total_qty,am.material_name, amt.material_unit');
		//$this->db->select('COALESCE(mri.total_qty, 0) - COALESCE(mri1.deduct_qty, 0) AS total_qty', FALSE);
		$this->db->from('material_received AS mr');
		$this->db->join('(SELECT material_id, SUM(add_qty) AS total_qty, MAX(id) AS id FROM material_received_inventory WHERE deduct_qty=0 GROUP BY material_id) AS mri', 'mri.material_id = mr.id', 'left');
		// $this->db->join('(SELECT material_id, SUM(deduct_qty) AS deduct_qty, MAX(id) AS id FROM material_received_inventory WHERE used_status = 1 GROUP BY material_id) AS mri1', 'mri1.material_id = mr.id', 'left');
		$this->db->join('add_materials AS am', 'mr.material_name = am.id', 'left');
		$this->db->join('add_material_unit AS amt', 'am.id = amt.add_material_id', 'left');
		$this->db->where('mr.project_id',$project_id);
		$this->db->where('mr.company_id',$company_id);
		$this->db->where('mr.supervisor_id',$supervisor_id);
		$this->db->where('mr.owner_id',$owner_id);
		$this->db->where('mr.material_name',$material_name);
		$this->db->group_by('mr.id, mri.total_qty, am.material_name, amt.material_unit');
		$this->db->order_by('mr.id', 'ASC');
		$query = $this->db->get();
	    //echo $this->db->last_query();die();
		$result = $query->result_array();
		//print_r($result);die();
		return $result;
    }

	public function get_received_list($project_id,$company_id,$supervisor_id,$owner_id)
    {
		$this->db->select('DISTINCT(material_received.material_name),add_trade.trade_name');
        $this->db->from('material_received');
        $this->db->join('add_trade', 'add_trade.add_material_id = material_received.material_name', 'left');
		$this->db->where('material_received.project_id',$project_id);
		$this->db->where('material_received.company_id',$company_id);
		$this->db->where('material_received.supervisor_id',$supervisor_id);
		$this->db->where('material_received.owner_id',$owner_id);
		$query = $this->db->get();
	 	$result = $query->result_array();
		return $result;
    }
    
   public function get_material_details_by_id($project_id,$company_id,$supervisor_id,$owner_id,$material_id)
    {
		$this->db->select('mr.id,mr.party_name,MAX(mri.id) AS max_id, mri.total_received,mri1.total_used,am.material_name, amt.material_type');
		$this->db->from('material_received AS mr');
		$this->db->join('(SELECT material_id, SUM(add_qty) AS total_received, MAX(id) AS id FROM material_received_inventory
		WHERE deduct_qty=0 GROUP BY material_id) AS mri', 'mri.material_id = mr.id', 'left');
		$this->db->join('(SELECT material_id, SUM(deduct_qty) AS total_used, MAX(id) AS id FROM material_received_inventory
		WHERE used_status = 1 and deduct_qty != 0 GROUP BY material_id) AS mri1', 'mri1.material_id = mr.id', 'left');
		$this->db->join('add_materials AS am', 'mr.id = am.id', 'left');
		$this->db->join('add_materials_type AS amt', 'am.material_type_id = amt.id', 'left');
		$this->db->where('mr.project_id',$project_id);
		$this->db->where('mr.company_id',$company_id);
		$this->db->where('mr.supervisor_id',$supervisor_id);
		$this->db->where('mr.owner_id',$owner_id);
		$this->db->where('mri.material_id',$material_id);
		$this->db->group_by('mr.id, mri.total_received, am.material_name, amt.material_type');
		$this->db->order_by('mr.id', 'ASC');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    }

	public function get_material_inventory_by_id($project_id,$company_id,$supervisor_id,$owner_id,$material_id)
    {
// 		$this->db->select('mri.id, mri.add_qty, mri.deduct_qty, mri.created_at, mri.total_amount, mri.used_status');
// 		$this->db->from('material_received AS mr');
// 		$this->db->join('material_received_inventory AS mri', 'mr.id = mri.material_id', 'left');
// 		$this->db->join('add_materials AS am', 'mr.id = am.id', 'left');
// 		$this->db->join('add_materials_type AS amt', 'am.material_type_id = amt.id', 'left');
// 		$this->db->where('mr.project_id',$project_id);
// 		$this->db->where('mr.company_id',$company_id);
// 		$this->db->where('mr.supervisor_id',$supervisor_id);
// 		$this->db->where('mr.owner_id',$owner_id);
// 		$this->db->where('mri.material_id',$material_id);
// 		$this->db->group_by('mr.id, mri.total_qty, am.material_name, amt.material_type');
// 		$this->db->order_by('mr.id', 'ASC');
        $this->db->select('mri.id, mri.add_qty, mri.deduct_qty, mri.used_status, mri.created_at, mri.updated_at, mr.party_name, add_materials.material_name');
        $this->db->from('material_received_inventory AS mri');
        $this->db->join('material_received AS mr', 'mr.id = mri.material_id', 'left');
        $this->db->join('add_materials', 'mr.material_name = add_materials.id', 'left');
        $this->db->where('mri.material_id', '1');
        $this->db->group_by('mri.id');
        $this->db->order_by('mri.id', 'ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$result = $query->result_array();
		
		return $result;
    }
    
    public function get_material_list()
    {
        $this->db->select('add_materials.*,add_trade.trade_name,add_material_unit.material_unit');
		$this->db->from('add_materials');
		$this->db->join('add_material_unit','add_material_unit.add_material_id=add_materials.id','left');
		$this->db->join('add_trade','add_trade.add_material_id=add_materials.id','left');
		$this->db->where('add_materials.status',0);
		$this->db->order_by('add_materials.id','DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
        $result = $query->result_array();
        return $result;
    }
    
     public function update_inventory($material_id)
    {
		
	    $this->db->select('mri.material_id, SUM(mri.total_qty) AS total_qty, MAX(mri.id) AS id');
        $this->db->from('material_received_inventory as mri');
        $this->db->where('used_status', 1);
		$this->db->where('deduct_qty', 0);
        $this->db->where('mri.material_id',$material_id );
        $this->db->group_by('mri.id, mri.total_qty');
        $this->db->order_by('mri.id', 'ASC');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
    }

	public function get_transaction_history($project_id,$company_id,$supervisor_id,$owner_id,$party_name,$material_id)
    {
		
	    $this->db->select('th.material_id, SUM(th.total_amount) AS total_amount, MAX(th.id) AS id');
        $this->db->from('transaction_history as th');
        $this->db->where('th.used_status', 1);
		$this->db->where('th.project_id',$project_id );
		$this->db->where('th.company_id',$company_id );
		$this->db->where('th.supervisor_id',$supervisor_id );
		$this->db->where('th.owner_id',$owner_id );
		$this->db->where('th.party_name',$party_name );
		$this->db->where('th.material_id',$material_id );
	    $this->db->group_by('th.id, th.total_amount');
        $this->db->order_by('th.id', 'ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$result = $query->result_array();
		return $result;
    }

	public function sum_material_purchase($project_id,$company_id,$supervisor_id,$owner_id,$party_name)
    {
		$this->db->select('SUM(th.add_amount) as total_amount, th.material_id, th.party_name');
        $this->db->from('transaction_history as th');
		$this->db->where('th.project_id',$project_id );
		$this->db->where('th.company_id',$company_id );
		$this->db->where('th.supervisor_id',$supervisor_id );
		$this->db->where('th.owner_id',$owner_id );
        $this->db->where('th.party_name', $party_name);
        $this->db->where('material_received_status', 1);
		$this->db->where('paid_unpaid_status', 0);
        $this->db->group_by('material_id');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$result = $query->result_array();
		return $result;
    }

	public function sum_material_purchase_by_id($project_id,$company_id,$supervisor_id,$owner_id,$party_name,$material_id)
    {
		$this->db->select('SUM(th.add_amount) as total_amount, th.material_id, th.party_name');
        $this->db->from('transaction_history as th');
		$this->db->where('th.project_id',$project_id );
		$this->db->where('th.company_id',$company_id );
		$this->db->where('th.supervisor_id',$supervisor_id );
		$this->db->where('th.owner_id',$owner_id );
        $this->db->where('th.party_name', $party_name);
		$this->db->where('th.material_id', $material_id);
        $this->db->where('material_received_status', 1);
        $this->db->group_by('material_id');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$result = $query->result_array();
		return $result;
    }

	public function get_material_received($project_id,$company_id,$supervisor_id,$owner_id)
    {
		$this->db->select('SUM(th.add_amount) as total_amount, th.material_id, th.party_name,th.created_at,th.paid_unpaid_status');
        $this->db->from('transaction_history as th');
		$this->db->where('th.project_id',$project_id );
		$this->db->where('th.company_id',$company_id );
		$this->db->where('th.supervisor_id',$supervisor_id );
		$this->db->where('th.owner_id',$owner_id );
       $this->db->where('material_received_status', 1);
        $this->db->group_by('material_id');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$result = $query->result_array();
		return $result;
    }


	public function get_payment_in($project_id,$company_id,$supervisor_id,$owner_id)
    {
		$this->db->select('th.total_amount as add_amount, th.material_id, th.party_name,th.created_at,th.paid_unpaid_status');
        $this->db->from('transaction_history as th');
		$this->db->where('th.project_id',$project_id );
		$this->db->where('th.company_id',$company_id );
		$this->db->where('th.supervisor_id',$supervisor_id );
		$this->db->where('th.owner_id',$owner_id );
       	$this->db->where('payment_in_status', 1);
        //$this->db->group_by('material_id');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$result = $query->result_array();
		return $result;
    }

	public function get_payment_out($project_id,$company_id,$supervisor_id,$owner_id)
    {
		$this->db->select('th.total_amount as add_amount, th.material_id, th.party_name,th.created_at,th.paid_unpaid_status');
        $this->db->from('transaction_history as th');
		$this->db->where('th.project_id',$project_id );
		$this->db->where('th.company_id',$company_id );
		$this->db->where('th.supervisor_id',$supervisor_id );
		$this->db->where('th.owner_id',$owner_id );
       	$this->db->where('payment_out_status', 1);
        //$this->db->group_by('material_id');
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		$result = $query->result_array();
		return $result;
    }
}