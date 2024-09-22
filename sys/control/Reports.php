<?php

use FontLib\Table\Type\post;

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('reports_model','reports');
		$this->load->model('buy_model','buy');
	}

	public function get_income_expense_dat_to_date()
	{
		$startDate 	= date('Y-m-d', strtotime($this->input->post('startDate')));
		$endDate 	= date('Y-m-d', strtotime($this->input->post('endDate')));
		$dt['getpay']	= $this->buy->get_payment_from_customer($startDate, $endDate);
		$dt['income']	= $this->buy->get_ohers_income($startDate, $endDate);
		$dt['expense']	= $this->buy->expense_other_perpose($startDate, $endDate);
		$dt['costpay']	= $this->buy->cost_pay_to_supplier($startDate, $endDate);
		$this->output->set_content_type('application/json')->set_output(json_encode($dt));
	}

	//Sales Report 
	public function sales(){
		$this->permission_check('sales_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_report');
		$this->load->view('report-sales', $data);
	}
	public function show_sales_report(){
		echo $this->reports->show_sales_report();
	}

	//Sales Return Report 
	public function sales_return(){
		$this->permission_check('sales_return_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_return_report');
		$this->load->view('report-sales-return', $data);
	}
	public function show_sales_return_report(){
		echo $this->reports->show_sales_return_report();
	}

	//Purchase report
	public function purchase(){
		$this->permission_check('purchase_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('purchase_report');
		$this->load->view('report-purchase', $data);
	}
	public function show_purchase_report(){
		echo $this->reports->show_purchase_report(); 
	}

	//Purchase Return report
	public function purchase_return(){
		$this->permission_check('purchase_return_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('purchase_return_report');
		$this->load->view('report-purchase-return', $data);
	}
	public function show_purchase_return_report(){
		echo $this->reports->show_purchase_return_report();
	}

	//Expense report
	public function expense(){
		$this->permission_check('expense_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('expense_report');
		$this->load->view('report-expense', $data);
	}
	public function show_expense_report(){
		echo $this->reports->show_expense_report();
	}
	//Profit report
	public function profit_loss(){
		$this->permission_check('profit_report');
		$data=$this->data;
		$data['page_title']= 'আয়-ব্যায় রিপোর্ট';
		$this->load->view('report-profit-loss', $data);
	}
	public function get_profit_loss_report(){
		echo json_encode($this->reports->get_profit_loss_report());
	}
	public function get_profit_by_item(){
		echo $this->reports->get_profit_by_item();
	}
	public function get_profit_by_invoice(){
		echo $this->reports->get_profit_by_invoice();
	}

	//Summary report
	public function stock(){
		$this->permission_check('stock_report');
		$data=$this->data;
		$data['items']=$this->buy->get_all_products();		
		$data['page_title']=$this->lang->line('stock_report');
		$this->load->view('report-stock', $data);
	}

	public function get_stock_report(){
		$data = array(
			'item_wise_report' => $this->show_stock_report(),
			'brand_wise_stock' => $this->brand_wise_stock(),
			'category_wise_stock' => $this->category_wise_stock(),
		);
		echo json_encode($data); 
	}
	/*Stock Report*/
	public function show_stock_report(){
		return $this->reports->show_stock_report();
	}
	public function brand_wise_stock(){
		return $this->reports->brand_wise_stock();
	}
	public function category_wise_stock(){
		return $this->reports->category_wise_stock();
	}
	//Item Sales Report 
	public function item_sales(){
		$this->permission_check('item_sales_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('item_sales_report');
		$this->load->view('report-sales-item', $data);
	}
	public function show_item_sales_report(){
		echo $this->reports->show_item_sales_report();
	}
	//Item purchase Report 
	public function item_purchase(){
		$this->permission_check('item_purchase_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('item_purchase_report');
		$this->load->view('report-purchase-item', $data);
	}

	public function show_purchase_items_reports()
	{
		$startDate 	= date('Y-m-d', strtotime($this->input->post('sdate')));
		$endDate 	= date('Y-m-d', strtotime($this->input->post('edate')));
		$itemid 	= $this->input->post('itemid');
		$this->output->set_content_type('application/json')->set_output(json_encode($this->buy->show_purchase_items_reports($startDate, $endDate, $itemid)));
	}

	public function get_buy_sell_history()
	{
		$purchase_item_id 	= $this->input->post('p_i_id');
		$purchase_id 	= $this->input->post('p_id');
		$data['purchase_item'] = $this->buy->get_purchase_item_by_id($purchase_item_id);
		$data['purchase_paymentss'] = $this->buy->get_purchase_payments_by_purchase_id($purchase_id);
		$data['purchase_cost_history'] = $this->buy->get_purchase_cost_by_purchase_id($purchase_item_id);
		$data['sell_historyss'] = $this->buy->get_sell_history_by_purchase_item_id($purchase_id); 
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function show_item_purchase_report(){
		echo $this->reports->show_item_purchase_report();
	}
	//Purchase Payments report
	public function purchase_payments(){
		$this->permission_check('purchase_payments_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('purchase_payments_report');
		$this->load->view('report-purchase-payments', $data);
	}
	public function show_purchase_payments_report(){
		echo $this->reports->show_purchase_payments_report();
	}
	public function supplier_payments_report(){
		echo $this->reports->supplier_payments_report();
	}

	//Sales Payments report
	public function sales_payments(){
		$this->permission_check('sales_payments_report');
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_payments_report');
		$this->load->view('report-sales-payments', $data);
	}
	public function show_sales_payments_report(){
		echo $this->reports->show_sales_payments_report();
	}
	public function customer_payments_report(){
		echo $this->reports->customer_payments_report();
	}
	//Expired Items Report 
	public function expired_items(){
		$data=$this->data;
		$data['page_title']=$this->lang->line('expired_items_report');
		$this->load->view('report-expired-items', $data);
	}
	public function show_expired_items_report(){
		echo $this->reports->show_expired_items_report();
	}
	public function suppliyers_reports()
	{
		$data=$this->data;
		$data['suppliers']=$this->buy->get_all_suppliers();
		$data['page_title']='সরবরাহকারী রিপোর্ট';
		$this->load->view('suppliyer-reports', $data);
	}
	public function get_suppliers_reports_date_to_date()
	{
		$startDate 		= date('Y-m-d', strtotime($this->input->post('sdate')));
		$endDate 		= date('Y-m-d', strtotime($this->input->post('edate')));
		$supplier_id 	= $this->input->post('supp_id');

		$data['purchase_item'] = $this->buy->get_purchase_item_by_date_to_date($startDate, $endDate, $supplier_id);

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	public function get_purchase_paymetns_by_purchase_id()
	{
		$purchase_id 	= $this->input->post('id');
		$data = $this->buy->get_purchase_payments_by_purchase_id($purchase_id);

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	
}

