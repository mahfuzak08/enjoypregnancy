<!--<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?php //echo base_url(); ?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Rizvi">
        <meta name="keyword" content="Php, Hospital, Clinic, Management, Software, Php, CodeIgniter, Hms, Accounting">
        <link rel="shortcut icon" href="uploads/favicon.png">
        <title>Forgot Password - <?php //echo $this->db->get('settings')->row()->system_vendor; ?></title>
        Bootstrap core CSS 
        <link href="common/css/bootstrap.min.css" rel="stylesheet">
        <link href="common/css/bootstrap-reset.css" rel="stylesheet">
       external css-
        <link href="common/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
         Custom styles for this template 
        <link href="common/css/style.css" rel="stylesheet">
        <link href="common/css/style-responsive.css" rel="stylesheet" />
         HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-
    </head>
    <body class="login-body">
        <div class="container">
            <style>
                form{
                    padding: 0px;
                    border: none;
                }
                .form-signin {
                    padding: 10px;
                    text-align: center;
                }
                .form-signin input[type="text"], .form-signin input[type="password"] {
                    border: 1px solid #555;
                }
            </style>
            <div class="form-signin">
                <h1><?php //echo lang('forgot_password_heading'); ?></h1>
                <p><?php //echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>
                <div id="infoMessage"><?php echo $message; ?></div>
                <?php //echo form_open("auth/forgot_password"); ?>
                <div class="login-wrap">
                    <p>
                        <label for="identity"><?php //echo (($type == 'email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label)); ?></label> <br />
                        <input type="text" class="form-control" placeholder="<?php //echo lang('email'); ?>" value="" name="email">
                    </p>
                </div>
                <input type="submit" class="btn detailsbutton" name="submit" value="Submit">
                <?php //echo form_close(); ?>
            </div>
        </div>
         js placed at the end of the document so the pages load faster
        <script src="common/js/jquery.js"></script>
        <script src="common/js/bootstrap.min.js"></script>
    </body>
</html>-->
<!-- Page Content -->
<div class="section-category content account-page">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-md-8 offset-md-2">
                
                <!-- Account Content -->
                <div class="account-content">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7 col-lg-6 login-left">
                            <img src="assets/img/login-banner.png" class="img-fluid" alt="Login Banner">    
                        </div>
                        <div class="col-md-12 col-lg-6 login-right">
                            <div class="login-header">
                                <h3>Forgot Password?</h3>
                                <p class="small text-muted">Enter your email to get a password reset link</p>
                            </div>
                            <style type="text/css">
                                .error_p p
                                {
                                    margin-bottom: 0px;
                                }
                            </style>
                            <!-- Forgot Password Form -->
                            <?php echo form_open("auth/forgot_password"); if($message!=""){?>
                                <div class="alert alert-danger error_p"><?php echo $message; ?></div>
                            <?php } ?>
                            <div class="login-wrap">
                                <div class="form-group form-focus">
                                    <input type="email" class="form-control floating" name="email">
                                    <label class="focus-label">Email</label>
                                </div>
                                <div class="text-right">
                                    <a class="forgot-link" href="auth/login">Remember your password?</a>
                                </div>
                            </div>
                            <!-- <input type="submit" class="btn detailsbutton" name="submit" value="Submit"> -->
                            <button class="btn btn-primary btn-block btn-lg login-btn" name="submit" type="submit">Reset Password</button>
                            <?php echo form_close(); ?>                            
                            <!-- /Forgot Password Form -->
                            
                        </div>
                    </div>
                </div>
                <!-- /Account Content -->
                
            </div>
        </div>

    </div>

</div>      
<!-- /Page Content -->