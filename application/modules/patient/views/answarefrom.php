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
                                                $andGroup = array('MC', 'SC', 'SLT','PF');
                                                if (!empty($quizs))
                                                    foreach ($quizs as $quiz) if ($quiz) { ?>
                                                        <div class="form-group">
                                                            <h4><?= $quiz->question ?></h4>
                                                           <?php
                                                           $ans = $this->pf_model->getPatientAnswareById($quiz->id, $template->fid);
                                                           if (in_array($quiz->question_type ,$andGroup)) { ?>
                                                            <?php

                                                            if ($ans)  { ?>
                                                                    <p>
                                                                        <?php
                                                                           $anwares = $ans->answare ;
                                                                         echo  $anwares = str_replace('|','<br>',$anwares);

                                                                        ?>   </p>
                                                                <?php } ?>
                                                            <?php } ?>

                                                            <?php if ($quiz->question_type == 'Attach') {
                                                                $ext = pathinfo($ans->answare, PATHINFO_EXTENSION);
                                                                ?>
                                                                <p>
                                                                  <?php
                                                                   $extensionImg = array("jpeg", "jpg", "png", "gif", "pdf" );
                                                                  $extensionVideo = array(  "mp4", "wav", "ogg", "avi","webm");
                                                                  if(in_array($ext,$extensionImg)){ ?>
                                                                    <a href="<?=base_url($ans->answare)?>" target="_blank">
                                                                        <img src="<?=base_url($ans->answare) ?>" height="100">  </a>
                                                                  <?php }
                                                                    if(in_array($ext,$extensionVideo)){ ?>
                                                                    <a href="<?=base_url($ans->answare)?>" target="_blank">
                                                                        <video controls width="250">

                                                                            <source src="<?=base_url($ans->answare) ?>"
                                                                                    type="video/webm">

                                                                            <source src="<?=base_url($ans->answare) ?>"
                                                                                    type="video/mp4">

                                                                            Sorry, your browser doesn't support embedded videos.
                                                                        </video>
                                                                       </a>
                                                                    <?php }?>
                                                                </p>
                                                            <?php } ?>

                                                            <?php if ($quiz->question_type == 'Signature') { ?>
                                                                <p><img src="<?=base_url($ans->answare)?>" height="60">  </p>
                                                            <?php } ?>

                                                            <hr>
                                                        </div>

                                                    <?php } ?>

                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group text-right">
                                        <button type="button" onclick="window.close()" class="btn btn-success">Close</button>
                                    </div>
                            </div>
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



