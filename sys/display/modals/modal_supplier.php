<div class="modal fade " id="supplier-modal" tabindex='-1'>
  <?= form_open('#', array('class' => '', 'id' => 'supplier-form')); ?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-custom">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center"><?= $this->lang->line('add_supplier'); ?></h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="supplier_name"><?= $this->lang->line('supplier_name'); ?>*</label>
                  <span id="supplier_name_msg" class="text-danger text-right pull-right"></span>
                  <input type="text" class="form-control sup_supplier_name" id="supplier_name" name="supplier_name" placeholder="" >
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="mobile"><?= $this->lang->line('mobile'); ?></label>
                  <span id="mobile_msg" class="text-danger text-right pull-right"></span>
                  <input type="tel"  class="form-control no_special_char_no_space sup_supplier_mobile_no" id="mobile" name="mobile" placeholder=""  >
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="country"><?= $this->lang->line('country'); ?></label>
                  <span id="country_msg" class="text-danger text-right pull-right"></span>
                 <select class="form-control select2 sup_supplier_country" id="country" name="country"  style="width: 100%;" onkeyup="shift_cursor(event,'state')" value="">
                    <?php
                    $query1="select * from db_country where status=1";
                    $q1=$this->db->query($query1);
                    if($q1->num_rows($q1)>0)
                     {
                         foreach($q1->result() as $res1)
                       {
                         echo "<option value='".$res1->id."'>".$res1->country."</option>";
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
                </div>
              </div>
            </div>
           <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="city"><?= $this->lang->line('city'); ?></label>
                  <span id="city_msg" class="text-danger text-right pull-right"></span>
                  <input type="text" class="form-control sup_supplier_city" id="city" name="city" placeholder="" >
                </div>
              </div>
            </div>
            

            <div class="col-md-8">
              <div class="box-body">
                <div class="form-group">
                  <label for="address"><?= $this->lang->line('address'); ?></label>
                  <span id="address_msg" class="text-danger text-right pull-right"></span>
                  <textarea type="text" class="form-control sup_supplier_address" id="address" name="address" placeholder="" ></textarea>
                </div>
              </div>
            </div>

          </div>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_supplier">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
 <?= form_close();?>
</div>
<!-- /.modal -->