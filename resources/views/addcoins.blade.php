<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <body>
        @foreach ($posts as $key => $raw)
          <div class="row my-3">
              <div class="col-lg-8 mx-auto">
                <div class="card shadow">
                  <div class="card-header bg-primary">
                    <h3 class="text-light fw-bold">Edit Post</h3>
                  </div>
                  <div class="card-body p-4">
                    <form action="javascript:;" method="get" enctype="multipart/form-data">
                      @csrf
                      {{-- @method('PUT') --}}
                      <div class="my-2">
                        Add photo coins
                        <input type="text" name="add_photo_coin" id="title" class="form-control" placeholder="Title" value="{{ $raw->add_photo_coin }}" required>
                      </div>
                      <div class="my-2">
                        referral bonus
                        <input type="text" name="reference_coin" id="title" class="form-control" placeholder="Title" value="{{ $raw->reference_coin }}" required>
                      </div>
                      <div class="my-2">
                        <input type="submit" value="update amount" class="btn btn-primary">
                      </div>
                     
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
      </body>
</body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</html>