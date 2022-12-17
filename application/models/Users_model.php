<?php

class Users_model extends CI_Model
{

    protected $table = 'users';

    public function insert($data)
    {

        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function select_all()
    {
        $this->db->order_by("id", "desc");
        $query = $this->db->get($this->table);

        return $query->result();
    }

    public function selectDataById($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);

        return $query->row();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

    public function active($id)
    {
        $this->db->set('status', '1');
        $this->db->where('id', $id);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    public function passive($id)
    {
        $this->db->set('status', '0
        ');
        $this->db->where('id', $id);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }
}