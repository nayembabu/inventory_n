<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('customers_model','customers');
	}

	public function index()
	{
		$this->permission_check('customers_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('customers_list');
		$this->load->view('customers-view',$data);
	}
	public function add()
	{
		$this->permission_check('customers_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('customers');
		$this->load->view('customers',$data);
	}

	public function newcustomers(){
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
			$result=$this->customers->verify_and_save();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	
	public function update($id){
		$this->permission_check('customers_edit');
		$data=$this->data;
		$result=$this->customers->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('customers');
		$this->load->view('customers', $data);
	}
	public function update_customers(){
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {			
			$result=$this->customers->update_customers();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function show_total_customer_paid_amount($customer_id){
		return $this->db->select("coalesce(sum(paid_amount),0) as tot")->where("customer_id",$customer_id)->get("db_sales")->row()->tot;
	}
	public function ajax_list()
	{
		$list = $this->customers->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$disable = ($customers->id==1) ? 'disabled' : '';
			if($customers->id==1){
				$row[] = '<span class="text-blue">NA</span>';	
			}
			else{
				$row[] = '<input type="checkbox" name="checkbox[]" '.$disable.' value='.$customers->id.' class="checkbox column_checkbox" >';
			}
			
			$row[] = $customers->customer_code;
			$row[] = $customers->customer_name;
			$row[] = $customers->mobile;

					$str2 = '<div class="btn-group" title="View Account">
								<a style="cursor:pointer" class="btn btn-danger btn-o" title="Delete Record ?" onclick="delete_customers('.$customers->id.')">
									<i class="fa fa-fw fa-trash text-white"></i>ডিলিট
								</a>
							</div>';
			$row[] =  $str2;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->customers->count_all(),
						"recordsFiltered" => $this->customers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check_with_msg('customers_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$result=$this->customers->update_status($id,$status);
		return $result;
	}
	
	public function delete_customers(){
		$this->permission_check_with_msg('customers_delete');
		$id=$this->input->post('q_id');
		return $this->customers->delete_customers_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('customers_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->customers->delete_customers_from_table($ids);
	}
	public function show_pay_now_modal(){
		$this->permission_check_with_msg('sales_payment_add');
		$customer_id=$this->input->post('customer_id');
		echo $this->customers->show_pay_now_modal($customer_id);
	}
	public function save_payment(){
		$this->permission_check_with_msg('sales_payment_add');
		echo $this->customers->save_payment();
	}
	public function show_pay_return_due_modal(){
		$this->permission_check_with_msg('sales_return_payment_add');
		$customer_id=$this->input->post('customer_id');
		echo $this->customers->show_pay_return_due_modal($customer_id);
	}
	public function save_return_due_payment(){
		$this->permission_check_with_msg('sales_payment_add');
		echo $this->customers->save_return_due_payment();
	}
	public function delete_opening_balance_entry(){
		$this->permission_check_with_msg('sales_payment_delete');
		$entry_id = $this->input->post('entry_id');
		echo $this->customers->delete_opening_balance_entry($entry_id);
	}
	public function getCustomers($id=''){
		echo $this->customers->getCustomersJson($id);
	}

}
