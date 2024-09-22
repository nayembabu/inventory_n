<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buy_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
        $this->load->database();
	}

	public function get_all_suppliers()
	{
		return $this->db->get('db_suppliers')->result();
	}

	public function insert_new_supplier($data)
	{
		return $this->db->insert('db_suppliers', $data);
	}

	public function get_all_products()
	{
		return $this->db
					->select('a.id,a.item_code,a.item_name,a.category_id,a.unit_id,a.price,a.status,a.stock,a.final_price,a.sales_price,b.unit_name,b.description,b.status')
					->join('db_units b', 'a.unit_id = b.id', 'left')
					->get('db_items a')
					->result();
	}   

	public function get_all_customers()
	{
		return $this->db->get('db_customers')->result();
	}  

	public function get_sales_due_info_by_sales_id($sales_id)
	{
		return $this->db
					->where('sales_id', $sales_id)
					->get('db_salespayments')
					->result(); 
	}

	public function get_sales_info_by_sales_id($sales_id)
	{
		return $this->db
					->select('a.id, b.customer_name, b.customer_code, b.mobile, b.address, a.sales_code, a.reference_no, a.pur_reference_no_lots, a.item_product_auto_iddd, a.purchase_auto_pr_ids, a.purchase_item_ap_ids, a.sell_ing_qnty_total, a.total_sell_price_s, a.price_per_kg_s_s, a.qnt_kgs_per_bosta, a.total_price_of_per_bosta, a.sell_ins_payment_take, a.total_sell_discount_s, a.sell_payment_due, a.sales_date, a.customer_id, a.grand_total, a.paid_amount, c.item_code, c.item_name, d.unit_name')
					->where('a.id', $sales_id)
					->join('db_customers b', 'b.id = a.customer_id', 'left')
					->join('db_items c', 'c.id = a.item_product_auto_iddd', 'left')
					->join('db_units d', 'c.unit_id = d.id', 'left')
					->get('db_sales a')
					->row();
	}

	public function insert_sales_payments_func($arr)
	{
        $this->db->insert('db_salespayments', $arr);
        return $this->db->insert_id();
	}  

	public function insert_customer_payments_func($arr)
	{
        $this->db->insert('db_customer_payments', $arr);
        return $this->db->insert_id();
	} 

	public function get_customer_sales_by_cus_id($cus_id)
	{
		return $this->db
					->select('a.id, b.item_name, a.reference_no, c.unit_name')
					->where('a.customer_id', $cus_id)
					->where('a.sell_payment_due !=', 0)
					->join('db_items b', 'b.id = a.item_product_auto_iddd', 'left')
					->join('db_units c', 'b.unit_id = c.id', 'left')
					->get('db_sales a')
					->result();
	}

	public function get_all_transports()
	{
		return $this->db->get('db_trans_port_profiles')->result();
	}

	public function insert_tbl_purchase_datas($data)
	{
        $this->db->insert('db_purchase', $data);
        return $this->db->insert_id();
	}     

	public function insert_tbl_transport_cost_account($data)
	{
        $this->db->insert('db_transport_cost_account', $data);
        return $this->db->insert_id();
	} 

	public function insert_batch_purchase_item_all_datas($data)
	{
        $this->db->insert_batch('db_purchaseitems', $data);
	}

	public function insert_tbl_purchase_item_datas($data)
	{
        $this->db->insert('db_purchaseitems', $data);
        return $this->db->insert_id();
	}

	public function insert_tbl_purchase_payments_datas($data)
	{
        $this->db->insert('db_purchasepayments', $data);
        return $this->db->insert_id();
	}  

	public function insert_tbl_supplyer_payments_datas($data)
	{
        $this->db->insert('db_supplier_payments', $data);
        return $this->db->insert_id();
	}  

	public function insert_tbl_purchase_costs_datas($data)
	{
        $this->db->insert('db_purchase_cost', $data);
        return $this->db->insert_id();
	}

	public function get_supplier_by_id($id)
	{
		return $this->db
					->select('id, supplier_code, supplier_name, mobile, phone, address')
					->where('id', $id)
					->get('db_suppliers')
					->row();
	}

	public function get_supplier_purchase_item_by_id($id)
	{
		return $this->db
					->select('b.item_name, b.item_code, a.id, a.ref_lot_no, a.pur_buying_types_statu, c.unit_name')
					->where('supplyer_id_a_pr', $id)
					->where('total_due_payments !=', 0)
					->join('db_items b', 'b.id = a.item_id', 'left')
					->join('db_units c', 'b.unit_id = c.id', 'left')
					->get('db_purchaseitems a')
					->result();
	}

	public function get_purchase_payments_data_infos($purchase_item_id)
	{
		return $this->db
					->where('purchase_item_s_id', $purchase_item_id)
					->get('db_purchasepayments')
					->result();
	}

	public function get_supplier_payments_by_id($id)
	{
		return $this->db
					->select('a.purchasepayment_id, a.supplier_id, a.payment_date, a.payment, b.purchase_id, c.items_uniq_int_id, c.purchase_code, c.reference_no, c.purchase_date, c.grand_total, c.paid_amount ')
					->where('a.supplier_id', $id)
					->join('db_purchasepayments b', 'b.id = a.purchasepayment_id', 'left')
					->join('db_purchase c', 'a.supplier_id = c.supplier_id', 'left')
					->get('db_supplier_payments a')
					->result();
	}

	public function get_purchase_payments_by_purchase_item_id($purchase_item_id)
	{
		return $this->db
					->where('purchase_item_s_id', $purchase_item_id)
					->get('db_purchasepayments')
					->result();
	}

	public function get_purchase_item_by_id($id)
	{
		return $this->db
					->select('a.id, a.purchase_id, a.purchase_status, a.item_id, a.supplyer_id_a_pr, a.ref_lot_no, a.purchase_qty, a.price_per_unit, a.purchase_total_bosta, a.due_sells_bosta_ss, a.pur_kg_per_bosta, a.pur_total_price, a.total_due_payments, a.pur_prostabit_rate, a.pur_buying_types_statu, a.total_cost, b.supplier_code, b.supplier_name, b.mobile, b.phone, b.address, b.purchase_due, c.items_uniq_int_id, c.purchase_code, c.reference_no, c.purchase_date, d.item_code, d.item_name, c.buying_type_status,e.unit_name')
					->where('a.id', $id)
					->join('db_suppliers b', 'a.supplyer_id_a_pr = b.id', 'left')
					->join('db_purchase c', 'a.purchase_id = c.id', 'left')
					->join('db_items d', 'a.item_id = d.id', 'left')
					->join('db_units e', 'd.unit_id = e.id', 'left')
					->get('db_purchaseitems a')
					->row();
	}

	public function save_new_customer($datas)
	{
        $this->db->insert('db_customers', $datas);
        return $this->db->insert_id();
	}

	public function get_customer_by_id($id)
	{
		return $this->db
					->where('id', $id)
					->get('db_customers')
					->row();
	}

	public function get_this_product_info_by_id($id)
	{
		return $this->db
					->where('d.id', $id)
					->join('db_units e', 'd.unit_id = e.id', 'left')
					->get('db_items d')
					->row();
	}

	public function get_all_purchases_infos($product_id)
	{
		return $this->db
					->select('a.id, a.purchase_id, a.purchase_id, a.purchase_status, a.item_id, a.supplyer_id_a_pr, a.ref_lot_no, a.purchase_qty, a.price_per_unit, a.purchase_total_bosta, a.due_sells_bosta_ss, a.pur_kg_per_bosta, a.pur_total_price, a.pur_prostabit_rate, a.unit_total_cost, a.total_cost, a.profit_margin_per, a.unit_sales_price, a.status, b.buying_type_status, c.supplier_name, e.unit_name ')
					->where('a.item_id', $product_id)
					->where('a.due_sells_bosta_ss !=', 0)
					->join('db_purchase b', 'a.purchase_id = b.id', 'left')
					->join('db_suppliers c', 'a.supplyer_id_a_pr = c.id', 'left')
					->join('db_items d', 'a.item_id = d.id', 'left')
					->join('db_units e', 'd.unit_id = e.id', 'left')
					->get('db_purchaseitems a')
					->result();
	}

	public function get_purchase_item_info_by_id($id)
	{
		return $this->db
					->where('id', $id)
					->join('db_purchase_cost', 'db_purchase_cost.purchase_idd_autooo = db_purchaseitems.purchase_id', 'left')
					->get('db_purchaseitems')
					->row();
	}

	public function get_sell_info_by_purchase_id($purchase_id)
	{
		return $this->db
					->select('a.grand_total, a.id, a.sales_code, a.reference_no, a.item_product_auto_iddd, a.purchase_auto_pr_ids, a.sales_date, a.customer_id, a.sales_status, b.customer_code, b.customer_name, b.mobile, b.address')
					->where('a.purchase_auto_pr_ids', $purchase_id)
					->join('db_customers b', 'a.customer_id = b.id', 'left')
					->get('db_sales a')
					->result();
	}
	
	public function entry_s_new_sales($arry)
	{
        $this->db->insert('db_sales', $arry);
        return $this->db->insert_id();
	}  
	
	public function insert_supplier_paymentss($arry)
	{
        $this->db->insert('db_supplier_payments', $arry);
        return $this->db->insert_id();
	}
	
	public function insert_expense_data($arry)
	{
        $this->db->insert('db_expense', $arry);
        return $this->db->insert_id();
	}
	
	public function insert_purchase_payments_func($data)
	{
        $this->db->insert('db_purchasepayments', $data);
        return $this->db->insert_id();
	}
	
	public function entry_sales_paymentss($arry)
	{
        $this->db->insert('db_salespayments', $arry);
        return $this->db->insert_id();
	}

	public function get_customer_by_cus_id($id)
	{
		return $this->db
					->where('id', $id)
					->get('db_customers')
					->row();
	}

	public function update_purchase_items_due($data, $id)
	{
		$this->db
			 ->where('id', $id)
			 ->update('db_purchaseitems', $data);
	}

	public function update_customer_total_due($data, $id)
	{
		$this->db
			 ->where('id', $id)
			 ->update('db_customers', $data);
	}

	public function update_sales_tbl($data, $id)
	{
		$this->db
			 ->where('id', $id)
			 ->update('db_sales', $data);
	}
	
	public function insert_income_payment($arry)
	{
        $this->db->insert('db_incomes', $arry);
        return $this->db->insert_id();
	}

	public function show_purchase_items_reports($s, $e, $item)
	{
		$this->db->select('a.purchase_code, a.items_uniq_int_id, a.purchase_date, a.supplier_id, a.buying_type_status, b.id, b.purchase_id, b.item_id, b.ref_lot_no, b.purchase_qty, b.price_per_unit, b.purchase_total_bosta, b.due_sells_bosta_ss, b.pur_kg_per_bosta, b.pur_total_price, b.total_due_payments, b.pur_prostabit_rate, b.total_cost, c.supplier_name, e.unit_name');
        $this->db->where('a.purchase_date >=', $s);
        $this->db->where('a.purchase_date <=', $e);
        $this->db->where('a.items_uniq_int_id', $item);
		$this->db->join('db_purchaseitems b', 'b.purchase_id = a.id', 'left');
		$this->db->join('db_suppliers c', 'c.id = a.supplier_id', 'left');
		$this->db->join('db_items d', 'a.items_uniq_int_id = d.id', 'left');
		$this->db->join('db_units e', 'd.unit_id = e.id', 'left');
        $query = $this->db->get('db_purchase a');
        return $query->result();
	}

	public function get_payment_from_customer($s, $e)
	{
        $this->db->where('payment_date >=', $s);
        $this->db->where('payment_date <=', $e);
        $query = $this->db->get('db_salespayments');
        return $query->result();
	}

	public function get_ohers_income($s, $e)
	{
        $this->db->where('income_date >=', $s);
        $this->db->where('income_date <=', $e);
        $query = $this->db->get('db_incomes');
        return $query->result();
	}

	public function expense_other_perpose($s, $e)
	{
        $this->db->where('expense_date >=', $s);
        $this->db->where('expense_date <=', $e);
        $query = $this->db->get('db_expense');
        return $query->result();
	}

	public function cost_pay_to_supplier($s, $e)
	{
        $this->db->where('payment_date >=', $s);
        $this->db->where('payment_date <=', $e);
        $query = $this->db->get('db_purchasepayments');
        return $query->result();
	}

	public function get_purchase_cost_by_purchase_id($purchase_id)
	{
        $this->db->where('purchase_idd_autooo', $purchase_id);
        $query = $this->db->get('db_purchase_cost');
        return $query->row();		
	}

	public function get_sell_history_by_purchase_item_id($purchase_id)
	{
        $this->db->where('purchase_item_ap_ids', $purchase_id);
		$this->db->join('db_customers', 'db_customers.id = db_sales.customer_id', 'left');
        $query = $this->db->get('db_sales');
        return $query->result();
	}

	public function get_purchase_payments_by_purchase_id($purchase_id)
	{
        $this->db->where('purchase_id', $purchase_id);
        $query = $this->db->get('db_purchasepayments');
        return $query->result();
	}

	public function get_purchase_item_by_date_to_date($s, $e, $supplier_id)
	{
        $this->db->where('purchase_item_dates >=', $s);
        $this->db->where('purchase_item_dates <=', $e);
        $this->db->where('supplyer_id_a_pr', $supplier_id);
		$this->db->join('db_items', 'db_purchaseitems.item_id = db_items.id', 'left');
		$this->db->join('db_units', 'db_items.unit_id = db_units.id', 'left');
        $query = $this->db->get('db_purchaseitems');
        return $query->result();
	}

	public function update_item_by_id($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('db_items', $data);
	}

	public function get_all_units()
	{
		$this->db->where('status !=', 0);
        $query = $this->db->get('db_units');
        return $query->result();
	}

	public function add_new_transport_profiles($data)
	{
		$this->db->insert('db_trans_port_profiles', $data);
	} 
	
	public function insert_purchase_this_transports_info($arry)
	{
        $this->db->insert('db_purchase_transports_info', $arry);
        return $this->db->insert_id();
	}

	public function insert_supplier_due_payment_amt($data)
	{
		$this->db->insert('db_supplier_due_unpayment', $data);
	} 

	public function get_due_purchase_transport_info_by_item_id($item_id)
	{
        return $this->db
					->where('ttl_due_bosta_this_trans !=', 0)
        			->where('products_items_at_ididii', $item_id)
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
        			->get('db_purchase_transports_info')
        			->result();
	}

	public function get_due_purchase_transport_info_by_id($id)
	{
        return $this->db
					->where('db_purchase_transports_info_a_idd', $id)
					->join('db_suppliers', 'db_suppliers.id = db_purchase_transports_info.sup_id_ass_iddd', 'left')
					->get('db_purchase_transports_info')
        			->row();
	}

	public function get_purchase_info_by_trans_id($trans_id)
	{
		return $this->db
					->where('pur_trans_info_auto_iddid', $trans_id)
					->get('db_purchase')
					->row();		
	} 

	public function get_purchase_cost_by_trans_id($trans_id)
	{
		return $this->db
					->where('purchase_transportss_info_a_pr_iddd', $trans_id)
					->get('db_purchase_cost')
					->row();		
	} 

	public function get_purchase_item_info_by_trans_id($ptid)
	{
		return $this->db
        			->where('due_sells_bosta_ss !=', 0)
					->where('purchase_trans_info_auto_pr_iddds', $ptid)
					->get('db_purchaseitems')
					->result();
	}



























}