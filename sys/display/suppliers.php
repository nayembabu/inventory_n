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
        <small>Add/Update Suppliers</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $base_url; ?>suppliers"><?= $this->lang->line('suppliers_list'); ?></a></li>
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
              <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'suppliers-form', 'enctype'=>'multipart/form-data', 'method'=>'POST', 'accept-charset'=>'UTF-8', 'novalidate'=>'novalidate' ));?>

              
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              <div class="box-body">
                <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                      <label for="supplier_name" class="col-sm-4 control-label"><?= $this->lang->line('supplier_name'); ?><label class="text-danger">*</label></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder=""  value="" autofocus>
                        <span id="supplier_name_msg" style="display:none" class="text-danger"></span>
                      </div>
                  </div>
                  

                  
                  <!-- ########### -->
               </div>


               <div class="col-md-5">
                  <div class="form-group">
                      <label for="mobile" class="col-sm-4 control-label"><?= $this->lang->line('mobile'); ?></label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control no_special_char_no_space" id="mobile" name="mobile" placeholder="" value="" >
                        <span id="mobile_msg" style="display:none" class="text-danger"></span>
                      </div>
                  </div>

                   
                </div>
                  <!-- ########### -->
               <div class="col-md-12">

                   <div class="form-group">
                      <label for="address" class="col-sm-2 control-label"><?= $this->lang->line('address'); ?></label>
                      <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="address" name="address" placeholder="" ></textarea>
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
                      <button type="button" id="save" class=" btn btn-block btn-success" title="Save Data">Save</button>
                    </div>
                    <div class="col-sm-3">
                      <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                    </div>
                </div>
              </div>
              <!-- /.box-footer -->

            <?= form_close(); ?>
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
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html>
