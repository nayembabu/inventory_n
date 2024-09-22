

$(document).on('change', '.select_customers_id', function () {
	let customer_id = $(this).val(); 
    if (customer_id != '') {
        $.ajax({
            type: "post",
            url: "expense/get_sales_by_customer_id",
            data: {
                c_id: customer_id   
            },
            success: function (res) {
                // sales_info
                
				let opt_html_data = '';
				for (let l = 0; l < res.sales_info.length; l++) {
					opt_html_data += `<option value="${res.sales_info[l].id}">${res.sales_info[l].item_name} - ${res.sales_info[l].reference_no}</option>`;
				}
				$('.products_select_data').html(
					`<select class="products_option_selection" style="width: 100%; font-size: 20px; " >
                        <option value="">সিলেক্ট করুন</option>
						${opt_html_data}
                      </select>`
				);
				$('.customers_data_assign_info').html(``);
				$('.previous_payments_data_assign').html(``);
            }
        });
    } else {
        
    }
});

$(document).on('change', '.products_option_selection', function () {
    let sales_selected_id = $(this).val();
    if (sales_selected_id == '') {
        // 
    }else {
        $.ajax({
            type: "post",
            url: "expense/get_sales_info_by_sales_id",
            data: {
                sales_id: sales_selected_id 
            },
            success: function (res) {
                
				let full_date = new Date();
				let year = full_date.getFullYear();
				let month = ("0" + (full_date.getMonth() + 1)).slice(-2);
				let day = ("0" + (full_date.getDate() )).slice(-2);
				let payments_html_data = '';
				let loan_paid_html = ``;
                let paid_amount_tk = 0;
				let purchase_typesss = '';

				if (res.sales_info.sell_payment_due >= 0) {
					loan_paid_html = `
						<div class="input-group col-lg-12 col-md-12 col-sm-12 row">
							<div class="col-md-6 ">
								<div class="input-group">
									<span class="input-group-addon">তারিখ</span>
									<input type="text" class="form-control pull-right datepicker purchase_payments_date"  id="pur_date" name="pur_date" value="${day}-${month}-${year}">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
							<div class="col-md-6 ">
								<div class="input-group">
									<span class="input-group-addon">পরিশোধিত টাকা</span>
									<input type="text" class="form-control total_amounts " style="text-align: right; " >
									<span class="input-group-addon">টাকা</span>
								</div>
							</div>
							<div class="col-md-6 ">
								<center class="bosta_qnty_cls" style=" color: green; "></center>
								<div class="input-group">
									<span class="input-group-addon">পরিমাণ বস্তায়</span>
									<input type="text" class="form-control qnty_bosta_ss" style="text-align: right; " value="">
									<span class="input-group-addon">বস্তা</span>
								</div>
							</div>
							<div class="col-md-6 ">
								<center class="kg_qntys_cls" style="color: green;"></center>
								<div class="input-group">
									<span class="input-group-addon">পরিমান কেজিতে</span>
									<input type="text" class="form-control qnty_kgss_p" style="text-align: right; " >
									<span class="input-group-addon">কেজি</span>
								</div>
								<div class="form-check">
									<input class="form-check-input clear_all_payments " type="checkbox" value="" id="flexCheckDefault">
									<label class="form-check-label" for="flexCheckDefault">
										সব টাকা পরিশোধ করা হয়েছে 
									</label>
								</div>
							</div>
							<center><div class="btn btn-success btn-lg paidable_amount_btn_data " sales_auto_idds="${res.sales_info.id}" customer_auto_id="${res.sales_info.customer_id}" item_auto_id="${res.sales_info.item_product_auto_iddd}" pur_auto_id="${res.sales_info.purchase_auto_pr_ids}" ref_lot_no="${res.sales_info.reference_no}" pur_item_auto_id="${res.sales_info.purchase_item_ap_ids}" kg_per_bostasss="${res.sales_info.qnt_kgs_per_bosta}" price_per_kgs_ss="${res.sales_info.price_per_kg_s_s}" total_dues_amnt_now="${res.sales_info.sell_payment_due}" style="margin-top: 20px; font-weight: bold; " > টাকা গ্রহন করুন </div></center>
						</div>`;
				}

				if (res.sales_pre_payment_info == '') {
					payments_html_data = `<tr>
												<td colspan="3" style="text-align: center; "> আগে পরিশোধ করা হয় নাই </td>
											</tr>`
				} else {
					for (let m = 0; m < res.sales_pre_payment_info.length; m++) {

						let full_date_s = new Date(res.sales_pre_payment_info[m].payment_date);
						let year_s = full_date_s.getFullYear();
						let month_s = ("0" + (full_date_s.getMonth() + 1)).slice(-2);
						let day_s = ("0" + (full_date_s.getDate() )).slice(-2);
                        paid_amount_tk += parseFloat(res.sales_pre_payment_info[m].payment);

						payments_html_data += 	`<tr>
													<td >${day_s}-${month_s}-${year_s}</td>
													<td > ${res.sales_pre_payment_info[m].payments_bosta_qnttt_ss} বস্তা --- ${res.sales_pre_payment_info[m].payments_kgs_qntttt_ss} কেজি </td>
													<th >৳ ${Math.round(res.sales_pre_payment_info[m].payment)}/-</th>
												</tr>`;
					} 
				}

				purchase_typesss = 'ডাইরেক্ট ক্রয়';
				$('.customers_data_assign_info').html(
					`<div class="">
						<table class="table">
							<tr>
								<th scope="col">নাম</th>
								<th scope="col">মোবাইল</th>
								<th scope="col">ঠিকানা</th>
							</tr>
							<tr>
								<td>${res.sales_info.customer_name}</td>
								<td>${res.sales_info.mobile}</td>
								<td>${res.sales_info.address}</td>
							</tr>
							<tr>
								<th scope="col">বিক্রির তারিখ</th>
								<th scope="col">লট নং</th>
							</tr>
							<tr>
								<td>${res.sales_info.sales_date}</td>
								<td>${res.sales_info.reference_no}</td>
							</tr>
						</table>
						<table class="table">
							<tr>
								<th>বিক্রয়কৃত পণ্য</th>
								<th>${res.sales_info.item_name}</th>
								<td>মোট দাম</td>
								<th style="text-align: right; ">৳ ${Math.round(res.sales_info.total_sell_price_s)}/-</th>
							</tr>
							<tr>
								<td colspan="3" align="right">ডিসকাউন্ট</td>
								<th style="text-align: right; " >৳ ${Math.round(res.sales_info.total_sell_discount_s)}/-</th>
							</tr>
							<tr>
								<td colspan="3" align="right">পরিশোধকৃত টাকা</td>
								<th style="text-align: right; " >৳ ${Math.round(paid_amount_tk)}/-</th>
							</tr>
							
							<tr>
								<td colspan="3" align="right">বকেয়া</td>
								<th style="text-align: right; " >৳ ${Math.round(res.sales_info.sell_payment_due)}/-</th>
							</tr>
						</table>
					</div>
					<div class="loan_paid_html_datas " > 
					${loan_paid_html}
					</div>`
				);

				$('.previous_payments_data_assign').html(
					`<table class="table">
						<tr>
							<td colspan="3" style="font-size: 25px; font-weight: bold; text-align: center; " > পূর্বের পরিশোধ তথ্য </td>
						</td>
						<tr>
							<th scope="col">তারিখ</th>
							<th scope="col">পরিমাণ</th>
							<th scope="col">টাকা</th>
						</tr>
						${payments_html_data}
					</table>`
				);

            }
        });
    }
});

