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



@stop


@section('content')

    <table class="table table-striped table-bordered" id="table" data-toggle="table" data-height="460"
        data-ajax="ajaxRequest" data-search="true" data-side-pagination="server" data-pagination="true">
        <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Email</td>
                {{-- <td>shark Level</td> --}}
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($sharks as $key => $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->email }}</td>
                    {{-- <td>{{ $value->shark_level }}</td> --}}

                    <!-- we will also add show, edit, and delete buttons -->
                    <td>

                        <!-- delete the shark (uses the destroy method DESTROY /sharks/{id} -->
                        <!-- we will add this later since its a little more complicated than the other two buttons -->

                        <!-- show the shark (uses the show method found at GET /sharks/{id} -->
                        <a class="btn btn-small btn-success" href="{{ url('show', $value->id) }}">Show </a>

                        <!-- edit this shark (uses the edit method found at GET /sharks/{id}/edit -->
                        <a class="btn btn-small btn-info" href="{{ URL::to('sharks/' . $value->id . '/edit') }}">Edit
                            this user</a>
                        {{-- <a href="{{ Storage::url($value->image)}}" target="_blank" download>Download</a> --}}

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $sharks->links() }}
    <div>
        <a class="btn btn-small btn-success" href="{{ url('/transactions') }}">Show all transactions </a>
    </div>
    <div>
        <table class="table table-striped table-bordered" id="table" data-toggle="table" data-height="460"
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
                    <a class="btn btn-small btn-success" href={{ route('change', $values->id) }}>change
                        amount</a>

                </td>
                </tr>
                @endforeach

    </div>

    </table>





@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop


@section('js')
    <script>
        console.log('Hi!');
        window.addEventListener('DOMContentLoaded', event => {
            // Simple-DataTables
            // https://github.com/fiduswriter/Simple-DataTables/wiki

            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });
        $('.coins').click(function(event) {
            $.ajax({
                type: 'POST',
                url: "edit-amount",
                data: {
                    add_photo_coin: add_photo_coin,
                },

                dataType: 'json',
                async: false,
                success: function(data) {
                    console.log(data);
                },
                error: function(data) {}
            });
        });
    </script>

@stop
@stop
