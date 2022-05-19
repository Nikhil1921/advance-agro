<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Packing extends MY_Controller {

    private $name = 'packing';
    private $title = 'packing';
    private $table = "packing";
    private $redirect = "packing";

    protected $validate = [
        [
            'field' => 'packing',
            'label' => 'Packing',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
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
        $fetch_data = $this->main->make_datatables('packingModel');
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->packing;

            $sub_array[] = '<div class="ml-0 table-display row">'.anchor($this->redirect.'/view/'.e_id($row->id), '<i class="fa fa-eye"></i>', 'class="btn btn-outline-info mr-2"').anchor($this->redirect.'/update/'.e_id($row->id), '<i class="fa fa-edit"></i>', 'class="btn btn-outline-primary mr-2"').
                    form_open($this->redirect.'/delete', ['id' => e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fas fa-trash"></i>','type'  => 'button','class' => 'btn btn-outline-danger', 'onclick' => "remove(".e_id($row->id).")"]).form_close().'</div>';

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();  

        $output = array(  
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->main->count($this->table, ['is_deleted' => 0]),
            "recordsFiltered"   => $this->main->get_filtered_data('packingModel'),
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
        		'packing'     => $this->input->post('packing')
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
		$data['data'] = $this->main->get($this->table, 'packing', ['id' => d_id($id)]);
		
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
		$data['data'] = $this->main->get($this->table, 'packing', ['id' => d_id($id)]);
		
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
        		'packing' => $this->input->post('packing')
        	];
        	
        	$id = $this->main->update(['id' => d_id($updateId)], $post, $this->table);

			flashMsg($id, ucwords($this->title)." Updated Successfully.", ucwords($this->title)." Not Updated. Try again.", $this->redirect);
        }
	}

	public function delete()
	{
        $post = [
                'is_deleted' => 1
            ];

		$id = $this->main->update(['id' => d_id($this->input->post('id'))], $post, $this->table);

		flashMsg($id, ucwords($this->title)." Deleted Successfully.", ucwords($this->title)." Not Deleted. Try again.", $this->redirect);
	}
}