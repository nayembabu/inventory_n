
//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent,target){

    if(kevent.keyCode==13){
		$("#"+target).focus();
    }
	
}


$('#save,#update').on("click",function (e) {
	var base_url=$("#base_url").val().trim();

    //Initially flag set true
    var flag=true;

    function check_field(id)
    {

      if(!$("#"+id).val().trim() ) //Also check Others????
        {

            $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
           // $('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }


   //Validate Input box or selection box should not be blank or empty
	  check_field("supplier_id");
    check_field("pur_date");
    check_field("purchase_status");
    //check_field("warehouse_id");
	/*if(!isNaN($("#amount").val().trim()) && parseFloat($("#amount").val().trim())==0){
        toastr["error"]("You have entered Payment Amount! <br>Please Select Payment Type!");
        return;
    }*/
	if(flag==false)
	{
		toastr["error"]("You have missed Something to Fillup!");
		return;
	}

	//Atleast one record must be added in purchase table 
    var rowcount=document.getElementById("hidden_rowcount").value;
	var flag1=false;
	for(var n=1;n<=rowcount;n++){
		if($("#td_data_"+n+"_3").val()!=null && $("#td_data_"+n+"_3").val()!=''){
			flag1=true;
		}	
	}
	
    if(flag1==false){
    	toastr["warning"]("Please Select Item!!");
        $("#item_search").focus();
		return;
    }
    //end

    var tot_subtotal_amt=$("#subtotal_amt").text();
    var other_charges_amt=$("#other_charges_amt").text();//other_charges include tax calcualated amount
    var tot_discount_to_all_amt=$("#discount_to_all_amt").text();
    var tot_round_off_amt=$("#round_off_amt").text();
    var tot_total_amt=$("#total_amt").text();

    var this_id=this.id;
    
			//if(confirm("Do You Wants to Save Record ?")){
				e.preventDefault();
				data = new FormData($('#purchase-form')[0]);//form name
        /*Check XSS Code*/
        if(!xss_validation(data)){ return false; }
        
        $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        $("#"+this_id).attr('disabled',true);  //Enable Save or Update button
				$.ajax({
				type: 'POST',
				url: base_url+'purchase/purchase_save_and_update?command='+this_id+'&rowcount='+rowcount+'&tot_subtotal_amt='+tot_subtotal_amt+'&tot_discount_to_all_amt='+tot_discount_to_all_amt+'&tot_round_off_amt='+tot_round_off_amt+'&tot_total_amt='+tot_total_amt+"&other_charges_amt="+other_charges_amt,
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				success: function(result){
         // alert(result);return;
				result=result.split("<<<###>>>");
					if(result[0]=="success")
					{
						location.href=base_url+"purchase/invoice/"+result[1];
					}
					else if(result[0]=="failed")
					{
					   toastr['error']("Sorry! Failed to save Record.Try again");
					}
					else
					{
						alert(result);
					}
					$("#"+this_id).attr('disabled',false);  //Enable Save or Update button
					$(".overlay").remove();

			   }
			   });
		//}
  
});
$('#item_search').keypress(function (e) {
 var key = e.which;
 // the enter key code
 if(key == 13){
    $("#item_search").autocomplete('search');
  }
});  


$("#item_search").bind("paste", function(e){
    $("#item_search").autocomplete('search');
} );
$("#item_search").autocomplete({
    source: function(data, cb){
        $.ajax({
          autoFocus:true,
            url: $("#base_url").val()+'items/get_json_items_details',
            method: 'GET',
            dataType: 'json',
            /*showHintOnFocus: true,
      autoSelect: true, 
      
      selectInitial :true,*/
      
            data: {
                name: data.term
            },
            success: function(res){
              //console.log(res);
                var result;
                result = [
                    {
                        //label: 'No Records Found '+data.term,
                        label: 'No Records Found ',
                        value: ''
                    }
                ];

                if (res.length) {
                    result = $.map(res, function(el){
                        return {
                            label: el.item_code +'--'+ el.label,
                            value: '',
                            id: el.id,
                            item_name: el.value,
                           // mobile: el.mobile,
                            //customer_dob: el.customer_dob,
                            //address: el.address,
                        };
                    });
                }

                cb(result);
            }
        });
    },

        response:function(e,ui){
          if(ui.content.length==1){
            $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
            $(this).autocomplete("close");
          }
          //console.log(ui.content[0].id);
        },

        //loader start
        search: function (e, ui) {
        },
        select: function (e, ui) { 
          
            //$("#mobile").val(ui.item.mobile)
            //$("#item_search").val(ui.item.value);
            //$("#customer_dob").val(ui.item.customer_dob)
            //$("#address").val(ui.item.address)
            //alert("id="+ui.item.id);
            if(typeof ui.content!='undefined'){
              console.log("Autoselected first");
              if(isNaN(ui.content[0].id)){
                return;
              }
              //var stock=ui.content[0].stock;
              var item_id=ui.content[0].id;
            }
            else{
              console.log("manual Selected");
              //var stock=ui.item.stock;
              var item_id=ui.item.id;
            }

            return_row_with_data(item_id);
            $("#item_search").val('');
        },   
        //loader end
});

function return_row_with_data(item_id){
  $("#item_search").addClass('ui-autocomplete-loader-center');
	var base_url=$("#base_url").val().trim();
	var rowcount=$("#hidden_rowcount").val();
	$.post(base_url+"purchase/return_row_with_data/"+rowcount+"/"+item_id,{},function(result){
        //alert(result);
        $('#purchase_table tbody').append(result);
       	$("#hidden_rowcount").val(parseFloat(rowcount)+1);
        success.currentTime = 0;
        success.play();
        enable_or_disable_item_discount();
        $("#item_search").removeClass('ui-autocomplete-loader-center');
    }); 
}
//INCREMENT ITEM
function increment_qty(rowcount){
  var item_qty=$("#td_data_"+rowcount+"_3").val();
  var available_qty=$("#tr_available_qty_"+rowcount+"_13").val();
  //if(parseFloat(item_qty)<parseFloat(available_qty)){
    item_qty=parseFloat(item_qty)+1;
    $("#td_data_"+rowcount+"_3").val(item_qty.toFixed(2));
  //}
  calculate_tax(rowcount);
}
//DECREMENT ITEM
function decrement_qty(rowcount){
  var item_qty=$("#td_data_"+rowcount+"_3").val();
  if(item_qty<=1){
    $("#td_data_"+rowcount+"_3").val((1).toFixed(2));
    return;
  }
  $("#td_data_"+rowcount+"_3").val((parseFloat(item_qty)-1).toFixed(2));
  calculate_tax(rowcount);
}

//CALCUALATED SALES PRICE
function calculate_sales_price(rowcount){
  var purchase_price = (isNaN(parseFloat($("#td_data_"+rowcount+"_10").val().trim()))) ? 0 :parseFloat($("#td_data_"+rowcount+"_10").val().trim()); 
  var profit_margin = (isNaN(parseFloat($("#td_data_"+rowcount+"_12").val().trim()))) ? 0 :parseFloat($("#td_data_"+rowcount+"_12").val().trim()); 
  var tax_type = $("#tax_type").val();
  var sales_price =parseFloat(0);
    sales_price = purchase_price + ((purchase_price*profit_margin)/parseFloat(100));
  $("#td_data_"+rowcount+"_13").val(sales_price.toFixed(2));
}
//END
//CALCULATE PROFIT MARGIN PERCENTAGE
function calculate_profit_margin(rowcount){
  var purchase_price = (isNaN(parseFloat($("#td_data_"+rowcount+"_10").val().trim()))) ? 0 :parseFloat($("#td_data_"+rowcount+"_10").val().trim()); 
  var sales_price = (isNaN(parseFloat($("#td_data_"+rowcount+"_13").val().trim()))) ? 0 :parseFloat($("#td_data_"+rowcount+"_13").val().trim());  
  var profit_margin = (sales_price-purchase_price);
  var profit_margin = (profit_margin/purchase_price)*parseFloat(100);
  $("#td_data_"+rowcount+"_12").val(profit_margin.toFixed(2));
}
//END

function update_paid_payment_total() {
  var rowcount=$("#paid_amt_tot").attr("data-rowcount");
  var tot=0;
  for(i=1;i<rowcount;i++){
    if(document.getElementById("paid_amt_"+i)){
      tot += parseFloat($("#paid_amt_"+i).html());
    }
  }
  $("#paid_amt_tot").html(tot.toFixed(2));
}
function delete_payment(payment_id){
 if(confirm("Do You Wants to Delete Record ?")){
    var base_url=$("#base_url").val().trim();
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
   $.post(base_url+"purchase/delete_payment",{payment_id:payment_id},function(result){
   //alert(result);return;
   result=result.trim();
     if(result=="success")
        {
          toastr["success"]("Record Deleted Successfully!");
          $("#payment_row_"+payment_id).remove();
          success.currentTime = 0; 
          success.play();
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
        update_paid_payment_total();
   });
   }//end confirmation   
  }

  //Delete Record start
function delete_purchase(q_id)
{
  
   if(confirm("Do You Wants to Delete Record ?")){
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $.post("purchase/delete_purchase",{q_id:q_id},function(result){
   //alert(result);return;
     if(result=="success")
        {
          toastr["success"]("Record Deleted Successfully!");
          $('#example2').DataTable().ajax.reload();
        }
        else if(result=="failed"){
          toastr["error"]("Failed to Delete .Try again!");
        }
        else{
           toastr["error"](result);
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
      data = new FormData($('#table_form')[0]);//form name
      /*Check XSS Code*/
      if(!xss_validation(data)){ return false; }
      
      $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
      $("#"+this_id).attr('disabled',true);  //Enable Save or Update button
      $.ajax({
      type: 'POST',
      url: 'purchase/multi_delete',
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

function pay_now(purchase_id){
  $.post('purchase/show_pay_now_modal', {purchase_id: purchase_id}, function(result) {
    $(".pay_now_modal").html('').html(result);
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
    format: 'dd-mm-yyyy',
     todayHighlight: true
    });
    $('#pay_now').modal('toggle');

  });
}
function view_payments(purchase_id){
  $.post('purchase/view_payments_modal', {purchase_id: purchase_id}, function(result) {
    $(".view_payments_modal").html('').html(result);
    $('#view_payments_modal').modal('toggle');
  });
}

function save_payment(purchase_id){
  var base_url=$("#base_url").val().trim();

    //Initially flag set true
    var flag=true;

    function check_field(id)
    {

      if(!$("#"+id).val().trim() ) //Also check Others????
        {

            $('#'+id+'_msg').fadeIn(200).show().html('Required Field').addClass('required');
           // $('#'+id).css({'background-color' : '#E8E2E9'});
            flag=false;
        }
        else
        {
             $('#'+id+'_msg').fadeOut(200).hide();
             //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
        }
    }


   //Validate Input box or selection box should not be blank or empty
    check_field("amount");
    check_field("payment_date");


    var payment_date=$("#payment_date").val().trim();
    var amount=$("#amount").val().trim();
    var payment_type=$("#payment_type").val().trim();
    var payment_note=$("#payment_note").val().trim();

    if(amount == 0){
      toastr["error"]("Please Enter Valid Amount!");
      return false; 
    }

    if(amount > parseFloat($("#due_amount_temp").html().trim())){
      toastr["error"]("Entered Amount Should not be Greater than Due Amount!");
      return false;
    }

    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
    $(".payment_save").attr('disabled',true);  //Enable Save or Update button
    $.post('purchase/save_payment', {purchase_id: purchase_id,payment_type:payment_type,amount:amount,payment_date:payment_date,payment_note:payment_note}, function(result) {
      result=result.trim();
  //alert(result);return;
        if(result=="success")
        {
          $('#pay_now').modal('toggle');
          toastr["success"]("Payment Recorded Successfully!");
          success.currentTime = 0; 
          success.play();
          $('#example2').DataTable().ajax.reload();
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
        $(".payment_save").attr('disabled',false);  //Enable Save or Update button
        $(".overlay").remove();
    });
}

function delete_purchase_payment(payment_id){
 if(confirm("Do You Wants to Delete Record ?")){
    var base_url=$("#base_url").val().trim();
    $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
   $.post(base_url+"purchase/delete_payment",{payment_id:payment_id},function(result){
   //alert(result);return;
   result=result.trim();
     if(result=="success")
        {
          $('#view_payments_modal').modal('toggle');
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
   });
   }//end confirmation   
  }

















  $(document).on('click', '.add_transport_profile', function () {
    $.ajax({
      type: "post",
      url: "purchase/save_new_transport_profile",
      data: {
        names: $('.trans_name').val(),
        mobile: $('.trans_mobile_no').val(),
        address: $('.transport_address').val(),
      },
      success: function (response) {
        location.reload();
      }
    });
  });
  
  $(document).on('click', '.add_supplier', function () { 
      $.ajax({
          type: 'POST',
          url: 'purchase/save_new_supplier',
          data: {
              sup_name:            $('.sup_supplier_name').val(),
              sup_mobile_no:       $('.sup_supplier_mobile_no').val(),
              sup_country:         $('.sup_supplier_country').val(),
              sup_city:            $('.sup_supplier_city').val(),
              sup_address:         $('.sup_supplier_address').val(),
          },
          success: function (res) {
              $('#supplier-modal').modal('hide');
              get_all_suppliers_info();
              $('.flshDataShow').html(`
                  <div class="alert alert-success alert-dismissable text-center">
                      <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>আমদানীকারক যোগ হয়েছে। </strong>
                  </div> 
              `);
              $('.flshDataShow').fadeOut('slow');
          }
      });
  });


  get_all_suppliers_info();
  function get_all_suppliers_info() {
      $.ajax({
          type: 'POST',
          url: 'purchase/get_suppliers_json',
          success: function (r) {
              let data_html = '';

              for (let n = 0; n < r.length; n++) {
                  data_html += `<option value="${r[n].id}">${r[n].supplier_name}</option>`;
              }
              $('#supplier_id').html(`<option value="">Select</option>${data_html}`);
          }
      });
  }

  $(document).on('change', '.selected_products_item', function () {
      if ($('.selected_products_item option:selected').val() == '') {                
          $('.buy_types_products_sys').html('');
          $('.account_form_assign_sys').html(``);
          $('.submit_btn_buy_sys').html(``);
      } else {
        $.ajax({
          type: "post",
          url: "purchase/get_products_by_id",
          data: {
            product_id: $(this).val()
          },
          success: function (rs) {
            $('.buy_types_products_sys').html(`<div class="input-group">
                          <span class="input-group-addon" title="Select Items"><i class="fa fa-check"></i></span>
                          <select class="form-control selected_products_types_system " unit_text="${rs.unit_name}" id="" name=""  style="width: 100%;">
                              <option value=""> সিলেক্ট করুন </option>
                              <option value="1"> ডাইরেক্ট ক্রয় </option>
                              <option value="2"> কমিশনে ক্রয় </option>
                          </select>
                      </div>`);  
            $('.account_form_assign_sys').html(``);
            $('.submit_btn_buy_sys').html(``);
          }
        });
      }
  });

  $(document).on('change', '.selected_products_types_system', function () {
    let unit_text = $(this).attr('unit_text');
      if ($('.selected_products_types_system option:selected').val() == 1) {                
          $('.account_form_assign_sys').html(`
                                              <div class="col-md-6 " style="margin-top: 10px; ">
                                                  <div class="input-group">
                                                      <span class="input-group-addon " style="font-size: 22px;" id="basic-addon1">এই গাড়িতে মোট মাল</span>
                                                      <input type="text" class="form-control total_items_this_transport " placeholder="পরিমাণ" style="text-align: right; font-size: 22px; font-weight: bold; height: 40px;  "   >
                                                      <span class="input-group-addon " style="font-size: 22px;">
                                                        ${unit_text}
                                                      </span>
                                                  </div> 
                                                  <div class="input-group" style="margin-top: 6px; ">
                                                      <span class="input-group-addon " style="font-size: 22px;" id="basic-addon1">মালের মোট কেজি </span>
                                                      <input type="text" class="form-control total_items_kgs_on_this_transport " placeholder="মোট কেজি" style="text-align: right; font-size: 22px; font-weight: bold; height: 40px;  "   >
                                                      <span class="input-group-addon " style="font-size: 22px;">
                                                        কেজি
                                                      </span>
                                                  </div> 
                                                  <center><h2> খরচের হিসাব </h2></center>
                                                  <div class="input-group">
                                                      <select class=" font20 transport_id_select " style="width: 100%;" >
                                                          <option value="">ট্রান্সপোর্ট সিলেক্ট করুন</option>
                                                          ${trans_port_for_loop}
                                                      </select>
                                                    <span class="input-group-addon pointer" data-toggle="modal" data-target="#transport-modal" title="New transport?"><i class="fa fa-user-plus text-primary fa-lg"></i></span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">ট্রান্সপোর্ট ভাড়া</span>
                                                      <input type="text" class="form-control font20 cost_of_transports " placeholder="পরিমাণ" style="text-align: right; "    >
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">ট্রান্সপোর্ট কমিশন </span> 
                                                      <input type="text" class="form-control  font20 com_cost_per_bosta " placeholder="প্রতি ${unit_text} খরচ" style="text-align: right; "    > 
                                                      <input type="text" readonly class="form-control col-md-6 font20 com_cost_totals " placeholder=" মোট কমিশন " style="text-align: right; "    > 
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div> 
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">রাস্তায় মাল নামছে </span> 
                                                      <input type="text" class="form-control  font20 rastay_namce_bosta " placeholder="কতো ${unit_text}" style="text-align: right; "    > 
                                                      <input type="text" readonly class="form-control col-md-6 font20 total_transport_bad_s " placeholder=" কমিশন বাদ গেছে " style="text-align: right; "    > 
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div> 
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">সর্বমোট কমিশন</span>
                                                      <input type="text" readonly class="form-control font20 intotal_commission_sss " placeholder="কমিশন সর্বমোট"  style="text-align: right; font-weight: bold; "   >
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">ঘর কুলি</span>
                                                      <input type="text" class="form-control font20 cost_of_ghar_kuli_per_bosta " placeholder="প্রতি ${unit_text} অনুযায়ী" style="text-align: right; "    >
                                                      <input type="text" class="form-control font20 cost_of_ghar_kuli " placeholder="পরিমাণ" style="text-align: right; "    >
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">ড্রাইভারের এডভান্স</span>
                                                      <input type="text" class="form-control font20 cost_of_drivar_advance " placeholder="পরিমাণ"  style="text-align: right; "   >
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">অন্যান্য খরচ</span>
                                                      <input type="text" class="form-control font20 others_total_cost_s " placeholder="পরিমাণ" style="text-align: right; "    >
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">হিসাব</span>
                                                      <div class="input-group " >
                                                        <span class="input-group-addon font20" id="basic-addon1">মোট দাম</span>
                                                        <input type="text" class="form-control font20 total_prices_of_this_transport_ss " placeholder="মোট দাম" style="text-align: right; "    >
                                                      </div>
                                                      <div class="input-group " >
                                                        <span class="input-group-addon font20" id="basic-addon1">ডিসকাউন্ট (-)</span>
                                                        <input type="text" class="form-control font20 discount_of_this_transport_tks " placeholder="ডিসকাউন্ট টাকা" style="text-align: right; "    >
                                                      </div>
                                                      <div class="input-group " >
                                                        <span class="input-group-addon font20" id="basic-addon1">কৈফয়ত (-)</span>
                                                        <input type="text" class="form-control font20 koifiyat_of_this_trnsprt " placeholder="কৈফয়ত টাকা (যদি থাকে)" style="text-align: right; "    >
                                                      </div>
                                                      <div class="input-group " >
                                                        <span class="input-group-addon font20" id="basic-addon1">জমা দিছেন</span>
                                                        <input type="text" class="form-control font20  paid_amount_of_this_transport_ss " placeholder="কতো টাকা জমা দিছেন" style="text-align: right; "    >
                                                      </div>
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px;  ">
                                                      <span class="input-group-addon font20" id="basic-addon1">মোট বকেয়া</span>
                                                      <input type="text" class="form-control font20  unpaid_amount_of_this_transport_suppliers " placeholder="পরিমাণ" style="text-align: right; font-weight: bold;  "    >
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">কৈফিয়ত বিবরণ</span>
                                                      <input type="text" class="form-control font20  koifiyat_description_this_transport " placeholder="বিস্তারিত বিবরণ" style=""    >
                                                  </div>

                                              </div> 




                                              
                                              <div class="col-md-6" style="margin-top: 45px;">
                                                <div class="all_hisab_data_assign " style="" >
                                                  <div class="data_assign_div_s" style="border: 2px solid black; border-radius: 5%; padding: 5px; " >
                                                    <center><h2> জমার হিসাব </h2></center>
                                                    <div class="input-group">
                                                        <span class="input-group-addon font20" id="basic-addon1">মালের বিবরণ</span>
                                                        <input type="text" class="form-control font20 description_of_items_pur items_descripton " placeholder="বিবরণ"  >
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon font20" id="basic-addon1">পরিমাণ</span>
                                                        <input type="text" class="form-control font20 buying_quantity_bosta buy_this_qnty " placeholder="পরিমাণ" style="text-align: right; "   >
                                                        <span class="input-group-addon font20">${unit_text}</span>
                                                    </div>
                                                    <div class="input-group " style="margin-top: 10px; ">
                                                        <span class="input-group-addon font20" id="basic-addon1">এক ${unit_text}তে কতো কেজি</span>
                                                        <input type="text" class="form-control font20 qnty_per_bosta  kg_qnty_pers " placeholder="পরিমাণ" style="text-align: right; "    >
                                                        <span class="input-group-addon font20">কেজি</span>
                                                    </div>
                                                    <div class="input-group " style="margin-top: 10px; ">
                                                        <span class="input-group-addon font20" id="basic-addon1">প্রতি কেজির দাম </span>
                                                        <input type="text" class="form-control font20 prices_per_kgs kgs_price " placeholder="পরিমাণ" style="text-align: right; "   >
                                                        <span class="input-group-addon font20">টাকা</span>
                                                    </div>
                                                    <div class="input-group " style="margin-top: 10px; ">
                                                        <span class="input-group-addon font20" id="basic-addon1">মোট দাম</span>
                                                        <input type="text" class="form-control font20 total_buyings_price_s total_buy_price " placeholder="পরিমাণ" style="text-align: right; "   >
                                                        <span class="input-group-addon font20">টাকা</span>
                                                    </div>
                                                    <div class="input-group " style="margin: 10px auto; text-align: center; ">
                                                      <div class="btn btn-primary btn-lg add_new_item_desc ">আরেকটা পন্য যোগ </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>`);
          $('.submit_btn_buy_sys').html(`<div class="btn btn-success btn-lg buy_this_type_btn " style="font-size: 40px; font-weight: bold; " > ক্রয় করুন </div>`);
      } else if ($('.selected_products_types_system option:selected').val() == 2) {
        let unit_text = $(this).attr('unit_text');
          $('.account_form_assign_sys').html(`
                                                <div class="col-md-6 " style="margin-top: 10px; ">
                                                  <div class="input-group">
                                                      <span class="input-group-addon " style="font-size: 22px;" id="basic-addon1">এই গাড়িতে মোট মাল</span>
                                                      <input type="text" class="form-control total_items_this_transport " placeholder="পরিমাণ" style="text-align: right; font-size: 22px; font-weight: bold; height: 40px;  "   >
                                                      <span class="input-group-addon " style="font-size: 22px;">
                                                        ${unit_text}
                                                      </span>
                                                  </div> 
                                                  <div class="input-group" style="margin-top: 6px; ">
                                                      <span class="input-group-addon " style="font-size: 22px;" id="basic-addon1">মালের মোট কেজি </span>
                                                      <input type="text" class="form-control total_items_kgs_on_this_transport " placeholder="মোট কেজি" style="text-align: right; font-size: 22px; font-weight: bold; height: 40px;  "   >
                                                      <span class="input-group-addon " style="font-size: 22px;">
                                                        কেজি
                                                      </span>
                                                  </div> 
                                                  <center><h2> খরচের হিসাব </h2></center>
                                                  <div class="input-group">
                                                      <select class=" font20 transport_id_select " style="width: 100%;" >
                                                          <option value="">ট্রান্সপোর্ট সিলেক্ট করুন</option>
                                                          ${trans_port_for_loop}
                                                      </select>
                                                    <span class="input-group-addon pointer" data-toggle="modal" data-target="#transport-modal" title="New transport?"><i class="fa fa-user-plus text-primary fa-lg"></i></span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">ট্রান্সপোর্ট ভাড়া</span>
                                                      <input type="text" class="form-control font20 cost_of_transports " placeholder="পরিমাণ" style="text-align: right; "    >
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">ট্রান্সপোর্ট কমিশন </span> 
                                                      <input type="text" class="form-control  font20 com_cost_per_bosta " placeholder="প্রতি ${unit_text} খরচ" style="text-align: right; "    > 
                                                      <input type="text" readonly class="form-control col-md-6 font20 com_cost_totals " placeholder=" মোট কমিশন " style="text-align: right; "    > 
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div> 
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">রাস্তায় মাল নামছে </span> 
                                                      <input type="text" class="form-control  font20 rastay_namce_bosta " placeholder="কতো ${unit_text}" style="text-align: right; "    > 
                                                      <input type="text" readonly class="form-control col-md-6 font20 total_transport_bad_s " placeholder=" কমিশন বাদ গেছে " style="text-align: right; "    > 
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div> 
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">সর্বমোট কমিশন</span>
                                                      <input type="text" readonly class="form-control font20 intotal_commission_sss " placeholder="কমিশন সর্বমোট"  style="text-align: right; font-weight: bold; "   >
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">ঘর কুলি</span>
                                                      <input type="text" class="form-control font20 cost_of_ghar_kuli_per_bosta " placeholder="প্রতি ${unit_text} অনুযায়ী" style="text-align: right; "    >
                                                      <input type="text" class="form-control font20 cost_of_ghar_kuli " placeholder="পরিমাণ" style="text-align: right; "    >
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">ড্রাইভারের এডভান্স</span>
                                                      <input type="text" class="form-control font20 cost_of_drivar_advance " placeholder="পরিমাণ"  style="text-align: right; "   >
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">অন্যান্য খরচ</span>
                                                      <input type="text" class="form-control font20 others_total_cost_s " placeholder="পরিমাণ" style="text-align: right; "    >
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">হিসাব</span>
                                                      <div class="input-group " >
                                                        <span class="input-group-addon font20" id="basic-addon1">মোট দাম</span>
                                                        <input type="text" class="form-control font20 total_prices_of_this_transport_ss " placeholder="মোট দাম" style="text-align: right; "    >
                                                      </div>
                                                      <div class="input-group " >
                                                        <span class="input-group-addon font20" id="basic-addon1">ডিসকাউন্ট (-)</span>
                                                        <input type="text" class="form-control font20 discount_of_this_transport_tks " placeholder="ডিসকাউন্ট টাকা" style="text-align: right; "    >
                                                      </div>
                                                      <div class="input-group " >
                                                        <span class="input-group-addon font20" id="basic-addon1">কৈফয়ত (-)</span>
                                                        <input type="text" class="form-control font20 koifiyat_of_this_trnsprt " placeholder="কৈফয়ত টাকা (যদি থাকে)" style="text-align: right; "    >
                                                      </div>
                                                      <div class="input-group " >
                                                        <span class="input-group-addon font20" id="basic-addon1">জমা দিছেন</span>
                                                        <input type="text" class="form-control font20  paid_amount_of_this_transport_ss " placeholder="কতো টাকা জমা দিছেন" style="text-align: right; "    >
                                                      </div>
                                                      <span class="input-group-addon font20">টাকা</span>
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">মোট বকেয়া</span>
                                                      <input type="text" class="form-control font20  unpaid_amount_of_this_transport_suppliers " placeholder="পরিমাণ" style="text-align: right; font-weight: bold;  "    >
                                                  </div>
                                                  <div class="input-group " style="margin-top: 10px; ">
                                                      <span class="input-group-addon font20" id="basic-addon1">কৈফিয়ত বিবরণ</span>
                                                      <input type="text" class="form-control font20  koifiyat_description_this_transport " placeholder="বিস্তারিত বিবরণ" style=""    >
                                                  </div>
                                              </div> 




                                              
                                              <div class="col-md-6" style="margin-top: 45px;">
                                                <div class="all_hisab_data_assign " style="" >
                                                  <div class="data_assign_div_s" style="border: 2px solid black; border-radius: 5%; padding: 5px; " >
                                                    <center><h2> জমার হিসাব </h2></center>
                                                    <div class="input-group">
                                                        <span class="input-group-addon font20" id="basic-addon1">মালের বিবরণ</span>
                                                        <input type="text" class="form-control font20 description_of_items_pur items_descripton" placeholder="বিবরণ"  >
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-addon font20" id="basic-addon1">পরিমাণ</span>
                                                        <input type="text" class="form-control font20 buying_quantity_bosta buy_this_qnty " placeholder="পরিমাণ" style="text-align: right; "   >
                                                        <span class="input-group-addon font20">${unit_text}</span>
                                                    </div>
                                                    <div class="input-group " style="margin-top: 10px; ">
                                                        <span class="input-group-addon font20" id="basic-addon1">এক ${unit_text}তে কতো কেজি</span>
                                                        <input type="text" class="form-control font20 qnty_per_bosta  kg_qnty_pers " placeholder="পরিমাণ" style="text-align: right; "    >
                                                        <span class="input-group-addon font20">কেজি</span>
                                                    </div>
                                                    <div class="input-group " style="margin-top: 10px; ">
                                                        <span class="input-group-addon font20" id="basic-addon1">প্রতি কেজির প্রস্তাবিত দাম </span>
                                                        <input type="text" class="form-control font20 prices_per_kgs kgs_price " placeholder="পরিমাণ" style="text-align: right; "   >
                                                        <span class="input-group-addon font20">টাকা</span>
                                                    </div>
                                                    <div class="input-group " style="margin-top: 10px; ">
                                                        <span class="input-group-addon font20" id="basic-addon1">মোট প্রস্তাবিত দাম</span>
                                                        <input type="text" class="form-control font20 total_buyings_price_s total_buy_price " placeholder="পরিমাণ" style="text-align: right; "   >
                                                        <span class="input-group-addon font20">টাকা</span>
                                                    </div>
                                                    <div class="input-group " style="margin: 10px auto; text-align: center; ">
                                                      <div class="btn btn-primary btn-lg add_new_item_desc ">আরেকটা পন্য যোগ </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                              `);
          $('.submit_btn_buy_sys').html(`<div class="btn btn-success btn-lg buy_this_type_btn " style="font-size: 40px; font-weight: bold; " > ক্রয় করুন </div>`);
      } else { 
          $('.buy_types_products_sys').html('');
          $('.account_form_assign_sys').html(``);
          $('.submit_btn_buy_sys').html(``);
      }
  });

  $(document).on('click', '.add_new_item_desc', function () {
    let unit_text = $('.selected_products_types_system').attr('unit_text');
    $('.all_hisab_data_assign').append(
                                        `<div class="data_assign_div_s" style="border: 2px solid black; border-radius: 5%; padding: 5px; margin-top: 5px; " >
                                          <center><h2> জমার হিসাব </h2></center>
                                          <div class="input-group">
                                              <span class="input-group-addon font20" id="basic-addon1">মালের বিবরণ</span>
                                              <input type="text" class="form-control font20 description_of_items_pur items_descripton " placeholder="বিবরণ"  >
                                          </div>
                                          <div class="input-group">
                                              <span class="input-group-addon font20" id="basic-addon1">পরিমাণ</span>
                                              <input type="text" class="form-control font20 buying_quantity_bosta buy_this_qnty " placeholder="পরিমাণ" style="text-align: right; "   >
                                              <span class="input-group-addon font20">${unit_text}</span>
                                          </div>
                                          <div class="input-group " style="margin-top: 10px; ">
                                              <span class="input-group-addon font20" id="basic-addon1">এক ${unit_text}তে কতো কেজি</span>
                                              <input type="text" class="form-control font20 qnty_per_bosta  kg_qnty_pers " placeholder="পরিমাণ" style="text-align: right; "    >
                                              <span class="input-group-addon font20">কেজি</span>
                                          </div>
                                          <div class="input-group " style="margin-top: 10px; ">
                                              <span class="input-group-addon font20" id="basic-addon1">প্রতি কেজির দাম </span>
                                              <input type="text" class="form-control font20 prices_per_kgs kgs_price " placeholder="পরিমাণ" style="text-align: right; "   >
                                              <span class="input-group-addon font20">টাকা</span>
                                          </div>
                                          <div class="input-group " style="margin-top: 10px; ">
                                              <span class="input-group-addon font20" id="basic-addon1">মোট দাম</span>
                                              <input type="text" class="form-control font20 total_buyings_price_s total_buy_price " placeholder="পরিমাণ" style="text-align: right; "   >
                                              <span class="input-group-addon font20">টাকা</span>
                                          </div>
                                          <div class="input-group " style="margin: 10px auto; text-align: center; ">
                                            <div class="btn btn-danger btn-lg delete_this_items_div ">এটা ডিলেট করুন</div>
                                          </div>
                                        </div>`);
  });

  $(document).on('keyup', '.total_buy_price, .kgs_price, .discount_of_this_transport_tks, .koifiyat_of_this_trnsprt, .paid_amount_of_this_transport_ss, .unpaid_amount_of_this_transport_suppliers ', function () {    
    let discount_amount;
    let koifiyat_amount;
    let paids_amount;
    if ($.isNumeric($('.discount_of_this_transport_tks').val())) {
      discount_amount = parseFloat($('.discount_of_this_transport_tks').val());
    } else {
      discount_amount = 0;
    }
    if ($.isNumeric($('.koifiyat_of_this_trnsprt').val())) {
      koifiyat_amount = parseFloat($('.koifiyat_of_this_trnsprt').val());
    } else {
      koifiyat_amount = 0;
    }
    if ($.isNumeric($('.paid_amount_of_this_transport_ss').val())) {
      paids_amount = parseFloat($('.paid_amount_of_this_transport_ss').val());
    } else {
      paids_amount = 0;
    }
    let cuttings_amount = discount_amount + koifiyat_amount + paids_amount;
    let sum_total = 0;
    $('.total_buy_price').each(function() {
      let bill_num = $(this).val();
      if ($.isNumeric(bill_num)) {
          sum_total += parseFloat(bill_num);
      }
    });
    let unpaids_amount = sum_total - cuttings_amount;
    $('.total_prices_of_this_transport_ss').val(sum_total);
    $('.unpaid_amount_of_this_transport_suppliers').val(unpaids_amount);
  });

  $(document).on('keyup', '.com_cost_per_bosta, .total_items_this_transport', function () {
    let total_items;
    let per_bosta;
    if ($('.total_items_this_transport').val() == '') {
      total_items = 0;
    }else {
      total_items = $('.total_items_this_transport').val();
    }
    if ($('.com_cost_per_bosta').val() == '') {
      per_bosta = 0;
    } else {
      per_bosta = $('.com_cost_per_bosta').val();
    }
    let total_commission = parseFloat(total_items) * parseFloat(per_bosta);
    $('.com_cost_totals').val(total_commission);
  });
  
  $(document).on('keyup', '.cost_of_ghar_kuli_per_bosta, .rastay_namce_bosta, .total_items_this_transport', function () {
    let total_items;
    let per_bosta;
    let rastay_namche_bosta_bad;
    let com_cost_per_bosta;

    if ($('.com_cost_per_bosta').val() == '') {
      com_cost_per_bosta = 0;
    } else {
      com_cost_per_bosta = $('.com_cost_per_bosta').val();
    } 
    if ($('.total_items_this_transport').val() == '') {
      total_items = 0;
    }else {
      total_items = $('.total_items_this_transport').val();
    }
    if ($('.cost_of_ghar_kuli_per_bosta').val() == '') {
      per_bosta = 0;
    } else {
      per_bosta = $('.cost_of_ghar_kuli_per_bosta').val();
    }
    if ($('.rastay_namce_bosta').val() == '') {
      rastay_namche_bosta_bad = 0;
    } else {
      rastay_namche_bosta_bad = $('.rastay_namce_bosta').val();
    }
    let total_transport = $('.com_cost_totals').val();
    $('.cost_of_ghar_kuli').val((parseFloat(total_items)-parseFloat(rastay_namche_bosta_bad))*parseFloat(per_bosta));
    $('.total_transport_bad_s').val(parseFloat(rastay_namche_bosta_bad)*parseFloat(com_cost_per_bosta));

    $('.intotal_commission_sss').val(total_transport - (parseFloat(rastay_namche_bosta_bad)*parseFloat(com_cost_per_bosta)));
  });

  $(document).on('click', '.delete_this_items_div', function () {
    $(this).parents('.data_assign_div_s').remove();
  });

  $(document).on('keyup', '.prostabito_rate_per_kgs', function () {
    let rate_per_kgs = $(this).val();
    let qnty_per_bosta = $('.qnty_per_bosta').val();
    let total_buying_qnt_bosta = $('.buying_quantity_bosta').val();

    if ($.isNumeric(rate_per_kgs)) {
      rate_per_kgs = parseFloat($(this).val());
    }else {
      rate_per_kgs = 0;
    }
    if ($.isNumeric(qnty_per_bosta)) {
      qnty_per_bosta = parseFloat($('.qnty_per_bosta').val());
    }else {
      qnty_per_bosta = 0;
    }
    if ($.isNumeric(total_buying_qnt_bosta)) {
      total_buying_qnt_bosta = parseFloat($('.buying_quantity_bosta').val());
    }else {
      total_buying_qnt_bosta = 0;
    }
    let total_price_buy = rate_per_kgs*qnty_per_bosta*total_buying_qnt_bosta;
    $('.prices_per_kgs').val(0);
    $('.total_buyings_price_s').val(total_price_buy);
  });
  
  $(document).on('keyup', '.prices_per_kgs, .buying_quantity_bosta, .qnty_per_bosta', function () {
    let price_per_kg;
    let qnty_per_bosta;
    let total_quantity_bosta;
    if ($(this).parents('.data_assign_div_s').find('.buying_quantity_bosta').val() == '') {
      total_quantity_bosta = 0;
    } else { 
      total_quantity_bosta = parseFloat($(this).parents('.data_assign_div_s').find('.buying_quantity_bosta').val());
    }
    if ($(this).parents('.data_assign_div_s').find('.prices_per_kgs').val() == '') {
      price_per_kg = 0;
    } else {
      price_per_kg = parseFloat($(this).parents('.data_assign_div_s').find('.prices_per_kgs').val());
    }
    if ($(this).parents('.data_assign_div_s').find('.qnty_per_bosta').val() == '') {
      qnty_per_bosta = 0;
    } else { 
      qnty_per_bosta = parseFloat($(this).parents('.data_assign_div_s').find('.qnty_per_bosta').val());
    }
    let results_total_buy = total_quantity_bosta * price_per_kg * qnty_per_bosta;
    if (isNaN(results_total_buy)) {
      $(this).parents('.data_assign_div_s').find('.total_buyings_price_s').val('');
    } else {
      $(this).parents('.data_assign_div_s').find('.total_buyings_price_s').val(results_total_buy);
    }
  }); 
 
  $(document).on('keyup', '.total_buyings_price_s, .buying_quantity_bosta, .qnty_per_bosta', function () {
    let total_buying_price;
    let qnty_per_bosta;
    let total_quantity_bosta;
    if ($.isNumeric($(this).parents('.data_assign_div_s').find('.buying_quantity_bosta').val())) {
      total_quantity_bosta = parseFloat($(this).parents('.data_assign_div_s').find('.buying_quantity_bosta').val());
    } else { 
      total_quantity_bosta = 0;
    }
    if ($.isNumeric($(this).parents('.data_assign_div_s').find('.total_buyings_price_s').val())) {
      total_buying_price = parseFloat($(this).parents('.data_assign_div_s').find('.total_buyings_price_s').val());
    } else {
      total_buying_price = 0;
    }
    if ($.isNumeric($(this).parents('.data_assign_div_s').find('.qnty_per_bosta').val())) {
      qnty_per_bosta = parseFloat($(this).parents('.data_assign_div_s').find('.qnty_per_bosta').val());
    } else { 
      qnty_per_bosta = 0;
    }
    let results_per_kg_price = total_buying_price / (total_quantity_bosta * qnty_per_bosta);
    if (isNaN(results_per_kg_price)) {
      $(this).parents('.data_assign_div_s').find('.prices_per_kgs').val(''); 
    } else {
      $(this).parents('.data_assign_div_s').find('.prices_per_kgs').val(results_per_kg_price); 
    }
  });

  $(document).on('click', '.buy_this_type_btn', function () { 
      if(confirm("আপনি কি ক্রয় করতে চান ? ")) {

          $.ajax({
              type: "POST",
              url: "buy_all_types_products",
              data: {
                'items_desc[]':           $('.items_descripton').map(function(){ return this.value; }).get(),
                'this_lot_qnty[]':        $('.buy_this_qnty').map(function(){ return this.value; }).get(),
                'kg_qnty_per_bosta[]':    $('.kg_qnty_pers').map(function(){ return this.value; }).get(),
                'price_per_kg[]':         $('.kgs_price').map(function(){ return this.value; }).get(),
                'total_buy_price[]':      $('.total_buy_price').map(function(){ return this.value; }).get(),
                'supplier_id':            $('.supplier_list_select option:selected').val(), 
                'pur_date':               $('.pur_date_select').val(), 
                'lots_nos':               $('.type_lot_nosss').val(), 
                'pur_status':             $('.purchases_status_selected option:selected').val(), 
                'product_select':         $('.selected_products_item option:selected').val(), 
                'buying_system':          $('.selected_products_types_system option:selected').val(), 
                'ttl_item_this_trns':     $('.total_items_this_transport').val(), 
                'ttl_item_kg_this_trns':  $('.total_items_kgs_on_this_transport').val(), 
                'transport_id':           $('.transport_id_select option:selected').val(), 
                'cost_of_transport':      $('.cost_of_transports').val(), 
                'trns_com_per_bosta':     $('.com_cost_per_bosta').val(), 
                'ttl_trns_com':           $('.com_cost_totals').val(), 
                'prodct_sell_road':       $('.rastay_namce_bosta').val(), 
                'trns_com_cutting':       $('.total_transport_bad_s').val(), 
                'ttl_com_for_trns':       $('.intotal_commission_sss').val(), 
                'ghar_kuli_per_bosta':    $('.cost_of_ghar_kuli_per_bosta').val(), 
                'cost_of_ghar_kuli':      $('.cost_of_ghar_kuli').val(), 
                'driver_advance':         $('.cost_of_drivar_advance').val(), 
                'others_cost':            $('.others_total_cost_s').val(),
                'total_trns_price':       $('.total_prices_of_this_transport_ss').val(), 
                'discount':               $('.discount_of_this_transport_tks').val(), 
                'paid_amount':            $('.paid_amount_of_this_transport_ss').val(), 
                'unpaid_amount_tk':       $('.unpaid_amount_of_this_transport_suppliers').val(), 
                'koifiyat_amount_tk':     $('.koifiyat_of_this_trnsprt').val(), 
                'kofiyat_desc':           $('.koifiyat_description_this_transport').val(), 
              },
              success: function (res) {
                if (res == 1) {
                  toastr["error"]("আপনার কোথাও ভুল হচ্ছে, চেক করুন। ");                  
                } else {

                  if ($('.rastay_namce_bosta').val() == '' || $('.rastay_namce_bosta').val() == 0) {
                    $('.account_form_assign_sys').html(``);
                  } else {
                    $('.account_form_assign_sys').html(`<a href="sales/add_rasta?trans_id=${res}" class=" btn btn-primary btn-lg " style="font-size: 40px; font-weight: bold; " > ক্রয় করুন </a>`);
                  }

                  $('.buy_types_products_sys').html(``);
                  $('.submit_btn_buy_sys').html(``);
                  $('type_lot_nosss').val('');
                  toastr["success"]("আপনার ক্রয় সফল হয়েছে। ");                  
                }
              }
          });
      }else {
        return false;
      } 

  });



