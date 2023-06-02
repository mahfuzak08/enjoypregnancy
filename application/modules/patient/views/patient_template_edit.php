<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">

            <header class="panel-heading">
                Showing patient form template
                <div class="col-md-4 no-print pull-right text-right">

                    <a class="btn btn-primary btn-sm"  href="<?=base_url('patient/edit_patient_form_template?id='.$template->id)?>"  > <i class="fa fa-pencil">  </i> Edit</a>
                    <a class="btn btn-success btn-sm"  href="<?=base_url('patient/duplicate_patient_form_template?token='.$template->id)?>"  > <i class="fa fa-copy">  </i> Duplicate</a>

                </div>
            </header>
            <div class="panel-body">

                <div class="adv-tableX  ">

                    <div class="space15"></div>
                    <div class="form-group">
                        <h5><?=$template->name;?></h5>
                    </div>
                    <div class="col-md-7">

                        <div id="sectionArea">
                          <?php
                          $data = unserialize($template->summary);
                          foreach($data->section as $key=>$section) { ?>
                           <div class="panel panel-primary">
                            <div class="panel-heading"><h4>  <?=$section->title?></h4></div>
                               <div class="panel-body">
                            <?php
                              $qsi =1;
                             if(!empty($section->quiz))
                              foreach($section->quiz as  $quiz) { ?>

                                  <div class="form-group">
                                  <h4><?=$quiz->title?>

                                  <?php if($quiz->quize_type == 'MC') { ?>
                                      <?php if($quiz->required == 1) { ?>   <small>* This question will be required</small>  <?php } ?></h4>
                                    <?php
                                     if($quiz->ans)
                                      foreach($quiz->ans as  $k=>$ans) { ?>
                                                  <p><input type="checkbox"> <?=$ans?></p>
                                      <?php } ?>
                                  <?php } ?>

                                    <?php if($quiz->quize_type == 'SC') { ?>
                                        <?php if($quiz->required == 1) { ?>   <small>* This question will be required</small>  <?php } ?></h4>
                                          <?php
                                          if($quiz->ans)
                                              foreach($quiz->ans as  $k=>$ans) { ?>
                                                  <p><input type="radio"> <?=$ans?></p>
                                              <?php } ?>
                                      <?php } ?>
                                      <?php if($quiz->quize_type == 'SLT') { ?>
                                          <?php if($quiz->required == 1) { ?>   <small>* This question will be required</small>  <?php } ?></h4>
                                                  <p><input type="text" class="form-control"> </p>
                                      <?php } ?>

                                      <?php if($quiz->quize_type == 'PF') { ?>
                                          <?php if($quiz->required == 1) { ?> <small>* This question will be required</small>  <?php } ?></h4>
                                                  <p><textarea  class="form-control"> </textarea></p>
                                      <?php } ?>

                                      <?php if($quiz->quize_type == 'Attach') { ?>
                                      <?php if($quiz->required == 1) { ?>   <small>* This question will be required</small>  <?php } ?></h4>
                                          <p><input type="file"></p>
                                      <?php } ?>

                                      <?php if($quiz->quize_type == 'Signature') { ?>
                                          <?php if($quiz->required == 1) { ?>   <small>* This question will be required</small>  <?php } ?></h4>
                                          <p><div style="width: 200px; height: 80px; border: 1px solid #dedede; background: #EDEDED"></div></p>
                                      <?php } ?>

                                  </div>
                       <hr>
                             <?php } ?>
                           </div>
                           </div>
                          <?php }  ?>
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



