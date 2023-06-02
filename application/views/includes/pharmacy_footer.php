<!-- <?php print_r($_COOKIE['presc_ids']); ?> -->
<div id="recaptcha-container" style="display: none;"></div>
<input type="hidden" name="products_id" id="products_id">
<input type="hidden" name="labtest_id" id="labtest_id">
<input type="hidden" name="prescription_id" id="prescription_id" value="<?php echo $_COOKIE['presc_ids']; ?>">
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script type="text/javascript">
$('#login_form').on('submit', function(e){
    e.preventDefault(); 
	$('.loginbtn').text('Please wait...');
	$('.loginbtn').prop('disabled', true);
	if($('#loginviaOTP').is(':checked'))
	{				
		var phonenumber = $('#phonecode').val() + $('#otpnumber').val();
		$.ajax({
            type: "POST",
            url: "auth/checkphonenumber",
            data: 'phonenumber='+phonenumber,
            processData: false,
            cache: false,
            success: function (result) {            
            if(result > 0)
            {            	
               phoneAuth(phonenumber);               
            }
            else
            {
            	$('.loginbtn').text('Login');
			    $('.loginbtn').prop('disabled', false);
                $('.reg_error_msg').addClass('alert-danger').addClass('alert').text('Invalid phone number.');
                $('.reg_error_msg').fadeIn('slow');
            }
           }
        });			
	}
	else
	{
		// $('#login_form').submit();
        var form = $('#login_form').serialize();
        $.ajax({
            type: "POST",
            url: "auth/loginpharmacy",
            data: form,
            processData: false,
            cache: false,
            success: function (result){      
            // console.log(result); return;      
            if(result == 1)
            {               
               // $('#login-modal-close').click();               
               // $('#upload-prescrip-modal-btn').click();
               window.location.reload();
               // window.location.href = location+"?loginhere=1";             
            }
            else
            {
                $('.loginbtn').text('Login');
                $('.loginbtn').prop('disabled', false);
                $('.reg_error_msg').addClass('alert-danger').addClass('alert').text('Invalid login details');
                $('.reg_error_msg').fadeIn('slow');
            }
          }
        });
	}
});
</script>
<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyCUUvykdOlvQsGPKXWTugJtVU5lQLGJz9w",
    authDomain: "callgpnow.firebaseapp.com",
    databaseURL: "https://callgpnow.firebaseio.com",
    projectId: "callgpnow",
    storageBucket: "callgpnow.appspot.com",
    messagingSenderId: "644330715635",
    appId: "1:644330715635:web:46d9dbed9b4cbbe04fba86"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>
<script type="text/javascript">
$('#loginviaOTP').click(function(e){
	if($(this).is(':checked'))
	{
		$('#password').prop('disabled',true);
		$('.simplenumberdiv').fadeOut('slow');
		$('.otpnumberdiv').fadeIn('slow');
		$('#otpnumber').prop('required',true);
		$('#identity').prop('required', false);
	}
	else
	{
		$('#password').prop('disabled',false);
		$('.simplenumberdiv').fadeIn('slow');
		$('.otpnumberdiv').fadeOut('slow');
		$('#otpnumber').prop('required',false);
		$('#identity').prop('required', true);
	}
});
$('#exampleModalCenter').on("shown.bs.modal", function() {
    $('#verification_code').focus();
});
window.onload=function () {
  render();
};
function render() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container',{
        'size': 'invisible'
    });
    recaptchaVerifier.render();
}
function phoneAuth(phonenumber) 
{    
    //get the number
    firebase.auth().settings.appVerificationDisabledForTesting = true;
    var number= '+'+phonenumber;
    //it takes two parameter first one is number,,,second one is recaptcha
    firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
        window.confirmationResult=confirmationResult;
        coderesult=confirmationResult;
        // console.log(coderesult);        
		$('#phon_number').val(phonenumber);
        $('#login-modal-close').click(); 
        $('#verification-modal').click();               
        $('.loginbtn').text('Login');
		$('.loginbtn').prop('disabled', false);	
		$('.verf_msg').fadeIn('slow');	
    }).catch(function (error){
    	// console.log(error.message);
        $('.reg_error_msg').addClass('alert-danger').addClass('alert').text(error.message);
        $('.reg_error_msg').fadeIn('slow');
        $('.loginbtn').text('Login');
		$('.loginbtn').prop('disabled', false);
    });
}
function codeverify() 
{
    var code=document.getElementById('verification_code').value;
    if(code=="")
    {
    	$('.verf_msg').fadeOut('slow');
        $('.error_msg').text('Please enter verification code.');
        $('.error_msg').fadeIn('slow');
    	$('#verification_code').css('border','1px solid red');
    	return;
    }
    $('.vrfy_btn').text('Please Wait....');
    $('.vrfy_btn').attr('disabled',true);
    coderesult.confirm(code).then(function (result) {
        var phoneNumber = result.phoneNumber;
        // $('#verificationCode').submit();
        var form = $('#verificationCode')[0];
        // form = form.seriel 
        $.ajax({
            type: "POST",
            url: "auth/loginViaOtppharmacy",
            data: form,
            processData: false,
            cache: false,
            success: function (result) {            
            if(result == 1)
            {               
               // $('#verification-modal-close').click();               
               // $('#upload-prescrip-modal-btn').click();
               window.location.reload();             
            }
            else
            {
                $('.error_msg').text('Invalid login details');
            }
           }
        });
        // console.log(result);
    }).catch(function (error) {
        $('.verf_msg').fadeOut('slow');
        $('.error_msg').text(error.message);
        $('.error_msg').fadeIn('slow');
        $('#verification_code').css('border','1px solid red');
        $('.vrfy_btn').text('Verify code');
        $('.vrfy_btn').attr('disabled',false);
    });
}
</script>

