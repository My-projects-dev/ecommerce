<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admins extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        is_logged();

        $this->load->model('Admins_model', 'admins_md');

    }

    public function index()
    {
        $data['title'] = 'Admins List';

        $data['lists'] = $this->admins_md->select_all();

        $this->load->admin('admins/index', $data);
    }

    public function create()
    {

        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('fullname', 'Ad ve soyad', 'required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[admins.email]');
            $this->form_validation->set_rules('password', 'Şifrə', 'required');

            if ($this->form_validation->run()) {

                $request_data = [
                    'fullname' => $this->security->xss_clean($this->input->post('fullname')),
                    'email' => $this->security->xss_clean($this->input->post('email')),
                    'password' => md5($this->input->post('password')),
                    'status' => $this->security->xss_clean($this->input->post('status'))
                ];

                $insert_id = $this->admins_md->insert($request_data);

                if ($insert_id > 0) {
                    $this->session->set_flashdata('success_message', 'Məlumat uğurla əlavə edildi');

                    redirect('backend/admins');
                }
            }
        }

        $data['title'] = 'Admins List';

        $this->load->admin('admins/create', $data);

    }

    public function edit($id)
    {

        if ($this->input->post()) {
            $id = $this->security->xss_clean($id);

            $this->load->library('form_validation');

            $this->form_validation->set_rules('fullname', 'Ad ve soyad', 'required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');


            if ($this->form_validation->run()) {

                $request_data = [
                    'fullname' => $this->security->xss_clean($this->input->post('fullname')),
                    'email' => $this->security->xss_clean($this->input->post('email')),
                    'status' => $this->security->xss_clean($this->input->post('status'))
                ];

                if (!empty($this->input->post('password'))) {
                    $request_data['password'] = md5($this->input->post('password'));
                }

                $another_id_has_mail = $this->admins_md->another_id_has_mail($id, $request_data['email']);

                if ($another_id_has_mail > 0) {

                    $this->session->set_flashdata('error_message', $request_data['email'].' mövcuddur');

                } else {

                    $affected_rows = $this->admins_md->update($id, $request_data);

                    if ($affected_rows > 0) {
                        $this->session->set_flashdata('success_message', 'Məlumat uğurla dəyişdirildi');

                        redirect('backend/admins/edit/' . $id);
                    }
                }
            }
        }

        $item = $this->admins_md->selectDataById($id);

        if (empty($item)) {
            $this->session->set_flashdata('error_message', 'Bu məlumat tapılmadı');

            redirect('backend/admins');
        }

        $data['item'] = $item;

        $data['title'] = 'Admins Edit';

        $this->load->admin('admins/edit', $data);

    }

    public function delete($id)
    {
        $id = $this->security->xss_clean($id);
        $item = $this->admins_md->delete($id);

        if ($item > 0) {
            $this->session->set_flashdata('success_message', 'Uğurlu şəkildə silindi');
        } else {
            $this->session->set_flashdata('error_message', 'Silinmə zamanı xəta baş verdi');
        }

        redirect('backend/admins');
    }
}
