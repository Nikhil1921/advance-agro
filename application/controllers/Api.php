<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        $this->load->model('ApiModel', 'api');
        // mobile();
    }

    private $table = 'admins';

    public function send_otp()
    {
        post();
        verifyRequiredParams(['mobile']);
        
        $post = ['mobile' => $this->input->post('mobile')];
        $check = $this->main->get($this->table, 'id', $post);
        if ($check) {
            $this->load->helper('string');
            $otp['otp'] = ($_SERVER['HTTP_HOST'] == 'localhost') ? 123456 : random_string('numeric', 6);
            // $otp['otp'] = 123456;
            $otp['last_update'] = date('Y-m-d H:i:s');
            
            $row = $this->main->update($check, $otp, $this->table);
        }else{
            $row = 0;
        }

        if($row)
        {
            $sms = "Advance Agri Brokers Admin Login OTP is ".$otp['otp'];
            send_sms($post['mobile'], $sms);

            $response['error'] = FALSE;
            $response['message'] ="OTP Send Successfully.";
            echoRespnse(200, $response);
        }
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "OTP Not Send. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function check_otp()
    {
        post();
        verifyRequiredParams(['mobile', 'otp']);
        
        $post = [
                'mobile'         => $this->input->post('mobile'),
                'otp'            => $this->input->post('otp'),
                'last_update >=' => date('Y-m-d H:i:s', strtotime('-5 minute'))
            ];
        
        if($row = $this->main->get($this->table, 'id adminId, name, mobile, email', $post))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Login Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Login Not Successful. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function addressList()
    {
        get();
        $api = authenticate($this->table);
        
        if($row = $this->main->getall('address', 'id, address', ['is_deleted' => 0]))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Address List Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Address List Not Successful.";
            echoRespnse(400, $response);
        }
    }

    public function addAddress()
    {
        post();
        verifyRequiredParams(['address']);
        $api = authenticate($this->table);

        $post = [
                'address'     => $this->input->post('address'),
                'created_at'  => date('Y-m-d H:i:s'),
                'last_update' => date('Y-m-d H:i:s')
            ];
        
        if($this->main->add($post, 'address'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Address Added Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Address Not Added. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function updateAddress()
    {
        post();
        verifyRequiredParams(['id', 'address']);
        $api = authenticate($this->table);

        $post = [
                'address'     => $this->input->post('address'),
                'last_update' => date('Y-m-d H:i:s')
            ];
        
        if($this->main->update(['id' => $this->input->post('id')], $post, 'address'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Address Updated Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Address Not Updated. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function deleteAddress()
    {
        post();
        verifyRequiredParams(['id']);
        $api = authenticate($this->table);

        $post = [
                'is_deleted' => 1,
                'last_update' => date('Y-m-d H:i:s')
            ];
        
        if($this->main->update(['id' => $this->input->post('id')], $post, 'address'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Address Deleted Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Address Not Deleted. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function paymentList()
    {
        get();
        $api = authenticate($this->table);
        
        if($row = $this->main->getall('payment', 'id, payment', ['is_deleted' => 0]))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Payment List Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Payment List Not Successful.";
            echoRespnse(400, $response);
        }
    }

    public function addPayment()
    {
        post();
        verifyRequiredParams(['payment']);
        $api = authenticate($this->table);

        $post = [
                'payment'     => $this->input->post('payment'),
                'created_at'  => date('Y-m-d H:i:s'),
                'last_update' => date('Y-m-d H:i:s')
            ];
        
        if($this->main->add($post, 'payment'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Payment Added Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Payment Not Added. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function updatePayment()
    {
        post();
        verifyRequiredParams(['id', 'payment']);
        $api = authenticate($this->table);

        $post = [
                'payment'     => $this->input->post('payment'),
                'last_update' => date('Y-m-d H:i:s')
            ];
        
        if($this->main->update(['id' => $this->input->post('id')], $post, 'payment'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Payment Updated Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Payment Not Updated. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function deletePayment()
    {
        post();
        verifyRequiredParams(['id']);
        $api = authenticate($this->table);

        $post = [
                'is_deleted' => 1,
                'last_update' => date('Y-m-d H:i:s')
            ];
        
        if($this->main->update(['id' => $this->input->post('id')], $post, 'payment'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Payment Deleted Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Payment Not Deleted. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function packingList()
    {
        get();
        $api = authenticate($this->table);
        
        if($row = $this->main->getall('packing', 'id, packing', ['is_deleted' => 0]))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Packing List Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Packing List Not Successful.";
            echoRespnse(400, $response);
        }
    }

    public function addPacking()
    {
        post();
        verifyRequiredParams(['packing']);
        $api = authenticate($this->table);

        $post = [
                'packing'     => $this->input->post('packing')
            ];
        
        if($this->main->add($post, 'packing'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Packing Added Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Packing Not Added. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function updatePacking()
    {
        post();
        verifyRequiredParams(['id', 'packing']);
        $api = authenticate($this->table);

        $post = [
                'packing'     => $this->input->post('packing')
            ];
        
        if($this->main->update(['id' => $this->input->post('id')], $post, 'packing'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Packing Updated Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Packing Not Updated. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function deletePacking()
    {
        post();
        verifyRequiredParams(['id']);
        $api = authenticate($this->table);

        $post = [
                'is_deleted' => 1
            ];
        
        if($this->main->update(['id' => $this->input->post('id')], $post, 'packing'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Packing Deleted Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Packing Not Deleted. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function companyList()
    {
        get();
        $api = authenticate($this->table);
        
        if($row = $this->main->getall('company', 'id, company_name, contact_person, address, city, gst_no, pan_no, contact_no, contact_email', ['is_deleted' => 0]))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Company List Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Company List Not Successful.";
            echoRespnse(400, $response);
        }
    }

    public function addCompany()
    {
        post();
        verifyRequiredParams(['company_name', 'contact_person', 'address', 'city', 'contact_no', 'contact_email']);
        $api = authenticate($this->table);

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
        
        if($this->main->add($post, 'company'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Company Added Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Company Not Added. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function updateCompany()
    {
        post();
        verifyRequiredParams(['id', 'company_name', 'contact_person', 'address', 'city', 'contact_no', 'contact_email']);
        $api = authenticate($this->table);

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
        
        if($this->main->update(['id' => $this->input->post('id')], $post, 'company'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Company Updated Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Company Not Updated. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function deleteCompany()
    {
        post();
        verifyRequiredParams(['id']);
        $api = authenticate($this->table);

        $post = [
                'is_deleted' => 1,
                'last_update' => date('Y-m-d H:i:s')
            ];
        
        if($this->main->update(['id' => $this->input->post('id')], $post, 'company'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Company Deleted Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Company Not Deleted. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function productList()
    {
        get();
        $api = authenticate($this->table);
        
        if($row = $this->main->getall('product', 'id, name, specification', ['is_deleted' => 0]))
        {
            foreach ($row as $k => $v) {
                foreach (json_decode($v['specification']) as $ke => $va) 
                {
                    $spec[$ke]['spec'] = $va;
                }
                $row[$k]['specification'] = $spec;
            }

            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Company List Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Company List Not Successful.";
            echoRespnse(400, $response);
        }
    }

    public function addProduct()
    {
        post();
        verifyRequiredParams(['name', 'specification']);
        $api = authenticate($this->table);

        $post = [
                'name' => $this->input->post('name'),
                'specification' => $this->input->post('specification'),
                'created_by'    => $api,
                'updated_by'    => $api,
                'created_at'    => date('Y-m-d H:i:s'),
                'last_update'   => date('Y-m-d H:i:s')
            ];
        
        if($this->main->add($post, 'product'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Product Added Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Product Not Added. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function updateProduct()
    {
        post();
        verifyRequiredParams(['id', 'name', 'specification']);
        $api = authenticate($this->table);

        $post = [
                'name' => $this->input->post('name'),
                'specification' => $this->input->post('specification'),
                'updated_by'    => $api,
                'last_update'   => date('Y-m-d H:i:s')
            ];
        
        if($this->main->update(['id' => $this->input->post('id')], $post, 'product'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Product Updated Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Product Not Updated. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function deleteProduct()
    {
        post();
        verifyRequiredParams(['id']);
        $api = authenticate($this->table);

        $post = [
                'is_deleted' => 1,
                'updated_by'    => $api,
                'last_update'   => date('Y-m-d H:i:s')
            ];
        
        if($this->main->update(['id' => $this->input->post('id')], $post, 'product'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Product Deleted Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Product Not Deleted. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function updateProfile()
    {
        post();
        verifyRequiredParams(['name', 'mobile', 'email']);
        $api = authenticate($this->table);

        $post = [
                'name'        => $this->input->post('name'),
                'mobile'      => $this->input->post('mobile'),
                'email'       => $this->input->post('email'),
                'last_update' => date('Y-m-d H:i:s')
            ];
        
        if($this->main->update(['id' => $api], $post, $this->table))
        {
            $response['error'] = FALSE;
            $response['message'] ="Profile Updated Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Profile Not Updated. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function sendGreets()
    {
        post();
        verifyRequiredParams(['greets']);
        $api = authenticate($this->table);
        
        if($users = $this->main->getall('company', 'contact_no', ['is_deleted' => 0]))
        {
            foreach ($users as $k => $v)
            $send[$k] = $v['contact_no'];
            // send_sms($this->input->post('greets'), implode(',', $send));

            $response['error'] = FALSE;
            $response['message'] ="Greetings Send Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Greetings Not Send. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function getSpecs()
    {
        get();
        verifyRequiredParams(['prod_id']);
        $api = authenticate($this->table);
        $contract_id = $this->input->get('contract_id');
        $prod_id = $this->input->get('prod_id');
        
        if (!empty($contract_id)) 
            $contract = $this->main->get("contract", 'product, specification', ['id' => $contract_id]);
        else
            $contract = 0;
        

        if ($contract && $prod_id == $contract['product']) {
            $i = 0;
            foreach (json_decode($contract['specification']) as $k => $v) {
                $row[$i]['spec'] = $k;
                $row[$i]['value'] = $v;
                $i++;
            }
        }else{
            $specs = $this->main->get('product', 'specification', ['id' => $prod_id]);
            if ($specs) {
                foreach (json_decode($specs['specification']) as $k => $v) {
                    $row[$k]['spec'] = $v;
                    $row[$k]['value'] = '';
                }
            }else
                $row = [];
        }

        if($row)
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Specification List Successful.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Specification List Not Successful. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function contractList()
    {
        get();
        $api = authenticate($this->table);
        $where = ['c.is_deleted' => 0];

        if ($this->input->get('status'))
            $where['c.status'] = $this->input->get('status');
        if ($this->input->get('buyer_id'))
            $where['c.buyer'] = $this->input->get('buyer_id');
        if ($this->input->get('seller_id'))
            $where['c.seller'] = $this->input->get('seller_id');
        if ($this->input->get('prod_id'))
            $where['c.product'] = $this->input->get('prod_id');

        if($row = $this->api->contractList($where))
        {
            $response['row'] = $row;
            $response['error'] = FALSE;
            $response['message'] ="Contract List Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Contract List Not Successful.";
            echoRespnse(400, $response);
        }
    }

    public function addContract()
    {
        post();
        $api = authenticate($this->table);
        verifyRequiredParams(['other_term', 'prod_id', 'quantity', 'quantity_type', 'buyer_id', 'seller_id', 'price', 'brokerage', 'packing_id', 'address_id', 'conditions', 'payment', 'contract_date', 'specification']);

        $post = [
            'product' => $this->input->post('prod_id'),
            'specification' => $this->input->post('specification'),
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
            'other_terms' => $this->input->post('other_term'),
            'created_by' => $api,
            'created_at'  => date('Y-m-d H:i:s'),
            'update_by' => $api,
            'contract_date' => date("Y-m-d", strtotime($this->input->post('contract_date'))),
            'last_update' => date('Y-m-d H:i:s')
        ];

        if($id = $this->main->add($post, 'contract'))
        {
            $buy = $this->main->get('company', 'contact_no, company_name', ['id' => $post['buyer']]);
            $sell = $this->main->get('company', 'contact_no, company_name', ['id' => $post['seller']]);
            
            $this->main->update(['id' => $id], ['contact_id' => date('Y', strtotime($post['contract_date'])).$id], 'contract');
            $this->sendMailBuyer($id, $post);
            $this->sendMailSeller($id, $post);
            
            $sms = "Your contract No. - ".date('Y', strtotime($post['contract_date'])).$id.".\nBuyer Name - ".$buy['company_name']."\nSeller Name - ".$sell['company_name']."\nRate - ".$post['price']."\nWeight - ".$post['quantity'].' - '.$post['quantity_type']."\nLoading Condition - ".$post['conditions']."\nPayment Condition - ".$this->main->check('payment', ['id' => $post['payment']], 'payment')."\nCheck your Email for contract.\n- Advance Agri Brokers, Unjha.";

            // send_sms($sms, $buy['contact_no'].','.$sell['contact_no']);

            $response['row'] = $id;
            $response['error'] = FALSE;
            $response['message'] ="Contract Added Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Contract Not Added. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function updateContract()
    {
        post();
        $api = authenticate($this->table);
        verifyRequiredParams(['id', 'other_term', 'prod_id', 'quantity', 'quantity_type', 'buyer_id', 'seller_id', 'price', 'brokerage', 'packing_id', 'address_id', 'conditions', 'payment', 'specification']);

        $post = [
            'product' => $this->input->post('prod_id'),
            'specification' => $this->input->post('specification'),
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
            'other_terms' => $this->input->post('other_term'),
            'update_by' => $api,
            'last_update' => date('Y-m-d H:i:s')
        ];

        $invoice = json_decode($this->main->check('contract', ['id' => $this->input->post('id')], 'invoice'));

        if($this->main->update(['id' => $this->input->post('id')], $post, 'contract'))
        {
            $this->sendMailBuyer($this->input->post('id'), $post, './assets/invoices/'.$invoice->buyer);
            $this->sendMailSeller($this->input->post('id'), $post, './assets/invoices/'.$invoice->seller);

            $response['error'] = FALSE;
            $response['message'] ="Contract Updated Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Contract Not Updated. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function deleteContract()
    {
        post();
        verifyRequiredParams(['id']);
        $api = authenticate($this->table);

        $post = [
                'is_deleted' => 1,
                'update_by' => $api,
                'last_update' => date('Y-m-d H:i:s')
            ];
        
        if($this->main->update(['id' => $this->input->post('id')], $post, 'contract'))
        {
            $response['error'] = FALSE;
            $response['message'] ="Contract Deleted Successfully.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Contract Not Deleted. Try again!";
            echoRespnse(400, $response);
        }
    }

    public function uploadCertificate()
    {
        post();
        verifyRequiredParams(['id']);
        $api = authenticate($this->table);

        $cer = self::certificate();
        if ($cer['error']) {
            $id = 0;
        } else{
            $post = [
                    'certificate' => $cer['name'],
                    'status' => 'Completed',
                    'update_by' => $api,
                    'last_update' => date('Y-m-d H:i:s')
                ];
            
            $id = $this->main->update(['id' => $this->input->post('id')], $post, 'contract');
        }

        if($id)
        {
            $this->load->model('contractModel', 'contract');
            $this->contract->sendContractSms($this->input->post('id'));

            $response['error'] = FALSE;
            $response['message'] = "Purity Certificate Uploaded.";
            echoRespnse(200, $response);
        } 
        else 
        {
            $response["error"] = TRUE;
            $response['message'] = "Purity Certificate Upload Not Successful.";
            echoRespnse(400, $response);
        }
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
        
        $mpdf->WriteHTML($this->load->view('contract/seller_invoice', $data, true), \Mpdf\HTMLParserMode::HTML_BODY);
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
        $mpdf->WriteHTML($this->load->view('contract/buyer_invoice', $data, true), \Mpdf\HTMLParserMode::HTML_BODY);
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