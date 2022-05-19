<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class ContractModel extends CI_Model 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public $table = "contract c";  
	public $select_column = ['c.id', 'b.company_name buyer', 's.company_name seller', 'p.name product', 'c.price', 'CONCAT(c.quantity, " - ", c.quantity_type) quantity', 'invoice', 'c.status', 'c.last_update', 'c.certificate','c.contact_id', '(c.price * c.quantity * brokerage / 100) brokerage', 'c.contract_date', 'c.conditions'];
	public $search_column = ['b.company_name', 's.company_name', 'p.name', 'c.price', 'c.quantity', 'c.quantity_type', 'c.contact_id', 'c.contract_date', 'c.conditions'];
    public $order_column = [null, 'c.contract_date', 'c.id', 'b.company_name', null, 's.company_name', null, 'p.name', 'c.price', 'c.quantity', null, null, null];
	public $order = ['c.id' => 'DESC'];

	public function make_query()  
	{  
        $this->db->select($this->select_column)	
            ->from($this->table)
            ->where(['c.is_deleted' => 0, 'c.status' => $this->input->post('status')])
            ->join('company b', 'b.id = c.buyer')
            ->join('company s', 's.id = c.seller')
            ->join('product p', 'p.id = c.product');

        if ($this->input->post('buyer_id')) 
            $this->db->where(['buyer' => $this->input->post('buyer_id')]);
        if ($this->input->post('seller_id')) 
            $this->db->where(['seller' => $this->input->post('seller_id')]);
        if ($this->input->post('prod_id')) 
            $this->db->where(['product' => $this->input->post('prod_id')]);
        if ($this->input->post('date_filter')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('date_filter')));
            $this->db->where(['c.contract_date >= ' => date('Y-m-d', strtotime($date[0])), 'c.contract_date <= ' => date('Y-m-d', strtotime($date[1]))]);
        }
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

    public function getContract($id)
    {
        array_push($this->select_column, 'c.brokerage', 'a.address delivery', 'c.specification', 'b.address buyer_address', 's.address seller_address', 'b.city buyer_city', 's.city seller_city', 'b.gst_no buyer_gst_no', 's.gst_no seller_gst_no', 'b.pan_no buyer_pan_no', 's.pan_no seller_pan_no', 'pa.packing', 'c.conditions', 'c.payment', 'c.other_terms', 'invoice', 'c.contract_date');
        
        return $this->db->select($this->select_column) 
                ->from($this->table)
                ->where(['c.is_deleted' => 0, 'c.id' => $id])
                ->join('company b', 'b.id = c.buyer')
                ->join('company s', 's.id = c.seller')
                ->join('product p', 'p.id = c.product')
                ->join('address a', 'a.id = c.delivery')
                ->join('packing pa', 'pa.id = c.packing')
                ->get()
                ->row_array();
    }

    public function sendContractSms($id)
    {   
        $cont = $this->db->select('c.contact_id, b.contact_no, b.company_name buyer, s.company_name seller, c.price, CONCAT(c.quantity, " - ", c.quantity_type) quantity, pa.payment')
                ->from($this->table)
                ->where(['c.is_deleted' => 0, 'c.id' => $id])
                ->join('company b', 'b.id = c.buyer')
                ->join('company s', 's.id = c.seller')
                ->join('payment pa', 'pa.id = c.payment')
                ->get()
                ->row_array();
                
        if ($cont) {
            $sms = "Your contract No. - ".$cont['contact_id'].".\nBuyer Name - ".$cont['buyer']."\nSeller Name - ".$cont['seller']."\nRate - ".$cont['price']."\nWeight - ".$cont['quantity']."\nPayment Condition - ".$cont['payment']."\n\nDelivered : ".date('d/m/Y')."\n Position : Completed\n\n- Advance Agri Brokers, Unjha.";

            send_sms($sms, $cont['contact_no']);
            return true;
        }else
            return true;
    }

    public function getChart($i, $d)
    {
        $this->load->helper('date');
        $start = nice_date(date('Y').$i.'01', 'Y-m-d').'<br>';
        $end = nice_date(date('Y').$i.$d, 'Y-m-d');
        
        return $this->db->select('id') 
                ->from($this->table)
                ->where(['c.is_deleted' => 0])
                ->where("c.contract_date BETWEEN '$start' AND '$end'")
                ->get()
                ->num_rows();
    }

    public function getData($post)
    {
        $date = explode("-", str_replace(" ", "", $post['dates']));
        return $this->db->select('p.name, c.contact_id, CONCAT(c.quantity, " ", c.quantity_type) quantity, c.price, (c.price * c.quantity * c.brokerage / 100) brokerage, c.contract_date')
                        ->from($this->table)
                        ->where(['c.status' => 'Completed', 'c.is_deleted' => 0, 'seller' => d_id($post['seller'])])
                        ->where(['c.contract_date >= ' => date('Y-m-d', strtotime($date[0])), 'c.contract_date <= ' => date('Y-m-d', strtotime($date[1]))])
                        ->join('product p', 'p.id = c.product')
                        ->get()
                        ->result();
    }

    public function getContractData($post)
    {
        return $this->db->select('p.name, c.contact_id, CONCAT(c.quantity, " ", c.quantity_type) quantity, c.price, (c.price * c.quantity * c.brokerage / 100) brokerage, c.contract_date')
                        ->from($this->table)
                        ->where_in('c.contact_id', $post['contract_id'])
                        ->join('product p', 'p.id = c.product')
                        ->get()
                        ->result();
    }
}