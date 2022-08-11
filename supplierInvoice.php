<?php require_once 'common/header.php' ?>
    <div class="container mt-3">
        <div class="card">
            <div class="card-header head-bg-info">
                <h4 class="m-b-0">
                    Supplier Invoices
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="table-responsive">
                    <table class="table table-striped table-bordered text-center" id="customerTable">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Invoice Id</th>
                            <th class="text-center">Customer Name</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Discount</th>
                            <th class="text-center">Tax</th>
                            <th class="text-center">Grand Total</th>
                            <th class="text-center">View Invoice</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderSummaryModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Summary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card w-auto m-0">
                        <div class="card-body">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeModal" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php require_once 'common/scripts.php' ?>
    <script>
        function render_datatable() {
            return $('#customerTable').DataTable({
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
                    console.log($(this));
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
                    "url": "controller/tableController.php?name=supplierInvoiceTable",
                    "dataType": "json",
                    "type": "POST",
                },
                "bJQueryUI": true,
                "columns": [
                    {"data": "sr_no"},
                    {"data": "inv_id"},
                    {"data": "name"},
                    {"data": "total"},
                    {"data": "discount"},
                    {"data": "tax"},
                    {"data": "finalAmount"},
                    {"data": "viewInvoice"},
                ],
            });
        }

        $(document).ready(function () {
            $('.loading').hide();
            let table = render_datatable();

            $(document).on("click", ".viewInvoice", function (event) {
                invId = $(this).data('id');
                $('#orderSummaryModal').modal('show');
            });

            $(document).on("click", ".close, .closeModal", function (event) {
                $('#orderSummaryModal').modal('hide');
            });

            $(document).on('shown.bs.modal', '#orderSummaryModal', function () {
                $.ajax({
                    type: "POST",
                    url: base_url + "controller/invoiceController.php?name=view",
                    data: 'invId=' + invId,
                    dataType: 'json',
                    beforeSend: function () {
                        $(".loading").show();
                    },
                    success: function (data) {
                        $(".loading").hide();
                        if (data.status) {
                            $("#orderSummaryModal .card-body").html(data.data.products);
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function () {
                        $(".loading").show();
                    }
                });
            }).on('hide.bs.modal', function () {
                invId = '';
            });
        });
    </script>
<?php require_once 'common/footer.php' ?>