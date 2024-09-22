<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('expense_model','expense');
		$this->load->model('expense_category_model','category');
		$this->load->model('buy_model','buy');
	}
	/* ######################################## EXPENSE START ############################# */
	public function index()
	{
		$this->permission_check('expense_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('expenses_list');
		$this->load->view('expense-list',$data);
	}

	public function add()
	{
		$this->permission_check('expense_add');
		$data=$this->data; 
		$data['page_title']=$this->lang->line('expenses');
		$this->load->view('expense',$data);
	} 

	public function other_income_adds()
	{
		$data=$this->data;  
		$data['page_title']='ইনকাম';
		$this->load->view('other_income_adds',$data);		
	}

	public function due_income_payments()
	{
		$data=$this->data; 
		$data['cus_s']=$this->buy->get_all_customers(); 
		$data['page_title']='ইনকাম';
		$this->load->view('income_payment_take',$data);		
	}

	public function paid_payment()
	{
		$data=$this->data; 
		$data['sups']=$this->buy->get_all_suppliers(); 
		$data['page_title']=$this->lang->line('expenses');
		$this->load->view('expense_payment_paid',$data); 
	}
	
	public function get_sales_by_customer_id()
	{
		$customer_id = $this->input->post('c_id');
		$data['customer'] = $this->buy->get_customer_by_id($customer_id);
		$data['sales_info'] = $this->buy->get_customer_sales_by_cus_id($customer_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_sales_info_by_sales_id()
	{
		$sales_id = $this->input->post('sales_id');
		$data['sales_info'] = $this->buy->get_sales_info_by_sales_id($sales_id);
		$data['sales_pre_payment_info'] = $this->buy->get_sales_due_info_by_sales_id($sales_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data)); 
	}

	public function get_product_item_by_supplier_id()
	{
		$supplier_id = $this->input->post('s_id');
		$data['suppl'] = $this->buy->get_supplier_by_id($supplier_id);
		$data['pur_item'] = $this->buy->get_supplier_purchase_item_by_id($supplier_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function get_purchase_item_full_infos_unpaid_amount()
	{
		$purchase_item_id = $this->input->post('p_i_id');
		$data['purchase_item_info'] = $this->buy->get_purchase_item_by_id($purchase_item_id);
		$data['purchase_payments'] = $this->buy->get_purchase_payments_by_purchase_item_id($purchase_item_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function new_incomes_entry()
	{
		$this->buy->insert_income_payment(
			array(
				"income_date"	=> date('Y-m-d', strtotime($this->input->post('income_date'))),
				"income_for"	=> $this->input->post('incomes_for'),
				"income_amount"	=> $this->input->post('income_amnt'),
				"c_o_p"			=> 2,
				"create_date"	=> date('Y-m-d'),
				"created_time"	=> time(),
			)
		);
	}

	public function paid_sales_pre_due_amount()
	{

		$this->input->post('sales_idds');

		if (empty($this->input->post('ttl_payment_amnt'))) {
			echo 0;
		} else {

			if ($this->input->post('clear_check') == 1) {
				$this->buy->update_sales_tbl(
					array(
						"sell_payment_due"	=> 0,
					), $this->input->post('sales_idds')
				);
			} else {
				$sales_infosss = $this->buy->get_sales_info_by_sales_id($this->input->post('sales_idds'));
				$this->buy->update_sales_tbl(
					array(
						"sell_payment_due"	=> $sales_infosss->sell_payment_due - $this->input->post('ttl_payment_amnt'),
					), $this->input->post('sales_idds')
				);
			}

			$insert_sales_payment_id = $this->buy->insert_sales_payments_func(
				array(
					"sales_id"					=> $this->input->post('sales_idds'),
					"refs_lots_nosss"			=> $this->input->post('ref_lot_no'),
					"payments_bosta_qnttt_ss"	=> $this->input->post('bosta_qnty'),
					"payments_kgs_qntttt_ss"	=> $this->input->post('qnty_kgs'),
					"payment_date"				=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"payment"					=> $this->input->post('ttl_payment_amnt'),
					"created_time"				=> time(),
					"created_date"				=> date('Y-m-d'),
					"status"					=> 1,
				)
			);

			$insert_customer_payment_id = $this->buy->insert_customer_payments_func(
				array(
					"salespayment_id"			=> $insert_sales_payment_id,
					"customer_id"				=> $this->input->post('customer_id'),
					"payment_date"				=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"payment"					=> $this->input->post('ttl_payment_amnt'),
					"created_time"				=> time(),
					"created_date"				=> date('Y-m-d'),
					"status"					=> 1,
				)
			);

			$this->buy->insert_income_payment(
				array(
					"income_date"				=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"income_for"				=> `কাস্টমারের বকেয়া টাকা দিয়েছে`,
					"income_amount"				=> $this->input->post('ttl_payment_amnt'),
					"c_o_p"						=> 1,
					"create_date"				=> date('Y-m-d'),
					"created_time"				=> time(),
				)
			);
			echo 1;
		}

	}

	public function paid_previous_due_amount_s()
	{
		if (empty($this->input->post('ttl_payment_amnt'))) {
			echo 0;
		} else {

			if ($this->input->post('clear_check') == 1) {
				$this->buy->update_purchase_items_due(
					array(
						"total_due_payments"	=> 0,
					), $this->input->post('get_pur_item_id')
				);
			} else {
				$purchase_item_infosss = $this->buy->get_purchase_item_info_by_id($this->input->post('get_pur_item_id'));
				$this->buy->update_purchase_items_due(
					array(
						"total_due_payments"	=> $purchase_item_infosss->total_due_payments - $this->input->post('ttl_payment_amnt'),
					), $this->input->post('get_pur_item_id')
				);
			}

			$insert_purchase_payment_id = $this->buy->insert_purchase_payments_func(
				array(
					"purchase_id"			=> $this->input->post('get_pur_id'),
					"items_uniqs_idd"		=> $this->input->post('get_item_id'),
					"purchase_item_s_id"	=> $this->input->post('get_pur_item_id'),
					"supplier_auto_pr_id"	=> $this->input->post('supp_id'),
					"payment_date"			=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"refs_lots_no_s"		=> $this->input->post('ref_lot_no'),
					"payments_bosta_qnt_s"	=> $this->input->post('bosta_qnty'),
					"payments_kgs_qnt"		=> $this->input->post('qnty_kgs'),
					"payment"				=> $this->input->post('ttl_payment_amnt'),
					"created_time"			=> time(),
					"created_date"			=> date('Y-m-d'),
					"status"				=> 1,
				)
			); 

			$insert_supplier_payment_id = $this->buy->insert_supplier_paymentss(
				array(
					"purchasepayment_id"		=> $insert_purchase_payment_id,
					"supplier_id"				=> $this->input->post('supp_id'),
					"pur_chase_a_pri_id"		=> $this->input->post('get_pur_id'),
					"pur_chase_item_s_pri_id"	=> $this->input->post('get_pur_item_id'),
					"payment_date"				=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"payment"					=> $this->input->post('ttl_payment_amnt'),
					"created_time"				=> time(),
					"created_date"				=> date('Y-m-d'),
					"status"					=> 1,
				)
			);   

			$this->buy->insert_expense_data(
				array(
					"expense_date"	=> date('Y-m-d', strtotime($this->input->post('payment_date'))),
					"reference_no"	=> $this->input->post('ref_lot_no'),
					"expense_for"	=> 'আমদানীকারকের টাকা দেওয়া হয়েছে।',
					"expense_amt"	=> $this->input->post('ttl_payment_amnt'),
					"o_p"			=> 1,
					"created_date"	=> date('Y-m-d'),
					"created_time"	=> time(),
					"status"		=> 1,
				)
			);
			echo 1;
		}
	}
	
	public function newexpense(){
		$this->form_validation->set_rules('expense_date', 'Expense Date', 'trim|required');
		$this->form_validation->set_rules('expense_amt', 'Expense Amount', 'trim|required');
		$this->form_validation->set_rules('expense_for', 'Expense for', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->expense->verify_and_save();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	public function update($id){
		$this->permission_check('expense_edit');
		$data=$this->data;
		$result=$this->expense->get_details($id,$data);
		$data=array_merge($data,$result);
		$this->load->view('expense', $data);
	}
	public function update_expense(){
		$this->form_validation->set_rules('expense_date', 'Expense Date', 'trim|required');
		$this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
		$this->form_validation->set_rules('expense_amt', 'Expense Amount', 'trim|required');
		$this->form_validation->set_rules('expense_for', 'Expense for', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->expense->update_expense();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function ajax_list()
	{
		$list = $this->expense->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $expense) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$expense->id.' class="checkbox column_checkbox" >';
			$row[] = show_date($expense->expense_date);
			$row[] = $expense->category_name;
			$row[] = $expense->reference_no;
			$row[] = $expense->expense_for;
			$row[] = app_number_format($expense->expense_amt);
			$row[] = $expense->note;			
			$row[] = ucfirst($expense->created_by);			
				     $str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('expense_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="expense/update/'.$expense->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('expense_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_expense('.$expense->id.')">
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
						"recordsTotal" => $this->expense->count_all(),
						"recordsFiltered" => $this->expense->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check_with_msg('expense_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		return $this->expense->update_status($id,$status);
		
	}
	public function delete_expense(){
		$this->permission_check_with_msg('expense_delete');
		$id=$this->input->post('q_id');
		return $this->expense->delete_expenses_from_table($id);
	}
	public function multi_delete_expense(){
		$this->permission_check_with_msg('expense_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->expense->delete_expenses_from_table($ids);
	}
	
	/* ######################################## EXPENSE END ############################# */





	/* ######################################## EXPENSE CATEGORY START ############################# */
	public function category()
	{	
		$this->permission_check('expense_category_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('expense_category_list');
		$this->load->view('expense-category-list',$data);
	}
	public function category_add()
	{
		$this->permission_check('expense_category_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('expense_category');
		$this->load->view('expense-category',$data);
	}
	public function newcategory(){
		$this->form_validation->set_rules('category', 'Category', 'trim|required');
		

		if ($this->form_validation->run() == TRUE) {
			$this->load->model('expense_category_model');
			$result=$this->expense_category_model->verify_and_save();
			echo $result;
		} else {
			echo "Please Enter Category name.";
		}
	}
	public function ajax_list_expense()
	{
		
		$list = $this->category->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $category) {
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$category->id.' class="checkbox column_checkbox" >';
			$row[] = $category->category_name;
			$row[] = $category->description;

			 		if($category->status==1){ 
			 			$str= "<span onclick='update_status(".$category->id.",0)' id='span_".$category->id."'  class='label label-success' style='cursor:pointer'>Active </span>";}
					else{ 
						$str = "<span onclick='update_status(".$category->id.",1)' id='span_".$category->id."'  class='label label-danger' style='cursor:pointer'> Inactive </span>";
					}
			$row[] = $str;			
					 $str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('expense_category_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="expense_update/'.$category->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Edit
												</a>
											</li>';

											if($this->permissions('expense_category_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_category('.$category->id.')">
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
						"recordsTotal" => $this->category->count_all(),
						"recordsFiltered" => $this->category->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function expense_update($id){
		$this->permission_check_with_msg('expense_category_edit');
		$data=$this->data;		
		$result=$this->category->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('expense_category');
		$this->load->view('expense-category', $data);
	}
	public function update_category(){
		$this->form_validation->set_rules('category', 'Category', 'trim|required');
		$this->form_validation->set_rules('q_id', '', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->category->update_category();
			echo $result;
		} else {
			echo "Please Enter Category name.";
		}
	}

	public function expense_update_status(){
		$this->permission_check_with_msg('expense_category_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		return $this->category->update_status($id,$status);
		
	}
	public function delete_category(){
		$this->permission_check_with_msg('expense_category_delete');
		$id=$this->input->post('q_id');
		return $this->category->delete_categories_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('expense_category_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->category->delete_categories_from_table($ids);
	}
	/* ######################################## EXPENSE CATEGORY END############################# */

}
