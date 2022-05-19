<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends MY_Controller {

    private $name = 'company';
    private $title = 'company';
    private $table = "company";
    private $redirect = "company";

    protected $validate = [
        [
            'field' => 'company_name',
            'label' => 'Company Name',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'contact_person',
            'label' => 'Contact Person',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'address',
            'label' => 'Address',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'city',
            'label' => 'City',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'contact_no',
            'label' => 'Contact No.',
            'rules' => 'required|numeric|exact_length[10]',
            'errors' => [
                'required' => "%s is Required",
                'numeric' => "%s is Invalid",
                'exact_length' => "%s is Invalid",
            ],
        ],
        [
            'field' => 'gst_no',
            'label' => 'GST No.',
            'rules' => 'max_length[20]',
            'errors' => [
                'max_length' => "%s is Invalid",
            ],
        ],
        [
            'field' => 'pan_no',
            'label' => 'PAN No.',
            'rules' => 'exact_length[10]',
            'errors' => [
                'exact_length' => "%s is Invalid",
            ],
        ],
        [
            'field' => 'contact_email',
            'label' => 'Contact Email',
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => "%s is Required",
                'valid_email' => "%s is Invalid"
            ],
        ]
    ];

	public function index()
	{
		$data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['dataTables'] = TRUE;
        $this->template->load('template', $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables('companyModel');
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)  
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->company_name;
            $sub_array[] = $row->contact_person;
            $sub_array[] = $row->contact_no;
            $sub_array[] = $row->contact_email;
            $sub_array[] = $row->city;

            $sub_array[] = '<div class="ml-0 table-display row">'.anchor($this->redirect.'/view/'.e_id($row->id), '<i class="fa fa-eye"></i>', 'class="btn btn-outline-info mr-2"').anchor($this->redirect.'/print/'.e_id($row->id), '<i class="fa fa-print"></i>', 'class="btn btn-outline-info mr-2"').anchor($this->redirect.'/update/'.e_id($row->id), '<i class="fa fa-edit"></i>', 'class="btn btn-outline-primary mr-2"').
                    form_open($this->redirect.'/delete', ['id' => e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fas fa-trash"></i>','type'  => 'button','class' => 'btn btn-outline-danger', 'onclick' => "remove(".e_id($row->id).")"]).form_close().'</div>';

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();  

        $output = array(  
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->main->count($this->table, ['is_deleted' => 0]),
            "recordsFiltered"   => $this->main->get_filtered_data('companyModel'),
            "data"              => $data,
            $csrf_name          => $csrf_hash
        );
        
        echo json_encode($output);
    }

    public function add()
	{
		$data['name'] = $this->name;
		$data['title'] = $this->title;
		$data['operation'] = "add";
        $data['url'] = $this->redirect;
        $this->form_validation->set_rules($this->validate);
        if ($this->form_validation->run() == FALSE)
        {
            return $this->template->load('template', $this->redirect.'/add', $data);
        }
        else
        {
        	$post = [
        		'company_name' => $this->input->post('company_name'),
                'contact_person' => $this->input->post('contact_person'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'gst_no' => (!empty($this->input->post('gst_no'))) ? $this->input->post('gst_no') : 'Not Given',
                'pan_no' => (!empty($this->input->post('pan_no'))) ? $this->input->post('pan_no') : 'Not Given',
                'contact_no' => $this->input->post('contact_no'),
                'contact_email' => $this->input->post('contact_email'),
                'created_at'   => date('Y-m-d H:i:s'),
        		'last_update'  => date('Y-m-d H:i:s')
        	];
        	
        	$id = $this->main->add($post, $this->table);

        	flashMsg($id, ucwords($this->title)." Added Successfully.", ucwords($this->title)." Not Added. Try again.", $this->redirect);
        }
	}

	public function view($id)
	{
		$data['name'] = $this->name;
		$data['title'] = $this->title;
		$data['operation'] = "view";
        $data['url'] = $this->redirect;
		$data['data'] = $this->main->get($this->table, 'company_name, contact_person, address, city, gst_no, pan_no, contact_no, contact_email', ['id' => d_id($id)]);
		
		if ($data['data']) 
			return $this->template->load('template', $this->redirect.'/view', $data);
		else
			return $this->error_404();
	}

	public function edit($id)
	{
		$data['name'] = $this->name;
		$data['title'] = $this->title;
		$data['operation'] = "update";
        $data['url'] = $this->redirect;
		$data['data'] = $this->main->get($this->table, 'company_name, contact_person, address, city, gst_no, pan_no, contact_no, contact_email', ['id' => d_id($id)]);
		
		if ($data['data']) 
		{
			$this->session->set_flashdata('updateId', $id);
			return $this->template->load('template', $this->redirect.'/update', $data);
		}
		else
			return $this->error_404();
	}

	public function update()
	{
		if (!$this->session->updateId) return redirect($this->redirect);
		$data['name'] = $this->name;
		$data['title'] = $this->title;
		$data['operation'] = "update";
        $data['url'] = $this->redirect;
		$updateId = $this->session->updateId;
		$this->form_validation->set_rules($this->validate);
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->edit($updateId);
        }
        else
        {
        	$post = [
                'company_name' => $this->input->post('company_name'),
                'contact_person' => $this->input->post('contact_person'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'gst_no' => (!empty($this->input->post('gst_no'))) ? $this->input->post('gst_no') : 'Not Given',
                'pan_no' => (!empty($this->input->post('pan_no'))) ? $this->input->post('pan_no') : 'Not Given',
                'contact_no' => $this->input->post('contact_no'),
                'contact_email' => $this->input->post('contact_email'),
                'last_update'  => date('Y-m-d H:i:s')
            ];
        	
        	$id = $this->main->update(['id' => d_id($updateId)], $post, $this->table);

			flashMsg($id, ucwords($this->title)." Updated Successfully.", ucwords($this->title)." Not Updated. Try again.", $this->redirect);
        }
	}

	public function delete()
    {
        $post = [
                'is_deleted' => 1,
                'last_update' => date('Y-m-d H:i:s')
            ];

        $id = $this->main->update(['id' => d_id($this->input->post('id'))], $post, $this->table);

        flashMsg($id, ucwords($this->title)." Deleted Successfully.", ucwords($this->title)." Not Deleted. Try again.", $this->redirect);
    }

    public function print($id)
    {
        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = "print";
        $data['url'] = $this->redirect;
        // $data['select'] = TRUE;
        $data['dateFilter'] = TRUE;
        
        $data['data'] = $this->main->get($this->table, 'company_name, contact_person, address, city, gst_no, pan_no, contact_no, contact_email', ['id' => d_id($id)]);
        if ($this->session->print):
            $data['print'] = $this->main->get("invoice", 'id, goods, brokerage, create_date', ['id' => $this->session->print]);
        endif;
        if ($this->input->server('REQUEST_METHOD') === 'POST'):
            $post = [
                'goods'       => $this->input->post('goods'),
                'brokerage'   => $this->input->post('brokerage'),
                'c_id'        => d_id($id),
                'create_date' => date("Y-m-d", strtotime($this->input->post('create_date')))
            ];
            $add = $this->main->add($post, "invoice");
            if ($add):
                $this->session->set_flashdata('print', $add);
            else:
                $this->session->set_flashdata('error', "Error in invoice creation.");
            endif;
            return redirect($this->redirect.'/print/'.$id);
        endif;
        if ($data['data']) 
            return $this->template->load('template', 'invoice/print', $data);
        else
            return $this->error_404();
    }
}