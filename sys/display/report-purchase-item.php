<!DOCTYPE html>
<html>
<head>
  <base href="<?php echo base_url(); ?>" target="">
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- </copy> -->  
 <style>
  .text_centers {
    text-align: center
  }
  .text_rights {
    text-align: right;
  }
 </style>

</head>
<body class="hold-transition skin-blue sidebar-mini">


<div class="wrapper">
 
 <?php include"sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$page_title;?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Please Enter Valid Information</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" id="report-form" onkeypress="return event.keyCode != 13;">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" id="base_url" value="<?=base_url()?>">
              <div class="box-body">
              <div class="form-group">
              <label for="from_date" class="col-sm-2 control-label"><?= $this->lang->line('from_date'); ?></label>
                 
          <div class="col-sm-3">
            <div class="input-group date">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right datepicker" id="from_date" name="from_date" value="<?php echo show_date(date('d-m-Y'));?>" >
              
            </div>
            <span id="purchase_date_msg" style="display:none" class="text-danger"></span>
          </div>
          <label for="to_date" class="col-sm-2 control-label"><?= $this->lang->line('to_date'); ?></label>
                   <div class="col-sm-3">
            <div class="input-group date">
              <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right datepicker" id="to_date" name="to_date" value="<?php echo show_date(date('d-m-Y'))?>" >
              
            </div>
            <span id="purchase_date_msg" style="display:none" class="text-danger"></span>
          </div>
        
                </div> 
                  <div class="form-group">
                    <label for="item_id" class="col-sm-2 control-label"><?= $this->lang->line('item_name'); ?></label>
                    <div class="col-sm-3">
                    <select class="form-control select2 " id="item_id" name="item_id">
                    </select>
                    <span id="item_id_msg" style="display:none" class="text-danger"></span>
                  </div>
          
                </div>
              </div>
              <!-- /.box-body -->
        
              <div class="box-footer">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                   <div class="col-md-3 col-md-offset-3">
                      <button type="button" id="view" class=" btn btn-block btn-success btn-lg " title="Save Data">Show</button>
                   </div>
                </div>
             </div>
             <!-- /.box-footer -->

             
            </form>
          </div>
          <!-- /.box -->
          
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
                ক্রয়কৃত পন্যের লিস্ট সিলেক্ট করুন  
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding " >
              <div class="nav-tabs-custom ref_assign_nav_data" ></div>
              <div class="purchase_history_with_sells " ></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
  </div>
  <!-- /.content-wrapper -->
  
 <?php include"footer.php"; ?>

 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- TABLES CODE -->
<?php include"comman/code_js_form.php"; ?>
<!-- TABLE EXPORT CODE -->
<?php include"comman/code_js_export.php"; ?>


<script src="<?php echo $theme_link; ?>js/ajaxselect/item_select_ajax.js"></script>  
<script>
   //Item Selection Box Search
   function getItemSelectionId() {
     return '#item_id';
   }
   //Item Selection Box Search - END
</script>

<script>
  $("#view,#view_all").on("click",function(){
    var base_url = $("#base_url").val();

    var from_date=document.getElementById("from_date").value.trim();
    var to_date=document.getElementById("to_date").value.trim();
    var item_id=document.getElementById("item_id").value.trim();
    if(from_date == "")
        {
            toastr["warning"]("Select From Date!");
            document.getElementById("from_date").focus();
            return;
        }

     if(to_date == "")
        {
            toastr["warning"]("Select To Date!");
            document.getElementById("to_date").focus();
            return;
        }

     if(item_id == "")
        {
            toastr["warning"]("Select Item!");
            document.getElementById("item_id").focus();
            return;
        }




        if(this.id=="view_all"){
          var view_all='yes';
        }
        else{
          var view_all='no';
        }

        $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

        /*
          $.post(base_url+"reports/show_item_purchase_report",{item_id:item_id,view_all:view_all,from_date:from_date,to_date:to_date},function(result){
          //alert(result);
            setTimeout(function() {
             $("#tbodyid").empty().append(result);     
             $(".overlay").remove();
            }, 0);
          }); 
        */

        $.ajax({
          type: "post",
          url: "reports/show_purchase_items_reports",
          data: {
            sdate: from_date,
            edate: to_date,
            itemid: item_id
          },
          success: function (res) { 
            $(".overlay").remove();
            let ref_data_s = '';
            for (let n = 0; n < res.length; n++) {
              ref_data_s += `<li>
                              <a class="clickable_item_id" href="#tab_1" data-toggle="tab" purchases_ids="${res[n].purchase_id}" purchases_item_ids="${res[n].id}">
                                ${res[n].supplier_name} - ${res[n].ref_lot_no} 
                              </a>
                            </li>`;
            } 

            $('.ref_assign_nav_data').html(
              `<ul class="nav nav-tabs bg-gray text-bold font-italic">${ref_data_s}</ul>`
            );

          }
        });
});


