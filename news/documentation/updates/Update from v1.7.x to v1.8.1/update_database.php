<?php
define('BASEPATH', "/");
define('ENVIRONMENT', 'production');
require_once "application/config/database.php";
$license_code = '';
$purchase_code = '';
if (!file_exists('old')) {
    echo '<strong>"old" folder not found!</strong><br>';
    echo 'The script will move all language translations from "old/application/language" folder to the database. So you need to create a folder named "old" for your old files. 
    Please change the name of your folder to the "old".';
    exit();
}
if (file_exists('license.php')) {
    include 'license.php';
}

if (!function_exists('curl_init')) {
    $error = 'cURL is not available on your server! Please enable cURL to continue the installation. You can read the documentation for more information.';
    exit();
}

//set database credentials
$database = $db['default'];
$db_host = $database['hostname'];
$db_name = $database['database'];
$db_user = $database['username'];
$db_password = $database['password'];

/* Connect */
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
$connection->query("SET CHARACTER SET utf8");
$connection->query("SET NAMES utf8");
if (!$connection) {
    $error = "Connect failed! Please check your database credentials.";
}

if (isset($_POST["btn_submit"])) {
    if (!empty($license_array) && !empty($license_array["purchase_code"]) && !empty($license_array["license_code"])) {
        update($license_array["license_code"], $license_array["purchase_code"], $connection);
        sleep(1);
        /* close connection */
        mysqli_close($connection);
        $success = 'The update has been successfully completed! Please delete the "update_database.php" file.';
    } else {
        $input_code = trim($_POST['license_code']);
        //current URL
        $http = 'http';
        if (isset($_SERVER['HTTPS'])) {
            $http = 'https';
        }
        $host = $_SERVER['HTTP_HOST'];
        $requestUri = $_SERVER['REQUEST_URI'];
        $current_url = $http . '://' . htmlentities($host) . '/' . htmlentities($requestUri);
        //check license
        $url = "https://codingest.net/api/verify-varient-license?license_code=" . $input_code . "&domain=" . $current_url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        if (empty($response)) {
            $url = "http://codingest.net/api/verify-varient-license?license_code=" . $input_code . "&domain=" . $current_url;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        $data = json_decode($response);
        if (!empty($data)) {
            if ($data->code == "error") {
                $error = "Invalid License Code!";
            } else {
                $license_code = $input_code;
                $purchase_code = $data->code;
                update($license_code, $purchase_code, $connection);
                sleep(1);
                /* close connection */
                mysqli_close($connection);
                $success = 'The update has been successfully completed! Please delete the "update_database.php" file.';
            }
        } else {
            $error = "Invalid License Code!";
        }
    }
}

function update($license_code, $purchase_code, $connection)
{
    update_17_to_18($license_code, $purchase_code, $connection);
    add_new_translations($license_code, $purchase_code, $connection);
}

function update_17_to_18($license_code, $purchase_code, $connection)
{
    $version = '1.7';
    $sql = "SELECT * FROM general_settings WHERE id = 1";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        if (!empty($row['version'])) {
            if ($row['version'] == '1.7.1') {
                $version = '1.7.1';
            }
        }
    }

    if ($version == '1.7') {
        $table_post_pageviews_week = "CREATE TABLE `post_pageviews_week` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `post_id` int(11) DEFAULT NULL,
            `ip_address` varchar(30) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        mysqli_query($connection, $table_post_pageviews_week);
        mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `version` VARCHAR(30) DEFAULT '1.8.1';");
        mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `last_popular_post_update` TIMESTAMP;");
        mysqli_query($connection, "ALTER TABLE post_pageviews_week ADD INDEX idx_post_id (post_id)");
        mysqli_query($connection, "ALTER TABLE post_pageviews_week ADD INDEX idx_created_at (created_at)");
        mysqli_query($connection, "RENAME TABLE post_pageviews TO post_pageviews_month;");
    }


    $table_language_translations = "CREATE TABLE `language_translations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `lang_id` smallint(6) DEFAULT NULL,
    `label` varchar(255) DEFAULT NULL,
    `translation` varchar(500) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_payouts = "CREATE TABLE `payouts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` int(11) DEFAULT NULL,
    `username` varchar(100) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `amount` double NOT NULL,
    `payout_method` varchar(50) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_user_payout_accounts = "CREATE TABLE `user_payout_accounts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` int(11) DEFAULT NULL,
    `payout_paypal_email` varchar(255) DEFAULT NULL,
    `iban_full_name` varchar(255) DEFAULT NULL,
    `iban_country` varchar(100) DEFAULT NULL,
    `iban_bank_name` varchar(255) DEFAULT NULL,
    `iban_number` varchar(500) DEFAULT NULL,
    `swift_full_name` varchar(255) DEFAULT NULL,
    `swift_address` varchar(500) DEFAULT NULL,
    `swift_state` varchar(255) DEFAULT NULL,
    `swift_city` varchar(255) DEFAULT NULL,
    `swift_postcode` varchar(100) DEFAULT NULL,
    `swift_country` varchar(100) DEFAULT NULL,
    `swift_bank_account_holder_name` varchar(255) DEFAULT NULL,
    `swift_iban` varchar(255) DEFAULT NULL,
    `swift_code` varchar(255) DEFAULT NULL,
    `swift_bank_name` varchar(255) DEFAULT NULL,
    `swift_bank_branch_city` varchar(255) DEFAULT NULL,
    `swift_bank_branch_country` varchar(100) DEFAULT NULL,
    `default_payout_account` varchar(30) NOT NULL DEFAULT 'paypal'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";


    mysqli_query($connection, $table_language_translations);
    mysqli_query($connection, $table_payouts);
    mysqli_query($connection, $table_user_payout_accounts);
    sleep(1);

    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `pwa_status` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `show_latest_posts_on_slider` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `show_latest_posts_on_featured` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `text_editor_lang`;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `last_popular_post_update`;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `show_user_email_on_profile` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `reward_system_status` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `reward_amount` DOUBLE DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `currency_name` VARCHAR(100) DEFAULT 'US Dollar';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `currency_symbol` VARCHAR(10) DEFAULT '$';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `currency_format` VARCHAR(10) DEFAULT 'us';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `currency_symbol_format` VARCHAR(10) DEFAULT 'left';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `payout_paypal_status` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `payout_iban_status` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `payout_swift_status` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `cookie_prefix` VARCHAR(50);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `last_cron_update` TIMESTAMP;");

    mysqli_query($connection, "ALTER TABLE images DROP COLUMN `lang_id`;");
    mysqli_query($connection, "ALTER TABLE languages ADD COLUMN `text_editor_lang` VARCHAR(30) DEFAULT 'en';");

    mysqli_query($connection, "ALTER TABLE post_pageviews_month ADD COLUMN `post_user_id` INT;");
    mysqli_query($connection, "ALTER TABLE post_pageviews_month ADD COLUMN `user_agent` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE post_pageviews_month ADD COLUMN `reward_amount` DOUBLE DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE post_pageviews_week ADD COLUMN `post_user_id` INT;");
    mysqli_query($connection, "ALTER TABLE post_pageviews_week ADD COLUMN `user_agent` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE post_pageviews_week ADD COLUMN `reward_amount` DOUBLE DEFAULT 0;");

    mysqli_query($connection, "ALTER TABLE roles_permissions ADD COLUMN `reward_system` TINYINT(1) DEFAULT 1;");

    mysqli_query($connection, "ALTER TABLE routes ADD COLUMN `delete_account` VARCHAR(100) DEFAULT 'delete-account';");
    mysqli_query($connection, "ALTER TABLE routes ADD COLUMN `earnings` VARCHAR(100) DEFAULT 'earnings';");
    mysqli_query($connection, "ALTER TABLE routes ADD COLUMN `payouts` VARCHAR(100) DEFAULT 'payouts';");
    mysqli_query($connection, "ALTER TABLE routes ADD COLUMN `set_payout_account` VARCHAR(100) DEFAULT 'set-payout-account';");

    mysqli_query($connection, "ALTER TABLE rss_feeds ADD COLUMN `is_cron_updated` TINYINT(1) DEFAULT 0;");

    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `reward_system_enabled` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `balance` DOUBLE DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `total_pageviews` INT DEFAULT 0;");
    sleep(1);

    //update version and add cookie prefix
    $cookie_prefix = uniqid();
    mysqli_query($connection, "UPDATE general_settings SET version='1.8.1', cookie_prefix='" . $cookie_prefix . "' WHERE id='1'");
    //update roles
    mysqli_query($connection, "UPDATE roles_permissions SET reward_system = 0 WHERE role = 'author' OR role = 'user'");

    //add language translations
    $sql = "SELECT * FROM languages ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $path = "old/application/language/" . $row["folder_name"] . "/site_lang.php";
        if (file_exists($path)) {
            include $path;
            if (!empty($lang)) {
                foreach ($lang as $key => $value) {
                    $insert_translation = "INSERT INTO `language_translations` (`lang_id`, `label`, `translation`) 
                    VALUES (" . $row["id"] . ", '" . $key . "' , '" . $value . "')";
                    mysqli_query($connection, $insert_translation);
                }
            }
        }
    }
    mysqli_query($connection, "ALTER TABLE languages DROP COLUMN `folder_name`;");
    //add index
    mysqli_query($connection, "ALTER TABLE language_translations ADD INDEX idx_lang_id (lang_id);");
    mysqli_query($connection, "ALTER TABLE user_payout_accounts ADD INDEX idx_user_id (user_id);");
}

