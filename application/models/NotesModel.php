<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class NotesModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "contracts_notes c";  
	public $select_column = ['c.id', 'c.contract'];
	public $search_column = ['c.contract'];
    public $order_column = [null, 'c.contract', null];
	public $order = ['c.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table)
            ->where(['note_type' => $this->input->post('status')]);

        foreach ($this->search_column as $i => $item) 
        {
            if($_POST['search']['value']) 
            {
                if($i===0) 
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->search_column) - 1 == $i) 
                    $this->db->group_end(); 
            }
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
	}           
}