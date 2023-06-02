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
      ?>>
    <head>
        <base href="<?php echo base_url(); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Zamil">
        <meta name="keyword" content="Php, Hospital, Clinic, Management, Software, Php, CodeIgniter, Hms, Accounting">
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

        <link rel="stylesheet" type="text/css" href="common/assets/select2/css/select2.min.css"/>
        <link rel="stylesheet" type="text/css" href="common/css/lightbox.css"/>
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-fileupload/bootstrap-fileupload.css" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />

        <link rel="stylesheet" type="text/css" href="common/assets/DataTables/DataTables-1.10.16/custom/css/datatable-responsive-cdn-version-1-0-7.css" />


        <!-- Google Fonts -->

        <style>
            @import url('https://fonts.googleapis.com/css?family=Ubuntu&display=swap');
        </style>


        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->



                <style>
                    #main-content {
                        margin-left: 20px;
                    }

                    body {
                        background: #FFFFFF;
                    }
                </style>



    </head>

    <body class="transparent">
        <section id="container" class="">





