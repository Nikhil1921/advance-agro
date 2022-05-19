<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MY_Controller {

    private $name = 'invoice';
    private $title = 'invoice';
    private $table = "invoice";
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
        $fetch_data = $this->main->make_datatables('invoiceModel');
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)  
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->company_name;
            $sub_array[] = $row->contact_person;
            $sub_array[] = $row->goods;
            $sub_array[] = $row->brokerage;
            $sub_array[] = date("d-m-Y", strtotime($row->create_date));

            $sub_array[] = '<div class="ml-0 table-display row">'.
                            anchor($this->redirect.'/print/'.e_id($row->id), '<i class="fa fa-print"></i>', 'class="btn btn-outline-info mr-2"').
                            form_open($this->redirect.'/delete', ['id' => e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fas fa-trash"></i>','type'  => 'button','class' => 'btn btn-outline-danger', 'onclick' => "remove(".e_id($row->id).")"]).form_close()
                            .'</div>';

            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();  

        $output = array(  
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->main->count($this->table, ['is_deleted' => 0]),
            "recordsFiltered"   => $this->main->get_filtered_data('invoiceModel'),
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
        $data['dateFilter'] = TRUE;
        $data['update'] = TRUE;
        $data['url'] = $this->redirect;
        $data['print'] = $this->main->get($this->table, 'id, goods, brokerage, create_date, c_id', ['id' => d_id($id)]);
        
        if ($data['print']):
            $data['data'] = $this->main->get("company", 'company_name, contact_person, address, city, gst_no, pan_no, contact_no, contact_email', ['id' => $data['print']['c_id']]);
            return $this->template->load('template', $this->redirect.'/print', $data);
        else:
            return $this->error_404();
        endif;
    }

    public function update($id)
    {
        $post = [
                'goods'       => $this->input->post('goods'),
                'brokerage'   => $this->input->post('brokerage'),
                'create_date' => date("Y-m-d", strtotime($this->input->post('create_date')))
            ];

        $id = $this->main->update(['id' => d_id($id)], $post, $this->table);

        flashMsg($id, ucwords($this->title)." Updated Successfully.", ucwords($this->title)." Not Updated. Try again.", $this->redirect);
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