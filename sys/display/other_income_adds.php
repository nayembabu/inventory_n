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
        ইনকাম
        <small>Add/Update Expense</small>
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
              <h3 class="box-title">Please Enter Valid Data</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <form class="form-horizontal" id="expense-form" >
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              <div class="box-body">
                <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                      <label for="expense_date" class="col-sm-4 control-label">ইনকামের তারিখ<label class="text-danger">*</label></label>

                  <div class="col-sm-8">
                    <div class="input-group date">
                      <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker incomes_dates" value="<?php echo  date('d-m-Y'); ?>" id="expense_date" name="expense_date" readonly >
                      <span id="expense_date_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>
                  </div>

                  
                  
                  <div class="form-group">
                    <label for="expense_amt" class="col-sm-4 control-label">টাকার পরিমাণ <label class="text-danger">*</label></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control only_currency incomes_amounts " id="expense_amt" name="expense_amt" placeholder="" style="text-align: right; " value="" >
                      <span id="expense_amt_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>
                  <!-- ########### -->
               </div>


               <div class="col-md-5">
                  
                <div class="form-group">
                      <label for="expense_for" class="col-sm-4 control-label">ইনকামের কারণ *</label></label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control incomes_for" id="expense_for" name="expense_for" placeholder="" value="" >
                    <span id="expense_for_msg" style="display:none" class="text-danger"></span>
                  </div>
                </div>
                </div>
                  <!-- ########### -->
                </div>
              
				
				
              </div>
              <!-- /.box-body -->

             <div class="box-footer">
                <div class="col-sm-8 col-sm-offset-2 text-center">
                   <!-- <div class="col-sm-4"></div> -->
                                 
                   <div class="col-md-3 col-md-offset-3">
                      <button type="button" id="save" class=" btn btn-block btn-success save_income_btn " title="Save Data">Save</button>
                   </div>
                   <div class="col-sm-3">
                    <a href="<?=base_url('dashboard');?>">
                      <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                    </a>
                   </div>
                </div>
             </div>
             <!-- /.box-footer -->
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




