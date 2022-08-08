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
                            <div class="row after-add-more">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="products">Product Name</label>
                                        <select name="product" id="products" class="form-control productsList"
                                                aria-describedby="basic-addon2">
                                            <option value="" selected disabled>Select Product</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mt-3">
                                        <label for="qty">Quantity</label>
                                        <input type="text" class="form-control" name="qty"
                                               placeholder="Enter quantity" id="qty"/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mt-3">
                                        <label for="addMore">&nbsp;</label>
                                        <button class="btn btn-light form-control showSummary">Show Summary
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer hide">
                        <div class="card-title">Order Summary</div>
                        <div class="card-body">
                            <div class="orderSummary">
                                <p>Total (Before Tax)</p>
                                <p>Discount</p>
                                <p>Tax</p>
                                <p>Total</p>
                            </div>
                            <div class="orderAmounts">
                                <p class="totalBeforeTax">$100.00</p>
                                <p class="discount">$0.00</p>
                                <p class="tax">$20.22</p>
                                <p class="finalTotal">$120.22</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Complete Order</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    let productList = [];
    $(document).ready(function () {

        $('#purchaseModal').on('shown.bs.modal', function () {
            getProductsList();
        });
        $('#purchaseModal').on('hide.bs.modal', function () {
            $('#purchaseForm')[0].reset();
        });
        $("#purchaseForm").validate({
            submitHandler: function (form) {
                console.log('valid');
                $.ajax({
                    type: "POST",
                    url: base_url + "controller/orderController.php?name=add",
                    data: $('#purchaseForm').serialize(),
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
                'product': {
                    required: true
                },
                'qty': {
                    required: true
                }
            },
            message: {
                'product': {
                    required: 'Please select product'
                },
                'qty': {
                    required: 'Please enter quantity'
                }
            }
        });

        $('#purchaseForm').submit(() => {
            return false;
        });

        $(".showSummary").click(() => {
            if ($("#purchaseForm").valid()) {
                let total = $('#products option:selected').data('price');
                let tax = $('#products option:selected').data('tax');
                let discount = $('#products option:selected').data('discount');
                let qty = $('#qty').val();
                console.log(total);
                console.log(tax);
                console.log(discount);
                total = total * parseInt(qty);
                $('.totalBeforeTax').text('$' + total);
                if (discount != '') {
                    discount = parseFloat(total * (discount / 100)).toFixed(2);
                    total = total - discount;
                }
                tax = total * (tax / 100);
                let finalAmount = tax + total;
                tax = parseFloat(tax).toFixed(2);
                total = parseFloat(total).toFixed(2);
                finalAmount = parseFloat(finalAmount).toFixed(2);
                $('.tax').text('$' + tax);
                $('.discount').text('$' + discount);
                $('.finalTotal').text('$' + finalAmount);
                $(".card-footer").removeClass('hide');
            }
        })
    });

    function getProductsList() {
        $.ajax({
            type: "POST",
            url: base_url + "controller/productController.php?name=showAll",
            data: $('#customerForm').serialize(),
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
</script>
</body>
</html>
