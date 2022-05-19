<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
*
*/
class ApiModel extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function contractList($where)
	{
		
		$contracts = $this->db->select(['c.id', 'b.company_name buyer', 's.company_name seller', 'p.name product', 'c.price', 'c.quantity', 'c.quantity_type', 'invoice', 'c.status', 'c.certificate','c.contact_id', '(c.price * c.quantity * brokerage / 100) brokerage', 'c.contract_date', 'c.brokerage', 'c.conditions', 'c.other_terms', 'a.address', 'pa.packing'])
			            ->from('contract c')
			            ->where($where)
			            ->join('company b', 'b.id = c.buyer')
			            ->join('company s', 's.id = c.seller')
			            ->join('product p', 'p.id = c.product')
			            ->join('address a', 'a.id = c.delivery')
			            ->join('packing pa', 'pa.id = c.packing')
			            ->get()
			            ->result_array();
			            
		if ($contracts) {
			foreach ($contracts as $k => $v) {
				$contracts[$k]['other_terms'] = json_decode($v['other_terms']);
				$in = json_decode($v['invoice']);
				foreach ($in as $key => $val) 
					$in->$key = assets('invoices/').$val;
				$contracts[$k]['invoice'] = $in;
			}
			return $contracts;
		}else
			return false;
	}
}