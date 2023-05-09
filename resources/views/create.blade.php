{{-- @extends('adminlte::page') --}}
@extends('adminlte::page')
@section('css')
    <style>
        label.error {
            color: #dc3545;
            font-size: 14px;
        }
    </style>
@endsection





@section('content')



    <form action="javascript:;" method="POST" enctype="multipart/form-data" id="formSubmission">
        @csrf
        <table class="table table-bordered" id="dynamicTable">

            <tr>

                <th>Name</th>

                <th>tags (flower,animal.nature, others)</th>
                <th>image</th>
                <th>Price</th>


                <th>Action</th>

            </tr>

            <tr>

                <td><input type="text" name="image[0][title]" id="image[0][title]" placeholder="Enter your title"
                        class="form-control"><span class="text-danger error-text image[0][tag]_err"  id="image.0.title"></span></td>

                <td><input type="text" name="image[0][tag]" id="image[0][tag]" placeholder="Enter your tags"
                        class="form-control" /><span class="text-danger error-text image[0][tag]_err"  id="image.0.tag"></span></td>
                <td><input type="file" name="image[0][file]" id="file" id="image.0.file" class="imageClass"
                         class="form-control" /><span class="text-danger error-text image[0][tag]_err"  id="image.0.file"></span></td>

                <td><input type="text" name="image[0][price]" placeholder="Enter your Price" id="image.0.price"
                        class="form-control"/><span class="text-danger error-text image[0][tag]_err"  id="image.0.price"></span>
                </td>

                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>

            </tr>



        </table>



        <button type="submit" id="senddata" class="btn btn-success">Save</button>

    </form>

    </div>


@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $("#formSubmission").validate({
                rules: {
                    this: {
                        required: true,
                        maxlength: 20,
                    },
                }
            });
        });
    </script>
    <script type="text/javascript">
        var i = 0;



        $("#add").click(function() {
            console.log('jasghdjkahsda');

            ++i;

            $("#dynamicTable").append('<tr><td><input type="text" name="image[' + i +
                '][title]" placeholder="Enter your Name" class="form-control" /><span class="text-danger error-text image[0][tag]_err"  id="image.0.title"></span></td><td><input type="text" name="image[' +
                i +
                '][tag]" placeholder="Enter your Qty" class="form-control" /><span class="text-danger error-text image[0][tag]_err"  id="image.0.tag"></span></td><td><input type="file"  class="imageClass" name="image[' +
                i +
                '][file]"  class="form-control" /><span class="text-danger error-text image[0][file]_err"  id="image.0.file"></span></td><td><input type="text"  name="image[' +
                i +
                '][price]" placeholder="Enter your Price" class="form-control" /><span class="text-danger error-text image[0][tag]_err"  id="image.0.price"></span></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'
            );


        });



        $(document).on('click', '.remove-tr', function() {

            $(this).parents('tr').remove();

        });


        $('#formSubmission').submit(function(e) {
            e.preventDefault();




            // console.log(new FormData(this));
            // alert("asdasd");
            // for (let i = 0; i < $('#form').length; i++) {
            //     const element = array[i];

            // }
            // var data = $('#formSubmission').serializeArray();
            // var file = $(this).image[file];
            // data.append('file', file);

            // var files = $('#file')[0].files;
            // var formData = new FormData();

            // console.log($('.imageClass')[0].files[0])

            // var formData = new FormData($('#formSubmission')[0]);
            // console.log(formData)

            // for($i=0;$i<2;$i++){

            //     formData.append('tax_file', $('.imageClass')[$i].files[0]);
            // }

            var formData = new FormData(this);





            // formData.append('title', $('.imageClass')[0].files[0]);

            // formData.append('title',);

            // console.log(formData)

            // alert(1)
            // formData.append("image",$("#file")[0].files[0]);
            // console.log(formData)

            // Append data 
            // fd.append('file', files[0]);
            // fd.append('_token', CSRF_TOKEN);
            // var formData = new FormData();

            // var postData = new FormData($('form')[0]);
            // formData.append("document_file", $(".imageClass")[0].files[0]);
            // console.log('imageClass':$(".imageClass")[0].files[0]);

            // data.push({
            //     'imageClass': $(".imageClass")[0].files[0]
            // });

            // var inputData = new FormData($(this)[0]);
            // alert("sdfsd");
            // console.log(data);

            // var url = "/";

            $.ajax({

                type: "post",
                url: 'add-photo',
                async: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    window.location = "/";
                },
                error: function(errors) {
                    // for
                    // var error = data.error
                    // $("#dynamicTable").append();
                    // console.log(xhr);
                    console.log(errors);
                    // console.log(status);
                    // var err = JSON.parse(xhr.responseText);
                    // alert(err.Message);
                    if (errors.status === 422) {
                        var errors = $.parseJSON(errors.responseText);
                        $.each(errors.errors, function(index,value) {
                            // $('.error-text'+index).append(value);
                             console.log("input[id='"+index+"']");
                            //  var p = $('#'+index);
                            //  $('#image.0.title').attr('value','YOUR_VALUE');
                            // $("input[id='"+index+"']").text('<span class="text-danger">'+value+'</span>');

                            // $('.error-text').append('<span class="text-danger">'+value+'<span>'+'<br>');
                            // console.log(p);
                            $("span[id='"+index+"']").append(value);
                            // console.log(input);
                            // $(p+'<span class="text-danger">').text(value);
                            // $(input).
                            // $("name=" + index).closest('.form-group').addClass('has-error').append(
                            //     '<span class="help-block"><strong>' + value +
                            //     '</strong></span>');

                            // console.log(errors.errors['image.0.file']);

                            // $.each(errors, function(key, message) {
                            // var input = '#formSubmission input name=' + index ;
                            // // $(input + '<span>strong').text(value);
                            // $(input).parent().parent().addClass('has-error');
                            // $(".error-text", { text: errors[this.id] }).append("#formSubmission");

                            //     $('.errorMsgntainer').append('<span class="text-danger">'+message+'<span>'+'<br>');
                            // });
                        });
                    };
                }

                





            });
            
        });
    </script>
@endsection
@endsection
