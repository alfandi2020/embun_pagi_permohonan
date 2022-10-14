<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('M_Permohonan'));
    }

    public function index()
    {
        $add = $this->input->post('adduser');
        if ($add == 'add') {
            $insert= [
                "nama" => $this->input->post('nama'),
                "username" => $this->input->post('username'),
                "password" => $this->input->post('password'),
                "level" => $this->input->post('level'),
                "role" => 1,
                "role" => 1,
                "status_sekolah" => $this->input->post('status_sekolah'),
                "status" => 'Aktif',
            ];
            $this->db->insert('users',$insert);
            redirect('user');
        }
        $data = [
            'title' => "List User",
            'titlePage' => 'List User',
            'data' => $this->db->get('users')->result()
        ];

		$this->load->view('body/header', $data);
		$this->load->view('body/user',$data);
		$this->load->view('body/footer');
    }
    function status($id)
    {

        $val = $this->input->post('status');
        $this->db->set('status',$val == null ? 'NonAktif' : 'Aktif');
        $this->db->where('id',$id);
        $cek=$this->db->update('users');
        if ($cek == true) {
            # code...
        redirect('user');
        }
    }
    function edit($id)
    {
        $this->db->where('id',$id);
        $get_user = $this->db->get('users')->row_array();
        $data = [
            'title' => "List User",
            'titlePage' => 'List User',
            'data' => $get_user
        ];

		$this->load->view('body/header', $data);
		$this->load->view('body/user',$data);
		$this->load->view('body/footer');
    }
}