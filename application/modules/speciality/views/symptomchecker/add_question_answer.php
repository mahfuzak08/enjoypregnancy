<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo 'Add'; ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">           
                        <div class="col-lg-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <?php echo validation_errors(); ?>
                                    <form role="form" action="speciality/addNewQuestioningAnswering" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Symptom</label>
                                                    <select class="form-control select2" name="symptom">
                                                        <option value="">Select Symptom</option>
                                                        <?php foreach($symptoms as $val){ ?>
                                                        <option value="<?php echo $val->symptoms ?>"> <?php echo $val->symptoms; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Question</label>
                                                    <textarea class="form-control ckeditor" id="editor1" name="question" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Answer</label>
                                                    <textarea class="form-control ckeditor" id="editor2" name="answer" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Self Care</label>
                                                    <textarea class="form-control ckeditor" id="editor3" name="self_care" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="id" value=''>
                                        <button type="submit" name="submit" class="btn btn-info"><?php echo lang('submit'); ?></button>
                                        <a href="symptomchecker/questionsAndanswers" name="submit" class="btn btn-primary"><?php echo 'Back to List'; ?></a>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->
<script type="text/javascript">
    $(document).ready(function () {
        $(".select2").select2();
    });
</script>
