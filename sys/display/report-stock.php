<!DOCTYPE html>
<html>
<head>
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
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <!-- /.content -->
    <section class="content">
      <div class="row">
                    
                  <div class="col-md-12">

                     <!-- Custom Tabs -->
                     <div class="nav-tabs-custom">
                        
                        <div class="tab-content">
                           <div class="tab-pane active" id="tab_1">
                              <div class="row">
                                 <!-- right column -->
                                 <div class="col-md-12">
                                    <!-- form start -->
                                          <center><h2>আইটেম লিস্ট</h2></center>  
                                          <div class="table-responsive">
                                          <table class="table table-bordered table-hover " id="report-data" >
                                            <thead>
                                             <tr class="bg-blue">
                                                <th>#</th>
                                                <th><?= $this->lang->line('item_code'); ?></th>
                                                <th><?= $this->lang->line('item_name'); ?></th>
                                                <th style="text-align: center; "><?= $this->lang->line('unit'); ?>(<?= $CI->currency(); ?>)</th>
                                                <th style="text-align: right; padding-right: 20px;  ">মোট স্টক </th>
                                             </tr>
                                            </thead>
                                             <tbody id="tbodyid">
                                                <?php $sl = 1; foreach ($items as $item) { ?>
                                                   <tr class="">
                                                      <td><?= $sl; ?></td>
                                                      <td><?= $item->item_code; ?></td>
                                                      <td><?= $item->item_name; ?></td>
                                                      <td style="text-align: center; "><?= $item->unit_name; ?></td>
                                                      <?php $stock_now = $this->db->select_sum('due_sells_bosta_ss')->where('due_sells_bosta_ss !=', 0)->where('item_id', $item->id)->get('db_purchaseitems')->row()->due_sells_bosta_ss; ?>
                                                      <td style="text-align: right; padding-right: 70px;  ">
                                                         <?php if (empty($stock_now)) {
                                                           echo '0 '.$item->unit_name ; 
                                                         }else {
                                                            echo $stock_now.' '.$item->unit_name;
                                                         } ?>
                                                      </td>
                                                   </tr>
                                                <?php $sl++; } ?>
                                             </tbody>
                                          </table>
                                          </div>
                                       <!-- /.box-body -->
                                 </div>
                                 <!--/.col (right) -->
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


   $("#item_id").on("change", function(){
         load_reports();
   });
</script>

<script type="text/javascript">
  function load_reports(){

   var brand_id=document.getElementById("brand_id").value.trim();
    var category_id=document.getElementById("category_id").value.trim();


   $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

        $.post("get_stock_report",{brand_id:brand_id,category_id:category_id,item_id:$("#item_id").val()},function(result){
            result = $.parseJSON(result);

              $.each( result, function( key, val ) {
                if(key=='item_wise_report'){
                    $("#tbodyid").empty().append(val);
                }
                if(key=='brand_wise_stock'){
                    $("#brand_wise_stock tbody").empty().append(val);     
                }
                if(key=='category_wise_stock'){
                    $("#category_wise_stock tbody").empty().append(val);     
                }

              });
              $(".overlay").remove();
           });

    }//function end
</script>
<script>
    $("#view,#view_all").on("click",function(){
    
   
     load_reports();
      
    
});


</script>


<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
    
    
</body>
</html>
