<?php 
if ($this->ion_auth->in_group(array('Patient')))
{ 
    $patient_ion_id = $this->ion_auth->get_user_id();
    $patient_data = $this->frontend_model->getpatiendatabyId($patient_ion_id);}

?>
<!-- function for change payment Method -->
<?php if($this->session->flashdata('stripe_session_id')){ ?>
  <script src="https://js.stripe.com/v3/"></script>
    <input type="hidden" name="CHECKOUT_SESSION_ID" id="CHECKOUT_SESSION_ID" value="<?php echo $this->session->flashdata('stripe_session_id'); ?>">
    <script type="text/javascript">
        var stripe = Stripe('pk_test_51IG6NjCnnFzOpBJCGIZgpMLbq3xKm4cNMEteFHpOOZ7Hl10XbTApuZV2OOL8YWweylWhi4abo6JDffMVltQjzDM700QKQ9X1GI');
        stripe.redirectToCheckout({
        sessionId: '<?php echo $this->session->flashdata('stripe_session_id'); ?>'
        }).then(function (result){
        });
    </script>
<?php exit(); } ?>
<!-- End here -->
<!--Breadcrumb -->
            <div class="breadcrumb-bar">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-md-12 col-12">
                            <nav aria-label="breadcrumb" class="page-breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url() ?>frontend/pharmacy">Pharmacy</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                                </ol>
                            </nav>
                            <h2 class="breadcrumb-title">Checkout</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Breadcrumb -->
            
            <!-- Page Content -->
            <div class="content">
                <div class="container">
                    <?php if(isset($_GET['cancel_payment'])){ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger"><strong>Oops!</strong> I am afraid your payment declined, please try again or contact the service provider.</div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-6 col-lg-7">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Billing details</h3>
                                </div>
                                <div class="card-body">
                                
                                    <!-- Checkout Form -->
                                    <form action="<?php echo base_url() ?>frontend/medcheckout" method="post" id="paymentFrm">
                                    
                                        <!-- Personal Information -->
                                        <div class="info-widget">
                                            <h4 class="card-title">Personal Information</h4>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group card-label">
                                                        <label>Name</label>
                                                        <input class="form-control" type="text" name="name" value="<?php echo $patient_data->name ?>" required>
                                                    </div>
                                                </div>                                               
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group card-label">
                                                        <label>Email</label>
                                                        <input class="form-control" type="email" name="email" value="<?php echo $patient_data->email ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group card-label">
                                                        <label>Phone</label>
                                                        <input class="form-control" type="text" name="phone" value="<?php echo $patient_data->phone ?>" required>
                                                    </div>
                                                </div>                                                
                                            </div>
                                            <?php if(empty($patient_data)){ ?>
                                            <div class="exist-customer">Existing Customer? <a href="#" data-toggle="modal" data-target="#login-modal">Click here to login</a></div>
                                        <?php } ?>
                                        </div>
                                        <!-- /Personal Information -->

                                        <!-- Shipping Details -->
                                        <div class="info-widget">
                                            <h4 class="card-title">Shipping Details</h4>
                                            <div class="form-group card-label">
                                                <label class="pl-0 ml-0 mb-2">Shipping Address</label>
                                                <textarea class="form-control" name="address" required></textarea>
                                            </div>
                                            <div class="form-group card-label">
                                                <label class="pl-0 ml-0 mb-2">Order notes (Optional)</label>
                                                <textarea rows="5" class="form-control" name="notes"></textarea>
                                            </div>
                                        </div>
                                        <!-- /Shipping Details -->
                                        
                                        <div class="payment-widget">
                                            <h4 class="card-title">Payment Method</h4>
                                            <div class="payment-list">
                                                <label class="payment-radio paypal-option" style="display: inline-block;">
                                                    <input type="radio" name="radio" value="by_hand" checked>
                                                    <span class="checkmark"></span>
                                                    Cash on delivery
                                                </label>
                                                &nbsp;&nbsp;
                                                <label class="payment-radio credit-card-option" style="display: inline-block;">
                                                    <input type="radio" name="radio" value="by_card">
                                                    <span class="checkmark"></span>
                                                    Credit card
                                                </label>
                                            </div>
                                            <!-- <div id="paymentResponse"></div> -->
                                            <!-- Credit Card Payment -->
                                            <div class="payment-list">
                                                
                                                <!-- <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group card-label">
                                                            <label for="card_number" class="pl-0 ml-0 mb-2">Card Number</label>
                                                            <div id="card_number" class="field form-control" placeholder="1234  5678  9876  5432"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group card-label">
                                                            <label for="expiry_month">Expiry Month</label>
                                                            <input class="form-control" id="expiry_month" placeholder="MM" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group card-label">
                                                            <label for="card_expiry" class="pl-0 ml-0 mb-2">Expiry Date</label>
                                                            <div id="card_expiry" class="field form-control"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group card-label">
                                                            <label for="card_cvc" class="pl-0 ml-0 mb-2">CVV</label>
                                                            <div id="card_cvc" class="field form-control"></div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <!-- /Credit Card Payment -->

                                            <!-- Terms Accept -->
                                            <div class="terms-accept">
                                                <div class="custom-checkbox">
                                                   <input type="checkbox" id="terms_accept1" required>
                                                   <label for="terms_accept1">I have read and accept <a href="frontend/terms_conditions">Terms &amp; Conditions</a></label>
                                                </div>
                                            </div>
                                            <!-- /Terms Accept -->
                                            
                                            <!-- Submit Section -->
                                            <div class="submit-section mt-4">
                                            <?php 
                                            if(empty($product_id_and_quantity))
                                            {
                                            	$product_id_and_quantity = $_COOKIE['prod_ids'];
                                            	$product_id_and_quantity = explode(',', $product_id_and_quantity);
                                            }
                                            for($i=0; $i<count($product_id_and_quantity); $i++)
                                            {
                                             ?>
                                             <input type="hidden" name="product_id_and_quantity[]" value="<?php echo $product_id_and_quantity[$i] ?>,1">
                                            <?php } ?>
                                            <?php 
                                            if(empty($prescriptions))
                                            {
                                            	$prescriptions = $_COOKIE['presc_ids'];
                                            	$prescriptions = explode(',', $prescriptions);
                                            }
                                            for($i=0; $i<count($prescriptions); $i++)
                                            {
                                             ?>
                                             <input type="hidden" name="prescriptions_ids[]" value="<?php echo $prescriptions[$i] ?>">
                                            <?php } ?>

                                            <input class="form-control" type="hidden" name="patient_id" value="<?php if($patient_data->id){ echo $patient_data->id; }else{ echo 0; } ?>">
                                            <input type="hidden" name="amount" id="amount_input" value="<?php echo $_GET['total_price'] ?>">
                                                <button type="submit" class="btn btn-primary submit-btn">Confirm and Pay</button>
                                            </div>
                                            <!-- /Submit Section -->
                                            
                                        </div>
                                    </form>
                                    <!-- /Checkout Form -->
                                    
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="col-md-6 col-lg-5 theiaStickySidebar">
                        
                            <!-- Booking Summary -->
                            <div class="card booking-card">
                                <div class="card-header">
                                    <h3 class="card-title">Your Order</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-center mb-0">
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                            <tbody>
                                            <?php 
                                               $presc_id = $_COOKIE['presc_ids'];
                                               $presc_id_split = explode(',', $presc_id);
                                               // $total_price = 0;
                                            	if($presc_id !="")
                                               { 
                                                   for($i=0; $i<count($presc_id_split); $i++)
                                                   {
                                                     $presc_res = $this->frontend_model->getpresmedicinesdetails($presc_id_split[$i]);
                                                     // $total_price = (str_replace('Rs.','',$prod_res->price) + $total_price);
                                                ?>
                                                <tr>                                                    
                                                    <td><img src="<?php echo $presc_res->img_url ?>" width="100px"></td>
                                                    <td class="text-right">---</td>
                                                </tr>
                                            <?php } } ?>
                                            <?php 
                                               $products_id = $_COOKIE['prod_ids'];
                                               $prod_id = explode(',', $products_id);
                                               $total_price = 0;
                                            if($products_id !="")
                                               { 
                                                   for($i=0; $i<count($prod_id); $i++)
                                                   {
                                                     $prod_res = $this->frontend_model->fetch_medicines_forcart($prod_id[$i]);
                                                     $total_price = (str_replace('Rs.','',$prod_res->price) + $total_price);
                                                ?>
                                                <tr>
                                                    <td><?php echo $prod_res->name ?></td>
                                                    <td class="text-right"><?php echo $prod_res->price ?></td>
                                                </tr>
                                            <?php } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="booking-summary pt-5">
                                        <div class="booking-item-wrap">
                                            <!-- <ul class="booking-date">
                                                <li>Subtotal <span>$5,877.00</span></li>
                                                <li>Shipping <span>$25.00</span></li>
                                            </ul> -->
                                            <ul class="booking-fee">
                                                <li>Tax <span>Rs.0</span></li>
                                            </ul>
                                            <div class="booking-total">
                                                <ul class="booking-total-list">
                                                    <li>
                                                        <span>Total</span>
                                                        <span class="total-cost"><?php echo 'Rs.'.$total_price ?></span>
                                                    </li>
                                                    <li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Booking Summary -->
                            
                        </div>
                    </div>

                </div>

            </div>      
            <!-- /Page Content-->
<script type="text/javascript">
    $('#paymentFrm').on('submit', function(){
        $('#amount_input').val('<?php echo $total_price ?>');
    });

</script>

  