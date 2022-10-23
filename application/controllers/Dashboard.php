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
        $level = $this->session->userdata('level');
        if($level == 3) {
           $cek_level =  $this->db->where('id_user', $this->session->userdata('id_user'));
        }
        $waiting = $this->db->get_where('tb_permohonan',['status_permohonan' => 'Waiting' ])->num_rows();
        if($level == 3) {
            $cek_level =  $this->db->where('id_user', $this->session->userdata('id_user'));
         }
        $approved = $this->db->get_where('tb_permohonan',['status_permohonan' => 'Approved'])->num_rows();
        if($level == 3) {
            $cek_level =  $this->db->where('id_user', $this->session->userdata('id_user'));
         }
        $rejected = $this->db->get_where('tb_permohonan',['status_permohonan' => 'Rejected'])->num_rows();
        if($level == 3) {
            $cek_level =  $this->db->where('id_user', $this->session->userdata('id_user'));
         }
        $done = $this->db->get_where('tb_permohonan',['status_permohonan' => 'Done'])->num_rows();
        $this->db->group_by('a.unik');
        $this->db->join('tb_permohonan as a','a.unik=b.unik');
        $statistik = $this->db->get('tb_permohonan_detail as b');
        $data = [
            'nama' => $this->session->userdata('nama'),
            'title' => "Selamat Datang di Dashboard Admin",
            'titlePage' => 'Dashboard Embun Pagi',
            'waiting' => $waiting,
            'approved' => $approved,
            'rejected' => $rejected,
            'done' => $done,
        ];

		$this->load->view('body/header', $data);
		$this->load->view('body/content');
		$this->load->view('body/footer');
	}
    
   

    
}