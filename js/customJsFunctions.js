jQuery.validator.addMethod("myEmail", function (value, element) {
    var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return regex.test(value);
});

jQuery.validator.addMethod('dropdown', function (value) {
    return (value !== '');
}, "");

jQuery.validator.addMethod("pwCheck", function (value) {
    return /^[A-Za-z0-9\d=!\-@#$._*]*$/.test(value) // consists of only these
        && /[a-z]/.test(value) // has a lowercase letter
        && /[A-Z]/.test(value) // has a capital letter
        && /\d/.test(value) // has a digit
        && /[=!\-@#$._*]/.test(value) // has a special character
});

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