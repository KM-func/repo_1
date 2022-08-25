<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Model { 
    public function get_all_products()
    {
        return $this->db->query("SELECT * FROM products")->result_array();
    }
    public function get_product_by_id($product_id)
    {
        $query = "SELECT * FROM products WHERE id = ?";
        $values = array($product_id);
        return $this->db->query($query, $values)->row_array();
    }  
}

?>