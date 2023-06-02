
<!--main content start-->
<section id="main-content" class="panel">


            <header class="panel-heading">
                <h5><?= $template->name; ?></h5>
            </header>
            <div class="panel-body">

                <div class="adv-tableX  ">


                    <div class="col-md-12 col-sm-12">
                        <form action="<?=base_url('pf/saveAnsFrm') ?>" method="post" enctype="multipart/form-data">
                            <div id="sectionArea">
                                <input type="hidden" name="token" value="<?= $template->token ?>" required >
                                      <?php
                                        foreach ($sections as $key => $section) {
                                        ?>
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <?=html_entity_decode($section->section);?>
                                            </div>
                                            <div class="panel-body" >

                                                <?php
                                                $qsi = 1;
                                                $quizs = $this->pf_model->getQuizById($section->id);

                                                if (!empty($quizs))
                                                    foreach ($quizs as $quiz) if ($quiz) { ?>

                                                        <div class="form-group">
                                                            <h4><?=html_entity_decode($quiz->question); ?>
                                                                <?php if ($quiz->question_type == 'MC') { ?>
                                                                <?php if ($quiz->required == 1) { ?>  *  <?php } ?></h4>
                                                            <?php
                                                            $answares = $this->pf_model->getAnswareById($quiz->id);
                                                            if ($answares)
                                                                foreach ($answares as $k => $ans) { ?>
                                                                    <p><input type="checkbox"
                                                                              name="ans[<?= $quiz->id ?>][]"
                                                                              value="<?= $ans->answare ?>" data-req="<?=$quiz->required?>" class="checkboxReqCheck" <?= ($quiz->required == 1) ? 'required' : '' ?>> <?=html_entity_decode($ans->answare)?>
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
                                                                                  value="<?= $ans->answare ?>" <?= ($quiz->required == 1) ? 'required' : '' ?>> <?=html_entity_decode($ans->answare)?>
                                                                        </p>
                                                                    <?php } ?>
                                                            <?php } ?>
                                                            <?php if ($quiz->question_type == 'SLT') { ?>

                                                                <?php if ($quiz->required == 1) { ?> * <?php } ?></h4>
                                                                <p><input type="text" class="form-control"
                                                                          name="ans[<?= $quiz->id ?>]" <?=($quiz->required == 1) ? 'required' : '' ?>>
                                                                </p>
                                                            <?php } ?>

                                                            <?php if ($quiz->question_type == 'PF') { ?>
                                                                <?php if ($quiz->required == 1) { ?> * <?php } ?></h4>
                                                                <p><textarea class="form-control"
                                                                             name="ans[<?= $quiz->id ?>]"  <?= ($quiz->required == 1) ? 'required' : '' ?>></textarea>
                                                                </p>
                                                            <?php } ?>

                                                            <?php if ($quiz->question_type == 'Attach') { ?>
                                                                <?php if ($quiz->required == 1) { ?> *  <?php } ?></h4>
                                                                <p><input type="file"
                                                                          name="ans[<?= $quiz->id ?>]" <?= ($quiz->required == 1) ? 'required' : '' ?>>
                                                                </p>
                                                            <?php } ?>

                                                            <?php if ($quiz->question_type == 'Signature') { ?>
                                                                <?php if ($quiz->required == 1) { ?>  *  <?php } ?></h4>
                                                                <div class="form-group">


                                                                            <canvas id="sig-canvas"  width="500"  height="200"> </canvas>


                                                                        <div>
                                                                            <button type="button" class="btn btn-default btn-xs" id="sig-clearBtn">Clear Signature</button>
                                                                        </div>


                                                                </div>
                                                                <p><input type="hidden" id="signature"  name="ans[<?= $quiz->id ?>]" <?= ($quiz->required == 1) ? 'required' : '' ?> value="<?='/uploads/signature/'.$template->token.'.jpg'?>">
                                                                </p>
                                                            <?php } ?>

                                                            <input type="hidden" name="anstype[<?= $quiz->id ?>]"   value="<?= $quiz->question_type ?>">
                                                            <hr/>
                                                        </div>
                                                    <?php  } ?>

                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>


                            </div>

                       </form>
                </div>

            </div>
                <style>
                    .signature{
                        border: 0px solid #dedede;
                        width: 100%;
                        height: 200px;
                        background: white;
                        padding: 0;
                        margin: 0;
                    }
                </style>

                <link rel="stylesheet" href="<?=base_url()?>common/css/bootstrap_form.css">
                <script src="https://code.jquery.com/jquery-2.1.0.min.js"></script>
                <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

                <script src="<?=base_url('common/js/signature.js')?>"></script>

                <script>
                    $(document).ready(function(){
                        $('.checkboxReqCheck').click(function(){
                           var namecheckbox = $(this).prop('name');
                            var requiredcheckbox = $(this).prop('required');
                            var reqStatus = $(this).data('req');
                  
                            ischeck =  $('input[name="'+namecheckbox+'"]').is(':checked')
                            if(!ischeck && reqStatus == 1){
                                $('input[name="'+namecheckbox+'"]').prop("required", true)
                            }else $('input[name="'+namecheckbox+'"]').prop("required", false)

                        })



                        $('#sig-canvas').fadeIn()
                        $.fn.saveSignature = function(dataUrl){

                            $.ajax({
                                type: "POST",
                                url: "<?=base_url()?>uploadsignatre.php",
                                data: {
                                    imgBase64: dataUrl,
                                    filename: "<?=$template->token.'.jpg'?>"
                                }
                            }).done(function(obj) {

                            });
                        }

                    });
                </script>

                <style>
                    body {
                        padding-top: 0px;
                        padding-bottom: 0px;
                    }

                    #sig-canvas {
                        border: 2px dotted #CCCCCC;
                        border-radius: 5px;
                        cursor: crosshair;
                        height: 200px;
                        display: none;
                    }

                    #sig-dataUrl {
                        width: 100%;
                    }

                </style>
</section>



