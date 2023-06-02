<!-- Breadcrumb -->
<div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>frontend/pharmacy">Pharmacy</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
                <h2 class="breadcrumb-title">Cart</h2>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
    <div class="container">         
        <form action="<?php echo base_url() ?>frontend/checkout" method="get">
        <div class="card card-table">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="tblbody">
                        <?php 
                           $products_id = $_COOKIE['prod_ids'];
                           $prod_id = explode(',', $products_id);

                           $presc_ids_h = $_COOKIE['presc_ids'];
                           $presc_ids = explode(',', $presc_ids_h);

                           $total_price = 0;
                           if($products_id !="")
                           { 
                               for($i=0; $i<count($prod_id); $i++)
                               {
                                 $prod_res = $this->frontend_model->fetch_medicines_forcart($prod_id[$i]);
                                 $total_price = (str_replace('Rs.','',$prod_res->price) + $total_price);
                            ?>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="product-description.html" class="avatar avatar-sm mr-2"><img class="avatar-img" src="<?php echo base_url() ?>assets/images/image/<?php echo $prod_res->image ?>.jpg" onerror="this.src = '<?php echo base_url(); ?>assets/images/default_image.jpg';" alt="Medicine img"></a>
                                    </h2>
                                    <a href="product-description.html"><?php echo $prod_res->name ?></a>
                                </td>
                                <td><?php echo $prod_res->price ?></td>                    
                                <td class="text-center">
                                <div class="custom-increment cart">
                                    <div class="input-group1">
                                        <span class="input-group-btn">
                                            <button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                              <span><i class="fas fa-minus"></i></span>
                                            </button>
                                        </span>
                                        <input type="text" id="quantity1" name="" class=" input-number" value="1">
                                        <input type="hidden" id="product_id_and_quantity" name="product_id_and_quantity[]" value="<?php echo $prod_res->id ?>,1">
                                        <span class="input-group-btn">
                                            <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                                <span><i class="fas fa-plus"></i></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                </td>
                                <td class="text-center"><?php echo $prod_res->price ?></td>
                                <td class="text-right">
                                    <div class="table-action">
                                        <a href="javascript:void(0);" onclick="removeproduct(<?php echo $prod_res->id ?>)" class="btn btn-sm bg-danger-light">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php } }
                        if($presc_ids_h !=""){
                           for($i=0; $i<count($presc_ids); $i++)
                           {
                             $presc_res = $this->frontend_model->getpresmedicinesdetails($presc_ids[$i]);
                         ?>
                         <tr>
                             <td colspan="4">
                                 <h2 class="table-avatar">
                                    <a href="#" class="avatar avatar-sm mr-2"><img class="avatar-img" src="<?php echo $presc_res->img_url ?>" onerror="this.src = '<?php echo base_url(); ?>assets/images/image_9.jpg';" alt="Medicine img"></a>
                                </h2>
                             </td>
                             <td class="text-right">
                                 <div class="table-action">
                                    <a href="javascript:void(0);" onclick="removeprrescookie(<?php echo $presc_ids[$i] ?>)" class="btn btn-sm bg-danger-light">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                                <input type="hidden" name="prescriptions_ids[]" value="<?php echo $presc_ids[$i] ?>">
                             </td>
                         </tr>
                        <?php } }
                        if($products_id =="" and $presc_ids_h==""){ ?>
                            <tr><td align="center" colspan="5"><h4 class="text-center">Your cart is empty</h4></td></tr>
                        <?php } ?>
                        </tbody>
                    </table>        
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 col-lg-8">
            </div>
            
            <div class="col-md-5 col-lg-4">
            
                <!-- Booking Summary -->
                <div class="card booking-card">
                    <div class="card-header">
                        <h4 class="card-title">Cart Totals</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="booking-summary">
                            <div class="booking-item-wrap">
                                <!-- <ul class="booking-date">
                                    <li>Subtotal <span>$5,877.00</span></li>
                                    <li>Shipping <span>$25.00<a href="#">Calculate shipping</a></span></li>
                                </ul> -->
                                <ul class="booking-fee pt-4">
                                    <li>Tax <span>Rs.0</span></li>
                                </ul>
                                <div class="booking-total">
                                    <ul class="booking-total-list">
                                        <li>
                                            <span>Total</span>
                                            <span class="total-cost">Rs.<?php echo $total_price; ?></span>
                                        </li>
                                        <li>
                                            <div class="clinic-booking pt-4">
                                                <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                                                <button type="submit" class="btn btn-primary btn-block btn-lg">Proceed to checkout</button>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Booking Summary -->
                
            </div>
        </div>
    </form>
    </div>
</div>      
<!-- /Page Content -->

<br>
<br>