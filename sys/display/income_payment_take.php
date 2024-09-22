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
 
  <?php
	
	if(!isset($expense_amt)){
    $category_id =$expense_for=$note=$expense_amt=$q_id=$reference_no='';
    $expense_date=show_date(date("d-m-Y"));
	}
 ?>
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ইনকাম
        <small>Add/Update income</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">ইনকাম</li>
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
          <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title">Please Select Valid Data</h3>
            </div>
            <!-- /.box-header -->

                <div class="box-header">
                    <div class="col-md-8  justify-content" >
                        <div class="input-group">
                            <span class="input-group-addon" title="Select Items"><i class="fa fa-user"></i></span>
                            <select class="form-control select2 select_customers_id " id="" name=""  style="width: 100%;">
                                <option value=""> <?= $this->lang->line('select'); ?> </option>
                                <?php foreach ($cus_s as $cus) { ?>
                                    <option value="<?php echo $cus->id; ?>"><?php echo $cus->customer_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="box-header row container ">
                    <div class="col-md-12 " >
                      <div class="col-md-6 products_select_data " >
                      </div>
                    </div>
                    <div class="col-md-12 " >
                      <div class="col-md-6 customers_data_assign_info " >
                      </div>
                      <div class="col-md-6 previous_payments_data_assign    " >
                      </div>
                    </div>
                </div>

                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
          </div>
          <!-- /.box -->
          
        </div>
        <!--/.col (right) -->
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

<script src="<?php echo $theme_link; ?>js/incomes.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
