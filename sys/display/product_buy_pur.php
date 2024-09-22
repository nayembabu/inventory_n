<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo base_url(); ?>" >
        <!-- TABLES CSS CODE -->
        <?php include"comman/code_css_form.php"; ?>
        <style>
            .font20 {
                font-size: 20px;
            }
            .font25 {
                font-size: 25px;
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include"sidebar.php"; ?>

            <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- **********************MODALS***************** -->
                <?php include"modals/modal_supplier.php"; ?>
                <?php include"modals/modal_purchase_item.php"; ?>
                <?php include"modals/transport_profile.php"; ?>
                <!-- **********************MODALS END***************** -->
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?=$page_title;?>
                        <small>Add/Update Purchase</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo $base_url; ?>purchase"><?= $this->lang->line('purchase_list'); ?></a></li>
                        <li><a href="<?php echo $base_url; ?>purchase/add"><?= $this->lang->line('new_purchase'); ?></a></li>
                        <li class="active"><?=$page_title;?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- ********** ALERT MESSAGE START******* -->
                        <span class="flshDataShow">
                            <?php include"comman/code_flashdata.php"; ?>
                        </span>
                        <!-- ********** ALERT MESSAGE END******* -->
                        <!-- right column -->
                        <div class="col-md-12">
                            <!-- Horizontal Form -->
                            <div class="box box-info " >
                                <div class="box-body">


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="supplier_id" class="col-sm-2 control-label"><?= $this->lang->line('supplier_name'); ?><label class="text-danger">*</label></label>
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <select class="form-control select2 supplier_list_select " id="supplier_id" name="supplier_id"  style="width: 100%;">
                                                    </select>
                                                    <span class="input-group-addon pointer" data-toggle="modal" data-target="#supplier-modal" title="New Supplier?"><i class="fa fa-user-plus text-primary fa-lg"></i></span>
                                                </div>
                                                <span id="supplier_id_msg" style="display:none" class="text-danger"></span>
                                            </div>
                                            <label for="pur_date" class="col-sm-2 control-label"><?= $this->lang->line('purchase_date'); ?> <label class="text-danger">*</label></label>
                                            <div class="col-sm-3">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right datepicker  pur_date_select"  id="pur_date" name="pur_date" readonly onkeyup="shift_cursor(event,'purchase_status')" value="<?= date('d-m-Y');?>">
                                                    </div>
                                                <span id="pur_date_msg" style="display:none" class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="purchase_status" class="col-sm-2 control-label"><?= $this->lang->line('status'); ?> <label class="text-danger">*</label></label>
                                            <div class="col-sm-3">
                                                <select class="form-control select2 purchases_status_selected " id="purchase_status" name="purchase_status"  style="width: 100%;" onkeyup="shift_cursor(event,'mobile')">
                                                        <!-- <option value="">-Select-</option> -->
                                                    <option value="Received">Received</option>
                                                    <!-- <option value="Pending">Pending</option>
                                                    <option value="Ordered">Ordered</option> -->
                                                </select>
                                                <span id="purchase_status_msg" style="display:none" class="text-danger"></span>
                                            </div>
                                            <label for="reference_no" class="col-sm-2 control-label"><?= $this->lang->line('lot'); ?> <?= $this->lang->line('no'); ?> </label>
                                            <div class="col-sm-3">
                                                <input type="text" value="" class="form-control type_lot_nosss " id="reference_no" name="reference_no" placeholder="" >
                                                <span id="reference_no_msg" style="display:none" class="text-danger"></span>
                                            </div>
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
                                                                <select class="form-control select2 selected_products_item" id="" name=""  style="width: 100%;">
                                                                    <option value=""> <?= $this->lang->line('product'); ?> <?= $this->lang->line('select'); ?> </option>
                                                                    <?php foreach ($products as $prd) { ?>
                                                                        <option value="<?php echo $prd->id; ?>"><?php echo $prd->item_name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 justify-content buy_types_products_sys" >
                                                        </div>
                                                    </div>

                                                </div>
                                                
                                                <div class="row account_form_assign_sys "></div>

                                                <div class="submit_btn_buy_sys" style="text-align: center; margin: 50px 0 20px 0; " ></div>

                                            </div>
                                      
                                        </div>
                                    </div>


                                </div>
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
        <script src="<?php echo $theme_link; ?>js/purchase.js"></script>
        <!-- <script src="<?php echo $theme_link; ?>js/ajaxselect/supplier_select_ajax.js"></script> -->

        <script>
            let trans_port_for_loop = `<?php foreach ($trans as $trn) { ?>
                                            <option value="<?php echo $trn->db_transport_id; ?>"><?php echo $trn->trans_port_namess; ?></option>
                                        <?php } ?>`;
        </script>

    </body>
</html>

