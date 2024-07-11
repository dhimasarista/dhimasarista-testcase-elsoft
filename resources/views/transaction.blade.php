@extends('layouts.app')
@section('content')
<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<!-- Tambahan script untuk SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function autoFormatDate() {
        var today = new Date().toISOString().substr(0, 10);
        $('#date-transaction').val(today);
    }
    function cleanForm() {
        $('#code-transaction').val('');
        autoFormatDate();
        $('#account').val('');
        $('#note').val('');
    }
</script>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-evenly mb-4">
        <h1 class="h3 mb-2 text-gray-800">List Item</h1>
        <a href="#" id="add-new-transaction" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" style="margin-left: 10px !important">
            <i class="fas  fa-sm text-white-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
            </i> Add New</a>
            <script>
                $("#add-new-transaction").on("click", e =>{
                    cleanForm()
                    $("#transactionModal").modal()
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
                            <th>No</th>
                            <th>Company</th>
                            <th>Code</th>
                            <th>Date</th>
                            <th>Account</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- Modal --}}
<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="transactionModalLabel">Create/Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="company">Company</label>
                        <p><b>{{ session()->get("name") }}</b></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="code-transaction">Code</label>
                        <input type="text" class="form-control" id="code-transaction" placeholder="<<Auto>>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="date-transaction">Date</label>
                        <input type="date" class="form-control" id="date-transaction">
                    </div>
                    <script>
                        $(document).ready(function() {
                            autoFormatDate()
                        });
                    </script>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account">Account</label>
                        <select class="form-control" id="account">
                        <option></option>
                        @foreach ($accounts as $a)
                            <option value="{{ $a->id }}">{{ $a->name }} - {{ session()->get("username") }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="note">Note</label>
                <textarea class="form-control" id="note" rows="3" placeholder="note"></textarea>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Back</button>
        <button type="button" class="btn btn-success">Save</button>
    </div>
    </div>
</div>
</div>
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#item-table').DataTable({
            // ajax: {
            //     "url": '/items/list',
            //     "dataSrc": 'items',
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            // },
            // columns: [
            //     {
            //         data: null,
            //         render: function (data, type, row) {
            //             return `
            //             <div class="dropdown custom-dropdown text-center">
            //                 <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
            //                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            //                     <a class="dropdown-item" href="#" onclick=view('${row.id}')>View</a>
            //                     <a class="dropdown-item" href="#" onclick=edit('${row.id}')>Edit</a>
            //                     <a class="dropdown-item" href="#" onclick=deleteItem('${row.id}')>Delete</a>
            //                 </div>
            //             </div>
            //             `;
            //         }
            //     },
            //     { data: 'label' },
            //     {
            //         data: 'company',
            //         render: function(data) {
            //             return data.name;
            //         }
            //     },
            //     { data: 'code' },
            //     {
            //             data: 'item_group',
            //             render: function(data) {
            //                 return data.name
            //             }
            //         },
            //     {
            //         data: 'is_active',
            //         render: function(data) {
            //             return data ? 'Y' : 'N';  // Misalnya, konversi boolean ke teks
            //         }
            //     },
            //     {
            //         data: null,
            //         render: function (data, type, row) {
            //             return 0
            //         }
            //     },
            // ]
        });
    });
</script>
@endsection
