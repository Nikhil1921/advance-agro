<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ((!empty($this->session->adminId)))
            return redirect('');
        $this->load->helper('string');
    }

    protected $table = "admins";
    protected $login = [
        [
            'field' => 'mobile',
            'label' => 'Mobile No.',
            'rules' => 'required|numeric|exact_length[10]',
            'errors' => [
                'required' => "%s is Required",
                'numeric' => "%s is Invalid",
                'exact_length' => "%s is Invalid",
            ],
        ],
    ];

    protected $otp = [
        [
            'field' => 'otp',
            'label' => 'OTP',
            'rules' => 'required|numeric|exact_length[6]',
            'errors' => [
                'required' => "%s is Required",
                'numeric' => "%s is Invalid",
                'exact_length' => "%s is Invalid",
            ],
        ],
    ];

	public function index()
	{
		$data['name'] = "login";
        $data['title'] = "login";
        $this->form_validation->set_rules($this->login);
        if ($this->form_validation->run() == FALSE)
        {
            return $this->template->load('auth/template', 'auth/login', $data);
        }
        else
        {
            $post = ['mobile' => $this->input->post('mobile')];
            $check = $this->main->get($this->table, 'id', $post);
            
            if ($check) {
                $otp['otp'] = ($_SERVER['HTTP_HOST'] == 'localhost') ? 123456 : random_string('numeric', 6);
                // $otp['otp'] = 123456;
                $otp['last_update'] = date('Y-m-d H:i:s');
                
                $id = $this->main->update($check, $otp, $this->table);
                $this->session->set_flashdata('mobileCheck', $post['mobile']);
                $sms = "Advance Agri Brokers Admin Login OTP is ".$otp['otp'];
                
                if ($id) send_sms($post['mobile'], $sms);

                flashMsg($id, "OTP Send Successfully.", "OTP Not Send. Try again.", "otp");
            }else{
               flashMsg($check, "", "Mobile not registered. Try again.", "login");
           }
        }
	}

    public function otp()
    {
        if (!$this->session->mobileCheck) return redirect('login');
        $this->session->set_flashdata('mobileCheck', $this->session->mobileCheck);
        $data['name'] = "check otp";
        $data['title'] = "check otp";
        $this->form_validation->set_rules($this->otp);
        if ($this->form_validation->run() == FALSE)
        {
            return $this->template->load('auth/template', 'auth/otp', $data);
        }
        else
        {
            $post = [
                'otp'            => $this->input->post('otp'),
                'mobile'         => $this->session->mobileCheck,
                'last_update >=' => date('Y-m-d H:i:s', strtotime('-5 minute'))
            ];

            $check = $this->main->get($this->table, 'id adminId, name, mobile, email', $post);

            if ($check) {
                $this->session->set_userdata($check);
                flashMsg($check, "Welcome ".ucwords($check['name']), "", "");
            }else{
               flashMsg($check, "", "Invalid OTP. Try again.", "otp");
           }
        }
    }
}
