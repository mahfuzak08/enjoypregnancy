<link rel="stylesheet" href="<?php echo base_url() ?>new_assets/plugins/datatables/datatables.min.css">
<!-- Page Content -->
<div class="content">
    <div class="container-fluid">
        <nav aria-label="breadcrumb" class="page-breadcrumb product-breadcrumb">
            <ol class="breadcrumb">
                <li class=""><a href="<?php echo base_url() ?>">Home</a></li>
                <li> / </li>
                <li class=""><a href="<?php echo base_url() ?>/lab-test">Lab Test</a></li>
                <li> / </li>                
                <li class="" aria-current="page">Medicines</li>
            </ol>
        </nav>
        <br>
        <?php if(empty($labtests)){
            echo "<br><br><h3 class='text-center'>No Result Found</h3>";
        } ?>
        <div class="row">
            <div class="col-md-1"></div>            
            <div class="col-md-10">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0">
                        <tr>
                            <th>S.No.</th>
                            <th>Test Name</th>
                            <th>Sample Required</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        <?php $i=1; foreach($labtests as $value){ ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $value->name ?></td>
                            <td><?php echo $value->sample_required ?></td>
                            <td>PKR <?php echo $value->price ?></td>
                            <td>
                                <button  type="button" class="btn btn-info viewdetailbtn<?php echo $value->id ?>" onclick="showlabtestdetails(<?php echo $value->id ?>)"><i class="fa fa-eye"></i> View Details</button> 
                                <button  type="button" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add To Cart</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="col-md-1"></div> 
        </div>
    </div>
</div>
<br>

<script type="text/javascript">
function showlabtestdetails(val)
{
    $.ajax({
        url:'frontend/getlabtestdetails',
        method: 'get',
        data:'id='+val,
        cache:false,
        beforeSend: function()
        {
            $('.viewdetailbtn'+val).html('Please Wait...');
        },
        success: function(result)
        {
            console.log(result);
            $('.viewdetailbtn'+val).html('<i class="fas fa-eye"></i> View Details');
            $('.labtestdetails_div').html(result);
            $('#myModal2').modal('show');
        }
    })
}
</script>