function add_new_translations($license_code, $purchase_code, $connection)
{
    $lang = array();
    $lang["dashboard"] = "Dashboard";
    $lang["earnings"] = "Earnings";
    $lang["payouts"] = "Payouts";
    $lang["pageviews"] = "Pageviews";
    $lang["reward_system"] = "Reward System";
    $lang["reward_amount"] = "Reward Amount for 1000 Pageviews";
    $lang["currency_name"] = "Currency Name";
    $lang["currency_symbol"] = "Currency Symbol";
    $lang["currency_format"] = "Currency Format";
    $lang["currency"] = "Currency";
    $lang["user_id"] = "User Id";
    $lang["total_pageviews"] = "Total Pageviews";
    $lang["balance"] = "Balance";
    $lang["currency_symbol_format"] = "Currency Symbol Format";
    $lang["left"] = "Left";
    $lang["right"] = "Right";
    $lang["payouts"] = "Payouts";
    $lang["amount"] = "Amount";
    $lang["payout_method"] = "Payout Method";
    $lang["payout_methods"] = "Payout Methods";
    $lang["cookie_prefix"] = "Cookie Prefix";
    $lang["add_payout"] = "Add Payout";
    $lang["insufficient_balance"] = "Insufficient balance!";
    $lang["msg_payout_added"] = "Payout has been successfully added!";
    $lang["confirm_record"] = "Are you sure you want to delete this record?";
    $lang["paypal"] = "PayPal";
    $lang["iban"] = "IBAN";
    $lang["swift"] = "SWIFT";
    $lang["set_payout_account"] = "Set Payout Account";
    $lang["paypal_email_address"] = "PayPal Email Address";
    $lang["set_default_payment_account"] = "Set as Default Payment Account";
    $lang["full_name"] = "Full Name";
    $lang["bank_name"] = "Bank Name";
    $lang["iban_long"] = "International Bank Account Number";
    $lang["swift_iban"] = "Bank Account Number/IBAN";
    $lang["postcode"] = "Postcode";
    $lang["bank_account_holder_name"] = "Bank Account Holder's Name";
    $lang["bank_branch_country"] = "Bank Branch Country";
    $lang["bank_branch_city"] = "Bank Branch City";
    $lang["swift_code"] = "SWIFT Code";
    $lang["country"] = "Country";
    $lang["state"] = "State";
    $lang["city"] = "City";
    $lang["warning_default_payout_account"] = "Your earnings will be sent to your default payout account.";
    $lang["user_agent"] = "User-Agent";
    $lang["upload_csv_file"] = "Upload CSV File";
    $lang["completed"] = "Completed";
    $lang["help_documents"] = "Help Documents";
    $lang["help_documents_exp"] = "You can use these documents to generate your CSV file";
    $lang["category_ids_list"] = "Category Ids list";
    $lang["download_csv_template"] = "Download CSV Template";
    $lang["download_csv_example"] = "Download CSV Example";
    $lang["bulk_post_upload"] = "Bulk Post Upload";
    $lang["bulk_post_upload_exp"] = "You can add your posts with a CSV file from this section";
    $lang["importing_posts"] = "Importing posts...";
    $lang["documentation"] = "Documentation";
    $lang["field"] = "Field";
    $lang["data_type"] = "Data Type";
    $lang["required"] = "Required";
    $lang["optional"] = "Optional";
    $lang["show_user_email_profile"] = "Show User's Email on Profile";
    $lang["pwa_warning"] = "If you enable PWA option, read 'Progressive Web App (PWA)' section from our documentation to make the necessary settings.";
    $lang["email_status"] = "Email Status";
    $lang["enable_reward_system"] = "Enable Reward System";
    $lang["disable_reward_system"] = "Disable Reward System";
    $lang["delete_account"] = "Delete Account";
    $lang["delete_account_confirm"] = "Deleting your account is permanent and will remove all content including comments, avatars and profile settings. Are you sure you want to delete your account?";
    $lang["msg_wrong_password"] = "Wrong Password!";
    $lang["show_latest_posts_on_slider"] = "Show Latest Posts on Slider";
    $lang["show_latest_posts_on_featured"] = "Show Latest Posts on Featured Posts";
    //add new phrases
    $sql = "SELECT * FROM languages ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        if (!empty($lang)) {
            foreach ($lang as $key => $value) {
                $insert_new_translation = "INSERT INTO `language_translations` (`lang_id`, `label`, `translation`) 
                    VALUES (" . $row["id"] . ", '" . $key . "' , '" . $value . "')";
                mysqli_query($connection, $insert_new_translation);
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Varient - Update Wizard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
    <!-- Font-awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #444 !important;
            font-size: 14px;

            background: #007991; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #007991, #6fe7c2); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #007991, #6fe7c2); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }

        .logo-cnt {
            text-align: center;
            color: #fff;
            padding: 60px 0 60px 0;
        }

        .logo-cnt .logo {
            font-size: 42px;
            line-height: 42px;
        }

        .logo-cnt p {
            font-size: 22px;
        }

        .install-box {
            width: 100%;
            padding: 30px;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            background-color: #fff;
            border-radius: 4px;
            display: block;
            float: left;
            margin-bottom: 100px;
        }

        .form-input {
            box-shadow: none !important;
            border: 1px solid #ddd;
            height: 44px;
            line-height: 44px;
            padding: 0 20px;
        }

        .form-input:focus {
            border-color: #239CA1 !important;
        }

        .btn-custom {
            background-color: #239CA1 !important;
            border-color: #239CA1 !important;
            border: 0 none;
            border-radius: 4px;
            box-shadow: none;
            color: #fff !important;
            font-size: 16px;
            font-weight: 300;
            height: 40px;
            line-height: 40px;
            margin: 0;
            min-width: 105px;
            padding: 0 20px;
            text-shadow: none;
            vertical-align: middle;
        }

        .btn-custom:hover, .btn-custom:active, .btn-custom:focus {
            background-color: #239CA1;
            border-color: #239CA1;
            opacity: .8;
        }

        .tab-content {
            width: 100%;
            float: left;
            display: block;
        }

        .tab-footer {
            width: 100%;
            float: left;
            display: block;
        }

        .buttons {
            display: block;
            float: left;
            width: 100%;
            margin-top: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            margin-top: 0;
            text-align: center;
        }

        .sub-title {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 30px;
            margin-top: 0;
            text-align: center;
        }

        .alert {
            text-align: center;
        }

        .alert strong {
            font-weight: 500 !important;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-md-offset-2">

            <div class="row">
                <div class="col-sm-12 logo-cnt">
                    <h1>Varient</h1>
                    <p>Welcome to the Update Wizard</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="install-box">
                        <h2 class="title">Update from v1.7.x to v1.8.1</h2>
                        <br><br>
                        <div class="messages">
                            <?php if (!empty($error)) { ?>
                                <div class="alert alert-danger">
                                    <strong><?php echo $error; ?></strong>
                                </div>
                            <?php } ?>
                            <?php if (!empty($success)) { ?>
                                <div class="alert alert-success">
                                    <strong><?php echo $success; ?></strong>
                                    <style>.alert-info {
                                            display: none;
                                        }</style>
                                </div>
                            <?php } ?>
                        </div>
                        <?php
                        if (empty($success)):
                            if (empty($license_array) || empty($license_array["purchase_code"]) || empty($license_array["license_code"])): ?>
                                <div class="alert alert-info" role="alert">
                                    You can get your license code from our support system: <a href="https://codingest.net/" target="_blank"><strong>https://codingest.net</strong></a>
                                </div>
                            <?php endif;
                        endif; ?>
                        <div class="step-contents">
                            <div class="tab-1">
                                <?php if (empty($success)): ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <div class="tab-content">
                                            <div class="tab_1">
                                                <?php if (empty($license_array) || empty($license_array["purchase_code"]) || empty($license_array["license_code"])): ?>
                                                    <div class="form-group">
                                                        <label for="email">License Code</label>
                                                        <textarea name="license_code" class="form-control form-input" style="resize: vertical; min-height: 80px; height: 80px; line-height: 24px;padding: 10px;" placeholder="Enter License Code" required><?php echo $license_code; ?></textarea>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="tab-footer text-center">
                                            <button type="submit" name="btn_submit" class="btn-custom">Update My Database</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
