<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Model {
     
    public function add_product_to_cart()
    {
        $query = "INSERT INTO carts (created_at) VALUES (?)"; 
        $values = array(date("Y-m-d, H:i:s")); 
        $this->db->query($query, $values);
        return $this->db->insert_id();  
    }
    public function get_products_from_cart($cart_id)
    { 
        $query = "SELECT cart_items.product_id,products.product_name,products.price,
            SUM(cart_items.quantity) AS quantity, SUM(products.price * cart_items.quantity) as sub_total
            FROM products INNER JOIN cart_items ON products.id = cart_items.product_id 
            WHERE cart_items.cart_id = ? GROUP BY products.id ";

        $values = array($cart_id); 
        return $this->db->query($query,$values)->result_array();
    }

    public function get_total_amount_from_cart($cart_id)
    {
        $query = "SELECT SUM(products.price * cart_items.quantity) as grand_total  FROM products INNER JOIN cart_items ON products.id = cart_items.product_id GROUP BY cart_items.cart_id HAVING cart_items.cart_id = ?";
        $values = array($cart_id); 
        return $this->db->query($query,$values)->row_array();
    }

    public function add_product_to_cart_items($cart_info)
    {
        $query = "INSERT INTO cart_items (cart_id, product_id, quantity, created_at) VALUES (?,?,?,?)";
        $values = array($cart_info['cart_id'], $cart_info['product_id'], $cart_info['quantity'], date("Y-m-d, H:i:s"));  
        return $this->db->query($query, $values);
    }

    public function remove_item_in_cart($product_id)
    {
        $query = "DELETE FROM cart_items WHERE product_id = ?";
        $value = $product_id;
        return $this->db->query($query,$value);
    }

    public function get_product_count_from_cart($cart_id)
    { 
        $query = "SELECT SUM(cart_items.quantity) AS quantity  FROM products INNER JOIN cart_items ON products.id = cart_items.product_id WHERE cart_items.cart_id = ? ";
        $values = $cart_id; 
        return $this->db->query($query,$values)->result_array();
    }

    public function get_unique_products_in_cart($cart_id)
    { 
        $query = "SELECT COUNT( DISTINCT product_id) as product_count FROM cart_items WHERE cart_items.cart_id = ?;";
        $values = $cart_id; 
        return $this->db->query($query,$values)->row_array();
    }
}

?>
