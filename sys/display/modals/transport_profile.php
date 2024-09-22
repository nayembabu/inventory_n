<div class="modal fade " id="transport-modal" tabindex='-1'>
  <?= form_open('#', array('class' => '', 'id' => 'supplier-form')); ?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-custom">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">নতুন ট্রান্সপোর্ট যোগ</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="box-body">
                <div class="form-group">
                  <label for="supplier_name"> ট্রান্সপোর্ট নাম *</label>
                  <span id="supplier_name_msg" class="text-danger text-right pull-right"></span>
                  <input type="text" class="form-control trans_name" id="supplier_name" name="supplier_name" placeholder="" >
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box-body">
                <div class="form-group">
                  <label for="mobile"><?= $this->lang->line('mobile'); ?></label>
                  <span id="mobile_msg" class="text-danger text-right pull-right"></span>
                  <input type="tel"  class="form-control no_special_char_no_space trans_mobile_no" id="mobile" name="mobile" placeholder=""  >
                </div>
              </div>
            </div>


            <div class="col-md-8">
              <div class="box-body">
                <div class="form-group">
                  <label for="address">ঠিকানা </label>
                  <span id="address_msg" class="text-danger text-right pull-right"></span>
                  <textarea type="text" class="form-control transport_address" id="address" name="address" placeholder="" ></textarea>
                </div>
              </div>
            </div>

          </div>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_transport_profile">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
 <?= form_close();?>
</div>
<!-- /.modal -->