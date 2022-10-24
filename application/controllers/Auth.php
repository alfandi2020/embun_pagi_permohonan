<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        $data = [
            'title' => "Selamat Datang di Dashboard Admin | Deigo Project",
            'titlePage' => 'Selamat Datang di Deigo Project Management'
        ];

        $this->form_validation->set_rules('username', 'Nama Pengguna', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if($this->form_validation->run() == false) {
            $this->load->view('auth/header', $data);
            $this->load->view('auth/index');
            $this->load->view('auth/footer');
        }else {
            $this->_login();
        }
    }

    private function _login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('users', ['username' => $username])->row_array();
        $cek_status = $this->db->get_where('users', ['username' => $username])->num_rows();
        
        //usernya ada
        if($cek_status == true) {
            if ($user['status'] == 'Aktif') {
                // cek password
                if(password_verify($password, $user['password'])) {
                    $data = [
                        'id_user' => $user['id'],
                        'nama' => $user['nama'],
                        'username' => $user['username'],
                        'role' => $user['role'],
                        'status_sekolah' => $user['status_sekolah'],
                        'level' => $user['level'],
                        'filterTahun' => date('Y')
                    ];

                    $this->session->set_userdata($data);
                    if ($user['level'] == 3) {
                        redirect('permohonan');
                    }else{
                        redirect('dashboard');
                    }
                }else{
                    $this->session->set_flashdata('msg','<div class="alert alert-danger">Password salah..!</div>');
                    redirect('auth');
                }
            }else{
                $this->session->set_flashdata('msg','<div class="alert alert-danger">username <b>'.$username.' </b> tidak aktif</div>');
                redirect('auth');
            }
        }else{
            $this->session->set_flashdata('msg','<div class="alert alert-danger">tidak ada dengan username <b>'.$username.' </b></div>');
            redirect('auth');
        }
    }

    function registrasi()
    {
        $this->load->view('auth/header');
        $this->load->view('auth/index');
        $this->load->view('auth/footer');
    }
    function action_regis()
    {
        if ($this->input->post('level') == '1') {
            $role = '1,2,3';
        }else if ($this->input->post('level') == '2') {
            $role = '1,2';
        }else{
            $role = '1';
        }
        $insert= [
            "nama" => $this->input->post('nama'),
            "username" => $this->input->post('username'),
            "password" => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
            "level" => $this->input->post('level'),
            "role" => $role,
            "status_sekolah" => implode(',',$this->input->post('status_sekolah')),
            "status" => 'NonAktif',
        ];
        $this->db->insert('users',$insert);
        redirect('user');
    }
    function update()
    {
        if ($this->input->post('level') == '1') {
            $role = '1,2,3';
        }else if ($this->input->post('level') == '2') {
            $role = '1,2';
        }else{
            $role = '1';
        }
        $insert= [
            "nama" => $this->input->post('nama'),
            "username" => $this->input->post('username'),
            "password" => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
            "level" => $this->input->post('level'),
            "role" => $role,
            "status_sekolah" => implode(',',$this->input->post('status_sekolah')),
        ];
        $this->db->where('id',$this->session->userdata('id_user'));
        $this->db->update('users',$insert);
        redirect('user');
    }
    public function logout() {
        $this->session->unset_userdata('id_users');
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('username');
        redirect('auth');
    }
}