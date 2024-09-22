<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('items_model','items');
		$this->load->model('buy_model','buy');
	}
	
	public function index()
	{
		$this->permission_check('items_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('items_list');
		$this->load->view('items-list',$data);
	}
	public function add()
	{
		$this->permission_check('items_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('items');
		$this->load->view('items',$data);
	}

	public function newitems(){ 
		$this->form_validation->set_rules('item_name', 'Item Name', 'trim|required');
		$this->form_validation->set_rules('unit_id', 'Unit', 'trim|required');

		
		if ($this->form_validation->run() == TRUE) {
			$result=$this->items->verify_and_save();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	public function update($id){
		$this->permission_check('items_edit');
		$data=$this->data;
		$this->load->model('items_model');
		$result=$this->items_model->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('items');
		$this->load->view('items', $data);
	}
	public function update_items(){
		$this->form_validation->set_rules('item_name', 'Item Name', 'trim|required');
		$this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
		$this->form_validation->set_rules('unit_id', 'Unit', 'trim|required');
		$this->form_validation->set_rules('price', 'Item Price', 'trim|required');
		$this->form_validation->set_rules('tax_id', 'Tax', 'trim|required');
		$this->form_validation->set_rules('purchase_price', 'Purchase Price', 'trim|required');
		//$this->form_validation->set_rules('profit_margin', 'Profit Margin', 'trim|required');
		$this->form_validation->set_rules('sales_price', 'Sales Price', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->items->update_items();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function get_brand_name($brand_id=''){
		if($brand_id==NULL || $brand_id=='' || $brand_id ==0){
			return;
		}
		return $this->db->query('select brand_name from db_brands where id="'.$brand_id.'"')->row()->brand_name;
	}
	
	public function get_item_by_id_ajax()
	{
		$id=$this->input->post('id');
		$dt['items'] = $this->buy->get_this_product_info_by_id($id);
		$unit_code_raw = $this->buy->get_all_units();
		$select_option = array();
		foreach ($unit_code_raw as $item_l) {
			$selected = ($item_l->id==$dt['items']->unit_id)? 'selected' : '';
			$select_option[] = "<option $selected value='".$item_l->id."'>".$item_l->unit_name."</option>";
		}
		$sopt = implode(' ', $select_option);
		$dt['unit_code'] = '<select class="form-control select2 unit_id_select ">'.$sopt.'</select>';
		$this->output->set_content_type('application/json')->set_output(json_encode($dt));
	}

	public function update_item_by_id()
	{
		$this->buy->update_item_by_id(array(
			"item_name"	=> $this->input->post('item_name'),
			"unit_id"	=> $this->input->post('unit_id'),
		), $this->input->post('id'));
	}

	public function ajax_list()
	{
		$list = $this->items->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		$tax_disabled = (is_tax_disabled()) ? true : false;
		foreach ($list as $items) {
			
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$items->id.' class="checkbox column_checkbox" >';

			$row[] = $items->item_code;
			$row[] = "<label class='text-blue'>".$items->item_name."</label>";
			$row[] = $items->unit_name;

			 		$str2 = '<div class="btn-group" title="View Account">
								<a class="btn btn-primary btn-o edit_item_this " data-toggle="modal" data-target="#modal_item_edit" style="cursor:pointer" title="পন্য এডিট " item_ids="'.$items->id.'">
									<i class="fa fa-fw fa-edit text-white"></i> Edit
								</a>
							</div>';
			$row[] = $str2;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->items->count_all(),
						"recordsFiltered" => $this->items->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check_with_msg('items_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$this->load->model('items_model');
		$result=$this->items_model->update_status($id,$status);
		return $result;
	}

	public function delete_items(){
		$this->permission_check_with_msg('items_delete');
		$id=$this->input->post('q_id');
		return $this->items->delete_items_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('items_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->items->delete_items_from_table($ids);
	}

	//Used in Purchase and sales Forms
	public function get_json_items_details(){
		$data = array();
		$display_json = array();
		//if (!empty($_GET['name'])) {
			$name = strtolower(trim($_GET['name']));
			$sql =$this->db->query("SELECT id,item_name,item_code,stock FROM db_items where  status=1 and  (LOWER(item_name) LIKE '%$name%' or LOWER(item_code) LIKE '%$name%' or LOWER(custom_barcode) LIKE '%$name%') limit 10");
			
			foreach ($sql->result() as $res) {
			      $json_arr["id"] = $res->id;
				  $json_arr["value"] = $res->item_name;
				  $json_arr["label"] = $res->item_name;
				  $json_arr["item_code"] = $res->item_code;
				  $json_arr["stock"] = $res->stock;
				  array_push($display_json, $json_arr);
				 /* $display_json[] =$res->id;
				  $display_json[] =$res->item_name;
				  $display_json[] =$res->item_code;*/
			}
		//}
		//echo json_encode($data);exit;
		echo json_encode($display_json);exit;
	}

	public function labels($purchase_id=''){
		$this->permission_check('print_labels');
		$data=$this->data;
		$data['page_title']=$this->lang->line('print_labels');
		$data['purchase_id']=$purchase_id;
		$this->load->view('labels',$data);
	}

	/*Labels Print request*/
	public function return_row_with_data($rowcount,$item_id){
		echo $this->items->get_items_info($rowcount,$item_id);
	}

	public function preview_labels(){
		echo $this->items->preview_labels();
	}

	//GET Labels from Purchase Invoice
	public function show_labels($purchase_id=''){
		$i=1;
		$result='';
		$q2=$this->db->query("select item_id,purchase_qty from db_purchaseitems where purchase_id='$purchase_id'");
		if($q2->num_rows()>0){
			
			foreach ($q2 -> result() as $res2) {
				$result.= $this->items->get_purchase_items_info($i++,$res2->item_id,$res2->purchase_qty);
			}
		}
		echo $result;
	}
	public function delete_stock_entry(){
		$this->permission_check_with_msg('items_delete');
		$entry_id = $this->input->post('entry_id');
		echo $this->items->delete_stock_entry($entry_id);
	}
	public function getItems($id=''){
		echo $this->items->getItemsJson($id);
	}
}
