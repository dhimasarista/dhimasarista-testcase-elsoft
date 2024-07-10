@extends('layouts.app')
@section('content')
<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-evenly mb-4">
        <h1 class="h3 mb-2 text-gray-800">List Item</h1>
        <a href="#" data-toggle="modal" data-target="#add-product-modal" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" style="margin-left: 10px !important">
            <i class="fas  fa-sm text-white-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
            </i> Add Product</a>
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
                            <th>ItemGrouo</th>
                            <th>Is Active</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="dropdown custom-dropdown text-center">
                                    <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">View</a>
                                        <a class="dropdown-item" href="#">Edit</a>
                                        <a class="dropdown-item" href="#">Delete</a>
                                    </div>
                                </div>
                            </td>
                            <td>Dhimas</td>
                            <td>Ok</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
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
                <h4 class="modal-title">Modal Title</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="companyName">Company Name</label>
                            <input type="text" class="form-control" id="companyName" placeholder="Company Name">
                        </div>
                        <div class="form-group col-6">
                            <label for="itemType">Item Type</label>
                            <input type="text" class="form-control" id="itemType" placeholder="Item Type">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="autoInput">Auto</label>
                            <input type="text" class="form-control" id="autoInput" placeholder="<<Auto>>">
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
                            </select>
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
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="currency">Currency</label>
                            <select class="form-control" id="currency">
                                <option>Select Currency</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="salesAmount">Sales Amount</label>
                            <input type="number" class="form-control" id="salesAmount" placeholder="Sales Amount">
                        </div>
                        <div class="form-group col-6">
                            <label for="purchaseCurrency">Purchase Currency</label>
                            <select class="form-control" id="purchaseCurrency">
                                <option>Select Purchase Currency</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="purchaseAmount">Purchase Amount</label>
                            <input type="number" class="form-control" id="purchaseAmount" placeholder="Purchase Amount">
                        </div>
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>

        </div>
    </div>
</div>
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#item-table').DataTable({
            ajax: {
                "url": '/items/list',
                "dataSrc": 'items',
            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row) {
                        return `
                        <div class="dropdown custom-dropdown text-center">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">View</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                        `;
                    }
                },
                { data: 'title' },
                { data: 'company' },
                { data: 'code' },
                { data: 'item_group' },
                { data: 'is_active' },
                { data: 'balance' },
            ]
        });
    });
</script>
@endsection
