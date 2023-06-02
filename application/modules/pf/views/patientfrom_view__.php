<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">

            <header class="panel-heading">
                <h5><?= $template->name; ?></h5>

            </header>
            <div class="panel-body">

                <div class="adv-tableX  ">

                    <div class="space15"></div>
                    <div class="form-group">

                    </div>
                    <div class="col-md-7">
                        <form action="<?= base_url('pf/saveAnsFrm') ?>" method="post" enctype="multipart/form-data">
                            <div id="sectionArea">
                                <input type="hidden" name="token" value="<?= $template->token ?>" required>

                                <section>

                                    <?php
                                    foreach ($sections as $key => $section) {
                                        ?>
                                        <div class="panel panel-primary">
                                            <header class="panel-heading">
                                                <?= $section->section ?>
                                            </header>
                                            <div class="panel-body">
                                                <?php
                                                $qsi = 1;
                                                $quizs = $this->pf_model->getQuizById($section->id);

                                                if (!empty($quizs))
                                                    foreach ($quizs as $quiz) if ($quiz) { ?>

                                                        <div class="form-group">
                                                            <h4><?= $quiz->question ?>
                                                                <?php if ($quiz->question_type == 'MC') { ?>
                                                                <?php if ($quiz->required == 1) { ?>  *  <?php } ?></h4>
                                                            <?php
                                                            $answares = $this->pf_model->getAnswareById($quiz->id);
                                                            if ($answares)
                                                                foreach ($answares as $k => $ans) { ?>
                                                                    <p><input type="checkbox"
                                                                              name="ans[<?= $quiz->id ?>][]"
                                                                              value="<?= $ans->answare ?>" <?= ($quiz->required == 1) ? 'required' : '' ?>> <?= $ans->answare ?>
                                                                    </p>
                                                                <?php } ?>
                                                            <?php } ?>

                                                            <?php if ($quiz->question_type == 'SC') { ?>

                                                                <?php if ($quiz->required == 1) { ?>  *  <?php } ?></h4>
                                                                <?php
                                                                $answares = $this->pf_model->getAnswareById($quiz->id);
                                                                if ($answares)
                                                                    foreach ($answares as $k => $ans) { ?>
                                                                        <p><input type="radio"
                                                                                  name="ans[<?= $quiz->id ?>]"
                                                                                  value="<?= $ans->answare ?>" <?= ($quiz->required == 1) ? 'required' : '' ?>> <?= $ans->answare ?>
                                                                        </p>
                                                                    <?php } ?>
                                                            <?php } ?>
                                                            <?php if ($quiz->question_type == 'SLT') { ?>

                                                                <?php if ($quiz->required == 1) { ?>  *   <?php } ?></h4>
                                                                <p><input type="text" class="form-control"
                                                                          name="ans[<?= $quiz->id ?>]" <?= ($quiz->required == 1) ? 'required' : '' ?>>
                                                                </p>
                                                            <?php } ?>

                                                            <?php if ($quiz->question_type == 'PF') { ?>
                                                                <?php if ($quiz->required == 1) { ?>  *  <?php } ?></h4>
                                                                <p><textarea class="form-control"
                                                                             name="ans[<?= $quiz->id ?>]"  <?= ($quiz->required == 1) ? 'required' : '' ?>> </textarea>
                                                                </p>
                                                            <?php } ?>

                                                            <?php if ($quiz->question_type == 'Attach') { ?>
                                                                <?php if ($quiz->required == 1) { ?>  *  <?php } ?></h4>
                                                                <p><input type="file"
                                                                          name="ans[<?= $quiz->id ?>]" <?= ($quiz->required == 1) ? 'required' : '' ?>>
                                                                </p>
                                                            <?php } ?>

                                                            <?php if ($quiz->question_type == 'Signature') { ?>
                                                                <?php if ($quiz->required == 1) { ?>  *  <?php } ?></h4>
                                                                <p><input type="file"
                                                                          name="ans[<?= $quiz->id ?>]" <?= ($quiz->required == 1) ? 'required' : '' ?>>
                                                                </p>
                                                            <?php } ?>

                                                            <hr>
                                                        </div>
                                                        <input type="hidden" name="anstype[<?= $quiz->id ?>]"
                                                               value="<?= $quiz->question_type ?>">
                                                    <?php } ?>

                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                            </div>
                    </div>

                    </form>
                </div>

            </div>

            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->



