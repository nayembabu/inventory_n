
/*Email validation code end*/
$('#save').on("click",function (e) {
	// var base_url=$("#base_url").val().trim();
    /*Initially flag set true*/
    var flag=true;

    function check_field(id)
    { 

      if(!$("#"+id).val().trim() ) //Also check Others????
        {
            $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
            //$('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }

    // Validate Input box or selection box should not be blank or empty
	check_field("expense_date");
	check_field("expense_for");
	check_field("expense_amt");

	if(flag==false)
    {
		toastr["warning"]("You have Missed Something to Fillup!")
		return;
    }

    var this_id=this.id;

    if(this_id=="save")  //Save start
    {

					if(confirm("Do You Wants to Save Record ?")){
						e.preventDefault();
						data = new FormData($('#expense-form')[0]);//form name
						/*Check XSS Code*/
						if(!xss_validation(data)){ return false; }
						
						$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
						$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
						$.ajax({
						type: 'POST',
						url: 'newexpense',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result){

							window.location="add";
							return;
							$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
							$(".overlay").remove();

					   }
					});
				}

				//e.preventDefault


    }//Save end
	
	else if(this_id=="update")  //Update start
    {
							
					if(confirm("Do You Wants to Save Record ?")){
						e.preventDefault();
						data = new FormData($('#expense-form')[0]);//form name
						/*Check XSS Code*/
						if(!xss_validation(data)){ return false; }
						
						$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
						$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
						$.ajax({
						type: 'POST',
						url: base_url+'expense/update_expense',
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result){
              //alert(result);return;
              			result=result.trim();
							if(result=="success")
							{
								//toastr["success"]("Record Updated Successfully!");
								window.location=base_url+"expense";
							}
							else if(result=="failed")
							{
							   toastr["error"]("Sorry! Failed to save Record.Try again!");
							}
							else
							{
								 toastr["error"](result);
							}
							$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
							$(".overlay").remove();
							return;
					   }
					   });
				}

				//e.preventDefault


    }//Save end
	

});


//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent,target){

    if(kevent.keyCode==13){
		$("#"+target).focus();
    }
	
}

//update status start
function update_status(id,status)
{
	
	$.post("expense/update_status",{id:id,status:status},function(result){
		if(result=="success")
				{
				  toastr["success"]("Record Updated Successfully!");
				  success.currentTime = 0; 
				  success.play();
				  if(status==0)
				  {
					  status="Inactive";
					  var span_class="label label-danger";
					  $("#span_"+id).attr('onclick','update_status('+id+',1)');
				  }
				  else{
					  status="Active";
					   var span_class="label label-success";
					   $("#span_"+id).attr('onclick','update_status('+id+',0)');
					  }

				  $("#span_"+id).attr('class',span_class);
				  $("#span_"+id).html(status);
				}
				else if(result=="failed"){
				  toastr["error"]("Failed to Update Status.Try again!");
				  failed.currentTime = 0; 
				  failed.play();
				}
				else{
				  toastr["error"](result);
				  failed.currentTime = 0; 
				  failed.play();
				}
				return false;
	});
}
//update status end


