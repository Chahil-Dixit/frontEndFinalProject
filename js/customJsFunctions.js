// check the validity of the email
jQuery.validator.addMethod("myEmail", function (value, element) {
    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return regex.test(value);
});

// Check if the dropdown is empty or not
jQuery.validator.addMethod('dropdown', function (value) {
    return (value !== '');
}, "");

// Check the strength of the password
jQuery.validator.addMethod("pwCheck", function (value) {
    return /^[A-Za-z0-9\d=!\-@#$._*]*$/.test(value) // consists of only these
        && /[a-z]/.test(value) // has a lowercase letter
        && /[A-Z]/.test(value) // has a capital letter
        && /\d/.test(value) // has a digit
        && /[=!\-@#$._*]/.test(value) // has a special character
});

// Check the input validation of the array inputs
jQuery.validator.addMethod("multiInputTest", function (value, element) {
    let flag = true;
    let name = element.name.replace(/[^a-zA-Z ]/g, "");
    let label = '';
    if (name === 'product') {
        label = 'Please select product';
    } else {
        label = 'Please enter quantity';
    }
    $("form [name^='" + name + "']").each(function (i, j) {
        $(this).parent('div').find('label.error').remove();
        if ($.trim($(this).val()) === '') {
            flag = false;
            $(this).parent('div').append('<label id=' + name + ' "' + i + '-error" class="error">' + label + '</label>');
        }
    });
    return flag;
}, "");

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    let charCode = (evt.which) ? evt.which : evt.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

function lettersOnly(evt) {
    evt = (evt) ? evt : event;
    let charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode :
        ((evt.which) ? evt.which : 0));
    if (charCode > 31 && (charCode < 65 || charCode > 90) &&
        (charCode < 97 || charCode > 122)) {
        alert("Enter letters only.");
        return false;
    }
    return true;
}

window.load = function () {
    $('.loading').hide();
}