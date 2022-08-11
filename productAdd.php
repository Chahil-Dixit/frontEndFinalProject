<?php
require_once 'common/header.php'
?>
<div class="container mt-3">
    <div class="card">
        <div class="card-header">Add Product</div>
        <div class="card-body">
            <form name="customerForm" action="#" id="customerForm" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="productName">Product Name:</label>
                    <input type="text" name="productName" class="form-control text-capitalize"
                           placeholder="Enter product name" id="productName" required maxlength="255"/>
                </div>

                <div class="form-group">
                    <label for="supplierId">Supplier:</label>
                    <select id="supplierId" class="form-control" name="supplierId">
                        <option disabled selected> -- Select Supplier --</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="price">Price:</label>
                    <input type="text" class="form-control" name="price" placeholder="Enter price" id="price"/>
                </div>

                <div class="form-group mt-3">
                    <label for="tax">Tax %:</label>
                    <input type="text" class="form-control" name="tax" placeholder="Enter tax" id="tax"/>
                </div>

                <div class="form-group mt-3">
                    <label for="discount">Discount %:</label>
                    <input type="text" class="form-control" name="discount" placeholder="Enter discount" id="discount"/>
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
        getSuppliersList();
        let phones = [{"mask": "(###) ###-####"}, {"mask": "(###) ###-####"}];
        $('#phone').inputmask({
            mask: phones,
            greedy: false,
            definitions: {'#': {validator: "[0-9]", cardinality: 1}}
        });

        $(document).on("click", ".resetBtn", function () {
            scrollToTopFunction();
        });

        $(document).on("keypress", "#tax, #price, #discount", function (event) {
            return isNumber(event);
        });

        $(document).on("keypress", "#productName,", function (event) {
            return lettersOnly(event);
        });

        $('#customerForm').validate({
            rules: {
                productName: {
                    required: true
                },
                supplierId: {
                    required: true,
                    dropdown: true
                },
                price: {
                    required: true,
                },
                tax: {
                    required: true,
                },
                discount: {
                    required: true
                },
            },
            messages: {
                productName: {
                    required: "Please enter product name",
                },
                supplierId: {
                    required: "Please select supplier",
                    dropdown: "Please select supplier"
                },
                price: {
                    required: "Please enter price",
                },
                tax: {
                    required: "Please enter tax",
                },
                discount: {
                    required: "Please enter discount",
                },
                houseNumber: {
                    required: "Please enter house number",
                },
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
            if ($("#customerForm").valid()) {
                console.log('form valid');
                $.ajax({
                    type: "POST",
                    url: base_url + "controller/productController.php?name=add",
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

    function getSuppliersList() {
        $.ajax({
            type: "POST",
            url: base_url + "controller/supplierController.php?name=viewAllName",
            data: $('#customerForm').serialize(),
            dataType: 'json',
            beforeSend: function () {
                $(".loading").show();
            },
            success: function (data) {
                $(".loading").hide();
                if (data.status) {
                    console.log('success');
                    data.data.forEach((value) => {
                        $('#supplierId').append('<option value="' + value.id+'">' + value.firstName + ' ' + value.lastName +'</option>')
                        console.log(value);
                    })
                } else {
                    console.log('error');
                    toastr.error(data.message);
                }
            },
            error: function () {
                $(".loading").show();
            }
        });
    }
</script>
<?php require_once 'common/footer.php' ?>
