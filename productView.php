<?php require_once 'common/header.php' ?>
    <div class="container mt-3">
        <div class="card">
            <div class="card-header head-bg-info">
                <h4 class="m-b-0">
                    Products
                    <button class="btn btn-primary float-right">
                        <a href="productAdd.php" class="text-white border-0 text-decoration-none productBtn">
                            Add Product
                        </a>
                    </button>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-responsive">
                    <table class="table table-striped table-bordered text-center" id="productTable">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Product Id</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Supplier Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Tax</th>
                            <th class="text-center">Discount</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php require_once 'common/scripts.php' ?>
    <script>
        function render_datatable() {
            return $('#productTable').DataTable({
                "processing": true,
                "serverSide": true,
                'lengthChange': false,
                'info': false,
                "searching": true,
                'autoWidth': false,
                'pageLength': 10,
                'ordering': false,
                'bPaginate': true,
                drawCallback: function (settings) {
                    if (Math.ceil((this.fnSettings().fnRecordsDisplay()) / this.fnSettings()._iDisplayLength) > 1) {
                        $('.dataTables_paginate').show();
                    } else {
                        $('.dataTables_paginate').hide();
                    }
                    if ($(this).find('.dataTables_empty').length == 1) {
                        if ($(".dataTables_filter input").val() == '') {
                            $('.dataTables_filter').hide();
                        } else {
                            $('.dataTables_filter').show();
                        }
                    } else {
                        $('.dataTables_filter').show();
                    }
                },
                "ajax": {
                    "url": "controller/tableController.php?name=productsTable",
                    "dataType": "json",
                    "type": "POST",
                },
                "bJQueryUI": true,
                "columns": [
                    {"data": "sr_no"},
                    {"data": "product_id"},
                    {"data": "productName"},
                    {"data": "supplier_id"},
                    {"data": "price"},
                    {"data": "tax"},
                    {"data": "discount"},
                ],
            });
        }

        $(document).ready(function () {
            $('.loading').hide();
            let table = render_datatable();
        });
    </script>
<?php require_once 'common/footer.php' ?>