<script type="text/javascript">
    $('#search-products').on('keyup paste focus', function(e){
        e.preventDefault();
        var product = $('#search-products').val();
        $.ajax({
            url:'frontend/searchproduct',
            method:'GET',
            data:'val='+product,
            cache: false,
            contentType:false,
            success:function(result)
            {
                var obj = JSON.parse(result);
                if(obj.length==0)
                {
                    $('.products-div').css('display','none');
                }
                else
                {
                    var i = 0;
                    var product_content = "";
                    var default_img = '<?php echo base_url(); ?>assets/images/default_image.jpg';
                    while(i < obj.length)
                    {
                        product_content += '<div class="row"> <div class="col-md-2"> <a href="frontend/product_description/'+obj[i]["id"]+'" class="product-link">  <div class="avatar"> <img class="avatar-img rounded" alt="Medicine Img" src="assets/images/image/'+obj[i]["image"]+'.jpg" onerror="this.src =\' '+default_img+' \'"> </div></a></div><div class="col-md-7"> <a href="frontend/product_description/'+obj[i]["id"]+'" class="product-link"><h4>'+obj[i]["name"]+'</h4><span>Category: '+obj[i]["subcategory"]+'</span><br> <span>Brand: '+obj[i]["vendor"]+'</span> </a> </div> <div class="col-md-3 text-center"><h4>'+obj[i]["price"]+'</h4> <button class="btn btn btn-primary cart-button" type="button" id="" onclick="addtocart('+obj[i]["id"]+')"><i class="fas fa-shopping-cart"></i></button> </div> </div> <hr>';
                        i++;
                    }
                    $('.product-rows').html(product_content);
                    $('.products-div').css('display','block');
                }
                console.log(obj);
            }
        });
        // console.log(product);
    });

    $('#search_category').on('change', function(e){
     var category_val = $('#search_category').val();
     window.location.href = "<?php echo base_url() ?>frontend/products?p_by_cond="+encodeURIComponent(category_val);
    });

    $('#search_brands').on('change', function(){
        var brand_val = $('#search_brands').val();
        window.location.href = "<?php echo base_url() ?>frontend/products?p_by_brand="+encodeURIComponent(brand_val);
    });

    $("#prescription_form").on("submit", function(ev) {
        $('.upload_presc_btn').text('Please wait...');
      ev.preventDefault();
      var formData = new FormData(this);        
      $.ajax({
        url: "<?php echo base_url() ?>frontend/uploadprescription",
        type: "POST",
        data: formData,
        success: function (result) {
            $('.upload_presc_btn').text('Upload');
            // console.log(result);
            if(result==0)
            {
                $('.prescriptimg_err').fadeIn('slow');
            }
            else
            {
                var exists_pres_ids = $('#prescription_id').val();
                if(exists_pres_ids=="")
                {
                    exists_pres_ids = result;
                }
                else
                {
                    exists_pres_ids = (exists_pres_ids +','+ result);
                }
                
                var exdays = 30;
                var d = new Date();
                d.setTime(d.getTime() + (exdays*24*60*60*1000));
                var expires = "expires="+ d.toUTCString();
                document.cookie = 'presc_ids' + "=" + exists_pres_ids + ";" + expires + ";path=/";
                alert('Prescription successfully uploaded to Cart.');                
                window.location.reload();
            }          
        },
        cache: false,
        contentType: false,
        processData: false
      });
        
    });
</script>

