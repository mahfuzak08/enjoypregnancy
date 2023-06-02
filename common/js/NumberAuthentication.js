window.onload=function () {
  render();
};
function render() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container',{
        'size': 'invisible'
    });
    recaptchaVerifier.render();
}
function phoneAuth(phonenumber) {
    
    //get the number
    firebase.auth().settings.appVerificationDisabledForTesting = true;
    var number= '+'+phonenumber; //document.getElementById('number').value;
    // console.log(phonenumber);
    // return;
    //phone number authentication function of firebase
    //it takes two parameter first one is number,,,second one is recaptcha
    firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
        //s is in lowercase
        window.confirmationResult=confirmationResult;
        coderesult=confirmationResult;
        console.log(coderesult);
        // alert("Message sent");
        $('#phone').css('border','');
        $('.verf_msg').fadeIn('slow');
        // $('#register').fadeOut('slow');
        // $('#verificationCode').fadeIn('slow');
        $('#verification-modal').click(); 
        // $('#verification_code').focus();
        $('#send_ptnt_otp').text('Signup');
        $('#send_ptnt_otp').attr('disabled',false);
    }).catch(function (error) {
        $('.reg_error_msg').text(error.message);
        $('.reg_error_msg').fadeIn('slow');
        $('#phone').css('border','1px solid red');
        $('#send_ptnt_otp').text('Signup');
        $('#send_ptnt_otp').attr('disabled',false);
        // $('#registerdiv').addClass('active');
        // $('#verificationCode').fadeOut('slow');
    });
}
function codeverify() {
    var code=document.getElementById('verification_code').value;
    // console.log(code);return;
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
        // alert("");
        var user=result.user;
        var form = $('#register')[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "auth/patient_register",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (result) {
            if(result > 0)
            {
                // $('#login_btn').click();
                // $('#registerdiv').removeClass('active');
                // $('#register').fadeIn('slow');
                // $('#verificationCode').fadeOut('slow');
                // $('.vrfy_btn').attr('disabled',false);
                // $('.vrfy_btn').text('Verify code');
                // $('.error_msg').fadeOut('slow');                
                // $('#verification_code').css('border','');
                if(result==2)
                {
                    // You will be login once admin approve your account and you will get a confirmation email from admin soon.
                    $('.success_vrfy_msg').text("Your account has been successfully created. Please check you email inbox / spam and click on the link to verify your email-ID.");   
                    // window.location.href = 'aut/login?reg=1';
                    $('#verificationCode').fadeOut('slow');
                    $('.congrats_msg').fadeIn('slow');
                }
                else
                {
                    $('.success_vrfy_msg').text("Your account has been successfully created. Please check you email inbox / spam and click on the link to verify your email-ID.");
                    // window.location.href = 'aut/login?reg=2';
                    $('#verificationCode').fadeOut('slow');
                    $('.congrats_msg').fadeIn('slow');
                }
                // $('.success_vrfy_msg').fadeIn('slow');
                // $('#patient_reg :input').each(function(){
                //     $(this).val('');
                // });
                // $( '#bdate' ).val(d+'-'+ma+'-'+y);
            }
            else
            {
                // $('.reg_error_msg').text('Your account couldn`t be created due to system error.');
                $('.verf_msg').fadeOut('slow');
                $('.error_msg').text('Your account couldn`t be created due to system error.');
                $('.error_msg').fadeIn('slow');
                // window.location.href = 'aut/login?reg=3';
                // scrolltopfnc();
                // $('#verificationCode').fadeOut('slow');
                // $('#register').fadeIn('slow');
                // $('#register_btn').click();
                // $('#login').removeClass('active');
            }
            },
            error: function (e) {

                // $("#output").text(e.responseText);
                console.log("ERROR : ", e);
                // $("#btnSubmit").prop("disabled", false);

            }
        });
        // console.log(user);
    }).catch(function (error) {
        $('.verf_msg').fadeOut('slow');
        $('.error_msg').text(error.message);
        $('.error_msg').fadeIn('slow');
        $('#verification_code').css('border','1px solid red');
        $('.vrfy_btn').text('Verify code');
        $('.vrfy_btn').attr('disabled',false);
    });
}