$(document).on('keyup', '.qnty_kgss_p', function () {
	let kg_qnts = parseFloat($(this).val());
	let kgsss_per_bosta = parseFloat($('.paidable_amount_btn_data').attr('kg_per_bostasss'));
	$('.kg_qntys_cls').html(`পরিমাণ ${kg_qnts} কেজি`);
	$('.bosta_qnty_cls').html(`পরিমাণ ${kg_qnts/kgsss_per_bosta} বস্তা`);
});

$(document).on('keyup', '.qnty_bosta_ss', function () {
	let bosta_qnts = parseFloat($(this).val());
	let kgsss_per_bosta = parseFloat($('.paidable_amount_btn_data').attr('kg_per_bostasss'));
	$('.kg_qntys_cls').html(`পরিমাণ ${bosta_qnts*kgsss_per_bosta} কেজি `);
	$('.bosta_qnty_cls').html(`পরিমাণ ${bosta_qnts} বস্তা `);
});

$(document).on('click', '.paidable_amount_btn_data', function () {
	if(confirm("টাকা পরিশোধ করতে চান ? ")) {
		let clear_all_payments_check = 0;
		if ($('.clear_all_payments').is(":checked")) {
			clear_all_payments_check = 1;
		}

		$.ajax({
			type: "post",
			url: "expense/paid_sales_pre_due_amount",
			data: {
				payment_date: 		$('.purchase_payments_date').val(),
				ttl_payment_amnt: 	$('.total_amounts').val(),
				bosta_qnty: 		$('.qnty_bosta_ss').val(),
				qnty_kgs: 			$('.qnty_kgss_p').val(),
				ref_lot_no: 		$('.paidable_amount_btn_data').attr('ref_lot_no'), 
				sales_idds: 		$('.paidable_amount_btn_data').attr('sales_auto_idds'), 
				get_pur_id: 		$('.paidable_amount_btn_data').attr('pur_auto_id'), 
				get_item_id: 		$('.paidable_amount_btn_data').attr('pur_item_auto_id'), 
				get_pur_item_id: 	$('.paidable_amount_btn_data').attr('pur_item_auto_id'), 
				customer_id: 		$('.paidable_amount_btn_data').attr('customer_auto_id'), 
				clear_check: 		clear_all_payments_check,
			},
			success: function (rs) {
				if (rs == 1) {
					toastr["success"]("টাকা পরিশোধ হয়েছে। ");
					$('.products_select_data').html(``);
					$('.customers_data_assign_info').html(``);
					$('.previous_payments_data_assign').html(``);

				} else {
					toastr["error"]("কোথাও ভুল হয়েছে, চেক করুন। ");
				}
			}
		});

	}
});

$(document).on('click', '.save_income_btn', function () {
    if ($('.incomes_amounts').val() == '') {
        toastr["error"]("কোথাও ভুল হয়েছে, চেক করুন। ");
    } else {
        
        let full_date_s = new Date();
        let year_s = full_date_s.getFullYear();
        let month_s = ("0" + (full_date_s.getMonth() + 1)).slice(-2);
        let day_s = ("0" + (full_date_s.getDate() )).slice(-2);

        $.ajax({
            type: "post",
            url: "expense/new_incomes_entry",
            data: {
                income_date: $('.incomes_dates').val(),
                income_amnt: $('.incomes_amounts').val(),
                incomes_for: $('.incomes_for').val()
            },
            success: function (res) {
				toastr["success"]("ইনকামের টাকা এন্ট্রি হয়েছে। ");
                $('.incomes_dates').val(`${day_s}-${month_s}-${year_s}`);
                $('.incomes_amounts').val('');
                $('.incomes_for').val('');
            }
        });
    }
});




