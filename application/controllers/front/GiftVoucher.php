<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GiftVoucher extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Admins_model', 'admins_md');

    }

    public function index()
    {
        $data['title'] = 'Gift voucher';

        $data['lists'] = $this->admins_md->select_all();

        $this->load->front('include/myaccount/gift_voucher', $data);
    }
}
