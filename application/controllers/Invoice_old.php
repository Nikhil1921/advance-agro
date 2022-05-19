<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MY_Controller {

    private $name = 'invoice';
    private $title = 'invoice';
    private $table = "company";
    private $redirect = "invoice";

	public function index()
	{
		$data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['dataTables'] = TRUE;
        $data['select'] = TRUE;
        $data['dateFilter'] = TRUE;

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

            $sub_array[] = '<div class="ml-0 table-display row">'.anchor($this->redirect.'/print/'.e_id($row->id), '<i class="fa fa-print"></i>', 'class="btn btn-outline-info mr-2"').'</div>';

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

    public function print($id)
    {
        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = "print";
        $data['url'] = $this->redirect;
        $data['select'] = TRUE;
        $data['dateFilter'] = TRUE;
        $data['data'] = $this->main->get($this->table, 'company_name, contact_person, address, city, gst_no, pan_no, contact_no, contact_email', ['id' => d_id($id)]);
        // $data['contarcts'] = $this->main->getall('contract', 'contact_id', ['status' => 'Completed', 'is_deleted' => 0, 'seller' => d_id($id)]);
        if ($this->session->print):
            $data['print'] = $this->main->get("invoice", 'goods, brokerage, create_date', ['id' => $this->session->print]);
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
            return $this->template->load('template', $this->redirect.'/print', $data);
        else
            return $this->error_404();
    }

    public function getData()
    {
        if (!$this->input->is_ajax_request())
           exit('No direct script access allowed');
        else{
            $this->load->model('contractModel', 'contract');
            $data = $this->contract->getData($this->input->post());
            echo json_encode($data);
            die();
        }
    }

    public function getContract()
    {
        if (!$this->input->is_ajax_request())
           exit('No direct script access allowed');
        else{
            $this->load->model('contractModel', 'contract');
            $data = $this->contract->getContractData($this->input->post());
            echo json_encode($data);
            die();
        }
    }
}