@extends('photogallery.master')

<body>
    {{-- <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0"> --}}

    {{-- <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block"> --}}

    </div>


    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <meta name="description" content="" />
            <meta name="author" content="" />
            <title>Photo gallery</title>
            <!-- Favicon-->
            <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
            <!-- Bootstrap icons-->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
            <!-- Core theme CSS (includes Bootstrap)-->
            {{-- <link href="css/styles.css" rel="stylesheet" /> --}}
        </head>

        <body>
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container px-4 px-lg-5">
                    <a class="navbar-brand" href="#!">Start uploading </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><span
                            class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        {{-- < class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4"> --}}
                        @if (Route::has('login'))
                            @auth
                                {{-- @dd(Auth::user()->affiliate_id); --}}
                                <div>
                                    {{ Auth::user()->name }}
                                </div>

                                <div>
                                    <a class="btn btn-default btn-flat float-right btn-block" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">logout</a>
                                    <form id="logout-form" action={{ route('logout') }} method="POST"
                                        style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                                {{-- <button class="btn " ><a href={{ route('addphoto') }}>add photos</a></button> --}}



                                <div class="card-body">

                                    <input type="text" value={{ Auth::user()->affiliate_id }} id="myInput">
                                    <button onclick="myFunction()" class="btn btn-primary">Copy code</button>


                                </div>
                                <div class="justify-content">

                                    <a class="btn btn-outline-dark" type="submit" href="{{ url('/transactions') }}">
                                        <i class="bi-wallet-fill me-1"></i>wallet
                                        @foreach ($wallet as $key => $value)
                                            @if (auth::id() == $value->user_id)
                                                <span
                                                    class="badge bg-dark text-white ms-1 rounded-pill">{{ $value->balance }}</span>
                                            @endif
                                        @endforeach

                                    </a>


                                    <a href={{ route('create.photo') }} class="btn btn-primary rounded-pill">add new
                                        post</a>
                                </div>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>&nbsp &nbsp&nbsp

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                                @endif
                            @endauth
                        @endif

                        </ul>

                    </div>
                </div>
            </nav>
            <!-- Header-->
            <header class="bg-dark py-5">
                <div class="container px-4 px-lg-5 my-5">
                    <div class="text-center text-white">
                        <h1 class="display-4 fw-bolder">Photo Gallery</h1>
                        <p class="lead fw-normal text-white-50 mb-0">upload photos and earn cash</p>
                    </div>
                </div>
            </header>
            <!-- Section-->
            <form action={{ route('search') }} method="get">
                {{ csrf_field() }}

                <div class="d-flex justify-content-center">
                    <div class="input-group mt-3" style="width: 50%">
                        <input type="text" class="form-control" name="search" placeholder="Search users"> <span
                            class="input-group-btn">
                            <button type="submit" class="btn btn-outline-success btn-default">
                                <span class="glyphicon glyphicon-search">submit</span>
                            </button>
                        </span>
                    </div>
                </div>
    </div>
    </form>
    <div class="d-flex d-flex justify-content-center">
        <h5>sort by :</h5>
        <a href="{{ url('/') }}?columname=price&sort=DESC" style="color:black"> High to low</a> |
        <a href="{{ url('/') }}?columname=price&sort=ASC" style="color:black">Low to high</a>|
        <a href="{{ url('/') }}?columname=title&sort=DESC">Z to A</a>|
        <a href="{{ url('/') }}?columname=title&sort=ASC">A to Z</a>

    </div>

    <section class="container py-5 d-flex " id="body">

        <div class="row g-3 mt-1  d-flex justify-content-around">


            @if (session('message'))
                <div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
                    <strong>{{ session('message') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @foreach ($posts as $key => $row)
                <div class="col-auto height d-flex">

                    <div class="col card">

                        <div class="d-flex">
                            <div class="col-auto mt-3">
                                <h5 class="main-heading mt-0"> Title : {{ $row->title }}</h5>
                                <div class="mt-3">
                                    <p class="text"> Tag : {{ $row->tags }}</p>
                                    <p class="text mb-0">Price : {{ $row->price }}</p>
                                    <div class="d-flex flex-row user-ratings">
                                        <div class="ratings">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            {{-- <i class="fa fa-star"></i> --}}
                                        </div>
                                        <h6 class="text-muted ml-1"> ratings: 4/5</h6>
                                    </div>
                                    <div class="image">
                                        <a href={{ route('show', $row->id) }}>
                                            <img src="{{ url('images/' . $row->imagename) }}" width="300px"
                                                height="200">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <p> owned by : {{ $row->user->name }}</p>
                        @foreach ($transactions as $key => $value)
                        @endforeach


                        @if (Route::has('login'))
                            @if ($value->user_id == Auth::id() && $value->user_id == $row->user->id)
                                <button class="btn btn-danger"><a href={{ route('download', $row->id) }}>
                                        download
                                    </a></button>
                            @elseif (!Route::has('login'))
                                <button class="btn btn-danger"><a href={{ route('login', $row->id) }}>
                                        add to cart
                                    </a></button>
                            @else
                                <button class="btn btn-danger"><a href={{ route('wallet', $row->id) }}> add to
                                        cart
                                    </a></button>
                            @endif
                        @endif








                    </div>

                </div>
            @endforeach
        </div>

    </section>
    <div class="d-flex justify-content-center">

        {{ $posts->appends(Request::except('page'))->links() }}
    </div>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; <span><a href="">molcature</a></span> 2023
            </p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    {{-- <script src="js/scripts.js"></script> --}}




    {{-- <button type="button" class="btn btn-outline-primary"><a href="{{ route('index') }}"> photos</a></button> --}}
    {{-- @if (session('message'))
            <div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
                <strong>{{ session('message') }}</strong>
            </div>
        @endif --}}
    {{-- <div class="row g-4 mt-1">
                <table>
                    @forelse($posts ?? '' as $key => $row)
                        <div class="col-lg-4">

                            <div class="card shadow">
                                <a href="/home/{{ $row->id }}">
                                    <img src="{{ asset('storage/public/public/images/' . $row->imagename) }}"
                                        class="card-img-top img-fluid">
                                </a>
                                <div class="card-body">
                                    <p class="btn btn-success rounded-pill btn-sm">{{ $row->tags }}</p>
                                    <div class="card-title fw-bold text-primary h4">{{ $row->title }}</div>
                                    <p class="text-secondary">{{ Str::limit($row->price, 100) }}</p>
                                </div>
                            </div>

                        </div>
                    @empty
                        <h2 class="text-center text-secondary p-4">No post found in the database!</h2>
                    @endforelse
                </table>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
                </nav>
                </form>
            </div> --}}
    {{-- {{ $posts ?? '' ?? ('')->onEachSide(5)->links() }} --}}


    </div>
    </div>
