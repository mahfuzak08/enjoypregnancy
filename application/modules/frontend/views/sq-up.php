<?php 
$currency = $this->settings_model->get_api_info('currency');
$squareup = $this->settings_model->get_api_info('squareup');
?>
<?php $cur_exc = json_decode(file_get_contents("https://www.amdoren.com/api/currency.php?api_key=". $currency->key1 ."&from=$base&to=GBP&amount=$baseamt")); ?>
<html>
	<head>
		<title><?= $title; ?></title>
		<!-- link to the Square web payment SDK library -->
		<script type="text/javascript" src="<?= $squareup->key1; ?>"></script>
		<script type="text/javascript">
			window.applicationId = "<?= $squareup->key2; ?>";
			window.locationId = "<?= $squareup->key3; ?>";
			window.currency = "GBP";
			window.country = "USA";
		</script>
		<link rel="stylesheet" type="text/css" href="<?= base_url("new_assets/plugins/sq-up/public/stylesheets/style.css"); ?>">
		<link rel="stylesheet" type="text/css" href="<?= base_url("new_assets/plugins/sq-up/public/stylesheets/sq-payment.css"); ?>">
	</head>

	<body>
		<form class="payment-form" id="fast-checkout">
			<div class="wrapper">
				<h3><?= $title; ?></h3>
				<input id="account-holder-name" type="text" placeholder="Full Name" name="ach-account-holder-name" autocomplete="name" />
				<div id="card-container"></div>
				<?php //print_r($cur_exc); ?>
				<button id="card-button" type="button">GBP <?= $cur_exc->amount; ?> Pay Now</button>
				<input type="hidden" name="token" id="token">
				<span id="payment-flow-message"></span>
			</div>
		</form>

		<script type="text/javascript" src="<?= base_url("new_assets/plugins/sq-up/public/js/sq-card-pay.js"); ?>"></script>
		<script type="text/javascript" src="<?= base_url("new_assets/plugins/sq-up/public/js/sq-payment-flow.js"); ?>"></script>
	</body>

</html>