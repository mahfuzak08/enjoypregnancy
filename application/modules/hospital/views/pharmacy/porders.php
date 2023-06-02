
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
                                <td><?php if($value->status=='pending'){ echo "<span class='badge bg-warning'>Pending</span>";}elseif($value->status=='cancelled'){ echo "<span class='badge bg-danger'>Cancelled</span>"; }elseif($value->status=='completed'){ echo "<span class='badge bg-success'>Completed</span>"; }elseif($value->status=='dispatched'){ echo "<span class='badge bg-dark'>Dispatched</span>"; } 
                                    if ($this->ion_auth->in_group(array('superadmin'))){}else{ if($user_info->is_saleman!=1){
                                        if($value->saleman_cancel_id!=''){ $this->db->where('ion_user_id',$value->saleman_cancel_id); $salemanname = $this->db->get('pharmacist')->row()->name; echo "<span class='badge bg-danger'>Rejected by saleman(".$salemanname.")</span>"; }
                                    } } ?></td>
                                <td>
                                    <a data-toggle="modal" href="javascript:void(0)" class="btn bg-primary btn-xs" onclick="getorderinformationByAjax(<?php echo $value->id ?>)"> <i class="fa fa-info"></i> Check Info </a> 
                                    <?php if($value->status=='completed'){ ?>
                                        <a href="<?php echo base_url() ?>assets/proof_of_delivery_files/<?php echo $value->proof_of_delivery ?>" target="_blank" class="btn green btn-xs"> <i class="fa fa-eye"></i> Proof of delivery</a>                                   
                                    <?php } if ($this->ion_auth->in_group(array('superadmin'))) { 
                                        if($value->status!='completed'){
                                    ?>
                                    <!-- <a href="hospital/pharmacy/markascomplete/<?php echo $value->id ?>" onclick="return confirm('Are you sure you want to complete this order?');" class="btn green btn-xs"> <i class="fa fa-check"></i> Mark as complete</a> -->
                                    <a href="#forward_order" data-toggle="modal" onclick="addOrderId('<?php echo $value->id ?>')" class="btn green btn-xs"> <i class="fa fa-check"></i> Forward to Pharmacy</a>
                                    <?php }
                                     }
                                     else
                                     {
                                        if($user_info->is_saleman==1)
                                        {
                                            if($value->status=='pending'){
                                     ?>
                                     <a href="home/acceptorderBysaleman/<?php echo $value->id ?>"  onclick="return confirm('Are you sure you want to accept this order?')" class="btn green btn-xs"> <i class="fa fa-check"></i> Accept</a>
                                     <a href="#reject_order" data-toggle="modal" onclick="addOrderId('<?php echo $value->id ?>')" class="btn bg-danger btn-xs"> <i class="fa fa-times"></i> Reject</a>
                                 <?php }elseif($value->status=='dispatched'){
                                    echo '<a href="#order_completion_proof" data-toggle="modal" onclick="addOrderId('.$value->id.');" class="btn green btn-xs"> <i class="fa fa-check"></i> Mark as complete</a>';
                                 } }else{ ?>
                                     
                                     <?php if($value->status!='completed' and $value->status!='dispatched'){ ?>
                                    <a href="#forward_order_to_saleman" data-toggle="modal" onclick="addOrderId('<?php echo $value->id ?>')" class="btn green btn-xs"> <i class="fa fa-check"></i> Assign To Saleman</a>
                                     <button type="button" onclick="cancelorder('<?php echo $value->id ?>')" class="btn bg-danger btn-xs"> <i class="fa fa-times"></i> Cancel </button>
                                    <?php } } } ?>
                                    
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
<!-- Order completion modal -->
<div class="modal fade" id="order_completion_proof" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: ;">
    <div class="modal-dialog">
    	<form action="home/markascomplete" method="post" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo 'Upload proof of deliver'; ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                	<label>Upload proof of deliver</label>
                	<input type="file" name="proof_of_delivery" class="form-control" required="required">
                </div>
            </div>
            <div class="modal-footer">
            	<input type="hidden" name="order_id" id="proof_of_order_id" value="">
                <button type="submit" class="btn btn-primary" aria-hidden="true"> Deliver Now</button>
            </div>
        </div>
        <!-- /.modal-content -->
    	</form>
    </div><!-- /.modal-dialog -->
</div>
<!-- end -->
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

<div class="modal fade" id="forward_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: ;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="hospital/pharmacy/forwardOrdertoPharmacy" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo 'Forward order to pharmacy'; ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Pharmacy</label>
                    <select class="form-control" name="pharmacy_id" required="required">
                        <option value="">Select Pharmacy</option>
                        <?php foreach($pharmacies as $key => $val){ ?>
                            <option value="<?php echo $val->ion_user_id ?>"><?php echo $val->name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="order_id" id="order_id" value="">
                <button type="submit" class="btn btn-primary"> Submit </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"> Close </button>
            </div>
        </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Forward To Salesman -->
<div class="modal fade" id="forward_order_to_saleman" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: ;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="home/assignOrdertoSaleman" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo 'Assign order to saleman'; ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Saleman</label>
                    <select class="form-control" name="saleman_id" required="required">
                        <option value="">Select Saleman</option>
                        <?php foreach($salemans as $key => $val){ ?>
                            <option value="<?php echo $val->ion_user_id ?>"><?php echo $val->name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="order_id" id="sale_order_id" value="">
                <button type="submit" class="btn btn-primary"> Submit </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"> Close </button>
            </div>
        </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- end here -->

<div class="modal fade" id="cancel_order_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: ;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="home/cancelorder" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo 'Cancel Order Reason'; ?></h4>
            </div>
            <div class="modal-body">
                <br>
                <div class="form-group">
                    <label>Reason</label>
                    <textarea class="form-control" name="reason" style="height: auto !important;" required="required"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="order_id" id="cancel_order_id" value="">
                <input type="hidden" name="redirect_url" id="" value="<?php echo $_SERVER['REQUEST_URI'] ?>">
                <button type="submit" class="btn btn-primary"> Submit </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"> Close </button>
            </div>
        </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="reject_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: ;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="home/rejectorderBysaleman" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">  <?php echo 'Reason'; ?></h4>
            </div>
            <div class="modal-body">
                <br>
                <div class="form-group">
                    <label>Reason</label>
                    <textarea class="form-control" name="reason" style="height: auto !important;" required="required"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="order_id" id="reject_order_id" value="">
                <input type="hidden" name="redirect_url" id="" value="<?php echo $_SERVER['REQUEST_URI'] ?>">
                <button type="submit" class="btn btn-primary"> Submit </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"> Close </button>
            </div>
        </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script src="common/js/codearistos.min.js"></script>
<script>
    $(document).ready(function () {
        $(".flashmessage").delay(3000).fadeOut(100);
    });

function addOrderId(val)
{
    $('#order_id').val(val);
    $('#sale_order_id').val(val);
    $('#reject_order_id').val(val);
    $('#proof_of_order_id').val(val);
}

function cancelorder(val)
{
    $('#cancel_order_id').val(val);
    $('#cancel_order_modal').modal('show');
}

function getorderinformationByAjax(pid)
{
	$.ajax({
		url:'home/getorderinformationByAjax',
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