<script type="text/javascript">
    function addtocart(val)
    {
        $('#car-loader-img'+val).fadeIn('slow');
        $('#cart-iconhere'+val).fadeOut('slow');        
        // $('#cartbadge').text(0);
        // $('.addcart_cart_btn'+val).text('Added');
        $('.addcart_cart_btn'+val).attr('onclick','addtocartstr('+val+')');

        if($('#products_id').val()=="")
        {
            var selected_prod_ids = val;
        }
        else
        {
            var selected_prod_ids = $('#products_id').val()+','+val;
        }

        $('#products_id').val(selected_prod_ids);
        var exdays = 30;
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = 'prod_ids' + "=" + selected_prod_ids + ";" + expires + ";path=/";

        var prod_count = $('#products_id').val().split(',');
        var prescription_id = $('#prescription_id').val().split(',');
        var t_count = (prod_count.length + prescription_id.length);
        $('#cartbadge').text(t_count);
        // $('.cart_fields'+val).fadeIn('slow');
        setTimeout(function(){
            $('#car-loader-img'+val).fadeOut('slow');
            $('#cart-iconhere'+val).fadeIn('slow');
            $('.shopping-cart').addClass('show-cart');
            $('.shopping-cart').css('display','block');
            getcartproducts();
        },1000);
    }

    function getCookie(cname) 
    {
      var name = cname + "=";
      var ca = document.cookie.split(';');
      for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }
    function checkproductcookies()
    {
        var prod_cookies_ids = getCookie("prod_ids");
        var prescription_cookie_ids = getCookie("presc_ids");
        var prod_t_number = 0;
        var pres_t_number = 0;
        if(prod_cookies_ids !="")
        {
            var loop_ids = prod_cookies_ids.split(',');
            for(i=0;i<=loop_ids.length;i++)
            {
                $('.addcart_cart_btn'+loop_ids[i]).attr('onclick','addtocartstr('+loop_ids[i]+')');          
            }
            $('#products_id').val(prod_cookies_ids);           
            prod_t_number = loop_ids.length;            
        }

        if(prescription_cookie_ids !="")
        {
            var pres_loop_ids = prescription_cookie_ids.split(',');
            pres_t_number = pres_loop_ids.length;            
        }
        var t_number = (prod_t_number + pres_t_number);
        $('#cartbadge').text(t_number);
        getcartproducts();
        console.log(prod_t_number +' : '+ pres_t_number);
    }
    checkproductcookies();

    function addtocartstr(val)
    {
        $('#car-loader-img'+val).fadeIn('slow');
        $('#cart-iconhere'+val).fadeOut('slow');
        setTimeout(function(){
            $('#car-loader-img'+val).fadeOut('slow');
            $('#cart-iconhere'+val).fadeIn('slow');
            $('.shopping-cart').addClass('show-cart');
            $('.shopping-cart').css('display','block');
            getcartproducts();
        },1000);
    }

    function getcartproducts()
    {
        var product_ids = $('#products_id').val();
        var prescription_id = $('#prescription_id').val();
        $.ajax({
            url:'<?php echo base_url() ?>frontend/getcartproductsdata',
            method:'GET',
            data:'product_ids='+product_ids+'&prescription_id='+prescription_id,
            cache: false,
            processData: false,
            success:function(result)
            {
                var obj = JSON.parse(result);
                $('.shopping-cart-items').html(obj['product_detail']);
                $('#cart-price').html('Rs.'+obj['price']);
                // console.log(obj);
            }
        });
    }

    function removeproduct(val)
    {
        if(confirm('Are you sure you want to delete this item from your cart?')==true)
        {
            $('.prod_row'+val).fadeOut('slow').remove();
            var prod_cookies_ids = getCookie("prod_ids");
            var loop_ids = prod_cookies_ids.split(',');
            var filteredItems = loop_ids.filter(function(item){
              return item !== val.toString();
            });
            
            filteredItems = filteredItems.toString();
            // console.log(filteredItems);
            // $('#cartbadge').text(filteredItems.length);
            // var prod_totlaprice = $('#totalprice_input').val();        
            // var last_tprice = (parseFloat(prod_totlaprice) - parseFloat(price)).toFixed(2);
            // $('#totalprice_span').text(last_tprice);
            // $('#totalprice_input').val(last_tprice);
            if(filteredItems.length==0)
            {
                $('.tblbody').html('<tr><td align="center" colspan="5"><h4 class="text-center">Your cart is empty</h4></td></tr>');
            }
            // return;
            var exdays = 30;
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
            document.cookie = 'prod_ids' + "=" + filteredItems + ";" + expires + ";path=/";
            window.location.reload();
        }
    }

    function removeprrescookie(val)
    {
        if(confirm('Are you sure you want to delete this item from your cart?')==true)
        {
            $('.prod_row'+val).fadeOut('slow').remove();
            var prod_cookies_ids = getCookie("presc_ids");
            var loop_ids = prod_cookies_ids.split(',');
            var filteredItems = loop_ids.filter(function(item){
              return item !== val.toString();
            });
            
            filteredItems = filteredItems.toString();
            // console.log(filteredItems);
            // $('#cartbadge').text(filteredItems.length);
            // var prod_totlaprice = $('#totalprice_input').val();        
            // var last_tprice = (parseFloat(prod_totlaprice) - parseFloat(price)).toFixed(2);
            // $('#totalprice_span').text(last_tprice);
            // $('#totalprice_input').val(last_tprice);
            if(filteredItems.length==0)
            {
                // $('.tblbody').html('<tr><td align="center" colspan="5"><h4 class="text-center">Your cart is empty</h4></td></tr>');
            }
            // return;
            var exdays = 30;
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+ d.toUTCString();
            document.cookie = 'presc_ids' + "=" + filteredItems + ";" + expires + ";path=/";
            window.location.reload();
        }
    }
</script>