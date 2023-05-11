{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')





@section('content')
    <div>
        <a class="btn btn-small btn-success" href="{{ url('/transactions') }}">Show all transactions </a>
    </div>
    <div class="mt-3">
        <a class="btn btn-small btn-success" href="{{ url('/imageview') }}">Show all image uploads </a>
    </div>
    <table id="users-tables" class="table table-striped table-no-bordered table-hover">
        <thead>
            <tr>
                <td>ID</td>
                <td>name</td>
                <td>email</td>
                {{-- <td>shark Level</td> --}}
                <td>reffer code</td>
                <td>created at</td>
                <td>updated at</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($sharks as $key => $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->email }}</td>
                    {{-- <td>{{ $value->shark_level }}</td> --}}

            {{-- <!-- we will also add show, edit, and delete buttons -->
                        <td>
                            
                            <!-- delete the shark (uses the destroy method DESTROY /sharks/{id} -->
                            <!-- we will add this later since its a little more complicated than the other two buttons -->
                            
                            <!-- show the shark (uses the show method found at GET /sharks/{id} -->
                            <a class="btn btn-small btn-success" href="{{ url('show', $value->id) }}">Show </a> --}}

            <!-- edit this shark (uses the edit method found at GET /sharks/{id}/edit -->
            {{-- <a class="btn btn-small btn-info" href="{{ URL::to('sharks/' . $value->id . '/edit') }}">Edit
                this user</a>
                        {{-- <a href="{{ Storage::url($value->image)}}" target="_blank" download>Download</a> --}}

            {{-- </td>
                </tr>
                @endforeach  --}}
        </tbody>
    </table>
    {{-- {{ $sharks->links() }} --}}

    <div>
        <table class="table table-striped mt-3 table-bordered" id="table" data-toggle="table" data-height="460"
            data-ajax="ajaxRequest" data-search="true" data-side-pagination="server" data-pagination="true">
            <thead>
                <tr>
                    <td>amount of </td>
                    <td>coins </td>
                    {{-- <td>actions</td> --}}
                    @foreach ($amounts as $key => $values)
                <tr>
                    {{-- <td>ID</td> --}}

                    <td>add photo coins</td>
                    <td>{{ $values->add_photo_coin }}</td>
                <tr>
                    <td>reference coins</td>

                    <td>{{ $values->reference_coin }}</td>
                </tr>
                <td>
                    <a class="btn btn-small btn-success" id="coins">change
                        amount</a>

                </td>
                </tr>
                @endforeach

    </div>

    </table>

    <form action="javascript:;" id="modaldata">
        @csrf
        <div class="modal fade" id="new_modal_plan">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">edit photo coins</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="add_photo_coin" class="col-form-label">add photo coins:</label>
                                <input type="text" value="" class="form-control" id="add_photo_coin">
                            </div>
                            <div class="mb-3">
                                <label for="reference_coin" class="col-form-label">Referral coin:</label>
                                <input class="form-control" value="" id="reference_coin">
                            </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" id="btn-save" class="btn btn-danger" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-success" id="savedata" data-dismiss="modal">save
                            changes</button>
                    </div>

                </div>
            </div>
        </div>
    </form>


@section('js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.dropdown-toggle').dropdown();
        });
        $(function() {
            var table = $('#users-tables').DataTable({
                processing: true,
                serverSide: true,

                ajax: "{{ route('index') }}",

                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: false
                    },
                    {
                        name: 'affiliate_id',
                        data: 'affiliate_id',
                        orderable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },


                ],

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#coins').click(function(e) {
                $('#new_modal_plan').modal('show');
                // $('#btn-save').val("add");
                $('#savedata').click(function(e) {

                    e.preventDefault();
                    var data1 = $('#add_photo_coin').val();
                    var data2 = $('#reference_coin').val();
                    
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: 'update-coins',
                        dataType: 'json',
                        async: false,
                        data: {
                            'add_photo_coin':data1,
                            'reference_coin':data2
                        },
                        success: function(data) {
                            window.location = "home";

                            console.log(data);
                        },
                        error: function(data) {}
                    });
                });
            });
        });
    </script>



@stop
@stop
