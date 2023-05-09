<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>purchase page</title>
</head>

<body>
    <div class=" container-fluid my-5 ">
        <div class="row justify-content-center ">
            <div class="col-xl-10">
                <div class="card shadow-lg ">
                    <div class="row p-2 mt-3 justify-content-between mx-sm-2">
                        <div class="col">

                            <p class="text-muted space mb-0 shop">photo gallery</p>
                        </div>
                        <div class="col">
                            <div class="row justify-content-start ">
                                <div class="col">
                                    <img class="irc_mi img-fluid cursor-pointer " src="https://i.imgur.com/jFQo2lD.png"
                                        width="70" height="70">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <img class="irc_mi img-fluid bell" src="https://i.imgur.com/uSHMClk.jpg" width="30"
                                height="30">
                        </div>
                    </div>
                    <div class="row  mx-auto justify-content-center text-center">
                        <div class="col-12 mt-3 ">
                            <nav aria-label="breadcrumb" class="second ">
                                <ol class="breadcrumb indigo lighten-6 first  ">
                                    <li class="breadcrumb-item font-weight-bold "><a class="black-text text-uppercase "
                                            href={{ route('create') }}><span class="mr-md-3 mr-1">BACK TO
                                                home</span></a><i class="fa fa-angle-double-right "
                                            aria-hidden="true"></i></li>
                                    {{-- <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase" href={{  }}><span class="mr-md-3 mr-1">SHOPPING BAG</span></a><i class="fa fa-angle-double-right text-uppercase " aria-hidden="true"></i></li> --}}
                                    <li class="breadcrumb-item font-weight-bold"><a
                                            class="black-text text-uppercase active-2" href="#"><span
                                                class="mr-md-3 mr-1">CHECKOUT</span></a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="row justify-content-around">
                        <div class="col-md-5">
                            <div class="card border-0">
                                <div class="card-header pb-0">
                                    <h2 class="card-title space ">Checkout</h2>
                                    <p class="card-text text-muted mt-4  space">SHIPPING DETAILS</p>
                                    <hr class="my-0">
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-between">
                                        <div class="col-auto mt-0">
                                            <p><b>{{ Auth::user()->name }}</b></p>
                                        </div>
                                        <div class="col-auto">
                                            <p><b>{{ Auth::user()->email }}</b> </p>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col">
                                            <p class="text-muted mb-2">PAYMENT DETAILS</p>
                                            <hr class="mt-0">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="NAME" class="small text-muted mb-1">NAME ON CARD</label>
                                        <input type="text" class="form-control form-control-sm" name="NAME"
                                            id="NAME" aria-describedby="helpId" placeholder={{ auth::user()->name }}>
                                    </div>
                                    <div class="form-group">
                                        <label for="NAME" class="small text-muted mb-1">CARD NUMBER</label>
                                        <input type="text" class="form-control form-control-sm" name="NAME"
                                            id="NAME" aria-describedby="helpId" placeholder="4534 5555 5555 5555">
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-sm-6 pr-sm-2">
                                            <div class="form-group">
                                                <label for="NAME" class="small text-muted mb-1">VALID
                                                    THROUGH</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="NAME" id="NAME" aria-describedby="helpId"
                                                    placeholder="06/21">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="NAME" class="small text-muted mb-1">CVC CODE</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="NAME" id="NAME" aria-describedby="helpId"
                                                    placeholder="183">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-md-5">
                                        <div class="col">
                                            <button type="button" name="" id=""
                                                class="btn  btn-lg btn-block ">PURCHASE $37 SEK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card border-0 ">
                                <div class="card-header card-2">
                                    <p class="card-text text-muted mt-md-4  mb-2 space">YOUR ORDER <span
                                            class=" small text-muted ml-2 cursor-pointer">EDIT SHOPPING BAG</span> </p>
                                    <hr class="my-2">
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row  justify-content-between">
                                        <div class="col-auto col-md-7">
                                            <div class="media flex-column flex-sm-row">
                                                    @foreach ($posts as $key => $raw)
                                                    <img src="{{ url('images/' . $raw->imagename) }}" width="200"
                                                    height="200">
                                                    <div class="media-body  my-auto">
                                                        <div class="row ">
                                                            <div class="col-auto">
                                                                <p class="mb-0"><b>{{ $raw->price }}</b></p><small
                                                                    class="text-muted">life time  Subscription</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" pl-0 flex-sm-col col-auto  my-auto">
                                                <p class="boxed-1"></p>
                                            </div>
                                            <div class=" pl-0 flex-sm-col col-auto  my-auto ">
                                                <p><b>{{ $raw->title }}</b></p>
                                            </div>
                                             </div>
                                     
                                         <div class="row mb-5 mt-4 ">
                                            <div class="col-md-7 col-lg-6 mx-auto"><a href="{{ route('transaction',$raw->id) }}"
                                                    class="btn btn-block btn-outline-primary btn-lg">purchase </a></div>
                                        </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</html>
