<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class InvoiceModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "invoice i";  
	public $select_column = ['i.id', 'c.company_name', 'c.contact_person', 'i.goods', 'i.brokerage', 'i.create_date'];
	public $search_column = ['c.company_name', 'c.contact_person', 'i.goods', 'i.brokerage', 'i.create_date'];
    public $order_column = [null, 'c.company_name', 'c.contact_person', 'i.goods', 'i.brokerage', 'i.create_date', null];
	public $order = ['i.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table)
            ->where(['i.is_deleted' => 0])
            ->join('company c', 'c.id = i.c_id');

        $i = 0;

        foreach ($this->search_column as $item) 
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
            $i++;
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