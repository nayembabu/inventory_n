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

	if(!isset($customer_name)){
    $customer_name=$mobile=$phone=$email=$country_id=$state_id=$city=
    $postcode=$address=$supplier_code=$gstin=$tax_number=
    $state_code=$customer_code=$company_name=$company_mobile=$opening_balance='';
	}
 ?>
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      <?=$page_title;?>
        <small>Add/Update Customer</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>customers"><?= $this->lang->line('customers_list'); ?></a></li>
        <li class="active"><?=$page_title;?></li>
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
           
            <!-- form start -->
            <form class="form-horizontal" id="customers-form" >
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              <div class="box-body">
                <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                      <label for="customer_name" class="col-sm-4 control-label"><?= $this->lang->line('customer_name'); ?><label class="text-danger">*</label></label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder=""  value="<?php print $customer_name; ?>" >
                      <span id="customer_name_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>

                  <!-- ########### -->
               </div>


               <div class="col-md-5"> 


                  
                  <div class="form-group">
                    <label for="mobile" class="col-sm-4 control-label"><?= $this->lang->line('mobile'); ?></label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control no_special_char_no_space" id="mobile" name="mobile" placeholder="" value="<?php print $mobile; ?>"  >
                      <span id="mobile_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>
                   
                </div>
                  <!-- ########### -->

              <div class="col-md-12" > 

                <div class="form-group">
                  <label for="address" class="col-sm-2 control-label"><?= $this->lang->line('address'); ?></label>
                  <div class="col-sm-10">
                    <textarea type="text" class="form-control" id="address" name="address" placeholder="" ><?php print $address; ?></textarea>
                    <span id="address_msg" style="display:none" class="text-danger"></span>
                  </div>
                </div>
              </div>

            </div>
              
				
				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                              <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <!-- <div class="col-sm-4"></div> -->
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="save" class=" btn btn-block btn-success new_customer_save_btn  " title="Save Data">Save</button>
                                 </div>
                                 <div class="col-sm-3">
                                    <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                                 </div>
                              </div>
                           </div>
                           <!-- /.box-footer -->
            </form>
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

<script src="<?php echo $theme_link; ?>js/customers.js"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
