<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="">

            <header class="panel-heading">
                <?php echo lang('patient'); ?> <?php echo 'form template'; ?>
                <div class="col-md-4 no-print pull-right"> 
                    <a data-toggle="modal" href="#myModal">
                        <div class="btn-group pull-right">
                            <a href="<?=base_url('patient/addtempate')?>" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> Add Template
                            </a>
                        </div>
                    </a>
                </div>
            </header>
            <div class="panel-body">

                <div class="adv-table editable-table ">

                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th># of Sections</th>
                                <th># of Questions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php
                         foreach($items as $key=>$item){?>
                         <tr>
                             <td><a href="patient/viewtemplate?id=<?=$item->id;?>"><?=$item->name;?></a> </td>
                             <td><?=$item->total_session;?></td>
                             <td><?=$item->total_question;?></td>
                             <td><a href="<?=base_url('patient/deletepatient_template?id='.$item->id)?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>
                         </tr>

                         <?php }  ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->



<script src="common/js/codearistos.min.js"></script>



