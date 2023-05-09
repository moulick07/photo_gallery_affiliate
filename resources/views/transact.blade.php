@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')



@stop


@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">


@section('content')

    <div class="justify-content">
        @auth
            <div class="d-flex justify-content-center">

                <a class="btn btn-outline-dark" type="submit" href="{{ url('/transactions') }}">
                    <i class="bi-wallet-fill me-1"></i>wallet
                    @foreach ($wallet as $key => $value)
                        @if (auth()->id() == $value->user_id)
                            <span class="badge bg-dark text-white ms-1 rounded-pill">{{ $value->balance }}</span>
                        @endif
                    @endforeach

                </a>&nbsp&nbsp&nbsp
                <div>

                    @if (Auth::user()->user_type == null)
                        <a href={{ route('welcome.guest') }}>click here to go to view all </a>
                    @else
                        <a href={{ route('index') }}>click here to go to view all </a>
                    @endif
                </div>
            </div>
        @endauth



        <table id="users-table" class="table table-striped table-no-bordered table-hover">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Amount</td>

                    <td>type</td>
                    <td>created at</td>
                    <td>updated at</td>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($users as $key => $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->user->name }}</td>
                    <td>{{ $value->amount }}</td>
                    @if ($value->type == 'debit')
                        <td class="text-danger">{{ $value->type }}</td>
                    @else
                        <td class="text-success">{{ $value->type }}</td>
                    @endif


                </tr>
            @endforeach
            </tr> --}}
            </tbody>
        </table>
        {{-- <div class="d-flex justify-content-center">

        {{ $users->links() }} --}}
    </div>
@endsection
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
        $(function() {
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,

                ajax: "{{ route('transact') }}",

                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        name: 'type',
                        data: 'type'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },

                ],
                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    console.log(nRow);
                    if (aData.type == "debit") {
                        // dd('khaskasbd');
                        $('tr', nRow).css('background-color', 'Tomato');
                    } else {
                        $('td', nRow).css('background-color', 'MediumSeaGreen');
                    }
                }
            });
        });
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection

@stop
