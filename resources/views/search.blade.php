@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')





@section('content')
    <a class="btn btn-small btn-success" href={{ route('index') }}>click here to go to view all </a>

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
                    <td> <a class="btn btn-small btn-success" href="{{ url('show', $value->id) }}">Show </a>
                        <a class="btn btn-small btn-success" href="{{ url('edit', $value->id) }}">edit </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
