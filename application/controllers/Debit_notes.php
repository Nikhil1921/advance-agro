<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Debit_notes extends MY_Controller {

    private $name = 'debit-notes';
    private $title = 'debit notes';
    private $table = "contracts_notes";
    private $redirect = "debit-notes";

    public function index()
	{
		$data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['dataTables'] = TRUE;
        
        return $this->template->load('template', $this->redirect.'/home', $data);
	}

    public function get()
    {
        $fetch_data = $this->main->make_datatables('notesModel');
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)  
        {
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->contract;

            $sub_array[] = '<div class="ml-0 table-display row">'.
                    anchor($this->redirect.'/add-update/'.e_id($row->id), '<i class="fa fa-edit"></i>', 'class="btn btn-outline-primary mr-2"').
                    anchor($this->redirect.'/print/'.e_id($row->id), '<i class="fa fa-print"></i>', 'class="btn btn-outline-primary mr-2"').
                    '</div>';

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();  

        $output = array(  
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->main->count($this->table, ['note_type' => $this->input->post('status')]),
            "recordsFiltered"   => $this->main->get_filtered_data('addressModel'),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        );
        
        echo json_encode($output);
    }

    public function add_update(int $id=0)
    {
        $this->form_validation->set_rules($this->validate);

        if ($this->form_validation->run() == FALSE)
        {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = "note";
            $data['url'] = $this->redirect;
            $data['contracts'] = $this->main->getall('contract', 'contact_id, id', ['is_deleted' => 0, 'status' => 'Completed']);
            $data['companies'] = $this->main->getall('company', 'company_name, id', ['is_deleted' => 0]);

            if($id !== 0) $data['data'] = $this->main->get('contracts_notes', 'id, actual, settled, quantity, brokerage, note_type, created_at, brok_price, contract, c_id, company_id', ['id' => d_id($id)]);

            if ($data['contracts'] && $data['companies'])
            {
                return $this->template->load('template', 'notes/add-update', $data);
            }
            else
                return $this->error_404();
        }else{
            $post = [
                'actual' => $this->input->post('actual'),
                'settled' => $this->input->post('settled'),
                'quantity' => $this->input->post('quantity'),
                'brokerage' => $this->input->post('brokerage'),
                'contract' => $this->input->post('contract'),
                'company_id' => d_id($this->input->post('company_id')),
                'note_type' => "Debit",
                'brok_price' => $this->input->post('brok_price'),
                'c_id' => d_id($this->input->post('c_id')),
                'created_at' => time()
            ];
            
            if($id !== 0){
                $id = d_id($id);
                $add = $this->main->update(['id' => $id], $post, 'contracts_notes');
            }else
                $add = $id = $this->main->add($post, 'contracts_notes');
            
            $redirect = $add ? "$this->redirect/print/".e_id($id) : "$this->redirect/add-update/".e_id($id);

            flashMsg($add, "Note added Successfully.", "Note Not added. Try again.", $redirect);
        }
    }

    public function print($id)
    {
        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = "note";
        $data['url'] = $this->redirect;
        $data['print'] = $this->main->get('contracts_notes', 'id, actual, settled, quantity, brokerage, note_type, created_at, brok_price, contract, c_id, company_id', ['id' => d_id($id)]);
        
        if ($data['print'])
        {
            return $this->template->load('template', 'notes/add-update', $data);
        }
        else
            return $this->error_404();
    }

    protected $validate = [
            [
                'field' => 'actual',
                'label' => 'Actual rate',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => "%s is Required",
                    'integer'  => "%s is Invalid",
                ],
            ],
            [
                'field' => 'contract',
                'label' => 'Contract',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => "%s is Required",
                    'integer'  => "%s is Invalid",
                ],
            ],
            [
                'field' => 'settled',
                'label' => 'Settled rate',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => "%s is Required",
                    'integer'  => "%s is Invalid",
                ],
            ],
            [
                'field' => 'quantity',
                'label' => 'Quantity',
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => "%s is Required",
                    'decimal'  => "%s is Invalid",
                ],
            ],
            [
                'field' => 'brokerage',
                'label' => 'Brokerage percentage',
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => "%s is Required",
                    'decimal'  => "%s is Invalid",
                ],
            ],
            [
                'field' => 'brok_price',
                'label' => 'Brokerage',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => "%s is Required",
                    'integer'  => "%s is Invalid",
                ],
            ],
        ];
}