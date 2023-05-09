<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    @foreach ($posts as $key => $raw)
        <div class="row my-4">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow">
                    <img src={{ url('/images/' . $raw->imagename) }} class="img-fluid card-img-top">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="btn btn-dark rounded-pill">{{ $raw->price }}</p>
                            <p class="lead">{{ \Carbon\Carbon::parse($raw->created_at)->diffForHumans() }}</p>
                        </div>

                        <hr>
                        <h3 class="fw-bold text-primary">{{ $raw->title }}</h3>
                        <p>{{ $raw->tags }}</p>
                    </div>
                    <div class="card-footer px-5 py-3 d-flex justify-content-end">
                        @if (Route::has('login'))
                            @auth
                                <a href={{ route('edit', $raw->id) }} class="btn btn-success rounded-pill me-2">Edit</a>
                                <form action="delete/{{ $raw->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger rounded-pill">Delete</button>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>&nbsp&nbsp&nbsp&nbsp

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                                    @endif
                                @endauth
                                @endif
                            </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</html>
