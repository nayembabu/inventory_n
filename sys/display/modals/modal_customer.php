<div class="modal fade " id="customer-modal" tabindex='-1'>
                <?= form_open('#', array('class' => '', 'id' => 'customer-form')); ?>
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header header-custom">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title text-center"><?= $this->lang->line('add_customer'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="customer_name"><?= $this->lang->line('customer_name'); ?>*</label>
                                <span id="customer_name_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control cus_name" id="customer_name" name="customer_name" placeholder="কাস্টমারের নাম" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="mobile"><?= $this->lang->line('mobile'); ?></label>
                                <span id="mobile_msg" class="text-danger text-right pull-right"></span>
                                <input type="tel"  class="form-control no_special_char_no_space cus_mobile_no " id="mobile" name="mobile" placeholder="মোবাইল নং"  >
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="opening_balance"><?= $this->lang->line('previous_due'); ?></label>
                                <span id="opening_balance_msg" class="text-danger text-right pull-right"></span>
                                <input type="text" class="form-control cus_previous_due" id="opening_balance" name="opening_balance" placeholder="" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="box-body">
                              <div class="form-group">
                                <label for="address"><?= $this->lang->line('address'); ?></label>
                                <span id="address_msg" class="text-danger text-right pull-right"></span>
                                <textarea type="text" rows="3" class="form-control cus_addrs" id="address" name="address" placeholder="পুরো ঠিকানা টাইপ করেন। " ></textarea>
                              </div>
                            </div>
                          </div>

                        </div>
                       
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary add_customer">Save</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
               <?= form_close();?>
              </div>
              <!-- /.modal -->