$(document).on('click', '.clickable_item_id', function () {  
  $('.purchase_history_with_sells').html('');
  let purchase_item_id = $(this).attr('purchases_item_ids');   
  let purchase_id = $(this).attr('purchases_ids');   
  $.ajax({
    type: "post",
    url: "reports/get_buy_sell_history",
    data: {
      p_i_id: purchase_item_id,
      p_id: purchase_id
    },
    success: function (res) {
      let typesss = '';
      let total_costs = parseFloat(res.purchase_cost_history.transport_cost) + parseFloat(res.purchase_cost_history.arot_cost) + parseFloat(res.purchase_cost_history.tohuri_cost) + parseFloat(res.purchase_cost_history.ghar_kuli_cost) + parseFloat(res.purchase_cost_history.other_total_cost);
      if (res.purchase_item.buying_type_status == 1) {
        typesss = `ডাইরেক্ট ক্রয়`;
      }else if (res.purchase_item.buying_type_status == 2) {
        typesss = `কমিশনে ক্রয়`;
      }
      let purchase_payment_s = '';
      for (let n = 0; n < res.purchase_paymentss.length; n++) {
        purchase_payment_s += `<tr>
                                <td>${res.purchase_paymentss[n].payment_date}</td>
                                <td class="text_rights  " >${res.purchase_paymentss[n].payment}</td>
                              </tr>`
      }
      let sel_history_data = '';
      for (let l = 0; l < res.sell_historyss.length; l++) {
        sel_history_data += `<tr>
                              <th style="font-size: 16px;" >${res.sell_historyss[l].customer_name}</th>
                              <th style="font-size: 16px;" class="text_rights  " > ${parseInt(res.sell_historyss[l].sell_ing_qnty_total)} ${res.purchase_item.unit_name} (${parseInt(res.sell_historyss[l].total_sell_price_s)} টাকা) </th>
                            </tr>
                            <tr>
                              <td style="text-align: right; " >বকেয়া </td>
                              <td class="text_rights  " >${parseInt(res.sell_historyss[l].sell_payment_due)} টাকা</td>
                            </tr>`;
      }
      $('.purchase_history_with_sells').html(
        `<div class="col-md-6 ">
            <table class="table" >
              <tr>
                <th colspan="2" class="text_centers " style="font-size: 20px;" ><span>${res.purchase_item.supplier_name}</span> (${typesss}) </th>
              </tr>
              <tr>
                <td>মোট পরিমাণ</td>
                <td class="text_rights " >${res.purchase_item.purchase_total_bosta} ${res.purchase_item.unit_name}</td>
              </tr>
              <tr>
                <td colspan="2" class="text_centers " > খরচের হিসাব </td>
              </tr>
              <tr>
                <td>পরিবহন খরচ</td>
                <td class="text_rights  " style="padding-right: 20px; " >${res.purchase_cost_history.transport_cost}</td>
              </tr>
              <tr>
                <td>আড়ৎ খরচ</td>
                <td class="text_rights  " style="padding-right: 20px; " >${res.purchase_cost_history.arot_cost}</td>
              </tr>
              <tr>
                <td>তহুরী খরচ</td>
                <td class="text_rights  " style="padding-right: 20px; " >${res.purchase_cost_history.tohuri_cost}</td>
              </tr>
              <tr>
                <td>ঘর কুলী খরচ</td>
                <td class="text_rights  " style="padding-right: 20px; " >${res.purchase_cost_history.ghar_kuli_cost}</td>
              </tr>
              <tr>
                <td>অন্যান্য খরচ</td>
                <td class="text_rights  " style="padding-right: 20px; " >${res.purchase_cost_history.other_total_cost}</td>
              </tr>
              <tr>
                <td>মোট খরচ</td>
                <th class="text_rights  " style="padding-right: 20px; " >${total_costs}</th>
              </tr>
              <tr>
                <td>মোট দাম</td>
                <th class="text_rights  "  style="font-size: 16px; " >${res.purchase_item.pur_total_price}</th>
              </tr>
              ${purchase_payment_s}
              <tr>
                <td>বকেয়া দেনা টাকা</td>
                <td class="text_rights  " >${res.purchase_item.total_due_payments}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6 ">
            <div></div>
            <table class="table">
              ${sel_history_data}
            </table>
          </div>`
      );      
    }
  });

});


</script>

<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>


</body>
</html>