//Delete Record start
function delete_expense(q_id)
{
	
   if(confirm("Do You Wants to Delete Record ?")){
   	$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
   $.post("expense/delete_expense",{q_id:q_id},function(result){
   //alert(result);return;
   result=result.trim();
	   if(result=="success")
				{
				  toastr["success"]("Record Deleted Successfully!");
				  success.currentTime = 0; 
				  success.play();
				  $('#example2').DataTable().ajax.reload();
				}
				else if(result=="failed"){
				  toastr["error"]("Failed to Delete .Try again!");
				  failed.currentTime = 0; 
				  failed.play();
				}
				else{
				  toastr["error"](result);
				  failed.currentTime = 0; 
				  failed.play();
				}
				$(".overlay").remove();
				return false;
   });
   }//end confirmation
}
//Delete Record end
function multi_delete(){
	//var base_url=$("#base_url").val().trim();
    var this_id=this.id;
    
		if(confirm("Are you sure ?")){
			$(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
			$("#"+this_id).attr('disabled',true);  //Enable Save or Update button
			
			data = new FormData($('#table_form')[0]);//form name
			$.ajax({
			type: 'POST',
			url: 'expense/multi_delete_expense',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			success: function(result){
				result=result.trim();
  //alert(result);return;
				if(result=="success")
				{
					toastr["success"]("Record Deleted Successfully!");
					success.currentTime = 0; 
				  	success.play();
					$('#example2').DataTable().ajax.reload();
					$(".delete_btn").hide();
					$(".group_check").prop("checked",false).iCheck('update');
				}
				else if(result=="failed")
				{
				   toastr["error"]("Sorry! Failed to save Record.Try again!");
				   failed.currentTime = 0; 
				   failed.play();
				}
				else
				{
					toastr["error"](result);
					failed.currentTime = 0; 
				  	failed.play();
				}
				$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
				$(".overlay").remove();
		   }
		   });
	}
	//e.preventDefault
}

$(document).on('change', '.select_supplier_id', function () { 
	let supplier_id = $(this).val(); 
	if (supplier_id != '') {
		$.ajax({
			type: "post",
			url: 'expense/get_product_item_by_supplier_id',
			data: {
				s_id: supplier_id
			},
			success: function (res) {
				let opt_html_data = '';
				for (let l = 0; l < res.pur_item.length; l++) {
					opt_html_data += `<option value="${res.pur_item[l].id}">${res.pur_item[l].item_name} - ${res.pur_item[l].ref_lot_no}</option>`;
				}
				$('.products_select_data').html(
					`<select class="products_option_selection" style="width: 100%; font-size: 20px; " >
                        <option value="">সিলেক্ট করুন</option>
						${opt_html_data}
                      </select>`
				);
				$('.supplier_data_assign_info').html(``);
				$('.previous_payments__datas_assigns').html(``);
			}
		})
	}
})

$(document).on('change', '.products_option_selection', function () { 
	let purchase_item_id_id = $(this).val();
	if (purchase_item_id_id != '') {
		$.ajax({
			type: "post",
			url: 'expense/get_purchase_item_full_infos_unpaid_amount',
			data: {
				p_i_id: purchase_item_id_id
			},
			success: function (res) {
				let full_date = new Date();
				let year = full_date.getFullYear();
				let month = ("0" + (full_date.getMonth() + 1)).slice(-2);
				let day = full_date.getDate();
				let payments_html_data = '';
				let loan_paid_html = ``;
				let purchase_typesss = '';

				if (res.purchase_item_info.total_due_payments >= 0) {
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
									<span class="input-group-addon">পরিশোধ টাকা</span>
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
							<center><div class="btn btn-success btn-lg paidable_amount_btn_data " supp_auto_id="${res.purchase_item_info.supplyer_id_a_pr}" item_auto_id="${res.purchase_item_info.item_id}" pur_auto_id="${res.purchase_item_info.purchase_id}" ref_lot_no="${res.purchase_item_info.ref_lot_no}" pur_item_auto_id="${res.purchase_item_info.id}" kg_per_bostasss="${res.purchase_item_info.pur_kg_per_bosta}" price_per_kgs_ss="${res.purchase_item_info.price_per_unit}" total_dues_amnt_now="${res.purchase_item_info.total_due_payments}" style="margin-top: 20px; font-weight: bold; " > পরিশোধ করুন </div></center>
						</div>`;
				}

				if (res.purchase_payments == '') {
					payments_html_data = `<tr>
												<td colspan="3" style="text-align: center; "> আগে পরিশোধ করা হয় নাই </td>
											</tr>`
				} else {
					for (let m = 0; m < res.purchase_payments.length; m++) {

						let full_date_s = new Date(res.purchase_payments[m].payment_date);
						let year_s = full_date_s.getFullYear();
						let month_s = ("0" + (full_date_s.getMonth() + 1)).slice(-2);
						let day_s = full_date_s.getDate();

						payments_html_data += 	`<tr>
													<td >${day_s}-${month_s}-${year_s}</td>
													<td > ${res.purchase_payments[m].payments_bosta_qnt_s} বস্তা --- ${res.purchase_payments[m].payments_kgs_qnt} কেজি </td>
													<th >৳ ${res.purchase_payments[m].payment}/-</th>
												</tr>`;
					} 
				}

				purchase_typesss = 'ডাইরেক্ট ক্রয়';
				$('.supplier_data_assign_info').html(
					`<div class="">
						<table class="table">
							<tr>
								<th scope="col">নাম</th>
								<th scope="col">মোবাইল</th>
								<th scope="col">ঠিকানা</th>
							</tr>
							<tr>
								<td>${res.purchase_item_info.supplier_name}</td>
								<td>${res.purchase_item_info.mobile}</td>
								<td>${res.purchase_item_info.address}</td>
							</tr>
							<tr>
								<th scope="col">কেনার তারিখ</th>
								<th scope="col">লট নং</th>
							</tr>
							<tr>
								<td>${res.purchase_item_info.purchase_date}</td>
								<td>${res.purchase_item_info.reference_no}</td>
							</tr>
						</table>
						<table class="table">
							<tr>
								<th>ক্রয়কৃত পণ্য</th>
								<th>${res.purchase_item_info.item_name}</th>
								<td>মোট দাম</td>
								<th style="text-align: right; ">৳ ${res.purchase_item_info.pur_total_price}/-</th>
							</tr>
							
							<tr>
								<td colspan="3" align="right">বকেয়া</td>
								<th style="text-align: right; " >৳ ${res.purchase_item_info.total_due_payments}/-</th>
							</tr>
						</table>
					</div>
					<div class="loan_paid_html_datas " > 
					${loan_paid_html}
					</div>`
				);

				$('.previous_payments__datas_assigns').html(
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

$(document).on('keyup', '.total_amounts', function () {
	let now_type_amount = parseFloat($(this).val());
	let due_total_amnts = parseFloat($('.paidable_amount_btn_data').attr('total_dues_amnt_now'));

	if (due_total_amnts < now_type_amount) {
		alert('অতিরিক্ত পরিশোধ করতেছেন। ');
		$('.total_amounts').val(``);
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
			url: "expense/paid_previous_due_amount_s",
			data: {
				payment_date: 		$('.purchase_payments_date').val(),
				ttl_payment_amnt: 	$('.total_amounts').val(),
				bosta_qnty: 		$('.qnty_bosta_ss').val(),
				qnty_kgs: 			$('.qnty_kgss_p').val(),
				ref_lot_no: 		$('.paidable_amount_btn_data').attr('ref_lot_no'), 
				get_pur_id: 		$('.paidable_amount_btn_data').attr('pur_auto_id'), 
				get_item_id: 		$('.paidable_amount_btn_data').attr('pur_item_auto_id'), 
				get_pur_item_id: 	$('.paidable_amount_btn_data').attr('pur_item_auto_id'), 
				supp_id: 			$('.paidable_amount_btn_data').attr('supp_auto_id'), 
				clear_check: 		clear_all_payments_check,
			},
			success: function (rs) {
				if (rs == 1) {
					toastr["success"]("টাকা পরিশোধ করা হয়েছে। ");
					$('.products_select_data').html(``);
					$('.supplier_data_assign_info').html(``);
					$('.previous_payments__datas_assigns').html(``);
				} else {
					toastr["error"]("কোথাও ভুল হয়েছে, চেক করুন। ");
				}
			}
		});

	}
});





