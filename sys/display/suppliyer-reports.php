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
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><?=$page_title;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- ********** ALERT MESSAGE START******* -->
        <?php include"comman/code_flashdata.php"; ?>
        <!-- ********** ALERT MESSAGE END******* -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info "><br>

            <div class="box-body table-responsive no-padding">
                <div class="form-group col-md-6">
                    <label for="to_date">শুরু তারিখ</label>                  
                    <div class="col-sm-12">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right datepicker  star_date_select "  id="pur_date" name="pur_date"  value="<?= date('d-m-Y');?>">
                    </div>
                    <span id="pur_date_msg" style="display:none" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="to_date">শেষ তারিখ</label>                  
                    <div class="col-sm-12">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right datepicker  end_select_date "  id="pur_date" name="pur_date" value="<?= date('d-m-Y');?>">
                    </div>
                    <span id="pur_date_msg" style="display:none" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-group col-md-8">
                    <label for="to_date">সরবরাহকারী সিলেক্ট করুন</label> 
                    <select class="form-control supplier_selected_id select2 "  >
                        <option value="">সরবরাহকারী লিস্ট</option>
                        <?php foreach($suppliers as $supplier) { ?>
                            <option value="<?php echo $supplier->id; ?>"> <?php echo $supplier->supplier_name; ?> </option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="box-footer">
                    <div class="col-sm-8 col-sm-offset-2 text-center">
                        <div class="col-md-3 col-md-offset-3">
                        <button type="button" id="view" class=" btn btn-block btn-lg btn-success show_reports_btn " title="Show Data">Show</button>
                        </div>
                    </div>
                </div>

            </div>

          </div>
          <!-- /.box -->          
        </div>
        

        
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-primary "><br>

            <div class="box-body table-responsive no-padding suppliers_data_date_to_date   "> 
              
            </div>
              
          </div>
          <!-- /.box -->          
        </div>


      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
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

<script src="<?php echo $theme_link; ?>js/suppliers.js"></script>

<script>
    $(document).on('click', '.show_reports_btn', function () {
        let start_dates = $('.star_date_select').val();
        let ends_datess = $('.end_select_date').val();
        let supplier_id = $('.supplier_selected_id').val();
        if (start_dates == '' || ends_datess == '' || supplier_id == '') {
          toastr["error"]("Select All !");
        }else {

          $.ajax({
              type: "post",
              url: "reports/get_suppliers_reports_date_to_date",
              data: {
                  sdate: start_dates,
                  edate: ends_datess,
                  supp_id: supplier_id
              },
              success: function (res) {
                let purchare_history_datas = '';
                let typesss = '';
                let purchase_payments_get = '';
                for (let n = 0; n < res.purchase_item.length; n++) { 

                  $.ajax({
                    type: "post",
                    url: "reports/get_purchase_paymetns_by_purchase_id",
                    data: {
                      id: res.purchase_item[n].purchase_id
                    },
                    success: function (result) {
                      for (let l = 0; l < result.length; l++) {
                        purchase_payments_get += `<tr>
                              <td>${result[l].payment_date}</td>
                              <td class="text_rights  " style="padding-right: 20px; " >${result[l].payment}</td>
                            </tr>`;  
                      }
                    }
                  });


                  if (parseInt(res.purchase_item[n].pur_buying_types_statu) == 1) {
                    typesss = `ডাইরেক্ট ক্রয়`;
                  }else if (parseInt(res.purchase_item[n].pur_buying_types_statu) == 2) {
                    typesss = `কমিশনে ক্রয়`;
                  }

                  purchare_history_datas += `<tr>
                        <th class=" " style="font-size: 20px; " ><span>${res.purchase_item[n].ref_lot_no}</span> (${typesss}) </th>
                        <th style="font-size: 20px; text-align: center; " >${res.purchase_item[n].purchase_total_bosta} ${res.purchase_item[n].unit_name} </th>
                        <th style="font-size: 20px; text-align: right; " >${res.purchase_item[n].pur_total_price} টাকা</th>
                      </tr>`
                }
                $('.suppliers_data_date_to_date').html(
                  `<div class="form-group col-md-6">
                    <table class="table table-dark " >
                      ${purchare_history_datas}
                    </table>
                  </div>
                  <div class="form-group col-md-6">
                  </div>`
                );
              }
          });

        }
    });

    function purchase_payments_by_purchases_id(purchase_id) {

      $.post("reports/show_item_purchase_report",{id:purchase_id},function(result){

      }); 

    }
</script>

<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
