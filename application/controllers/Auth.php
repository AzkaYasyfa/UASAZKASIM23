<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Auth extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
    }
    public function login(){
        $this->load->view('auth/login');
    }

    public function register(){
        $this->load->view('templates/header');
        $this->load->view('auth/register');
        $this->load->view('templates/footer');
    }
    public function process_register(){
        $this->form_validation->set_rules('username','username','required|is_unique[users.username]');
        $this->form_validation->set_rules('password','password','required|min_length[6]');
        $this->form_validation->set_rules('confirm_password','konfirmasi password','required|matches[password]');
        $this->form_validation->set_rules('role','role','required');

        if($this->form_validation->run() == FALSE){
            $this->load->view('templates/header');
            $this->load->view('auth/register');
            $this->load->view('templates/footer');
        }else{
            $data = [
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => $this->input->post('role')
            ];

            if($this->User_model->insert_user($data)){
                $this->session->set_flashdata('success','Pendaftaran Berhasil silahkan login');
                redirect('auth/login');
            }else{
                $this->session->set_flashdata('error','Pendaftaran gagal silahkan coba lagi');
                redirect('auth/register');
            }
        }
    }
    public function process_login(){
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        $user=$this->User_model->check_user($username,$password);
        if($user){
            $this->session->set_userdata([
                'id'=>$user->id,
                'username'=>$user->username,
                'role'=>$user->role,
                'logged_in'=> TRUE
            ]);
               $this->redirect_by_role($user->role) ;
            }else{
                $this->session->set_flashdata('error', 'username dan password salah');
                redirect('auth/login');
            }
        }
        private function redirect_by_role($role){
            switch($role){
                case 'admin':
                    redirect('dashboard');
                    break;
                case 'sales' :
                    redirect('dashboard');
                    break;
                case 'manager' :
                    redirect('dashboard');
                    break;
                default:
                redirect('auth/login');
            }
        }
        public function logout(){
            $this->session->sess_destroy();
            redirect('auth/login');
        }
    }
