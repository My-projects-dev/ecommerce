<?php

class Images_model extends CI_Model
{

    protected $table = 'images';

    public function insert($data)
    {
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function select_all()
    {
        $query = $this->db->get($this->table);

        return $query->result();
    }

    public function selectDataByProductId($product_id)
    {
        $this->db->where('product_id', $product_id);
        $query = $this->db->get($this->table);

        return $query->result();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

    public function update2($id, $data, $productId)
    {
        $this->db->where('id', $id);
        $this->db->where('product_id', $productId);
        $this->db->update($this->table, $data);

        return $this->db->affected_rows();
    }

    public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete($this->table);

        return $this->db->affected_rows();
    }
}