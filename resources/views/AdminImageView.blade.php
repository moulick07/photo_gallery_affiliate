@extends('adminlte::page')

@section('title', 'Dashboard')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@stop

@section('content_header')



@section('content')
    @if (session('message'))
        <div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
            <strong>{{ session('message') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="d-flex content-align-center"> 
        <table class="table table-striped table-bordered" id="table" data-toggle="table" data-height="460"
            data-ajax="ajaxRequest" data-search="true" data-side-pagination="server" data-pagination="true">
            <thead>
                <tr>
                    {{-- <td>id</td> --}}
                    <td>price</td>
                    <td>title</td>
                    <td>tags</td>
                    <td>uploaded by </td>
                    <td>image</td>
                    <td>action</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $key => $values)
                    <tr>
                        {{-- <td>ID</td> --}}
                        <td>{{ $values->id }}</td>
                        <td>{{ $values->price }}</td>
                        <td>{{ $values->title }}</td>
                        <td>{{ $values->tags }}</td>
                        <td>{{ $values->user->name }}</td>
                        <td> <img src="{{ url('images/' . $values->imagename) }}" width="300px" height="150"></td>
                        <td>
                            <a class="btn btn-small btn-success" href={{ route('deletebyadmin', $values->id) }}>delete</a>
                        </td>

                    </tr>
            </tbody>
            @endforeach
        </table>
    </div>
    <div class="d-flex content-self-center">

        {{ $images->links() }}
    </div>
@stop
@stop
