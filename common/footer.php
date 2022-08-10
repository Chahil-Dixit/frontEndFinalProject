<style>
    .card {
        margin-left: 0 !important;
    }

    .card-footer .card-body {
        display: flex;
        justify-content: space-between;
    }
</style>
<div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Items</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card w-auto m-0">
                    <div class="card-body">
                        <form action="#" method="post" id="purchaseForm">
                            <input type="hidden" name="total" value="0">
                            <input type="hidden" name="tax" value="0">
                            <input type="hidden" name="discount" value="0">
                            <input type="hidden" name="finalTotal" value="0">
                            <div class="row after-add-more">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="product0">Product Name</label>
                                        <select name="product[]" id="product0" class="form-control productsList">
                                            <option value="" selected disabled>Select Product</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mt-3">
                                        <label for="qty0">Quantity</label>
                                        <input type="text" class="form-control" name="qty[]"
                                               placeholder="Enter quantity" id="qty0"/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mt-3">
                                        <label for="addMore">&nbsp;</label>
                                        <button class="btn btn-success add-more form-control" type="button">Add More
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 copy hide">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="product">Product Name</label>
                                    <select name="product[]" id="product" class="form-control productsList">
                                        <option value="" selected disabled>Select Product</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mt-3">
                                    <label for="qty">Quantity</label>
                                    <input type="text" class="form-control" name="qty[]"
                                           placeholder="Enter quantity" id="qty"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mt-3">
                                    <label for="addMore" class="noSpaceWidth">&nbsp;</label>
                                    <div class="btn-group">
                                        <button class="btn btn-light form-control" id="addMore">Add More Item</button>
                                        <button class="btn btn-danger form-control remove" id="remove">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer hide">
                        <div class="card-title">Order Summary</div>
                        <div class="card-body">
                            <div class="orderSummary">
                                <p>Total (Before Tax)</p>
                                <p>Discount</p>
                                <p>Tax</p>
                                <p class="fw-bold">Grand Total</p>
                            </div>
                            <div class="orderAmounts">
                                <p class="totalBeforeTax">$0.00</p>
                                <p class="discount text-success">$0.00</p>
                                <p class="tax">$0.00</p>
                                <p class="finalTotal fw-bold">$0.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary addOrder">Order Summary</button>
                <button type="button" class="btn btn-primary placeOrder">Place Order</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    let productList = [];
    let total = 0;
    let tax = 0;
    let discount = 0;
    let finalAmount = 0;

    $(document).ready(function () {
        $(".add-more").click(function () {
            let lastQty = $('form input[name^="qty"]:last').prop('id');
            // Read the Number from last input and increment id value by 1
            let num = parseInt(lastQty.match(/\d+/g), 10) + 1;

            // Copy the input block and paste it into form
            let html = $(".copy").html();
            $(".after-add-more").after(html);

            $("form input[name^='qty']:last").prop('id', 'qty' + num);
            $("form input[name^='product']:last").prop('id', 'product' + num);
        });

        $("body").on("click", ".remove", function () {
            $(this).parents(".row").remove();
        });

        $(document).on("keypress", "input[name^='qty']", function (event) {
            return isNumber(event);
        }).on("blur", "input[name^='qty']", function () {
            return calculateTotal();
        })

        $('#purchaseModal').on('shown.bs.modal', function () {
            getProductsList();
        }).on('hide.bs.modal', function () {
            $('#purchaseForm')[0].reset();
        });

        $("#purchaseForm").validate({
            submitHandler: function (form) {
                $.ajax({
                    type: "POST",
                    url: base_url + "controller/orderController.php?name=add",
                    data: form,
                    dataType: 'json',
                    beforeSend: function () {
                        $(".loading").show();
                    },
                    success: function (data) {
                        $(".loading").hide();
                        if (data.status) {

                        } else {
                            console.log('error');
                            toastr.error(data.message);
                        }
                    },
                    error: function () {
                        $(".loading").show();
                    }
                });
            },
            rules: {
                'product[]': {
                    "multiInputTest": true
                },
                'qty[]': {
                    "multiInputTest": true
                }
            },
        });

        $('#purchaseForm').submit(() => {
            return false;
        });

        $(document).on("click", ".addOrder, .placeOrder", function (event) {
            calculateTotal();
        });

        $(document).on("click", ".placeOrder", function (event) {
            $("#purchaseForm").submit();
        });
    });

    function getProductsList() {
        $.ajax({
            type: "GET",
            url: base_url + "controller/productController.php?name=showAll",
            data: '',
            dataType: 'json',
            beforeSend: function () {
                $(".loading").show();
            },
            success: function (data) {
                $(".loading").hide();
                if (data.status) {
                    productList = data.data;
                    $('.productsList').html('<option value="" selected disabled>Select Product</option>');
                    data.data.forEach((value) => {
                        $('.productsList').append('<option value="' + value.id +
                            '" data-tax="' + value.tax + '" data-discount="' + value.discount +
                            '" data-price="' + value.price + '">' + value.productName + '</option>');
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

    function calculateTotal() {
        if ($("#purchaseForm").valid()) {
            total = 0;
            tax = 0;
            discount = 0;
            finalAmount = 0;
            $("form [name^=product] > option:selected").each(function (i, j) {
                let productData = $('#product' + i + ' option:selected');
                let tempTotal = productData.data('price');
                let tempTax = productData.data('tax');
                let tempDiscount = productData.data('discount');
                let qty = $('form #qty' + i).val();
                tempTotal += tempTotal * parseInt(qty);
                if (tempDiscount > 0) {
                    discount += tempTotal * (tempDiscount / 100);
                }
                tax += tempTotal * (tempTax / 100);
                total += tempTotal;
            });
            total = total - discount;
            $('.totalBeforeTax').html('&nbsp;&nbsp;&nbsp;$' + parseFloat(total).toFixed(2));
            $("input[name^='total']").val(tax);

            finalAmount = tax + total;
            tax = parseFloat(tax).toFixed(2);
            finalAmount = parseFloat(finalAmount).toFixed(2);
            discount = parseFloat(discount).toFixed(2);

            $('.tax').html('&nbsp;&nbsp;&nbsp;$' + tax);
            $("input[name^='tax']").val(tax);
            $('.discount').html('-&nbsp;$' + discount);
            $("input[name^='discount']").val(tax);
            $('.finalTotal').html('&nbsp;&nbsp;&nbsp;$' + finalAmount);
            $("input[name^='finalTotal']").val(tax);
            $(".card-footer").removeClass('hide');
        }
    }
</script>
</body>
</html>
