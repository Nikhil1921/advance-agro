<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class MainModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function add($post, $table)
	{
		if ($this->db->insert($table, $post)) {
			$id = $this->db->insert_id();
			return ($id) ? $id : true;
		}else
			return false;
	}

	public function update($where, $post, $table)
	{
		return $this->db->where($where)->update($table, $post);
	}

	public function get($table, $select, $where, $join = '')
	{
		$this->db->select($select);
		
		if (is_array($join)) {
			foreach ($join as $i => $t) {
            	$this->db->join($t, $t.'.id = u.'.$i);
        	}
		}
		
		$return = $this->db->where($where)->from($table)->get()->row_array();
		
		if ($return) {
			return $return; 	
		}else{
			return FALSE;
		}
	}

	public function delete($id, $table)
	{
		return $this->db->delete($table, $id);
	}

	public function check($table, $where, $select)
	{
		$check = $this->db->select($select)->where($where)->from($table)->get()->row_array();

		if ($check) {
			return $check[$select];
		}else{
			return FALSE;
		}
	}

	public function make_datatables($model)
	{  
	   $this->load->model($model, 'model');			
	   $this->model->make_query();  
	   if($_POST["length"] != -1)  
	   {  
	        $this->db->limit($_POST['length'], $_POST['start']);
	   }  
	   $query = $this->db->get(); 
	   return $query->result();  
	}  

	public function get_filtered_data($model){  
	   $this->load->model($model, 'model');			
	   $this->model->make_query();  
	   $query = $this->db->get();  

	   return $query->num_rows();  
	}

	public function all($table, $where='')  
	{  
		if ($where != '') {
			$this->db->where($where);
		}
		return $this->db->get($table)->num_rows();
	}

	public function getall($table, $select, $where= '', $joins = '', $order_by = '', $not_in = '', $limit = '',$in="")
	{  
		$this->db->select($select);

		if ($where != '') {
			$this->db->where($where);
		}

		if ($not_in != '') {
			$not_in;
		}

		if ($order_by != '') {
			$this->db->order_by($order_by);
		}
		
		if (is_array($joins)) {
			foreach ($joins as $key => $join) {
				$this->db->join($join, $join.'.id = '.$table.'.'.$key);
			}
		}
		if ($limit != '') {
			$this->db->limit($limit);
		}
		if ($in != '') {
			$in;
		}
	    return $this->db->order_by('id', 'DESC')->get($table)->result_array();
	}

	public function count($table, $where, $group = "")
	{
		if ($group != '') {
			$this->db->group_by($group);
		}
		return $this->db->get_where($table, $where)->num_rows();
	}
}