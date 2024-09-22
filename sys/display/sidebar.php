<!-- Change the theme color if it is set -->
   <script type="text/javascript">
    if(theme_skin!='skin-blue'){
      $("body").addClass(theme_skin);
      $("body").removeClass('skin-blue');
    }
    if(sidebar_collapse=='true'){
      $("body").addClass('sidebar-collapse');
    }
  </script> 
  <!-- end --> 

<?php 
    $CI =& get_instance();
  ?>
<header class="main-header">

    <!-- Logo -->
    <a href="<?php echo $base_url; ?>dashboard" class="logo">
      <span class="logo-mini"><b>ক্রয়</b></span>
      <span class="logo-lg"><b><?php  echo $SITE_TITLE;?></b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
       
        <ul class="nav navbar-nav">
          <!-- <li class="text-center hidden-xs" id="">
            <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search Sales Invoice">
            </div>
          </form> 
          </li> -->
          <!-- User Account Menu -->
            
            <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown" title="App Language" data-toggle='tooltip'>
              <i class="fa fa-language "></i>
                    <?= $this->session->userdata('language'); ?>
            </a>
            <ul class="dropdown-menu " style="width: auto;height: auto;">
              <li>
                <ul class="menu">
                  <?php 
                  $lang_query=$this->db->query('select * from db_languages where status=1 order by language asc');
                  foreach ($lang_query->result() as $res) { 
                    $selected='';
                    if($this->session->userdata('language')==$res->language){
                      $selected ='text-blue';
                    }
                    ?>
                    <li>
                    <a href="<?= $base_url;?>site/langauge/<?= $res->id;?>" ><h3 class='<?=$selected;?>'><?= $res->language;?></h3></a>
                  </li>  
                  <?php } ?>
                </ul>
              </li>
            </ul>
          </li>
          


          <li class="dropdown user user-menu " style="margin-right: 40px; ">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo get_profile_picture(); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php print ucfirst($this->session->userdata('inv_username')); ?></span>
            </a>

            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo get_profile_picture(); ?>" class="img-circle" alt="User Image">

                <p>
                 <?php print ucfirst($this->session->userdata('inv_username')); ?>
                  <small>Year <?=date("Y");?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo $base_url; ?>users/edit/<?= $this->session->userdata('inv_userid'); ?>" class="btn btn-default btn-flat"><?= $this->lang->line('profile'); ?></a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo $base_url; ?>logout" class="btn btn-default btn-flat"><?= $this->lang->line('logout'); ?></a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>

    </nav>
  </header>
 
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo get_profile_picture(); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php print ucfirst($this->session->userdata('inv_username')); ?><i class="fa fa-fw fa-check-circle text-aqua"></i></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <!--<li class="header">MAIN NAVIGATION</li>-->

  		  <li class="dashboard-active-li "><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard text-aqua"></i> <span><?= $this->lang->line('dashboard'); ?></span></a></li>
		
		    <li class="pos-active-li sales-list-active-li saled_view_file-active-li sales-return-active-li sales-return-list-active-li ">
          <a href="<?php echo $base_url; ?>sales/add">
            <i class=" fa fa-shopping-cart text-aqua"></i> <span><?= $this->lang->line('sales'); ?></span>
          </a>
        </li>

        <li class="purchase-list-active-li product_buy_pur-active-li purchase-returns-list-active-li purchase-returns-active-li purchase-active-li ">
          <a href="<?php echo $base_url; ?>purchase/add">
            <i class="fa fa-th-large text-aqua"></i> <span><?= $this->lang->line('purchase'); ?></span>
          </a>
        </li>

       <li class=" income_payment_take-active-li expense-category-active-li expense-category-list-active-li other_income_adds-active-li treeview">
          <a href="#">
            <i class="fa fa-plus-circle text-aqua"></i> <span>জমা</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="income_payment_take-active-li"><a href="<?php echo $base_url; ?>expense/due_income_payments"><i class="fa fa-dollar "></i> <span>টাকা গ্রহণ</span></a></li>
            <li class="other_income_adds-active-li"><a href="<?php echo $base_url; ?>expense/other_income_adds"><i class="fa fa-plus-square-o "></i> <span>অন্যান্য ইনকাম</span></a></li>
          </ul>
        </li>


       <li class="expense-list-active-li expense-active-li expense_payment_paid-active-li expense-category-active-li expense-category-list-active-li treeview">
          <a href="#">
            <i class="fa fa-minus-circle text-aqua"></i> <span><?= $this->lang->line('expenses'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="expense_payment_paid-active-li"><a href="<?php echo $base_url; ?>expense/paid_payment"><i class="fa fa-users "></i> <span>টাকা পরিশোধ</span></a></li>
            <li class="expense-active-li"><a href="<?php echo $base_url; ?>expense/add"><i class="fa fa-minus-square "></i> <span><?= $this->lang->line('new_expense'); ?></span></a></li>

          </ul>
        </li>

        <li class="customers-view-active-li customers-active-li import_customers-active-li treeview">
          <a href="#">
            <i class="fa fa-group text-aqua"></i> <span><?= $this->lang->line('customers'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="customers-active-li"><a href="<?php echo $base_url; ?>customers/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('new_customer'); ?></span></a></li>
            <li class="customers-view-active-li"><a href="<?php echo $base_url; ?>customers"><i class="fa fa-list "></i> <span><?= $this->lang->line('customers_list'); ?></span></a></li>
          </ul>
        </li>    

		
        <li class="suppliers-list-active-li suppliers-active-li import_suppliers-active-li treeview">
          <a href="#">
            <i class="fa fa-user-plus text-aqua"></i> <span><?= $this->lang->line('suppliers'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li class="suppliers-active-li"><a href="<?php echo $base_url; ?>suppliers/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('new_supplier'); ?></span></a></li>
              <li class="suppliers-list-active-li"><a href="<?php echo $base_url; ?>suppliers"><i class="fa fa-list "></i> <span><?= $this->lang->line('suppliers_list'); ?></span></a></li>
          </ul>
        </li>
        
        <li class="items-list-active-li items-active-li  category-view-active-li category-active-li brand-active-li brand-view-active-li labels-active-li import_items-active-li treeview">
          <a href="#">
            <i class="fa fa-cubes text-aqua"></i> <span><?= $this->lang->line('items'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="items-active-li"><a href="<?php echo $base_url; ?>items/add"><i class="fa fa-plus-square-o "></i> <span>নতুন পন্য যোগ</span></a></li>
            <li class="items-list-active-li"><a href="<?php echo $base_url; ?>items"><i class="fa fa-list "></i> <span>পন্যের তালিকা</span></a></li>
          </ul>
        </li>


		    <li class="report-sales-active-li report-sales-return-active-li report-purchase-active-li report-purchase-return-active-li report-expense-active-li report-profit-loss-active-li report-stock-active-li report-purchase-payments-active-li report-sales-item-active-li report-sales-payments-active-li report-expired-items-active-li suppliyer-reports-active-li report-purchase-item-active-li treeview">
          <a href="#">
            <i class="fa fa-bar-chart text-aqua"></i> <span><?= $this->lang->line('reports'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li class="report-profit-loss-active-li"><a href="<?php echo $base_url; ?>reports/profit_loss" ><i class="fa fa-files-o "></i> <span> আয় ব্যায় </span></a></li>
            
            <li class="report-purchase-active-li"><a href="<?php echo $base_url; ?>reports/purchase" ><i class="fa fa-files-o "></i> <span> ক্রয় রিপোর্ট </span></a></li>

            <li class="report-purchase-item-active-li"><a href="<?php echo $base_url; ?>reports/item_purchase" ><i class="fa fa-files-o "></i> <span>আইটেম রিপোর্ট</span></a></li>

            <li class="suppliyer-reports-active-li"><a href="<?php echo $base_url; ?>reports/suppliyers_reports" ><i class="fa fa-files-o "></i> <span>সরবহকারী রিপোর্ট</span></a></li>

            <li class="report-sales-active-li"><a href="<?php echo $base_url; ?>reports/sales" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('sales_report'); ?></span></a></li>
            
            <li class="report-stock-active-li"><a href="<?php echo $base_url; ?>reports/stock" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('stock_report'); ?></span>
              </a></li>
              
	       </ul>
      </li>

	   <!-- Users -->
      <li class="users-view-active-li users-active-li roles-list-active-li role-active-li treeview">
          <a href="#">
            <i class="fa fa-users text-aqua"></i> <span><?= $this->lang->line('users'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="users-active-li"><a href="<?php echo $base_url; ?>users/"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('new_user'); ?></span></a></li>
            
            <li class="users-view-active-li"><a href="<?php echo $base_url; ?>users/view"><i class="fa fa-list "></i> <span><?= $this->lang->line('users_list'); ?></span></a></li>
            
            <li class="roles-list-active-li role-active-li">
              <a href="<?php echo $base_url; ?>roles/view">
                <i class="fa fa-list "></i> 
                <span><?= $this->lang->line('roles_list'); ?></span></a>
            </li>
            
          </ul>
        </li>
    <!-- SMS 
        <li class="sms-active-li sms-api-active-li sms-template-active-li sms-templates-list-active-li treeview">
          <a href="#">
            <i class="fa fa-envelope text-aqua"></i> <span><?= $this->lang->line('sms'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="sms-active-li"><a href="<?php echo $base_url; ?>sms"><i class="fa fa-envelope-o "></i> <span><?= $this->lang->line('send_sms'); ?></span></a></li>
            
            <li class="sms-templates-list-active-li sms-template-active-li"><a href="<?php echo $base_url; ?>templates/sms"><i class="fa fa-list "></i> <span><?= $this->lang->line('sms_templates'); ?></span></a></li>
            
            <li class="sms-api-active-li"><a href="<?php echo $base_url; ?>sms/api"><i class="fa fa-cube "></i> <span><?= $this->lang->line('sms_api'); ?></span></a></li>
            
          </ul>
        </li>
        -->
		<!--<li class="header">SETTINGS</li>
		    <li class=" company-profile-active-li site-settings-active-li  change-pass-active-li dbbackup-active-li warehouse-active-li warehouse-list-active-li tax-active-li currency-view-active-li currency-active-li  database_updater-active-li tax-list-active-li units-list-active-li unit-active-li payment_types_list-active-li payment_types-active-li treeview">
          <a href="#">
            <i class="fa fa-gears text-aqua"></i> <span><?= $this->lang->line('settings'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="company-profile-active-li"><a href="<?php echo $base_url; ?>company"><i class="fa fa-suitcase "></i> <span><?= $this->lang->line('company_profile'); ?></span></a></li>
            
            <li class="site-settings-active-li"><a href="<?php echo $base_url; ?>site"><i class="fa fa-shield  "></i> <span><?= $this->lang->line('site_settings'); ?></span></a></li>
            
            <li class="tax-active-li  tax-list-active-li"><a href="<?php echo $base_url; ?>tax"><i class="fa fa-percent  "></i> <span><?= $this->lang->line('tax_list'); ?></span></a></li>
            
            <li class="units-list-active-li unit-active-li"><a href="<?php echo $base_url; ?>units/"><i class="fa fa-list "></i> <span><?= $this->lang->line('units_list'); ?></span></a></li>
            
            <li class="payment_types_list-active-li payment_types-active-li"><a href="<?php echo $base_url; ?>payment_types/"><i class="fa fa-list "></i> <span><?= $this->lang->line('payment_types_list'); ?></span></a></li>
            
            <li class="currency-view-active-li currency-active-li"><a href="<?php echo $base_url; ?>currency/view"><i class="fa fa-gg "></i> <span><?= $this->lang->line('currency_list'); ?></span></a></li>
            
            <li class="change-pass-active-li"><a href="<?php echo $base_url; ?>users/password_reset"><i class="fa fa-lock "></i> <span><?= $this->lang->line('change_password'); ?></span></a></li>
            
            <li class="dbbackup-active-li"><a href="<?php echo $base_url; ?>users/dbbackup"><i class="fa fa-database "></i> <span><?= $this->lang->line('database_backup'); ?></span></a></li>
            
            
		   </ul>
        </li>
        -->
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
