<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->library('user_agent');
		$this->load->model('purchase_model','purchase');
		$this->load->model('buy_model','buy');
	}

	public function index()
	{ 
		$this->permission_check('purchase_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('purchase_list');
		$this->load->view('purchase-list',$data);
	}

	public function get_products_by_id()
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($this->buy->get_this_product_info_by_id($this->input->post('product_id'))));
	}
 
	public function buying_this_products_fun()
	{

// supplier_id --
// pur_date --
// lots_nos --
// pur_status
// product_select --
// buying_system --

// ttl_item_this_trns 
// ttl_item_kg_this_trns 

// transport_id  
// cost_of_transport 
// trns_com_per_bosta 
// ttl_trns_com 
// prodct_sell_road 
// trns_com_cutting 
// ttl_com_for_trns 
// ghar_kuli_per_bosta 
// cost_of_ghar_kuli 
// driver_advance 
// others_cost 

// total_trns_price --
// discount --
// paid_amount ---
// unpaid_amount_tk --
// koifiyat_amount_tk --
// kofiyat_desc --

		if (empty($this->input->post('lots_nos')) || empty($this->input->post('supplier_id'))) {
			echo 1;
		}else {

			$last_purchase_transports_id = $this->buy->insert_purchase_this_transports_info(
				array(
					'transport_i_a_iiiiidd' 					=> $this->input->post('transport_id'), 
					'products_items_at_ididii' 					=> $this->input->post('product_select'), 
					'lot_trns_ref_nop_s' 						=> $this->input->post('lots_nos'), 
					'sup_id_ass_iddd' 							=> $this->input->post('supplier_id'), 
					'pur_date_timsssss' 						=> date('Y-m-d', strtotime($this->input->post('pur_date'))), 
					'pur_status_buy_change' 					=> $this->input->post('buying_system'), 
					'ttl_items_bosta_this_trans' 				=> $this->input->post('ttl_item_this_trns'), 
					'ttl_due_bosta_this_trans' 					=> $this->input->post('ttl_item_this_trns'), 
					'ttl_item_kg_trans' 						=> $this->input->post('ttl_item_kg_this_trns'), 
					'ttl_trans_other_cost' 						=> $this->input->post('cost_of_transport'), 
					'trans_com_per_bosta' 						=> $this->input->post('trns_com_per_bosta'), 
					'ttl_trans_com' 							=> $this->input->post('ttl_trns_com'), 
					'prodct_sell_bosta_in_road' 				=> $this->input->post('prodct_sell_road'), 
					'trans_com_cutting_amnt' 					=> $this->input->post('trns_com_cutting'), 
					'ttl_com_amnt_for_trans' 					=> $this->input->post('ttl_com_for_trns'), 
					'ghar_kuli_rates_per_bosta' 				=> $this->input->post('ghar_kuli_per_bosta'), 
					'ttal_ghar_kuli_cost_amnt' 					=> $this->input->post('ttl_item_this_trns')*$this->input->post('ghar_kuli_per_bosta'), 
					'ghar_kuli_cost_amnt_for_trans_with_cut'	=> $this->input->post('cost_of_ghar_kuli'), 
					'driver_advance_amnt_cost' 					=> $this->input->post('driver_advance'), 
					'others_cost_amnt_for_trans' 				=> $this->input->post('others_cost'), 
					'total_trans_price' 						=> $this->input->post('total_trns_price'), 
					'ttal_discount_amnt_trans' 					=> $this->input->post('discount'), 
					'supp_paid_amnt_s' 							=> $this->input->post('paid_amount'), 
					'unpaid_amount_this_trans_tk' 				=> $this->input->post('unpaid_amount_tk'), 
					'koifiyat_amount_tk_for_this_trans' 		=> $this->input->post('koifiyat_amount_tk'), 
					'kofiyat_desc_for_this_trans' 				=> $this->input->post('kofiyat_desc'), 
					'now_timess' 								=> time(), 
					'now_date_formate' 							=> date('Y-m-d'), 
				)
			);

			$last_purchase_id = $this->buy->insert_supplier_due_payment_amt(
				array(
					'ttl_pruchase_dates_times' 			=> date('Y-m-d', strtotime($this->input->post('pur_date'))),
					'purchase_transport_infos_iddis' 	=> $last_purchase_transports_id,
					'purchase_ttl_amnt_paidable' 		=> $this->input->post('total_trns_price'),
					'ttl_purchase_discount_ss' 			=> $this->input->post('discount'),
					'ttl_supp_koifiyat_ss' 				=> $this->input->post('koifiyat_amount_tk'),
					'ttl_due_nowsss_purchasess' 		=> $this->input->post('unpaid_amount_tk'),
					'cr_times_entry' 					=> time(),
					'cr_dates_entryss' 					=> date('Y-m-d'),
				)
			); 

			$last_purchase_id = $this->buy->insert_tbl_purchase_datas(
				array(
					'items_uniq_int_id' 			=> $this->input->post('product_select'),
					'pur_trans_info_auto_iddid'		=> $last_purchase_transports_id,
					'ttl_buy_purchases_bosta'		=> $this->input->post('ttl_item_this_trns'),
					'due_of_this_trans_purchase'	=> $this->input->post('ttl_item_this_trns'),
					'purchase_code' 				=> time(),
					'reference_no' 					=> $this->input->post('lots_nos'), 
					'grand_total' 					=> $this->input->post('total_trns_price'), 
					'paid_amount' 					=> $this->input->post('purchase_payment'), 
					'purchase_date' 				=> date('Y-m-d', strtotime($this->input->post('pur_date'))),
					'purchase_status' 				=> $this->input->post('pur_status'),
					'buying_type_status' 			=> $this->input->post('buying_system'),
					'supplier_id' 					=> $this->input->post('supplier_id'),
					'created_date' 					=> date('Y-m-d'),
					'created_time' 					=> time(),
					'system_ip' 					=> $_SERVER['REMOTE_ADDR'],
					'system_name' 					=> gethostbyaddr($_SERVER['REMOTE_ADDR']),
					'status' 						=> 1,
				)
			); 

			$this_items_desc_this_lot	= array($this->input->post('items_desc')); 
			$lots_qnty_this_lot			= array($this->input->post('this_lot_qnty')); 
			$kg_per_bosta_this_lot		= array($this->input->post('kg_qnty_per_bosta'));
			$price_per_kg_this_lot		= array($this->input->post('price_per_kg'));
			$ttl_buying_price_this_lot	= array($this->input->post('total_buy_price'));
			$data = [];
			foreach ($lots_qnty_this_lot as $key => $value) {
				foreach ($value as $key1 => $value1) {
					$data[] = [
						'purchase_id' 						=> $last_purchase_id,
						'purchase_trans_info_auto_pr_iddds' => $last_purchase_transports_id,
						'purchase_status'					=> $this->input->post('pur_status'),
						'pur_buying_types_statu'			=> $this->input->post('pur_status'),
						'item_id' 							=> $this->input->post('product_select'),
						'supplyer_id_a_pr' 					=> $this->input->post('supplier_id'),
						'ref_lot_no'						=> $this_items_desc_this_lot[$key][$key1],
						'purchase_item_dates'				=> date('Y-m-d', strtotime($this->input->post('pur_date'))),
						'purchase_qty' 						=> $lots_qnty_this_lot[$key][$key1],
						'price_per_unit' 					=> $price_per_kg_this_lot[$key][$key1],
						'purchase_total_bosta' 				=> $lots_qnty_this_lot[$key][$key1],
						'due_sells_bosta_ss' 				=> $lots_qnty_this_lot[$key][$key1],
						'pur_kg_per_bosta' 					=> $kg_per_bosta_this_lot[$key][$key1],
						'pur_total_price' 					=> $ttl_buying_price_this_lot[$key][$key1],
						'total_due_payments' 				=> $ttl_buying_price_this_lot[$key][$key1],
						'total_cost' 						=> $ttl_buying_price_this_lot[$key][$key1],
						'status'							=> 1,
					];
				}
			}
			$this->buy->insert_batch_purchase_item_all_datas($data);

			/* 
			$last_purchase_item_id = $this->buy->insert_tbl_purchase_item_datas(
				array(
					'purchase_id' 							=> $last_purchase_id,
					'purchase_trans_info_auto_pr_iddds' 	=> $last_purchase_transports_id,
					'purchase_status'						=> $this->input->post('pur_status'),
					'item_id' 								=> $this->input->post('product_select'),
					'supplyer_id_a_pr' 						=> $this->input->post('supplier_id'),
					'ref_lot_no'							=> $this->input->post('lots_nos'),
					'purchase_item_dates'					=> date('Y-m-d', strtotime($this->input->post('pur_date'))),
					'purchase_qty' 							=> $this->input->post('total_buying_kg'),
					'price_per_unit' 						=> $this->input->post('price_per_kg'),
					'purchase_total_bosta' 					=> $this->input->post('qnty_bosta'),
					'due_sells_bosta_ss' 					=> $this->input->post('qnty_bosta'),
					'pur_kg_per_bosta' 						=> $this->input->post('qnty_per_bosta'),
					'pur_total_price' 						=> $this->input->post('total_buy_price'),
					'pur_prostabit_rate' 					=> $this->input->post('prostabit_buying_rate'),
					'total_cost' 							=> $this->input->post('total_buy_price'),
					'status'								=> 1,
				)
			);
			*/ 

			$last_purchase_payments_id = $this->buy->insert_tbl_purchase_payments_datas(
				array(
					'purchase_id' 			=> $last_purchase_id, 
					'items_uniqs_idd' 		=> $this->input->post('product_select'), 
					'supplier_auto_pr_id' 	=> $this->input->post('supplier_id'), 
					'payment_date'			=> date('Y-m-d', strtotime($this->input->post('pur_date'))),
					'payment' 				=> $this->input->post('paid_amount'),
					'created_date' 			=> date('Y-m-d'),
					'created_time' 			=> time(),
					'system_ip' 			=> $_SERVER['REMOTE_ADDR'],
					'system_name' 			=> gethostbyaddr($_SERVER['REMOTE_ADDR']),
					'status' 				=> 1,
				)
			);  

			$last_supplyer_payments_id = $this->buy->insert_tbl_supplyer_payments_datas(
				array(
					'purchasepayment_id' 	=> $last_purchase_payments_id,
					'supplier_id' 			=> $this->input->post('supplier_id'),
					'payment_date' 			=> date('Y-m-d', strtotime($this->input->post('pur_date'))),
					'payment' 				=> $this->input->post('paid_amount'),
					'system_ip' 			=> $_SERVER['REMOTE_ADDR'],
					'system_name' 			=> gethostbyaddr($_SERVER['REMOTE_ADDR']),
					'created_time' 			=> time(),
					'created_date' 			=> date('Y-m-d'),
					'status' 				=> 1,
				)
			);  

			$this->buy->insert_tbl_transport_cost_account(
				array(
					'trans_auto_prr_idiiidd' 		=> $this->input->post('transport_id'),
					'pruchase_trans__info_prr_idd' 	=> $last_purchase_transports_id,
					'trans_vara_cost' 				=> $this->input->post('cost_of_transport'),
					'trans_comission_per_bostasss' 	=> $this->input->post('trns_com_per_bosta'),
					'trans_comission_give' 			=> $this->input->post('ttl_trns_com'),
					'purchase_datess_times_now' 	=> date('Y-m-d', strtotime($this->input->post('pur_date'))),
					'todays_dates_now' 				=> date('Y-m-d'),
					'todays_times_now' 				=> time(),
				)
			);  

			$this->buy->insert_expense_data(
				array(
					"expense_date"	=> date('Y-m-d', strtotime($this->input->post('pur_date'))),
					"reference_no"	=> $this->input->post('lots_nos'),
					"expense_for"	=> 'আমদানীকারকের টাকা দেওয়া হয়েছে।',
					"expense_amt"	=> $this->input->post('paid_amount'),
					"o_p"			=> 1,
					"created_date"	=> date('Y-m-d'),
					"created_time"	=> time(),
					"status"		=> 1,
				)
			); 

			$last_purchase_costs_id = $this->buy->insert_tbl_purchase_costs_datas(
				array(
					'item_aauto_iddds' 						=> $this->input->post('product_select'),
					'purchase_idd_autooo' 					=> $last_purchase_id,
					'transport_aaatt_id' 					=> $this->input->post('transport_id'),
					'purchase_transportss_info_a_pr_iddd'	=> $last_purchase_transports_id,
					'transport_cost' 						=> $this->input->post('cost_of_transport'),
					'trns_com_per_bosta' 					=> $this->input->post('trns_com_per_bosta'),
					'ttl_trnasport_comission_cccst' 		=> $this->input->post('ttl_trns_com'),
					'products_selling_in_road' 				=> $this->input->post('prodct_sell_road'),
					'transport_comsn_cutts' 				=> $this->input->post('trns_com_cutting'),
					'ttl_comsn_for_transport' 				=> $this->input->post('ttl_com_for_trns'),
					'ghar_kuli_cost_per_bosta_s' 			=> $this->input->post('ghar_kuli_per_bosta'),
					'ttl_cost_of_ghar_kuli_sss' 			=> $this->input->post('cost_of_ghar_kuli'),
					'ttl_driver_advance_cost_ss' 			=> $this->input->post('driver_advance'),
					'other_total_cost' 						=> $this->input->post('others_cost'),
				)
			);
			echo $last_purchase_transports_id;
		}
	}

	public function add()
	{
		$data=$this->data;
		$data['page_title']=$this->lang->line('purchase');
		$data['suppliers']=$this->buy->get_all_suppliers();
		$data['products']=$this->buy->get_all_products();
		$data['trans']=$this->buy->get_all_transports();

		$this->load->view('product_buy_pur',$data);
		// $this->load->view('purchase',$data);
	}

	public function save_new_transport_profile()
	{
		$this->buy->add_new_transport_profiles(array(
			"trans_port_namess"	=> $this->input->post('names'),
			"trans_phone"	=> $this->input->post('mobile'),
			"trans_addrs"	=> $this->input->post('address'),
		));
	}

	public function get_suppliers_json()
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($this->buy->get_all_suppliers()));
		
	}

	public function save_new_supplier()
	{
		$this->buy->insert_new_supplier(array(
			"supplier_name"		=> $this->input->post('sup_name'), 
			"mobile"			=> $this->input->post('sup_mobile_no'), 
			"country_id"		=> $this->input->post('sup_country'), 
			"city"				=> $this->input->post('sup_city'), 
			"address"			=> $this->input->post('sup_address'), 
		)); 
		$this->session->set_flashdata('success', 'Success!! New Supplier Added Successfully!');
	}

	public function purchase_save_and_update(){
		$this->form_validation->set_rules('pur_date', 'Purchase Date', 'trim|required');
		$this->form_validation->set_rules('supplier_id', 'Supplier Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
	    	$result = $this->purchase->verify_save_and_update();
	    	echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	
	public function update($id){
		$this->permission_check('purchase_edit');
		$data=$this->data;
		$data=array_merge($data,array('purchase_id'=>$id));
		$data['page_title']=$this->lang->line('purchase');
		$this->load->view('purchase', $data);
	}
	
	//adding new item from Modal
	public function newsupplier(){
	
		$this->form_validation->set_rules('supplier_name', 'supplier Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			$this->load->model('suppliers_model');
			$result=$this->suppliers_model->verify_and_save();
			//fetch latest item details
			$res=array();
			$query=$this->db->query("select id,supplier_name from db_suppliers order by id desc limit 1");
			$res['id']=$query->row()->id;
			$res['supplier_name']=$query->row()->supplier_name;
			$res['result']=$result;
			
			echo json_encode($res);

		} 
		else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function ajax_list()
	{
		$list = $this->purchase->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $purchase) {
			
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$purchase->id.' class="checkbox column_checkbox" >';
			$row[] = show_date($purchase->purchase_date);

			$info = (!empty($purchase->return_bit)) ? "\n<span class='label label-danger' style='cursor:pointer'><i class='fa fa-fw fa-undo'></i>Return Raised</span>" : '';

			$row[] = $purchase->purchase_code.$info;
			$row[] = $purchase->purchase_status;
			$row[] = $purchase->reference_no;
			$row[] = $purchase->supplier_name;
			/*$row[] = $purchase->warehouse_name;*/
			$row[] = app_number_format($purchase->grand_total);
			$row[] = app_number_format($purchase->paid_amount);
			$row[] = app_number_format($purchase->purchase_due);
					$str='';
					if($purchase->payment_status=='Unpaid')
			          $str= "<span class='label label-danger' style='cursor:pointer'>Unpaid </span>";
			        if($purchase->payment_status=='Partial')
			          $str="<span class='label label-warning' style='cursor:pointer'> Partial </span>";
			        if($purchase->payment_status=='Paid')
			          $str="<span class='label label-success' style='cursor:pointer'> Paid </span>";

			$row[] = $str;
			$row[] = $purchase->created_by;
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';
											if($this->permissions('purchase_view'))
											$str2.='<li>
												<a title="View Invoice" href="purchase/invoice/'.$purchase->id.'" ><i class="fa fa-fw fa-eye text-blue"></i>View Purchase
												</a>
											</li>';

											if($this->permissions('purchase_edit'))
											$str2.='<li>
												<a title="Update Record ?" href="purchase/update/'.$purchase->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('purchase_payment_view'))
											$str2.='
											<li>
												<a title="Pay" class="pointer" onclick="view_payments('.$purchase->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>View Payments
												</a>
											</li>';

											if($this->permissions('purchase_payment_add'))
											$str2.='<li>
												<a title="Pay" class="pointer" onclick="pay_now('.$purchase->id.')" >
													<i class="fa fa-fw  fa-hourglass-half text-blue"></i>Pay Now
												</a>
											</li>';

											if($this->permissions('purchase_add') || $this->permissions('purchase_edit'))
											$str2.='<li>
												<a title="Update Record ?" target="_blank" href="purchase/print_invoice/'.$purchase->id.'">
													<i class="fa fa-fw fa-print text-blue"></i>Print
												</a>
											</li>
											<li>
												<a title="Update Record ?" target="_blank" href="purchase/pdf/'.$purchase->id.'">
													<i class="fa fa-fw fa-file-pdf-o text-blue"></i>PDF
												</a>
											</li>';

											if($this->permissions('purchase_return'))
											$str2.='<li>
												<a title="Purchase Return" href="purchase_return/add/'.$purchase->id.'">
													<i class="fa fa-fw fa-undo text-blue"></i>Purchase Return
												</a>
											</li>';

											if($this->permissions('purchase_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_purchase(\''.$purchase->id.'\')">
													<i class="fa fa-fw fa-trash text-red"></i>Delete
												</a>
											</li>
											
										</ul>
									</div>';			

			$row[] = $str2;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->purchase->count_all(),
						"recordsFiltered" => $this->purchase->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	
	public function delete_purchase(){
		$this->permission_check_with_msg('purchase_delete');
		$id=$this->input->post('q_id');
		echo $this->purchase->delete_purchase($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('purchase_delete');
		$ids=implode (",",$_POST['checkbox']);
		echo $this->purchase->delete_purchase($ids);
	}


	//Table ajax code
	public function search_item(){
		$q=$this->input->get('q');
		$result=$this->purchase->search_item($q);
		echo $result;
	}
	public function find_item_details(){
		$id=$this->input->post('id');
		
		$result=$this->purchase->find_item_details($id);
		echo $result;
	}

	//Purchase invoice form
	public function invoice($id)
	{
		if(!$this->permissions('purchase_add') && !$this->permissions('purchase_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('purchase_id'=>$id));
		$data['page_title']=$this->lang->line('purchase_invoice');
		$this->load->view('pur-invoice',$data); 
	}
	
	//Print Purchase invoice 
	public function print_invoice($purchase_id)
	{
		if(!$this->permissions('purchase_add') && !$this->permissions('purchase_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('purchase_id'=>$purchase_id));
		$data['page_title']=$this->lang->line('purchase_invoice');
		$this->load->view('print-purchase-invoice',$data);
	}
	public function pdf($purchase_id)
	{
		if(!$this->permissions('purchase_add') && !$this->permissions('purchase_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('purchase_id'=>$purchase_id));
		$data['page_title']=$this->lang->line('purchase_invoice');
		$this->load->view('print-purchase-invoice',$data);

		mb_internal_encoding('UTF-8');

		// Get output html
        $html = $this->output->get_output();
        // Load pdf library
        $this->load->library('pdf');
        
        // Load HTML content
        $this->dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');/*landscape or portrait*/
        
        // Render the HTML as PDF
        $this->dompdf->render();
        
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("Purchase_invoice_$purchase_id", array("Attachment"=>0));
	}


	//Purchase Barcode image
	public function barcode_image($item_code)
	{
		$this->load->library('zend');
	    $this->zend->load('Zend/Barcode');
	    Zend_Barcode::render('code39', 'image', array('text' => $item_code), array());
	}


	public function return_row_with_data($rowcount,$item_id){
		echo $this->purchase->get_items_info($rowcount,$item_id);
	}
	public function return_purchase_list($purchase_id){
		echo $this->purchase->return_purchase_list($purchase_id);
	}
	public function delete_payment(){
		$this->permission_check_with_msg('purchase_payment_delete');
		$payment_id = $this->input->post('payment_id');
		echo $this->purchase->delete_payment($payment_id);
	}

	public function show_pay_now_modal(){
		$this->permission_check_with_msg('purchase_view');
		$purchase_id=$this->input->post('purchase_id');
		echo $this->purchase->show_pay_now_modal($purchase_id);
	}

	public function save_payment(){
		$this->permission_check_with_msg('purchase_add');
		echo $this->purchase->save_payment();
	}
	
	public function view_payments_modal(){
		$this->permission_check_with_msg('purchase_view');
		$purchase_id=$this->input->post('purchase_id');
		echo $this->purchase->view_payments_modal($purchase_id);
	}

	
}
