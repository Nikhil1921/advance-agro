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

	public $table = "contracts_notes n";  
	public $select_column = ['n.id', 'c1.contact_id AS contract1', 'c2.contact_id AS contract2', 'c.company_name'];
	public $search_column = ['c1.contact_id', 'c2.contact_id', 'c.company_name'];
    public $order_column = [null, 'c1.contact_id', 'c2.contact_id', 'c.company_name', null];
	public $order = ['n.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table)
            ->where(['n.note_type' => $this->input->post('status')])
            ->join('company c', 'c.id = n.company_id3')
            ->join('contract c1', 'c1.id = n.c_id')
            ->join('contract c2', 'c2.id = n.contract');

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