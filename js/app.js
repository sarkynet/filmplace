
// Login Asychronous Request
$('#SignIn').click(function () {
    validateInput('validateLogin') // Form Validation

    //Sending asynchronous request
    if (authenticate.flag == true) {
        $('#SignIn').html('<img src="./images/dual-ring-loader.gif" width="32" />');

        setTimeout(function () {
            $.ajax({
                url: '../config/auth.php',
                type: authenticate.requestType[0],
                dataType: authenticate.dataType,
                data: {
                    email: authenticate.Email.val(),
                    password: authenticate.Password.val(),
                },
                success: function (asyncRequest) {
                    authenticate.Email.val(null);
                    authenticate.Password.val(null);
                    $('#loginStatus').html(asyncRequest);

                    setTimeout(function () {
                        $('#loginStatus').fadeOut(1000);
                    }, 5000);

                    $('#loginStatus').val(null).show();
                }
            })
        }, 3000);
    }
});



// Password Verification Asychronous Request 
$('#VerifyAccount').click(function () {
    validateInput('validateAccount');

    //Sending asynchronous request
    if (authenticate.flag == true) {
        $('#VerifyAccount').html('<img src="./images/dual-ring-loader.gif" width="32" />');
        setTimeout(function () {
            $.ajax({
                url: '../config/auth.php',
                dataType: authenticate.returnType,
                type: authenticate.requestType[0],
                data: {
                    email: authenticate.Email.val(),
                    answer: authenticate.Answer.val(),
                    securityQuestion: authenticate.Question.val()
                },
                success: function (asyncRequest) {
                    authenticate.Email.val(null);
                    authenticate.Answer.val(null);
                    authenticate.securityQuestion.val(null);

                    if (asyncRequest.status == true) {
                        $('#small-dialog2').html(authenticate.ChangePassword.html());
                        authenticate.verifiedEmail.val(authResponse.email);
                        authenticate.verifiedUserId.val(authResponse.userId);
                    }
                    else
                        $('#AccountVerificationStatus').html(authResponse.error);

                    $("#PasswordResetStatus").html(asyncRequest);
                    setTimeout(function () {
                        $('#AccountVerificationStatus').fadeOut(1000);

                    }, 5000);
                    $("#AccountVerificationStatus").val(null).show();
                }
            })
        }, 3000);
    }
});


// Password Reset Asychronous Request 
$('#ResetPassword').click(function () {
    validateInput('validatePassword');

    //Sending asynchronous request
    if (authenticate.flag == true) {
        $('#ResetPassword').html('<img src="./images/dual-ring-loader.gif" width="32" />');

        setTimeout(function(){
            $.ajax({
                url: '../config/auth.php',
                dataType: authenticate.returnType,
                type: authenticate.requestType[0],
                data: {
                    password : authenticate.Password.val(),
                    
                },
            })
        }, 3000)
    }

});



/**
 * 
 * @param { This function validates form controls when called.
  Each group of controls should have a unique placholder.
  * 
  EXAMPLE:
  *
  <input type='text' name="Username" required="true" validate />
* 
* <script>
* 
*  validateInput('validate);
* </script>
* } inputArgs 
 */

function validateInput(inputArgs) {
    let validInput = $('[' + inputArgs + ']');
    for (let formInput = 0; formInput < validInput.length; formInput++) {
        if (validInput.get(formInput).value == null || validInput.get(formInput).value == '') {
            validInput[formInput].placeholder = 'This field is required';
            return false;
        }
    }
    authenticate.flag = true;
}



var authenticate = {
    flag: false,
    Email: $('#Email'),
    Password: $('#Password'),
    returnType: 'JSON',
    requestType: ['POST', 'GET'],
    Question: $('#SecurityQuestion'),
    Answer: $('#Answer'),
    ChangePassword: $('#small-dialog3'), //Change Password markup
    verifiedEmail: $('#VerifiedEmail'),
    verifiedUserId: $('#VerifiedUserId'),
    confirmNewPassword: $('#ConfirmNewPassword')

}
