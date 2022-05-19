<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    private $name = 'dashboard';
    private $table = "admins";
    private $redirect = "dashboard";

    protected $validate = [
        [
            'field' => 'name',
            'label' => 'Profile Name',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
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
        [
            'field' => 'email',
            'label' => 'Email',
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
		$data['title'] = $this->name;
        $data['chart'] = TRUE;
        $this->load->library('calendar');
        $this->load->model('contractModel', 'contract');
        for ($i=1; $i < 13; $i++) { 
            $d = $this->calendar->get_total_days($i, date('Y'));
            $mo = (strlen($i) < 2) ? '0'.$i : $i;
            $m = $this->calendar->get_month_name($mo);

            $data['chart_data'][$m] = $this->contract->getChart($mo, $d);
        }
        $data['chart_data'] = (object) $data['chart_data'];
        
        $this->template->load('template', 'home', $data);
	}

	public function profile()
	{
		$data['name'] = $this->name;
		$data['title'] = "profile";
		$this->form_validation->set_rules($this->validate);
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->template->load('template', 'profile', $data);
        }
        else
        {
        	$post = [
        		'name'        => $this->input->post('name'),
        		'mobile'      => $this->input->post('mobile'),
        		'email'       => $this->input->post('email'),
        		'last_update' => date('Y-m-d H:i:s')
        	];
        	
        	$id = $this->main->update(['id' => $this->id], $post, $this->table);
        	
        	if ($id) {
        		$check = $this->main->get($this->table, 'id adminId, name, mobile, email', ['id' => $this->id]);
        		$this->session->set_userdata($check);
        	}

			flashMsg($id, "Profile Updated Successfully.", "Profile Not Updated. Try again.", 'profile');
        }
	}

    public function brokerage()
    {
        $data['name'] = $this->name;
        $data['title'] = "profile";
        $this->form_validation->set_rules('brokerage', 'Brokerage', 'required|max_length[5]|decimal', ['required' => "%s is Required", 'max_length' => "%s is Invalid", 'decimal' => "%s is Invalid"]);
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->template->load('template', 'profile', $data);
        }
        else
        {
            $post = [
                'brokerage' => $this->input->post('brokerage')
            ];
            
            $id = $this->main->update(['id' => 1], $post, "brokerage");
            
            if ($id) {
                $check = $this->main->get($this->table, 'id adminId, name, mobile, email', ['id' => $this->id]);
                $this->session->set_userdata($check);
            }

            flashMsg($id, "Brokerage Updated Successfully.", "Brokerage Not Updated. Try again.", 'profile');
        }
    }

	public function logout()
	{
		$this->session->sess_destroy();
		return redirect('login');
	}

    public function greetings()
    {
        $data['name'] = $this->name;
        $data['title'] = "greetings";
        $this->form_validation->set_rules('greetings', 'Greetings', 'required', ['required' => "%s is Required"]);
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->template->load('template', 'profile', $data);
        }
        else
        {
            $users = $this->main->getall('company', 'contact_no', ['is_deleted' => 0]);
            
            foreach ($users as $k => $v)
                $send[$k] = $v['contact_no'];
            // send_sms($this->input->post('greetings'), implode(',', $send));

            flashMsg(TRUE, "Greetings Send Successfully.", "", 'greetings');
        }
    }
}
