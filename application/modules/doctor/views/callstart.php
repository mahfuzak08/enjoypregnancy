<!-- main page content in right side -->
<div class="col-md-7 col-lg-8 col-xl-9">
	<!-- patient top info and graph status -->
	<?php $this->load->view("partial/_doctor_top_info"); ?>
	<!-- / patient top info and graph status -->
	<div class="row">
		<div class="col-md-12 text-center">
            <h1>Join Zoom Meeting</h1>
            <a href="<?= site_url("doctor/dashboard"); ?>" class="btn btn-sm bg-info-light">
                <i class="fa fa-chevron-left"></i> Go Back
            </a>
        </div>
    </div>
</div>
<script>
        // Function to open the popup window
        function openPopup(url) {
            var width = 600;
            var height = 400;
            var left = (screen.width / 2) - (width / 2);
            var top = (screen.height / 2) - (height / 2);
            window.open(url, '_blank', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + width + ', height=' + height + ', top=' + top + ', left=' + left);
        }

        // Function to show the popup when the page loads
        window.onload = function() {
            var url = '<?php echo $url; ?>';
            openPopup(url);
        };
</script>