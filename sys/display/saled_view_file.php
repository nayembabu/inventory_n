<!DOCTYPE html>
<html>

<head>
  <base href="<?php echo base_url(); ?>">
      <!-- FORM CSS CODE -->
   <?php include"comman/code_css_form.php"; ?>
   
   <style type="text/css">
      table.table-bordered > thead > tr > th {
      /* border:1px solid black;*/
      text-align: center;
      }
      .table > tbody > tr > td, 
      .table > tbody > tr > th, 
      .table > tfoot > tr > td, 
      .table > tfoot > tr > th, 
      .table > thead > tr > td, 
      .table > thead > tr > th 
      {
      padding-left: 2px;
      padding-right: 2px;  

      }
   </style>
</head>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
 
 
 <?php include"sidebar.php"; ?>
 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- **********************MODALS***************** -->
    <?php include"modals/modal_customer.php"; ?>
    <?php include"modals/modal_pos_sales_item.php"; ?>
    <!-- **********************MODALS END***************** -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
         <h1>
            <?=$page_title;?>
            <small>বিক্রয়</small>
         </h1>
         <ol class="breadcrumb">
            <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a >বিক্রয়</a></li>
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
                     <div class="box box-info " >
                        <!-- style="background: #68deac;" -->
                        
                        <!-- form start -->
                         <!-- OK START -->
                        <?= form_open('#', array('class' => 'form-horizontal', 'id' => 'sales-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <input type="hidden" value='1' id="hidden_rowcount" name="hidden_rowcount">
                           <input type="hidden" value='0' id="hidden_update_rowid" name="hidden_update_rowid">

                          
                           <div class="box-body">
                              <div class="form-group">
                                 <label for="customer_id" class="col-sm-2 control-label"><?= $this->lang->line('customer_name'); ?><label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                    <div class="input-group">
                                       <select class="form-control select2 customer_uniqs_id" id="customer_id" name="customer_id" style="width: 100%;" >
                                       </select>
                                       <span class="input-group-addon pointer" data-toggle="modal" data-target="#customer-modal" title="New Customer?"><i class="fa fa-user-plus text-primary fa-lg"></i></span>
                                    </div>
                                    <span id="customer_id_msg" style="display:none" class="text-danger"></span>
                                 </div>
                                 <label for="sales_date" class="col-sm-2 control-label"><?= $this->lang->line('sales_date'); ?> <label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                    <div class="input-group date">
                                       <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                       </div>
                                       <input type="text" class="form-control sales_datess pull-right datepicker"  id="sales_date" name="sales_date" readonly value="<?= date('d-m-Y');?>">
                                    </div>
                                    <span id="sales_date_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label for="sales_status" class="col-sm-2 control-label"><?= $this->lang->line('status'); ?> <label class="text-danger">*</label></label>
                                 <div class="col-sm-3">
                                       <select class="form-control select2" id="sales_status" name="sales_status"  style="width: 100%;" >
                                            <option value="Final">Final</option>
                                            <!-- <option value="Quotation">Quotation</option> -->
                                       </select>
                                    <span id="sales_status_msg" style="display:none" class="text-danger"></span>
                                 </div>
                                 <label for="reference_no" class="col-sm-2 control-label"><?= $this->lang->line('lot'); ?> <?= $this->lang->line('no'); ?> </label>
                                 <div class="col-sm-3">
                                    <input type="text" value="" class="form-control ref_lots_nos_s " id="reference_no" name="reference_no" placeholder="লট নং " >
                                    <span id="reference_no_msg" style="display:none" class="text-danger"></span>
                                 </div>
                                
                              </div>
                              



                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="box">

                                       <div class="box-info">
                                          <div class="box-header">
                                             <div class="col-md-8  justify-content" >
                                                <div class="input-group">
                                                      <span class="input-group-addon" title="Select Items"><i class="fa fa-barcode"></i></span>
                                                      <select class="form-control select2 selected_products_item " id="" name=""  style="width: 100%;">
                                                         <option value=""> <?= $this->lang->line('product'); ?> <?= $this->lang->line('select'); ?> </option>
                                                         <?php foreach ($products as $prd) { ?>
                                                            <option value="<?php echo $prd->id; ?>"><?php echo $prd->item_name; ?></option>
                                                         <?php } ?>
                                                      </select>
                                                </div>
                                             </div>
                                          </div>
                                       </div>










                                      <section class="content">
                                        <div class="row">
                                          <div class="col-md-12">

                                            <!-- Custom Tabs -->
                                            <div class="nav-tabs-custom nav_assign_ul_data"></div>

                                            <div>
                                                <div class="tab-content">
                                                  <div class="tab-pane active">
                                                      <div class="row ">
                                                         <div class="col-md-6 col-xs-12 ttl_data_show_rows ">
                                                         </div>
                                                         <div class="col-md-6 col-xs-12  ">


                                                         <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="col-sm-12" style="overflow-y:auto;border:1px solid #337ab7;" >
                      <table class="table table-condensed table-bordered table-striped table-responsive items_table" style="">
                        <thead class="bg-primary">
                          <th width="30%"><?= $this->lang->line('item_name'); ?></th>
                          <th width="10%"><?= $this->lang->line('stock'); ?></th>
                          <th width="25%"><?= $this->lang->line('quantity'); ?></th>
                          <th width="15%"><?= $this->lang->line('price'); ?></th>
                          <th width="10%"><?= $this->lang->line('discount'); ?></th>
                          <th width="10%" class='<?=tax_disable_class()?>'><?= $this->lang->line('tax'); ?></th>
                          <th width="15%"><?= $this->lang->line('subtotal'); ?></th>
                          <th width="5%"><i class="fa fa-close"></i></th>
                        </thead>
                        <tbody id="pos-form-tbody" style="font-size: 16px;font-weight: bold;overflow: scroll;">
                          <!-- body code -->
                        </tbody>        
                        <tfoot>
                          <!-- footer code -->
                        </tfoot>              
                      </table>
                    </div>
                  </div>
                </div>
              </div>



                                                         </div>
                                                      </div>
                                                      <!-- /.row -->
                                                  </div>
                                                  <!-- /.tab-pane -->
                                                  
                                                  
                                                </div>
                                                <!-- /.tab-content -->
                                            </div>
                                            <!-- nav-tabs-custom -->
                                            
                                          </div>
                                          <!-- /.col -->
                                      </div>
                                      <!-- /.row -->
                                    </section>

                                       <div class="submit_btn_selling_sys" style="text-align: center; margin: 50px 0 20px 0; " ></div>

                                    </div>

                                 </div>
                              </div>

                           <?= form_close(); ?>
                           <!-- OK END -->
                     </div>
                  </div>
                  <!-- /.box-footer -->
                 
               </div>
               <!-- /.box -->
             </section>
            <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 <?php include"footer.php"; ?>
<!-- SOUND CODE -->
<?php include"comman/code_js_sound.php"; ?>
<!-- GENERAL CODE -->
<?php include"comman/code_js_form.php"; ?>

<script src="<?php echo $theme_link; ?>js/modals.js"></script>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

      <script src="<?php echo $theme_link; ?>js/sales.js"></script>  
      <script src="<?php echo $theme_link; ?>js/ajaxselect/customer_select_ajax.js"></script>  


      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
</body>
</html> 
