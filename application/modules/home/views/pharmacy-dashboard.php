<!DOCTYPE html>


<html lang="en" <?php
if (!$this->ion_auth->in_group(array('superadmin'))) {
    $this->db->where('hospital_id', $this->hospital_id);
    $settings_lang = $this->db->get('settings')->row()->language;
    if ($settings_lang == 'arabic') {
        ?>     
              dir="rtl"
          <?php } else { ?>
              dir="ltr"
              <?php
          }
      } else {
          $this->db->where('hospital_id', 'superadmin');
          $settings_lang = $this->db->get('settings')->row()->language;
          if ($settings_lang == 'arabic') {
              ?>
              dir="rtl"     
          <?php } else { ?> 
              dir="ltr"
              <?php
          }
      }
      if ($this->ion_auth->in_group(array('Pharmacist')))
      {
        $user_id_here = $this->ion_auth->get_user_id();
        $this->db->where('ion_user_id', $user_id_here);
        $query_pharma = $this->db->get('pharmacist')->row_array();
        if($query_pharma['is_saleman']==1){
            $saleman_handler = 1;
        }
        else
        {
            $saleman_handler = 0;
        }
        
      }
      else
      {
        $saleman_handler = 0;
      }
      ?>>
    <head>
        <base href="<?php echo base_url(); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Rizvi">
        <meta name="keyword" content="Maulaji Health Services">
        <link rel="shortcut icon" href="uploads/favicon.png">
        <title> <?php echo $this->router->fetch_class(); ?> | 
            <?php
            if ($this->ion_auth->in_group(array('superadmin'))) {
                $this->db->where('hospital_id', 'superadmin');
            } else {
                $this->db->where('hospital_id', $this->hospital_id);
            }
            ?>
            <?php
            echo $this->db->get('settings')->row()->system_vendor;
            ?>  
        </title>
        <link href="common/css/bootstrap.min.css" rel="stylesheet">
        <link href="common/css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="common/assets/fontawesome5pro/css/all.min.css" rel="stylesheet" />
        <link href="common/assets/DataTables/datatables.min.css" rel="stylesheet" />
        <!-- <link href="common/assets/font-awesome/css/font-awesome.css" rel="stylesheet" /> -->
        <!-- Custom styles for this template -->
        <link href="common/css/style.css" rel="stylesheet">
        <link href="common/css/style-responsive.css" rel="stylesheet" />
        <link rel="stylesheet" href="common/assets/bootstrap-datepicker/css/datepicker.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-daterangepicker/daterangepicker-bs3.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-datetimepicker/css/datetimepicker.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-timepicker/compiled/timepicker.css">
        <link rel="stylesheet" type="text/css" href="common/assets/jquery-multi-select/css/multi-select.css" />
        <link href="common/css/invoice-print.css" rel="stylesheet" media="print">
        <link href="common/assets/fullcalendar/fullcalendar.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="common/assets/select2/css/select2.min.css"/>
        <link rel="stylesheet" type="text/css" href="common/css/lightbox.css"/>
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-fileupload/bootstrap-fileupload.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />

        <link rel="stylesheet" type="text/css" href="common/assets/DataTables/DataTables-1.10.16/custom/css/datatable-responsive-cdn-version-1-0-7.css" />

        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
        <!-- Google Fonts -->

        <style>
            /*@import url('https://fonts.googleapis.com/css?family=Ubuntu&display=swap');*/
        </style>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->


        <?php
        if (!$this->ion_auth->in_group(array('superadmin'))) {
            if ($settings_lang == 'arabic') {
                ?>
                <style>
                    #main-content {
                        margin-right: 211px;
                        margin-left: 0px; 
                    }

                    body {
                        background: #f1f1f1;

                    }
                </style>

                <?php
            }
        } else {
            if ($settings_lang == 'arabic') {
                ?>
                <style>
                    #main-content {
                        margin-right: 211px;
                        margin-left: 0px; 
                    }

                    body {
                        background: #f1f1f1;

                    }
                </style>

                <?php
            }
        }
        ?>

    </head>

    <body oncontextmenu="return false">
        <section id="container" class="">
            <!--header start-->
            <header class="header white-bg">
                <div class="sidebar-toggle-box">
                    <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-dedent fa-bars tooltips"></div>
                </div>
                <!--logo start-->
                <?php
                if (!$this->ion_auth->in_group(array('superadmin'))) {
                    $this->db->where('hospital_id', $this->hospital_id);
                    $settings_title = $this->db->get('settings')->row()->title;
                    $settings_title = explode(' ', $settings_title);
                    ?>
                    <a href="home" class="logo">
                        <strong>
                            <?php echo $settings_title[0]; ?>

                            <?php
                            if (!empty($settings_title[1])) {
                                echo $settings_title[1];
                            }
                            ?>

                            <?php
                            if (!empty($settings_title[2])) {
                                echo $settings_title[2];
                            }
                            if (empty($settings_title[0]) and empty($settings_title[1]) and empty($settings_title[2]))
                            {
                                echo "Health Services"; 
                            }

                            ?>

                        </strong>
                    </a>

                <?php } else { ?>

                    <a href="" class="logo">
                        <strong>
                            Pharmacy
                            <span>
                                System
                            </span>
                        </strong>
                    </a>

                <?php } ?>
                <!--logo end-->
                <div class="nav notify-row" id="top_menu">
                    <!--  notification start -->
                    <ul class="nav top-menu">
                        <!-- Bed Notification start -->
                     
                        <!-- medicine notification end -->  
                        
                    </ul>
                </div>
                <div class="top-nav ">

                    <ul class="nav pull-right top-menu">
                        <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <img alt="" src="uploads/favicon.png" width="21" height="23">
                                <span class="username">
                                    <?php
                                    $username = $this->ion_auth->user()->row()->username;
                                    if (!empty($username)) {
                                        $username = explode(' ', $username);
                                        $first_name = $username[0];
                                        echo $first_name;
                                    }
                                    ?> 
                                </span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu extended logout">
                                <div class="log-arrow-up"></div>
                                <?php if (!$this->ion_auth->in_group('admin')) { ?> 
                                    <li><a href=""><i class="fa fa-home"></i> <?php echo lang('dashboard'); ?></a></li>
                                <?php } ?>
                                <li><a href="profile"><i class=" fa fa-suitcase"></i><?php echo lang('profile'); ?></a></li>
                                <?php if ($this->ion_auth->in_group('admin')) { ?> 
                                    <li><a href="settings"><i class="fa fa-cog"></i> <?php echo lang('settings'); ?></a></li>
                                <?php } ?>

                                <li><a><i class="fa fa-user"></i> <?php echo $this->ion_auth->get_users_groups()->row()->name ?></a></li>
                                <li><a href="auth/logout"><i class="fa fa-key"></i> <?php echo lang('log_out'); ?></a></li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->
                    </ul>
                    <?php
                    $message = $this->session->flashdata('feedback');
                    if (!empty($message)) {
                        ?>
                        <code class="flashmessage pull-right"> <?php echo $message; ?></code>
                    <?php } ?> 
                </div>
            </header>
            <!--header end-->
            <!--sidebar start-->

            <!--sidebar start-->
            <aside>
                
                <div id="sidebar"  class="nav-collapse" style="<?php  ?>">
                    <!-- sidebar menu start-->
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a href="home"> 
                                <i class="fa fa-home"></i>
                                <span><?php echo lang('dashboard'); ?></span>
                            </a>
                        </li>
                        <?php if ($this->ion_auth->in_group(array('superadmin'))) { ?>
                        <li>
                            <a href="hospital/pharmacies"> 
                                <i class="fas fa-hospital-alt"></i>
                                <span><?php echo 'All Pharmacies'; ?></span>
                            </a>
                        </li>

                        <li>
                            <a href="request">
                                <i class="fa fa-sitemap"></i>
                                <span><?php echo lang('requests'); ?></span>
                            </a>
                        </li>

                        <li>
                            <a href="hospital/pharmacy/porders"> 
                                <i class="fa fa-money-check"></i>
                                <span>Orders</span>
                                <span class="badge bg-warning">
                                <?php $this->db->where('status','pending');
                                $res_num_orders = $this->db->get('mp_orders')->num_rows(); echo $res_num_orders ?></span>
                            </a>
                        </li>

                        <!--<li>-->
                        <!--    <a href="medicine"> -->
                        <!--        <i class="fas fa-capsules"></i>-->
                        <!--        <span><?php echo 'Medicines'; ?></span>-->
                        <!--    </a>-->
                        <!--</li>   -->
                        
                        <li class="sub-menu">
                            <a href="javascript:;" >
                                <i class="fa fa-capsules"></i>
                                <span><?php echo lang('medicine'); ?></span>
                            </a>
                            <ul class="sub">
                                <li><a  href="medicine"><i class="fa fa-medkit"></i><?php echo lang('medicine_list'); ?></a></li>
                                <li><a  href="medicine/addMedicineView"><i class="fa fa-plus-circle"></i><?php echo lang('add_medicine'); ?></a></li>
                                <li><a  href="medicine/medicineCategory"><i class="fa fa-edit"></i><?php echo lang('medicine_category'); ?></a></li>
                                <li><a  href="medicine/addCategoryView"><i class="fa fa-plus-circle"></i><?php echo lang('add_medicine_category'); ?></a></li>
                                <!-- <li><a  href="medicine/medicineStockAlert"><i class="fa fa-plus-circle"></i><?php echo lang('medicine_stock_alert'); ?></a></li> -->

                            </ul>
                        </li>
                    <?php }
                    elseif($saleman_handler==1)
                    { ?>
                        <li><a href="home/porders"><i class="fa fa-money-check"></i> <span>Orders</span> 
                        <span class="badge bg-warning">
                        <?php                             
                            $uid = $this->ion_auth->get_user_id(); 
                            $this->db->where(array('status' => 'pending', 'assign_to_saleman' => $uid));
                            $res_num_orders = $this->db->get('mp_orders')->num_rows(); echo $res_num_orders ?>                                
                        </span></a>
                        </li>
                   <?php }
                    else{
                        if ($this->ion_auth->in_group(array('Pharmacist')))
                        {
                            $modules = $this->home_model->getPharmacyModulesById();
                        }
                        else
                        {
                            $modules = $this->home_model->getPharmacyModules();
                        }
                        $modules = explode(',',$modules);
                        // echo "<pre>";
                        // print_r($modules);
                        if (!$this->ion_auth->in_group(array('Pharmacist')))
                        {
                        if(in_array('pharmacists', $modules)){
                        ?>
                        <li><a href="<?php echo base_url() ?>home/pharmacists"><i class="fa fa-users"></i> Pharmacists</a></li>
                        <?php }
                        }
                        if(in_array('orders', $modules)){
                        ?>
                        <li><a href="home/porders"><i class="fa fa-money-check"></i> <span>Orders</span> <span class="badge bg-warning">
                        <?php 
                            if ($this->ion_auth->in_group(array('Pharmacist')))
                            {
                                $uid = $this->session->userdata('hospital_ion_id');
                            } 
                            else
                            {
                                $uid = $this->ion_auth->get_user_id(); 
                            }
                            $this->db->where(array('status' => 'in_progress', 'assign_to' => $uid));
                            $res_num_orders = $this->db->get('mp_orders')->num_rows(); echo $res_num_orders ?></span></a>
                        </li>
                        <?php }
                        if(in_array('orders', $modules)){
                         ?>
                        <li><a href="home/salesman"><i class="fa fa-users"></i> Salesman</a></li>
                        <?php } } ?>
                        <li>
                            <a href="profile" >
                                <i class="fa fa-user"></i>
                                <span> <?php echo lang('profile'); ?> </span>
                            </a>
                        </li>

                        <!--multi level menu start-->

                        <!--multi level menu end-->

                    </ul>
                    <!-- sidebar menu end-->
                </div>
            </aside>
            <!--sidebar end-->




