<!DOCTYPE html>
<html>
<head>
   <base href="<?php echo base_url(); ?>" target="">
   <!-- TABLES CSS CODE -->
   <?php include"comman/code_css_form.php"; ?>
   <!-- </copy> -->  
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
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <section class="content">
      <div class="row" >

         <div class="col-md-12">
            <div class="box box-primary">
               <div class="box-body table-responsive no-padding">
                  <div class="form-group col-md-4">
                     <label for="to_date">শুরু তারিখ</label>                  
                     <div class="col-sm-12">
                        <div class="input-group date">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                           <input type="text" class="form-control pull-right datepicker  star_date_select "  id="pur_date" name="pur_date" readonly onkeyup="shift_cursor(event,'purchase_status')" value="<?= date('d-m-Y');?>">
                        </div>
                        <span id="pur_date_msg" style="display:none" class="text-danger"></span>
                     </div>
                  </div>
                  <div class="form-group col-md-4">
                     <label for="to_date">শেষ তারিখ</label>                  
                     <div class="col-sm-12">
                        <div class="input-group date">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                           <input type="text" class="form-control pull-right datepicker  end_select_date "  id="pur_date" name="pur_date" readonly onkeyup="shift_cursor(event,'purchase_status')" value="<?= date('d-m-Y');?>">
                        </div>
                        <span id="pur_date_msg" style="display:none" class="text-danger"></span>
                     </div>
                  </div>
                  <div class="form-group col-md-4">
                     <label for="to_date">সার্চ করুন</label>                  
                     <div class="col-sm-12">
                        <div class="input-group ">
                           <div class="btn btn-success income_expense_report_btns ">সার্চ করুন</div>
                        </div>
                        <span id="pur_date_msg" style="display:none" class="text-danger"></span>
                     </div>
                  </div>
               </div>
            </div>
         </div>


         <div class="assign_ie_data">
            
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

<script>

   $(document).on('click', '.income_expense_report_btns', function () {

      $.ajax({
         type: "post",
         url: "reports/get_income_expense_dat_to_date",
         data: {
            startDate:  $('.star_date_select').val(),
            endDate:    $('.end_select_date').val(),
         },
         success: function (r) {
            // Sum the price property of each object using reduce()
         let getpayTotalPayment = r.getpay.reduce((accumulator, current) => accumulator + parseFloat(current.payment), 0);
         let incomeTotal = r.income.reduce((accumulator, current) => accumulator + parseFloat(current.income_amount), 0);
         let expenseTotal = r.expense.reduce((accumulator, current) => accumulator + parseFloat(current.expense_amt), 0);
         let costpayTotalPay = r.costpay.reduce((accumulator, current) => accumulator + parseFloat(current.payment), 0);
            
            let income_list_data = '';
            let expense_list_datas = '';

            for (let n = 0; n < r.income.length; n++) { 
               income_list_data += 
                                 `<tr>
                                    <td>${r.income[n].income_for}</td>
                                    <td class="text-right text-bold ">${r.income[n].income_amount}</td>
                                 </tr>`;
            }

            for (let n = 0; n < r.expense.length; n++) { 
               expense_list_datas += 
                                 `<tr>
                                    <td>${r.expense[n].expense_for}</td>
                                    <td class="text-right text-bold ">${r.expense[n].expense_amt}</td>
                                 </tr>`;
            }


            $('.assign_ie_data').html(
                     `<div class="col-md-6">
                        <div class="box box-primary">
                           <div class="box-header" style="font-size: 22px;">
                              <center><b>জমার হিসাব</b></center>
                           </div>
                           <!-- /.box-header -->
                           <div class="box-body table-responsive no-padding">
                              <table class="table table-bordered table-hover " id="report-data" >

                                 <tr>
                                    <th>মোট ইনকাম</th>
                                    <th class="text-right text-bold ">${incomeTotal}</th>
                                 </tr>

                              </table>
                              <div style="font-size: 16px; margin: 5px; "><center><b>বিস্তারিত</b></center></div>
                              <table class="table table-bordered table-hover " id="report-data" style="" >
                                 ${income_list_data}
                              </table>
                           </div>
                           <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                     </div>
                     <div class="col-md-6">
                        <div class="box box-primary">
                           <div class="box-header" style="font-size: 22px;">
                              <center><b>খরচের হিসাব</b></center>
                           </div>
                           <!-- /.box-header -->
                           <div class="box-body table-responsive no-padding">
                              <table class="table table-bordered table-hover " id="report-data-4" >

                                 <tr>
                                    <th>মোট খরচ</th>
                                    <th class="text-right text-bold ">${expenseTotal}</th>
                                 </tr>

                              </table>
                              
                              <div style="font-size: 16px; margin: 5px; "><center><b>বিস্তারিত</b></center></div>
                              <table class="table table-bordered table-hover " id="report-data" style="" >
                                 ${expense_list_datas}
                              </table>

                           </div>
                           <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
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
