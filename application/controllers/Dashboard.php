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
        

        $data = [
            'nama' => $this->session->userdata('nama'),
            'title' => "Selamat Datang di Dashboard Admin",
            'titlePage' => 'Dashboard Embun Pagi',
            'waiting' => $waiting,
            'approved' => $approved,
            'rejected' => $rejected,
            'done' => $done,
            'bulan1' => $this->db->query("SELECT SUM(b.nominal) as jan from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='01'")->row_array(),
            'bulan2' => $this->db->query("SELECT SUM(b.nominal) as feb from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='02'")->row_array(),
            'bulan3' => $this->db->query("SELECT SUM(b.nominal) as mar from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='03'")->row_array(),
            'bulan4' => $this->db->query("SELECT SUM(b.nominal) as apr from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='04'")->row_array(),
            'bulan5' => $this->db->query("SELECT SUM(b.nominal) as mei from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='05'")->row_array(),
            'bulan6' => $this->db->query("SELECT SUM(b.nominal) as jun from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='06'")->row_array(),
            'bulan7' => $this->db->query("SELECT SUM(b.nominal) as jul from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='07'")->row_array(),
            'bulan8' => $this->db->query("SELECT SUM(b.nominal) as agu from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='08'")->row_array(),
            'bulan9' => $this->db->query("SELECT SUM(b.nominal) as sep from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='09'")->row_array(),
            'bulan10' => $this->db->query("SELECT SUM(b.nominal) as okt from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='10'")->row_array(),
            'bulan11' => $this->db->query("SELECT SUM(b.nominal) as nov from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='11'")->row_array(),
            'bulan12' => $this->db->query("SELECT SUM(b.nominal) as des from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='12'")->row_array(),
        ];
        // $data['bulan'] = $this->db->query("SELECT SUM(b.nominal) as jan from tb_permohonan as a left JOIN tb_permohonan_detail as b on(a.unik=b.unik) WHERE a.status_permohonan='Done' AND DATE_FORMAT(a.tgl_permohonan,'%m')='09'")->row_array();

		$this->load->view('body/header', $data);
		$this->load->view('body/content');
		$this->load->view('body/footer',$data);
	}
    
   

    
}