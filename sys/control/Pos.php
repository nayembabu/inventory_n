<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos extends MY_Controller {


	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('pos_model','pos_model');
		$this->load->model('buy_model','buy');
		$this->load->helper('sms_template_helper');

	}

	public function is_sms_enabled(){
		return is_sms_enabled();
	}
	
	public function index()
	{
		$this->permission_check('pos');
		$data=$this->data;
		$data['page_title']='POS';
		$data['result'] = $this->get_hold_invoice_list();
		$data['tot_count'] = $this->get_hold_invoice_count();
		$this->load->view('pos',$data);
	}

	//adding new item from Modal
	public function newcustomer(){
	

		$last_id = $this->buy->save_new_customer(
			array(
				"customer_name" => $this->input->post('name'),
				"mobile" => $this->input->post('mobile'),
				"sales_due" => $this->input->post('due'),
				"opening_balance" => $this->input->post('due'),
				"address" => $this->input->post('address'),
				"system_ip" => $_SERVER['REMOTE_ADDR'],
				"system_name" => gethostbyaddr($_SERVER['REMOTE_ADDR']),
				"created_date" => date('Y-m-d'),
				"created_time" => time(),
				"customer_code" => time(),
				"status" => 1
			)
		);
		$res = $this->buy->get_customer_by_id($last_id);


		// $this->load->model('customers_model');
		// $result=$this->customers_model->verify_and_save();
		// //fetch latest item details
		// $res=array();
		// $query=$this->db->query("select id,customer_name from db_customers order by id desc limit 1");
		// $res['id']=$query->row()->id;
		// $res['customer_name']=$query->row()->customer_name;
		// $res['result']=$result;
		// echo json_encode($res);
		$this->output->set_content_type('application/json')->set_output(json_encode($res));
		
	}

	public function get_details(){
		
		echo $this->pos_model->get_details();
	}
	public function receive_order(){
	    echo $this->pos_model->receive_order();
	}
	public function pos_save_update(){
	    $result='';
	    if($this->input->post('command')=='update'){//Update
	    	$result = $this->pos_model->pos_save_update();
	    }
	    else{//Save
	    	$result = $this->pos_model->pos_save_update();
		    //$result =$result."<<<###>>>".$this->pos_model->get_details();
		    $result =$result."<<<###>>>".$this->pos_model->hold_invoice_list();
		    $q1=$this->db->query("SELECT * FROM db_hold");
			$data['tot_count']=$q1->num_rows();
		    $result =$result."<<<###>>>".$q1->num_rows();
	    }
	    
	    echo $result;exit();
	}
	public function edit($sales_id){
		$this->permission_check('sales_edit');
	    $data=$this->data;
	    $data['sales_id']=$sales_id;
	    $data['page_title']='POS Update';
	    $data['result'] = $this->get_hold_invoice_list();
		$data['tot_count'] = $this->get_hold_invoice_count();
		$data['customer_id'] = get_sales_details($sales_id)->customer_id;
		$this->load->view('pos',$data);
	}
	public function fetch_sales($sales_id){
	    $result=$this->pos_model->edit_pos($sales_id);
	}
	/* ######################################## HOLD INVOICE ############################# */
	public function hold_invoice(){
	    echo $this->pos_model->hold_list_save_update();
	}
	public function hold_invoice_list(){
		$data =array();
		$data['result'] = $this->get_hold_invoice_list();
		$data['tot_count'] = $this->get_hold_invoice_count();
		echo json_encode($data);
	}

	public function get_hold_invoice_list(){
		$data =array();
		$result= $this->pos_model->hold_invoice_list();
		return $result;
	}
	public function get_hold_invoice_count(){
		$q1=$this->db->query("SELECT * FROM db_hold");
		return $q1->num_rows();
	}

	public function hold_invoice_delete($invoice_id){
		$result=$this->pos_model->hold_invoice_delete($invoice_id);
		echo trim($result);
	}
	public function hold_invoice_edit(){
		echo $this->pos_model->hold_invoice_edit();
	}
	public function add_payment_row(){
		return $this->load->view('modals_pos_payment/modal_payments_multi_sub');
	}
	//Print sales POS invoice 
	public function print_invoice_pos($sales_id){
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_invoice');
		$data=array_merge($data,array('sales_id'=>$sales_id));
		$this->load->view('sal-invoice-pos',$data);
	}
	public function get_item_details(){
		echo $this->pos_model->get_item_details($this->input->post('item_id'));
	}
	public function print_qr($data='')
	{
		$this->load->model('Qrcode_model','qr');

		return $this->qr->qr_image($data);

		exit;

		$data  = trim($data);	

		//if the parameter value has slash
		$data = base64_decode(str_replace('-', '=', str_replace('_', '/', $data)));

		// quick and simple:
		//return '<img src="'.(new QRCode)->render($data).'" alt="QR Code" />';
		$options = new QROptions([
			
		]);

		return (!empty($data)) ? '<img src="'.(new QRCode($options))->render($data).'" alt="QR Code" />' : '';		
	}
}
