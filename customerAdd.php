<?php require_once 'common/header.php' ?>
<div class="container mt-3">
    <div class="card">
        <div class="card-header">Add Customer</div>
        <div class="card-body">
            <form name="customerForm" action="#" id="customerForm" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" name="firstName" class="form-control text-capitalize"
                           placeholder="Enter your first name" id="firstName" required maxlength="20"/>
                </div>

                <div class="form-group">
                    <label for="lastName">Last Name:</label>
                    <input type="text" name="lastName" class="form-control text-capitalize"
                           placeholder="Enter your last name" id="lastName" required maxlength="20">
                </div>

                <div class="form-group mb-0">
                    <label for="inlineRadio1">Gender Type:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio1"
                               value="male">
                        <label class="form-check-label" for="inlineRadio1">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2"
                               value="female">
                        <label class="form-check-label" for="inlineRadio2">Female</label>
                    </div>
                </div>

                <div>
                    <label for="phone"> Customer Phone:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">+1</span>
                        </div>
                        <input type="text" class="form-control" maxlength="14" name="phone"
                               placeholder="Enter Customer Phone #" id="phone" required>
                    </div>
                </div>


                <div class="form-group mt-3">
                    <label for="email">Email Address:</label>
                    <input type="email" class="form-control text-lowercase"
                           onfocusout="validateEmail(email)" name="email"
                           placeholder="Enter your email" id="email"/>
                </div>

                <div class="form-group mt-3">
                    <label for="Address">Home Address:</label>
                    <div class="row">
                        <div class="col-12">
                            <textarea type="text" class="form-control" name="address"
                                      placeholder="Address" id="address"></textarea>
                        </div>
                        <div class="col-6 mt-2">
                            <input type="text" placeholder="House number" id="houseNumber" class="form-control"
                                   name="houseNumber" maxlength="10"/>
                        </div>
                        <div class="col-6 mt-2">
                            <select id="country" class="form-control" name="country">
                                <option disabled selected> -- Select Province --</option>
                                <option value="Ontario">Ontario</option>
                                <option value="Nova Scotia">Nova Scotia</option>
                                <option value="Vancouver">Vancouver</option>
                                <option value="British Columbia">British Columbia</option>
                                <option value="Vancouver">Vancouver</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Please enter complex password (8 digits include characters, symbols,
                        integers):</label>
                    <input type="password" placeholder="Enter password" id="password" class="form-control"
                           name="password"/>
                </div>

                <div class="form-group">
                    <label for="confPassword">Please enter same password as above</label>
                    <input type="password" placeholder="Enter password (check)" id="confPassword"
                           class="form-control" name="confPassword"/>
                </div>
                <div class="buttons float-right">
                    <input type="button" value="Submit" class="signUpBtn btn btn-primary" id="submit">
                    <button type="reset" value="reset" class="btn btn-danger resetBtn"> Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once 'common/scripts.php' ?>
<script>
    // When the user clicks on the button, scroll to the top of the document
    function scrollToTopFunction() {
        $(".mainDiv").animate({scrollTop: 0});
    }

    window.onload = function () {
        $('.loading').hide();
        let phones = [{"mask": "(###) ###-####"}, {"mask": "(###) ###-####"}];
        $('#phone').inputmask({
            mask: phones,
            greedy: false,
            definitions: {'#': {validator: "[0-9]", cardinality: 1}}
        });

        $(document).on("keypress", "#phone, #houseNumber", function (event) {
            return isNumber(event);
        });

        $(document).on("keypress", "#firstName, #lastName", function (event) {
            return lettersOnly(event);
        });

        $(document).on("click", ".resetBtn", function () {
            scrollToTopFunction();
        });

        $('#customerForm').validate({
            rules: {
                firstName: {
                    required: true
                },
                lastName: {
                    required: true
                },
                gender: {
                    required: true
                },
                email: {
                    required: true,
                    myEmail: true,
                    remote: "controller/authController.php?name=check_exists_email"
                },
                phone: {
                    required: true,
                    remote: "controller/authController.php?name=check_exists_mobile"
                },
                address: {
                    required: true,
                },
                houseNumber: {
                    required: true,
                },
                country: {
                    required: true,
                    dropdown: true
                },
                teacherId: {
                    required: true
                },
                password: {
                    required: true,
                    pwCheck: true,
                    minlength: 8
                },
                confPassword: {
                    required: true,
                    equalTo: "#confPassword",
                },
            },
            messages: {
                firstName: {
                    required: "Please enter first name",
                },
                lastName: {
                    required: "Please enter last name",
                },
                gender: {
                    required: "Please select gender",
                },
                email: {
                    required: "Please enter email ID",
                    myEmail: "Please enter valid email ID",
                    remote: "Email address is already taken, please enter different"
                },
                phone: {
                    required: "Please enter phone",
                    remote: "Phone number is already taken, please enter different"
                },
                address: {
                    required: "Please enter address",
                },
                houseNumber: {
                    required: "Please enter house number",
                },
                country: {
                    required: "Please select country",
                    dropdown: "Please select country"
                },
                password: {
                    required: "Please enter password",
                    pwCheck: "<span class='pw_strength'>Improve the password strength<br/>-Use one capital letter<br/>" +
                        "-Use one special character(@,#,$,%,etc.)<br/>-Use atleast two numeric values</span>",
                    minlength: "Password should be minimum 8 characters long"
                },
                confPassword: {
                    required: "Please enter password again",
                    equalTo: 'Please enter same password',
                }
            },
            errorPlacement: function (error, element) {
                if (element.parent().hasClass('input-field')
                    || element.parent().hasClass('input-group')) {
                    error.insertAfter(element.parent());
                } else if (element.parent().hasClass('form-check-inline')) {
                    error.insertAfter(element.parent().parent());
                } else {
                    error.insertAfter(element);
                }
            },
        });

        $(document).on("click", "#submit", function () {
            console.log('asd');
            if ($("#customerForm").valid()) {
                console.log('form valid');
                $.ajax({
                    type: "POST",
                    url: base_url + "controller/customerController.php?name=add",
                    data: $('#customerForm').serialize(),
                    dataType: 'json',
                    beforeSend: function () {
                        $(".loading").show();
                    },
                    success: function (data) {
                        $(".loading").hide();
                        if (data.status) {
                            console.log('success');
                            toastr.success(data.message);
                            $('.resetBtn').click();
                            window.location = base_url + 'customerView.php';
                        } else {
                            console.log('error');
                            toastr.error(data.message);
                        }
                    },
                    error: function () {
                        $(".loading").show();
                    }
                });
            } else {
                console.log('form invalid');
                return false;
            }
        });
    };
</script>
<?php require_once 'common/footer.php' ?>
