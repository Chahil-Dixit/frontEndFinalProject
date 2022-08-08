<?php require_once 'common/header.php' ?>
    <div class="container mt-3">
        <div class="card">
            <div class="card-header head-bg-info">
                <h4 class="m-b-0">
                    Suppliers
                    <button class="btn btn-primary float-right">
                        <a href="supplierAdd.php" class="text-white border-0 text-decoration-none customerBtn">Add
                            Supplier</a>
                    </button>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive path_report_print" id="table-responsive">
                    <table class="table table-striped table-bordered text-center" id="supplierTable">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Supplier Id</th>
                            <th class="text-center">First Name</th>
                            <th class="text-center">Last Name</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">House Number</th>
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
            return $('#supplierTable').DataTable({
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
                    "url": "controller/tableController.php?name=suppliersTable",
                    "dataType": "json",
                    "type": "POST",
                },
                "bJQueryUI": true,
                "columns": [
                    {"data": "sr_no"},
                    {"data": "customer_id"},
                    {"data": "first_name"},
                    {"data": "last_name"},
                    {"data": "gender"},
                    {"data": "phone"},
                    {"data": "email"},
                    {"data": "address"},
                    {"data": "house_number"},
                ],
            });
        }

        $(document).ready(function () {
            $('.loading').hide();
            let table = render_datatable();
        });
    </script>
<?php require_once 'common/footer.php' ?>