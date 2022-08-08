<?php
require_once 'controller/database.php';
session_start();
if (isset($_SESSION["loggedIn"])) {
    header('Location:index.php', true);
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="css/toastr.min.css" rel="stylesheet"/>
</head>
<body>
<div class="container">
    <div class="forms">
        <div class="form login">
            <span class="title">Login</span>

            <form action="#" id="loginFrm" method="post">
                <div class="input-field">
                    <input type="text" placeholder="Enter your email" required autocomplete="newEmail" name="newEmail"
                           id="newEmail">
                    <i class="uil uil-envelope"></i>
                </div>

                <div class="input-field">
                    <input type="password" id="password" placeholder="Enter your password" required
                           autocomplete="new-password" name="password">
                    <i class="uil uil-lock icon"></i>
                    <i class="uil uil-eye-slash showHidePw"></i>
                </div>

                <div class="input-field button">
                    <input type="button" value="Login Now" class="loginBtn">
                    <button class="btn waitBtn hide" type="button" disabled>
                        <div class="loader"></div>
                        <span class="sr-only">Please wait...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/toastr.min.js"></script>
<script>
    const container = document.querySelector(".container"),
        pwShowHide = document.querySelectorAll(".showHidePw"),
        pwFields = document.querySelectorAll(".password");

    pwShowHide.forEach(eyeIcon => {
        eyeIcon.addEventListener("click", () => {
            pwFields.forEach(pwField => {
                if (pwField.type === "password") {
                    pwField.type = "text";

                    pwShowHide.forEach(icon => {
                        icon.classList.replace("uil-eye-slash", "uil-eye");
                    })
                } else {
                    pwField.type = "password";

                    pwShowHide.forEach(icon => {
                        icon.classList.replace("uil-eye", "uil-eye-slash");
                    })
                }
            })
        })
    })

    const base_url = '<?php echo $baseUrl; ?>';

    jQuery.validator.addMethod("myEmail", function (value, element) {
        var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        return regex.test(value);
    });

    $('#loginFrm').validate({
        rules: {
            newEmail: {
                required: true,
                myEmail: true,
            },
            password: {
                required: true
            }
        },
        messages: {
            newEmail: {
                required: "Please enter email ID",
                myEmail: "Please enter valid email ID",
            },
            password: {
                required: "Please enter password",
            },
        },
        errorPlacement: function (error, element) {
            if (element.parent().hasClass('input-field')) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
    });

    $(document).on("click", ".loginBtn", function () {
        if ($("#loginFrm").valid()) {
            console.log('form valid');
            $.ajax({
                type: "POST",
                url: base_url + "controller/authController.php?name=login",
                data: $('#loginFrm').serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $(".waitBtn").removeClass('hide');
                    $(".loginBtn").addClass('hide');
                },
                success: function (data) {
                    if (data.status) {
                        console.log('success');
                        toastr.success(data.message);
                        window.location.replace(base_url + "index.php");
                    } else {
                        console.log('error');
                        toastr.error(data.message);
                    }
                    $(".waitBtn").addClass('hide');
                    $(".loginBtn").removeClass('hide');
                }
            });
        } else {
            return false;
        }
    });
</script>
</body>
</html>