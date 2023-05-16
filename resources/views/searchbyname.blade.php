<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    {{-- <script src="https://unpkg.com/ag-grid-community@26.2.1/dist/ag-grid-community.min.nostyle.js"></script> --}}
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community@26.2.1/dist/styles/ag-grid.css">
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community@26.2.1/dist/styles/ag-theme-alpine.css">
    {{-- <link rel="stylesheet" type="text/css" href="css/style.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{-- <script src="https://cdn.freecodecamp.org/testable-projects-fcc/v1/bundle.js"></script> --}}
    {{-- <script src="js/script.js" type="text/javascript"></script> --}}


</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Start uploading </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
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
                            <form id="logout-form" action={{ route('logout') }} method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                        {{-- <button class="btn " ><a href={{ route('addphoto') }}>add photos</a></button> --}}



                        <div class="card-body">

                            <input type="text" value={{ Auth::user()->affiliate_id }} id="myInput">
                            <button onclick="myFunction()" class="btn btn-primary">Copy code</button>


                        </div>
                        <div class="justify-content">

                            <button class="btn btn-outline-dark" type="submit">
                                <i class="bi-wallet-fill me-1"></i>wallet
                                @foreach ($wallet as $key => $value)
                                    @if (auth::id() == $value->user_id)
                                        <span
                                            class="badge bg-dark text-white ms-1 rounded-pill">{{ $value->balance }}</span>
                                    @endif
                                @endforeach

                            </button>
                            </form>

                            <a href={{ route('create.photo') }} class="btn btn-primary rounded-pill">add new
                                post</a>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

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

    </div>
    <div class="mt-3 d-flex justify-content-center">

        <a class="btn btn-small btn-success" href={{ route('welcome.guest') }}>click here to go to view all </a>
    </div>

    <section class="container py-5 d-flex " id="body">

        <div class="row g-3 mt-1  d-flex justify-content-around">

            <div class="d-flex d-flex justify-content-center">
                <h5>sort by :</h5>
                <a href="{{ url('/') }}?columname=price&sort=DESC" style="color:black"> High to low</a> |
                <a href="{{ url('/') }}?columname=price&sort=ASC" style="color:black">Low to high</a>|
                <a href="{{ url('/') }}?columname=title&sort=DESC">Z to A</a>|
                <a href="{{ url('/') }}?columname=title&sort=ASC">A to Z</a>

            </div>
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
                     

                        <button class="btn btn-danger"><a href={{ route('login') }}> add to cart
                            </a></button>
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
            <p class="m-0 text-center text-white">Copyright &copy; <span><a href="">molcature</a></span> 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->



    </div>
    </div>
</body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
{{-- <script>
$('#search1').on('click', function() {
$value = $('#search').val();
console.log($value);
$.ajax({
    type: 'get',
    url: 'search',
    data: {
        'search': $value
    },
    success: function(data) {
        console.log(data);
        for(var i=0;i<data.length;i++){
            $('#body').html(data[i]);
        }
    }
});
})
</script> --}}



<script>
    function myFunction() {
        // Get the text field
        var copyText = document.getElementById("myInput");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);
    }
</script>
<script>
    var msg = '{{ Session::get('alert') }}';
    var exist = '{{ Session::has('alert') }}';
    if (exist) {
        alert(msg);
    }
</script>


</html>
