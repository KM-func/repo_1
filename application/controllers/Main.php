<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller { 
	public function __construct()
	{
		CI_Controller::__construct();
		$this->load->model("product");
		$this->load->model("cart"); 
		$this->load->helper('security'); 
	}
	public function index()
	{
		$cart_id = $this->session->userdata("cart_id");

		$data['unique_products'] = $this->cart->get_unique_products_in_cart($cart_id);
		$data["products"] = $this->product->get_all_products();
		$data["csrf"] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->load->view('main/index.html.php', $data); 
	}
	
	
	public function add_to_cart(){

        $this->load->library("form_validation");  
		
		$user_data = $this->security->xss_clean($this->input->post());   
		
        $this->form_validation->set_rules('quantity', 'Product quantity', 'required');
        if ($this->form_validation->run() == FALSE)
		{
            $errors = validation_errors('<div class="error">', '</div>');
            $this->session->set_flashdata('error_list', $errors);
            redirect(base_url());
        }
		else
		{

            if($this->session->has_userdata("cart_id"))
			{
                $cart_id = $this->session->userdata("cart_id");
                
            }
			else
			{ 
                $cart_id = $this->cart->add_product_to_cart();
                $this->session->set_userdata("cart_id",$cart_id);
            }
     
            $cart_info = array(
                "quantity" => $user_data['quantity'],
                "product_id" => $user_data['product_id'],
                "cart_id" => $cart_id 
            ); 
           
            $add_product = $this->cart->add_product_to_cart_items($cart_info);
            $cart_items = $this->cart->get_products_from_cart($cart_id);
            foreach($cart_items as $cart_item_info){
                $total_in_cart = $cart_item_info["quantity"];
            }
            $this->session->set_userdata("cart_total",$total_in_cart);
            $this->session->set_flashdata('add_to_cart_success', '<div class="success">Product has been added to cart</div>');
    
            redirect(base_url());
        } 
    }

	public function cart()
	{ 
		$cart_id = $this->session->userdata("cart_id"); 
        $data["cart_items"] = $this->cart->get_products_from_cart($cart_id);
        $data["total"] = $this->cart->get_total_amount_from_cart($cart_id);
		$data["csrf"] = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->load->view('main/cart.html.php', $data); 
	}

	public function remove_item(){
		$user_data = $this->security->xss_clean($this->input->post()); 

		$this->cart->remove_item_in_cart($user_data['product_id']);
		
		$get_items_in_cart = $this->cart->get_product_count_from_cart($this->session->userdata("cart_id"));
		foreach($get_items_in_cart as $cart_item_info){
			$total_in_cart = $cart_item_info["quantity"];
		}
		$this->session->set_userdata("cart_total",$total_in_cart);
 
		$this->session->set_flashdata("remove_item",'<div class="success">Item has been remove from Cart</div>');
		redirect("main/cart");
	 }

	public function check_out()
	{
		// No time for sprite API just yet hahahah
		redirect("main/cart");
	}
}
