<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading"><?= $head_label; ?></header>
            <div class="panel-body">
				<?php $val = array($apiinfo->key1, $apiinfo->key2, $apiinfo->key3, $apiinfo->key4, $apiinfo->key5, $apiinfo->key6); ?>
                <form action="settings/manage_api" method="post">
					<?php foreach($labels as $n=>$label) { ?>
					<div class="form-group col-md-12">
						<label><?= $label; ?></label> 
						<input type="text" class="form-control" name="key<?= ($n+1); ?>" value="<?= $val[$n]; ?>">
					</div>
					<?php } ?>
					<div class="form-group col-md-12"> 
						<input type="radio" name="status" value="1" <?= $apiinfo->status == 1 ? "checked" : ""; ?>>
						<label>Enable</label> 
						<input type="radio" name="status" value="0" <?= $apiinfo->status == 0 ? "checked" : ""; ?>>
						<label>Disable</label>
					</div>
					
					<div class="form-group col-md-12"> 
						<input type="hidden" name="id" value="<?= @$apiinfo->id; ?>">
						<input type="hidden" name="type" value="<?= $_GET['t']; ?>">
						<button type="submit" name="api-submit" class="btn green"> <?php echo lang('submit'); ?></button>
					</div>
				</form>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<script src="common/js/codearistos.min.js"></script>