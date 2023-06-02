
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo 'Orders'; ?>
                <div class="col-md-4 clearfix no-print pull-right">
                    <!-- <a href="finance/addPaymentView"> 
                        <div class="btn-group pull-right">
                            <button id="" class="btn green btn-xs">
                                <i class="fa fa-plus-circle"></i> <?php echo lang('add_payment'); ?>
                            </button>
                        </div>
                    </a>  -->
                </div>
            </header>

            <div class="panel-body">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php echo 'Order ID'; ?></th>
                                <th><?php echo 'Customer Name'; ?></th>
                                <!-- <th><?php echo 'Customer Email'; ?></th> -->
                                <!-- <th><?php echo 'Customer Phone'; ?></th> -->
                                <!-- <th><?php echo lang('doctor'); ?></th> -->
                                <th><?php echo lang('date'); ?></th>                                
                                <th><?php echo 'Amount'; ?></th>
                                <th><?php echo 'Prescriptions'; ?></th>
                                <th><?php echo 'Non-Prescriptions'; ?></th>
                                <!-- <th><?php echo lang('discount'); ?></th> -->
                                <!-- <th><?php echo lang('grand_total'); ?></th> -->
                                <!-- <th><?php echo lang('paid'); ?> <?php echo lang('amount'); ?></th> -->
                                <!-- <th><?php echo lang('due'); ?></th> -->
                                <!-- <th><?php echo lang('remarks'); ?></th> -->
                                <th class="option_th no-print"><?php echo 'Status'; ?></th>
                                <th class="option_th no-print"><?php echo lang('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        <style>
                            /*.img_url{
                                height:20px;
                                width:20px;
                                background-size: contain; 
                                max-height:20px;
                                border-radius: 100px;
                            }*/
                            .option_th{
                                width:18%;
                            }

                        </style>
                        <?php if(count($orders)==0){
                            echo "<tr><td colspan='10' style='text-align:center'><h4>0 Orders found</h4></td></tr>";
                        }else{ foreach($orders as $value){ ?>
                            <tr>
                                <td><?php echo $value->order_id ?></td>
                                <td><?php echo $value->name ?></td>
                                <!-- <td><?php echo $value->email ?></td> -->
                                <!-- <td><?php echo $value->phone ?></td> -->
                                <td><?php echo date('Y-m-d H:i:s',strtotime($value->date)); ?></td>
                                <td><?php echo 'Rs.'.$value->amount ?></td>
                                <td><?php $count_presc = json_decode($value->prescription_image); $count_presc = count($count_presc); echo $count_presc; ?></td>
                                <td><?php $count_non_presc = json_decode($value->non_prescription_order); $count_non_presc = count($count_non_presc); echo $count_non_presc; ?></td>
                                <td><?php if($value->status=='pending'){ echo "<span class='badge bg-warning'>Pending</span>";}elseif($value->status=='rejected'){ echo "<span class='badge bg-danger'>Rejected</span>"; }elseif($value->status=='completed'){ echo "<span class='badge bg-success'>Completed</span>"; } ?></td>
                                <td>
                                    <a data-toggle="modal" href="javascript:void(0)" class="btn bg-primary btn-xs" onclick="getorderinformationByAjax(<?php echo $value->id ?>)"> <i class="fa fa-info"></i> Check Info </a>
                                    <a id="" class="btn green btn-xs"> <i class="fa fa-check"></i> Mark as complete</a>
                                    <button type="button" onclick="cancelorder('<?php echo $value->order_id ?>')" class="btn bg-danger btn-xs" disabled> <i class="fa fa-times"></i> Cancel </button>
                                </td>
                            </tr>
                        <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<div class="modal fade" id="checkinfomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: ;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo 'Order Info'; ?></h4>
            </div>
            <div class="modal-body order-details">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true"> Close </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script src="common/js/codearistos.min.js"></script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });
function getorderinformationByAjax(pid)
{
	$.ajax({
		url:'finance/pharmacy/getorderinformationByAjax',
		method:'post',
		data:'pid='+pid,
		cache: false,
		success:function(result)
		{
            $('.order-details').html(result);
   //          var obj = JSON.parse(result);
			// console.log(obj);
            $('#checkinfomodal').modal('show');
		}
	});
}
</script>
