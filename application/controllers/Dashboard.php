<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard
 extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
        $data = [
            'nama' => $this->session->userdata('nama'),
            'title' => "Selamat Datang di Dashboard Admin | Deigo Project",
            'titlePage' => 'Dashboard Admin Deigo Project'
        ];

		$this->load->view('body/header', $data);
		$this->load->view('body/content');
		$this->load->view('body/footer');
	}
    
   

    
}