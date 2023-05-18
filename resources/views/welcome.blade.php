@extends('photogallery.master')


  


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
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
            <!-- Core theme CSS (includes Bootstrap)-->
            <link href="css/styles.css" rel="stylesheet" />
            <style>
                :root,
                :root.light {
                    --color-bg: #ffffff;
                    --color-fg: #000000;
                    --card-bg-color: #fafafa;
                }

                :root.dark {
                    --color-bg: #263238;
                    --color-fg: #ffffff;
                    --card-bg-color: #607d8b;
                }

                body {
                    background-color: var(--color-bg);
                    color: var(--color-fg);
                }

                #theme {
                    background-color: var(--card-bg-color) !important;
                }
            </style>
        </head>

        <body id="theme">

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

            <div class="form-switch text-center my-5">
                <input type="checkbox" id="mode" class="form-check-input">change theme
                <label for="mode" class="form-check-label" ></label>
              </div>
            <div class="d-flex justify-content-center">

                @auth
                    @if (Auth::user()->user_type == 1)
                        <h3 class="d-flex justify-content-center mt-2 mb-2">Welcome Admin</h3>
                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <a class="btn btn-success mt-2" href={{ route('index') }}>
                            <h4> click here to go dashboard </h3>
                        </a>
                    @endif
                @endauth
            </div>
            <form action={{ route('search') }} method="get" loading="lazy">
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


    <section class="container py-5 d-flex " id="body" loading="lazy">
        <div class="row g-3 mt-1  d-flex justify-content-around" id="toster">


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

                                        </div>
                                        <h6 class="text-muted ml-1"> ratings: 4/5</h6>
                                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

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
                        <h6 class="text-muted ml-1">created at:
                            {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</h6>
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
    <div class="social-btn-sp d-flex justify-content-center">
        share our page
        {!! $shareButtons1 !!}
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/share.js') }}"></script>

    <script>
        const modeBtn = document.getElementById('mode');
        modeBtn.onchange = (e) => {
            if (modeBtn.checked === true) {
                document.documentElement.classList.remove("light")
                document.documentElement.classList.add("dark")
                window.localStorage.setItem('mode', 'dark');
            } else {
                document.documentElement.classList.remove("dark")
                document.documentElement.classList.add("light")
                window.localStorage.setItem('mode', 'light');
            }
        }

        const mode = window.localStorage.getItem('mode');
        if (mode == 'dark') {
            modeBtn.checked = true;
            document.documentElement.classList.remove("light")
            document.documentElement.classList.add("dark")
        }

        if (mode == 'light') {
            modeBtn.checked = false;
            document.documentElement.classList.remove("dark")
            document.documentElement.classList.add("light")
        }
    </script>
    </div>
    </div>
