<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contract extends MY_Controller {

    private $name = 'contract';
    private $title = 'contract';
    private $table = "contract";
    private $redirect = "contract";

    protected $validate = [
        [
            'field' => 'buyer_id',
            'label' => 'Buyer',
            'rules' => 'required|integer',
            'errors' => [
                'required' => "%s is Required",
                'integer'  => "%s is Invalid",
            ],
        ],
        [
            'field' => 'seller_id',
            'label' => 'Seller',
            'rules' => 'required|integer',
            'errors' => [
                'required' => "%s is Required",
                'integer'  => "%s is Invalid",
            ],
        ],
        [
            'field' => 'prod_id',
            'label' => 'Product',
            'rules' => 'required|integer',
            'errors' => [
                'required' => "%s is Required",
                'integer'  => "%s is Invalid",
            ],
        ],
        [
            'field' => 'packing_id',
            'label' => 'Packing',
            'rules' => 'required|integer',
            'errors' => [
                'required' => "%s is Required",
                'integer'  => "%s is Invalid",
            ],
        ],
        [
            'field' => 'address_id',
            'label' => 'Delivery Address',
            'rules' => 'required|integer',
            'errors' => [
                'required' => "%s is Required",
                'integer'  => "%s is Invalid",
            ],
        ],
        [
            'field' => 'conditions',
            'label' => 'Loading Condition',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'quantity',
            'label' => 'Quantity',
            'rules' => 'required|decimal',
            'errors' => [
                'required' => "%s is Required",
                'decimal'  => "%s is Invalid"
            ],
        ],
        [
            'field' => 'quantity_type',
            'label' => 'Quantity Type',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'price',
            'label' => 'Price',
            'rules' => 'required|decimal',
            'errors' => [
                'required' => "%s is Required",
                'decimal'  => "%s is Invalid"
            ],
        ],
        [
            'field' => 'brokerage',
            'label' => 'Brokerage',
            'rules' => 'required|decimal',
            'errors' => [
                'required' => "%s is Required",
                'decimal'  => "%s is Invalid"
            ],
        ],
        [
            'field' => 'contract_date',
            'label' => 'Contract Date',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'payment',
            'label' => 'Payment',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ]
    ];

	public function index()
	{
		$data['name'] = $this->name;
		$data['title'] = $this->title;
        $data['url'] = $this->redirect;
        $data['dataTables'] = TRUE;
        $data['select'] = TRUE;
        $data['dateFilter'] = TRUE;

        $data['products'] = $this->main->getall('product', 'id, name', ['is_deleted' => 0]);
        $data['companies'] = $this->main->getall('company', 'id, company_name', ['is_deleted' => 0]);

        $this->template->load('template', $this->redirect.'/home', $data);
	}

	public function get()
    {
        $fetch_data = $this->main->make_datatables('contractModel');
        $sr = $_POST['start'] + 1;
        $data = array();

        foreach($fetch_data as $row)  
        {  
            $sub_array = array();
            $sub_array[] = $sr;
            $sub_array[] = $row->contract_date;
            $sub_array[] = $row->contact_id;
            $invoice = json_decode($row->invoice);
            $sub_array[] = $row->buyer;
            $sub_array[] = anchor('assets/invoices/'.$invoice->buyer, '<i class="fa fa-print"></i>', 'class="btn btn-outline-info mr-2"');
            $sub_array[] = $row->seller;
            $sub_array[] = anchor('assets/invoices/'.$invoice->seller, '<i class="fa fa-print"></i>', 'class="btn btn-outline-info mr-2"');
            $sub_array[] = $row->product;
            $sub_array[] = $row->price;
            $sub_array[] = $row->quantity;
            $sub_array[] = $row->brokerage;
            $sub_array[] = $row->conditions;

            $action = '<div class="ml-0 table-display row">';

            if ($row->status == 'Pending'){
                $action .= anchor($this->redirect.'/update/'.e_id($row->id), '<i class="fa fa-edit"></i>', 'class="btn btn-outline-primary mr-2"').
                        anchor($this->redirect.'/note/'.e_id($row->id), '<i class="fa fa-sticky-note"></i>', 'class="btn btn-outline-primary mr-2"').
                        form_button([ 'content' => '<i class="fas fa-upload"></i>','type'  => 'button','class' => 'btn btn-outline-secondary mr-2', 'onclick' => "uploadCertificate(".e_id($row->id).")"]);

            }

            if ($row->status == 'Completed' && $row->certificate != 'NA')
                $action .= anchor('assets/certificate/'.$row->certificate, '<i class="fa fa-certificate"></i>', 'class="btn btn-outline-secondary mr-2"');
            
            $action .= form_open($this->redirect.'/delete', ['id' => e_id($row->id)], ['id' => e_id($row->id)]).form_button([ 'content' => '<i class="fas fa-trash"></i>','type'  => 'button','class' => 'btn btn-outline-danger', 'onclick' => "remove(".e_id($row->id).")"]).form_close().'</div>';
            $sub_array[] = $action;
            $data[] = $sub_array;  
            $sr++;
        }
        
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();  

        $count = ['is_deleted' => 0, 'status' => $this->input->post('status')];

        if ($this->input->post('buyer_id')) 
            $count['buyer'] = $this->input->post('buyer_id');
        if ($this->input->post('seller_id')) 
            $count['seller'] = $this->input->post('seller_id');
        if ($this->input->post('prod_id')) 
            $count['product'] = $this->input->post('prod_id');
        
        if ($this->input->post('date_filter')) {
            $date = explode("-", str_replace(" ", "", $this->input->post('date_filter')));
            $count['contract_date >= '] = date('Y-m-d', strtotime($date[0]));
            $count['contract_date <= '] = date('Y-m-d', strtotime($date[1]));
        }

        $output = array(  
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->main->count($this->table, $count),
            "recordsFiltered"   => $this->main->get_filtered_data('contractModel'),
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
        $data['select'] = TRUE;
        $data['checkbox'] = TRUE;
        $data['inputmask'] = TRUE;
        
        $this->form_validation->set_rules($this->validate);
        if ($this->form_validation->run() == FALSE)
        {
        	$data['products'] = $this->main->getall('product', 'id, name, specification', ['is_deleted' => 0]);
        	$data['packing'] = $this->main->getall('packing', 'id, packing', ['is_deleted' => 0]);
        	$data['companies'] = $this->main->getall('company', 'id, company_name', ['is_deleted' => 0]);
        	$data['addresses'] = $this->main->getall('address', 'id, address', ['is_deleted' => 0]);
            $data['payments'] = $this->main->getall('payment', 'id, payment', ['is_deleted' => 0]);

            return $this->template->load('template', $this->redirect.'/add', $data);
        }
        else
        {
            $other_terms = (!empty($this->input->post('other_term'))) ? json_encode($this->input->post('other_term')) : 'Not Applicable';

        	$post = [
                'product' => $this->input->post('prod_id'),
                'specification' => (!empty($this->input->post('specification'))) ? json_encode($this->input->post('specification')) : '',
                'quantity' => $this->input->post('quantity'),
                'quantity_type' => $this->input->post('quantity_type'),
                'buyer' => $this->input->post('buyer_id'),
                'seller' => $this->input->post('seller_id'),
                'price' => $this->input->post('price'),
                'brokerage' => $this->input->post('brokerage'),
                'packing' => $this->input->post('packing_id'),
                'delivery' => $this->input->post('address_id'),
                'conditions' => $this->input->post('conditions'),
                'payment' => $this->input->post('payment'),
                'invoice' => json_encode(['buyer' => 'buyer_'.time().'.pdf', 'seller' => 'seller_'.time().'.pdf']),
                'other_terms' => $other_terms,
                'created_by' => $this->id,
                'created_at'  => date('Y-m-d H:i:s'),
                'update_by' => $this->id,
                'contract_date' => date("Y-m-d", strtotime($this->input->post('contract_date'))),
                'last_update' => date('Y-m-d H:i:s')
        	];

            $id = $this->main->add($post, $this->table);

            if ($id) 
            {
                $buy = $this->main->get('company', 'contact_no, company_name', ['id' => $post['buyer']]);
                $sell = $this->main->get('company', 'contact_no, company_name', ['id' => $post['seller']]);
                
                $this->main->update(['id' => $id], ['contact_id' => date('Y', strtotime($post['contract_date'])).$id], $this->table);
                $this->sendMailBuyer($id, $post);
                $this->sendMailSeller($id, $post);
                
                $sms = "Your contract No. - ".date('Y', strtotime($post['contract_date'])).$id.".\nBuyer Name - ".$buy['company_name']."\nSeller Name - ".$sell['company_name']."\nRate - ".$post['price']."\nWeight - ".$post['quantity'].' - '.$post['quantity_type']."\nLoading Condition - ".$post['conditions']."\nPayment Condition - ".$this->main->check('payment', ['id' => $post['payment']], 'payment')."\nCheck your Email for contract.\n- Advance Agri Brokers, Unjha.";

                // send_sms($buy['contact_no'].','.$sell['contact_no'], $sms);
            }

        	flashMsg($id, ucwords($this->title)." Added Successfully.", ucwords($this->title)." Not Added. Try again.", $this->redirect);
        }
	}

	public function edit($id)
	{
		$data['name'] = $this->name;
		$data['title'] = $this->title;
		$data['operation'] = "update";
        $data['url'] = $this->redirect;
        $data['select'] = TRUE;
        $data['checkbox'] = TRUE;
        
        $data['data'] = $this->main->get($this->table, 'product, quantity, quantity_type, buyer buyer_id, seller seller_id, price, brokerage, packing, delivery, conditions, payment, other_terms, invoice, contract_date', ['id' => d_id($id)]);
		
		if ($data['data'])
		{
			$this->session->set_flashdata('updateId', $id);
            $data['products'] = $this->main->getall('product', 'id, name', ['is_deleted' => 0]);
            $data['packing'] = $this->main->getall('packing', 'id, packing', ['is_deleted' => 0]);
            $data['companies'] = $this->main->getall('company', 'id, company_name', ['is_deleted' => 0]);
            $data['addresses'] = $this->main->getall('address', 'id, address', ['is_deleted' => 0]);
            $data['payments'] = $this->main->getall('payment', 'id, payment', ['is_deleted' => 0]);
			return $this->template->load('template', $this->redirect.'/update', $data);
		}
		else
			return $this->error_404();
	}

	public function update()
	{
		if (!$this->session->updateId) return redirect($this->redirect);
        $this->session->set_flashdata('updateId', $this->session->updateId);
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
        	$other_terms = (!empty($this->input->post('other_term'))) ? json_encode($this->input->post('other_term')) : 'Not Applicable';

            $post = [
                'product' => $this->input->post('prod_id'),
                'specification' => (!empty($this->input->post('specification'))) ? json_encode($this->input->post('specification')) : '',
                'quantity' => $this->input->post('quantity'),
                'quantity_type' => $this->input->post('quantity_type'),
                'buyer' => $this->input->post('buyer_id'),
                'seller' => $this->input->post('seller_id'),
                'price' => $this->input->post('price'),
                'brokerage' => $this->input->post('brokerage'),
                'packing' => $this->input->post('packing_id'),
                'delivery' => $this->input->post('address_id'),
                'conditions' => $this->input->post('conditions'),
                'payment' => $this->input->post('payment'),
                'invoice' => json_encode(['buyer' => 'buyer_'.time().'.pdf', 'seller' => 'seller_'.time().'.pdf']),
                'other_terms' => $other_terms,
                'update_by' => $this->id,
                'last_update' => date('Y-m-d H:i:s')
            ];
            
        	$id = $this->main->update(['id' => d_id($updateId)], $post, $this->table);
            $invoice = json_decode($this->input->post('invoice'));
        	
            if ($id) $this->sendMailBuyer(d_id($updateId), $post, './assets/invoices/'.$invoice->buyer);
            if ($id) $this->sendMailSeller(d_id($updateId), $post, './assets/invoices/'.$invoice->seller);

			flashMsg($id, ucwords($this->title)." Updated Successfully.", ucwords($this->title)." Not Updated. Try again.", $this->redirect);
        }
	}

	public function note($id)
    {
        $validate = [
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

        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE)
        {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = "note";
            $data['url'] = $this->redirect;
            $data['data'] = $this->main->get($this->table, 'quantity_type, contact_id, contract_date, buyer', ['id' => d_id($id)]);
            
            if ($data['data'])
            {
                if($this->session->note_id)
                    $data['print'] = $this->main->get('contracts_notes', 'id, actual, settled, quantity, brokerage, note_type, created_at, brok_price', ['id' => $this->session->note_id, 'c_id' => d_id($id)]);
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
                'note_type' => $this->input->post('note_type'),
                'brok_price' => $this->input->post('brok_price'),
                'c_id' => d_id($id),
                'created_at' => time()
            ];
            
            $add = $this->main->add($post, 'contracts_notes');
            // if($add) $this->session->set_userdata('note_id', $add);
            if($add) $this->session->set_flashdata('note_id', $add);
            flashMsg($add, "Note added Successfully.", "Note Not added. Try again.", "$this->redirect/note/$id");
        }
    }

	public function delete()
	{
        $post = [
                'is_deleted' => 1,
                'update_by' => $this->id,
                'last_update' => date('Y-m-d H:i:s')
            ];

		$id = $this->main->update(['id' => d_id($this->input->post('id'))], $post, $this->table);

		flashMsg($id, ucwords($this->title)." Deleted Successfully.", ucwords($this->title)." Not Deleted. Try again.", $this->redirect);
	}

    public function upload()
    {
        $cer = self::certificate();
        if ($cer['error']) {
            $id = 0;
            $error = $cer['msg'];
        } else{
            $post = [
                    'certificate' => $cer['name'],
                    'status' => 'Completed',
                    'update_by' => $this->id,
                    'last_update' => date('Y-m-d H:i:s')
                ];
            
            $id = $this->main->update(['id' => d_id($this->input->post('contract_id'))], $post, $this->table);
            $error = "Purity Certificate Upload Not Successful.";
        }

        if ($id) {
            $this->load->model('contractModel', 'contract');
            $this->contract->sendContractSms(d_id($this->input->post('contract_id')));
        }
        
        flashMsg($id, "Purity Certificate Upload Successful.", $error, $this->redirect);
    }

    public function getSpecs($id)
    {
        $specs = $this->main->get('product', 'specification', ['id' => $id]);
        $spec = '';
        
        if ($specs) {
        
            if (!empty($updateId = $this->session->updateId)) {
                $this->session->set_flashdata('updateId', $updateId);
                $data = $this->main->get($this->table, 'product, specification', ['id' => d_id($updateId)]);
                
                if ($id == $data['product']) {
                    foreach (json_decode($data['specification']) as $k => $v) {
                        $spec .= '<div class="col-6"> <div class="form-group"> <label for="specification_'.$k.'">'.strtoupper(str_replace("_", ' ', trim($k))).'</label> <input type="text" name="specification['.strtoupper(str_replace(" ", '_', trim($k))).']" class="form-control" id="specification_'.$k.'" placeholder="Enter '.strtoupper(str_replace("_", ' ', trim($k))).'" value="'.$v.'"> </div></div>';
                    }
                }else{
                    foreach (json_decode($specs['specification']) as $k => $v) {
                        $spec .= '<div class="col-6"> <div class="form-group"> <label for="specification_'.$k.'">'.strtoupper($v).'</label> <input type="text" name="specification['.strtoupper(str_replace(" ", '_', trim($v))).']" class="form-control" id="specification_'.$k.'" placeholder="Enter '.strtoupper($v).'"> </div></div>';
                    }
                }
            }else{
                foreach (json_decode($specs['specification']) as $k => $v) {
                    $spec .= '<div class="col-6"> <div class="form-group"> <label for="specification_'.$k.'">'.strtoupper($v).'</label> <input type="text" name="specification['.strtoupper(str_replace(" ", '_', trim($v))).']" class="form-control" id="specification_'.$k.'" placeholder="Enter '.strtoupper($v).'"> </div></div>';
                }
            }
        }
        
        echo $spec;
    }

    protected function certificate()
    {
        if (empty($_FILES['certificate']['name'])) {
            return ['error' => false, 'name' => 'NA'];
        }else{
            $config['upload_path']= "./assets/certificate/";
            $config['allowed_types']='pdf';

            $this->upload->initialize($config);
            $extn = explode(".", strtolower($_FILES['certificate']['name']));
            $_FILES['certificate']['name'] = time().'.'.end($extn);

            if (!$this->upload->do_upload("certificate")) {
                return ['error' => true, 'msg' => $this->upload->display_errors()];
            }else{
                return ['error' => false, 'name' => $this->upload->data('file_name')];
            }
        }
    }

    protected function sendMailSeller($id, $post, $unlink=null)
    {
        $this->load->model('contractModel', 'contract');
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetWatermarkImage(assets('images/letterhead.png'), 1, 'P');
        $mpdf->showWatermarkImage = true;
        $curl_handle = curl_init();
        curl_setopt($curl_handle,CURLOPT_URL, assets('dist/css/print.css'));
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        $stylesheet = curl_exec($curl_handle);        
        curl_close($curl_handle);
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $data['data'] = $this->contract->getContract($id);
        
        $mpdf->WriteHTML($this->load->view($this->redirect.'/seller_invoice', $data, true), \Mpdf\HTMLParserMode::HTML_BODY);
        $filename = json_decode($post['invoice'])->seller;
        /*$mpdf->Output();
        re();*/
        $mpdf->Output('./assets/invoices/'.$filename, "F");

        if ($unlink && file_exists($unlink)) unlink($unlink);
        
        if (ENVIRONMENT === 'production') 
        {
            /*email send*/
            $this->load->library('email');
            $message = '';
            
            $seller = $this->main->check('company', ['id' => $post['seller']], 'contact_email');

            $this->email->clear(TRUE);
            $this->email->set_newline("\r\n");
            $this->email->from('advanceagribrokers@gmail.com');
            $this->email->to($seller);
            $this->email->subject('Contract created successfully.');
            $this->email->message($message);
            
            $this->email->attach($_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"])."assets/invoices/".$filename);
            $this->email->send();
            /*email send end*/
        }
    }

    protected function sendMailBuyer($id, $post, $unlink=null)
    {
        $this->load->model('contractModel', 'contract');
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetWatermarkImage(assets('images/letterhead.png'), 1, 'P');
        $mpdf->showWatermarkImage = true;

        $curl_handle = curl_init();
        curl_setopt($curl_handle,CURLOPT_URL, assets('dist/css/print.css'));
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        $stylesheet = curl_exec($curl_handle);        
        curl_close($curl_handle);
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
        $data['data'] = $this->contract->getContract($id);
        $mpdf->WriteHTML($this->load->view($this->redirect.'/buyer_invoice', $data, true), \Mpdf\HTMLParserMode::HTML_BODY);
        $filename = json_decode($post['invoice'])->buyer;
        
        /*$mpdf->Output();
        re();*/
        $mpdf->Output('./assets/invoices/'.$filename, "F");

        if ($unlink && file_exists($unlink)) unlink($unlink);
        
        if (ENVIRONMENT === 'production') 
        {
            /*email send*/
            $this->load->library('email');
            $message = '';
            
            $buyer  = $this->main->check('company', ['id' => $post['buyer']], 'contact_email');

            $this->email->clear(TRUE);
            $this->email->set_newline("\r\n");
            $this->email->from('advanceagribrokers@gmail.com');
            $this->email->to($buyer);
            $this->email->subject('Contract created successfully.');
            $this->email->message($message);
            
            $this->email->attach($_SERVER['DOCUMENT_ROOT'] . str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"])."assets/invoices/".$filename);
            $this->email->send();
            /*email send end*/
        }
    }
}