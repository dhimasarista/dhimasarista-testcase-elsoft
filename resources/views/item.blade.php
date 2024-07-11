@extends('layouts.app')
@section('content')
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Tambahan script untuk SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function fetchItemAccountGroups(id) {
            $.ajax({
                url: `/item-account-groups/${id}`,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Kosongkan select itemAccountGroup terlebih dahulu
                    $('#itemAccountGroup').empty();
                    // Tambahkan opsi default
                    $('#itemAccountGroup').append('<option value="">Select Item Account Group</option>');
                    // Tambahkan pilihan dari response
                    if (response.item_account_group) {
                        $('#itemAccountGroup').append('<option value="' + response.item_account_group.id +
                            '">' + response.item_account_group.name + '</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        // Fungsi untuk membersihkan form
        function cleanForm() {
            $('#companyName').val('');
            $('#itemType').val('');
            $('#code-item').val('');
            $('#title').val('');
            $('#itemGroup').prop('selectedIndex', 0).trigger('change');
            $('#itemAccountGroup').prop('selectedIndex', 0).trigger('change');
            $('#itemUnit').prop('selectedIndex', 0).trigger('change');
            $('#currency').val('');
            $('#salesAmount').val('');
            $('#purchaseCurrency').val('');
            $('#purchaseAmount').val('');
            $('#isActive').prop('checked', false);
        }

        function edit(id) {
            // Lakukan request AJAX untuk mengambil data item berdasarkan ID
            TopLoaderService.start()
            $.ajax({
                url: '/items/' + id,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // $('#companyName').text(response.company.name);
                    // $('#itemType').text(response.item_type.name);
                    $('#code-item').val(response.item.code);
                    $('#title').val(response.item.label);
                    $('#itemGroup').val(response.item.item_group_id).trigger('change');
                    $('#itemUnit').val(response.item.item_unit_id).trigger('change');
                    $('#isActive').prop('checked', response.item.is_active);
                    $('#item-form').attr('data-form-type', "edit-item")
                    $('#item-form').attr('data-item-id', response.item.id);
                    fetchItemAccountGroups($('#itemGroup').val());
                    // Tampilkan modal edit
                    $('#add-product-modal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch item:', error);
                    alert('Failed to fetch item. Please try again.');
                },
                complete: function(data) {
                    TopLoaderService.end()
                    var itemAccountGroupId = data.item.item_account_group_id;
                    $('#itemAccountGroup option').each(function() {
                        if ($(this).val() == itemAccountGroupId) {
                            $(this).prop('selected', true);
                            return false; // Keluar dari loop setelah menemukan yang sesuai
                        }
                    });
                }
            });
        }
        // Fungsi untuk menghapus item
        function deleteItem(id) {
            // Lakukan konfirmasi penghapusan
            if (confirm('Are you sure you want to delete this item?')) {
                TopLoaderService.start()
                $.ajax({
                    url: '/items/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        TopLoaderService.end()
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then(() => {
                            $('#item-table').DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                        TopLoaderService.end()
                        alert('Failed to delete item. Please try again.');
                    }
                });
            }
        }
    </script>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-evenly mb-4">
            <h1 class="h3 mb-2 text-gray-800">List Item</h1>
            <a href="#" id="add-product-button" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"
                style="margin-left: 10px !important">
                <i class="fas  fa-sm text-white-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z" />
                    </svg>
                </i> Add Product</a>
            <script>
                $("#add-product-button").on("click", e => {
                    cleanForm()
                    $('#add-product-modal').modal('show');
                })
            </script>
        </div>
        <!-- DataTales -->
        <div class="card shadow mb-4">
            {{-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div> --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="item-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Title</th>
                                <th>Company</th>
                                <th>Code</th>
                                <th>Item Group</th>
                                <th>Is Active</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="add-product-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Product</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="item-form">
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="companyName">Company</label>
                                <p><b>{{ $companyName }}</b></p>
                            </div>
                            <div class="form-group col-6">
                                <label for="itemType">Item Type</label>
                                {{-- <input type="text" class="form-control" id="itemType" placeholder="Item Type"> --}}
                                <p><b>Product</b></p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="code-item">Auto</label>
                                <input type="text" class="form-control" id="code-item" placeholder="<<Auto>>">
                            </div>
                            <div class="form-group col-6">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" placeholder="Title">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="itemGroup">Item Group</label>
                                <select class="form-control" id="itemGroup">
                                    <option>Select Item Group</option>
                                    @foreach ($itemGroups as $itemGroup)
                                        <option value="{{ $itemGroup->id }}">{{ $itemGroup->name }} - {{ $itemGroup->code }}
                                        </option>
                                    @endforeach
                                </select>
                                <script>
                                    // Event listener untuk select itemGroup
                                    $('#itemGroup').on('change', function() {
                                        var itemGroupId = $(this).val();
                                        fetchItemAccountGroups(itemGroupId);
                                    });
                                </script>
                            </div>
                            <div class="form-group col-6">
                                <label for="itemAccountGroup">Item Account Group</label>
                                <select class="form-control" id="itemAccountGroup">
                                    <option>Select Item Account Group</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="itemUnit">Item Unit</label>
                                <select class="form-control" id="itemUnit">
                                    <option>Select Item Unit</option>
                                    @foreach ($itemUnits as $itemUnits)
                                        <option value="{{ $itemUnits->id }}">{{ $itemUnits->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group col-6">
                            <label for="currency">Sales Currency</label>
                            <select class="form-control" id="salesCurrency">
                                <option>Select Sales Currency</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name }} - {{ $currency->code }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        </div>
                        {{-- <div class="form-row">
                        <div class="form-group col-6">
                            <label for="salesAmount">Sales Amount</label>
                            <input type="number" class="form-control" id="salesAmount" placeholder="Sales Amount">
                        </div>
                        <div class="form-group col-6">
                            <label for="purchaseCurrency">Purchase Currency</label>
                            <select class="form-control" id="purchaseCurrency">
                                <option>Select Purchase Currency</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name }} - {{ $currency->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                        <div class="form-row">
                            {{-- <div class="form-group col-6">
                            <label for="purchaseAmount">Purchase Amount</label>
                            <input type="number" class="form-control" id="purchaseAmount" placeholder="Purchase Amount">
                        </div> --}}
                            <div class="form-group col-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="isActive">
                                    <label class="form-check-label" for="isActive">Is Active</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal" id="close-item-form">Close</button>
                    <button type="button" class="btn btn-success" id="submit-item-form">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Event listener untuk tombol Save
        $('#submit-item-form').on('click', function() {
            TopLoaderService.start()
            var formData = {
                company_id: $('#companyName').val(), // Adjust according to the selected company id
                item_type_id: $('#itemType').val(),
                label: $('#title').val(),
                item_group_id: $('#itemGroup').val(),
                item_account_group_id: $('#itemAccountGroup').val(),
                item_unit_id: $('#itemUnit').val(),
                is_active: $('#isActive').is(':checked') ? 1 : 0,
                code: $('#code-item').val() === "" ? "<<Auto>>" : $('#code-item').val(),
            };

            var url = "";
            var method = "";

            if ($('#item-form').attr('data-form-type') === 'edit-item') {
                // Edit item: PUT request
                var itemId = $('#item-form').attr('data-item-id');
                url = `/items/${itemId}`;
                method = 'PUT';
            } else {
                // Add new item: POST request
                url = "/items";
                method = 'POST';
            }

            // Perform AJAX request
            $.ajax({
                url: url,
                type: method,
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    TopLoaderService.end()
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then(() => {
                        cleanForm();
                        $('#item-table').DataTable().ajax.reload();
                        $('#add-product-modal').modal('hide');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                    TopLoaderService.end()
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to save item'
                    });
                }
            });
        });


        // Event listener untuk tombol Close
        $('#close-item-form').on('click', function() {
            $('#item-form').attr('data-form-type', null)
            cleanForm();
        });
    </script>
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#item-table').DataTable({
                ajax: {
                    "url": '/items/list',
                    "dataSrc": 'items',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                },
                columns: [{
                        data: null,
                        render: function(data, type, row) {
                            return `
                        <div class="dropdown custom-dropdown text-center">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" onclick=view('${row.id}')>View</a>
                                <a class="dropdown-item" href="#" onclick=edit('${row.id}')>Edit</a>
                                <a class="dropdown-item" href="#" onclick=deleteItem('${row.id}')>Delete</a>
                            </div>
                        </div>
                        `;
                        }
                    },
                    {
                        data: 'label'
                    },
                    {
                        data: 'company',
                        render: function(data) {
                            return data.name;
                        }
                    },
                    {
                        data: 'code'
                    },
                    {
                        data: 'item_group',
                        render: function(data) {
                            return data.name
                        }
                    },
                    {
                        data: 'is_active',
                        render: function(data) {
                            return data ? 'Y' : 'N'; // Misalnya, konversi boolean ke teks
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return 0
                        }
                    },
                ]
            });
        });
    </script>
@endsection
