<!DOCTYPE html>
<html>
   <head>
      <base href="<?php echo base_url(); ?>" target="">
  <!-- TABLES CSS CODE -->
  <?php include"comman/code_css_form.php"; ?>
  <!-- </copy> -->  
  </head>
   <body class="hold-transition skin-blue  sidebar-mini">

    <!-- **********************MODALS***************** -->
    <?php include"modals/modal_brand.php"; ?>
    <?php include"modals/modal_category.php"; ?>
    <?php include"modals/modal_unit.php"; ?>
    <?php include"modals/modal_tax.php"; ?>
    <!-- **********************MODALS END***************** -->
      
      </div>
      <div class="wrapper">
      <?php include"sidebar.php"; ?>
      <?php
         if(!isset($item_name)){
         $custom_barcode ='';
         $item_name=$sku=$hsn=$opening_stock=$item_code=$brand_id=$category_id=$gst_percentage=$tax_type=
         $sales_price=$purchase_price=$profit_margin=$unit_id=$price=$lot_number="";
         $stock = 0;
         $alert_qty= 0;
         $expire_date ='';
         $description ='';
         $final_price ='';
          $tax_id='';
          $discount='';
          $discount_type='Percentage';



          //Create items unique Number
         $qs5="select item_init from db_company";
         $q5=$this->db->query($qs5);
         $item_init=$q5->row()->item_init;
         
         $this->db->query("ALTER TABLE db_items AUTO_INCREMENT = 1");
         $qs4="select coalesce(max(id),0)+1 as maxid from db_items";
         $q1=$this->db->query($qs4);
         $maxid=$q1->row()->maxid;
         $item_code=$item_init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
         //end


         }
         $new_opening_stock ='';
         $adjustment_note ='';
         ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <section class="content-header">
            <h1>
               <?= $page_title;?>
               <small>Add/Update Items</small>
            </h1>
            <ol class="breadcrumb">
               <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
               <li class="active"><?= $page_title;?></li>
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
                     
                      <?= form_open('#', array('class' => 'form', 'id' => 'items-form', 'enctype'=>'multipart/form-data', 'method'=>'POST'));?>
                        <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                        <div class="box-body">
                           <div class="row">
                              <div class="form-group col-md-4">
                                 <label for="item_code">পন্য কোড<span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" id="item_code" name="item_code" placeholder="" value="<?php print $item_code; ?>" >
                                 <span id="item_code_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <div class="form-group col-md-4">
                                 <label for="item_name"><?= $this->lang->line('item_name'); ?><span class="text-danger">*</span></label>
                                 <input type="text" class="form-control" id="item_name" name="item_name" placeholder="" value="<?php print $item_name; ?>" >
                                 <span id="item_name_msg" style="display:none" class="text-danger"></span>
                              </div>

                              <div class="form-group col-md-4">
                                 <label for="unit_id" class="control-label"><?= $this->lang->line('unit'); ?><span class="text-danger">*</span></label>
                                 <div class="input-group">
                                 <select class="form-control select2" id="unit_id" name="unit_id"  style="width: 100%;" >
                                    <?php
                                       $query1="select * from db_units where status=1";
                                       $q1=$this->db->query($query1);
                                       if($q1->num_rows($q1)>0)
                                        {
                                         echo '<option value="">-Select-</option>'; 
                                            foreach($q1->result() as $res1)
                                          {
                                            $selected = ($res1->id==$unit_id)? 'selected' : '';
                                            echo "<option $selected value='".$res1->id."'>".$res1->unit_name."</option>";
                                          }
                                        }
                                        else
                                        {
                                           ?>
                                    <option value="">No Records Found</option>
                                    <?php
                                       }
                                       ?>
                                 </select>
                                 <span class="input-group-addon pointer" data-toggle="modal" data-target="#unit_modal" title="Add Unit"><i class="fa fa-plus-square-o text-primary fa-lg"></i></span>
                                    </div>
                                 <span id="unit_id_msg" style="display:none" class="text-danger"></span>
                              </div>
                           </div>
                           <hr>
                           </div>
                           <!-- /row -->
                           <!-- /.box-body -->
                           <div class="box-footer">
                              <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <!-- <div class="col-sm-4"></div> -->
                                 
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="save" class=" btn btn-block btn-success" title="Save Data">Save</button>
                                 </div>
                                 <div class="col-sm-3">
                                  <a href="<?=base_url('dashboard');?>">
                                    <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Close</button>
                                  </a>
                                 </div>
                              </div>
                           </div>
                           <!-- /.box-footer -->
                     <?= form_close(); ?>
                     </div>
                     <!-- /.box -->
                  </div>
                  <!--/.col (right) -->
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
      <script src="<?php echo $theme_link; ?>js/items.js"></script>
      <script src="<?php echo $theme_link; ?>js/modals.js"></script>
      <script>
         $("#discount_type").val('<?=$discount_type; ?>');
      </script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
   </body>
</html>
