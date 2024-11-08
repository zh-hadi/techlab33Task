@extends('layouts.MainLayout')

@section('content')
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand">Image Crud with SPA</a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add Image
                </button>
            </div>
        </nav>

        <section class="image_galary">
            <div class="row mb-5 mb-5 ">
                @foreach ($images as $image)
                    <div class="rounded col image position-relative mb-5">
                        <div class="z-0 " sytel="width: 300px">
                            <img class="" style="width: 300px" src=" {{ asset( "storage/".$image->image)}}" alt="" srcset="">
                        </div>
                        <div class="show visually-hidden  position-absolute top-0   h-100 z-n2 view_info" style="width: 300px">
                            <div class="text-white p-5 h-100 d-flex flex-column justify-content-between align-items-center">
                                <div>
                                    create at
                                </div>
                                <div>
                                    <button type="button" class="btn border text-white showImage" idValue="{{ $image->id }}" href="{{ route('image.show', $image->id ) }}">
                                        View
                                    </button>
                                </div>
                                <div class="w-100 d-flex justify-content-between">
                                    <button type="button" class="btn btn-primary editModal" idValue="{{ $image->id }}" href="{{ route('image.show', $image->id ) }}">
                                        Edit
                                    </button>

                                    <form id="deleteImage" action="{{ route('image.destroy', $image->id ) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-primary">Delete</button>
                                    </form>
                                </div>
                            </div>
                   
                        </div>
                    </div>
                @endforeach

            </div>
            
        </section>

        <!-- Modal  add image -->
        <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload image with Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            <form action="{{ route('image.store') }}" id="formSubmit" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="imagetitle" class="form-label">Image Title</label>
                    <input type="text" name='title' class="form-control" id="imagetitle" >
                    <small id="error_title" class="text-danger"></small>
                </div>
                <div class="mb-3">
                    <label for="imagefile" class="form-label">Chose image</label>
                    <input type="file" name="image" class="form-control" id="imagefile">
                    <small id="error_image" class="text-danger"></small>
                </div>
                <div class="d-flex mt-5 justify-content-between">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>


            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
            </div>
        </div>
        </div>

        <!-- Modal update image -->

        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload image with Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            <form  id="formUpdate" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="updateImage" class="form-label">Image Title</label>
                    <input type="text" name='title' class="form-control" id="updateImageTitle"  >
                    <small id="up_error_title" class="text-danger"></small>
                </div>
                <div class="mb-3">
                    <label for="imagefile" class="form-label">Chose image</label>
                    <input type="file" name="image" class="form-control" id="imagefile">
                    <small id="up_error_image" class="text-danger"></small>
                </div>
                <div class="d-flex mt-5 justify-content-between">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>


            </div>
                </div>
            </div>
        </div>

        <!-- model show image -->

<!-- Modal -->
<div class="modal fade" id="showImage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div>
  
            <img id="img_id" src="" alt="" width="400" height="400">
        </div>
      </div>
    </div>
  </div>
</div>

        <script>
            $(document).ready(function(){

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "3000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                    };

               
                $(document).on('mouseenter', '.image', function(){
                    let el = this.children[1];
                    $(el).removeClass('visually-hidden');
                    $(el).fadeIn();
                    
                }).on('mouseleave', '.image', function(){
                    let el = this.children[1];
                    $(el).addClass('visually-hidden');
                });

                $(document).on('submit', '#formSubmit', function(e){
                    e.preventDefault();

                    $('#error_title').hide();
                    $('#error_image').hide();

                    let formData = new FormData(this);

                    console.log(formData);
                    let url = $(this).attr('action');

                    $.ajax({
                        type: "POST",
                        url: url,
                        data:formData,
                        processData:false,
                        contentType: false,
                        success: function(res){
                            if(res.status == 400){
                                for(let error in res.errors){
                                    let id = '#error_'+error;
                                    $(id).text(res.errors[error][0]);
                                    $(id).show();
                                }
                            }
                            if(res.status == 200){
                                console.log(res);
                                $('#exampleModal').modal('hide');
                                $('.image_galary').load(location.href+' .image_galary');
                                toastr.success(res.message);

                            }
                        }
                    });
                });

                // update image
                $('.editModal').on('click', function(){
                    $('#updateModal').modal('show');
                    let url = $(this).attr('href');
                    
                    
                    $.ajax({
                        type: "get",
                        url: url,
                        success: function(res){
                            console.log(res.image)
                            $('#updateImageTitle').val(res.image.title);
                            $('#formUpdate').attr('image_id', res.image.id);
                            console.log(res.image.title);
                        }
                    });
                });

                $('.showImage').on('click', function(){
                    $('#showImage').modal('show');
                    let url = $(this).attr('href');
                    
                    
                    $.ajax({
                        type: "get",
                        url: url,
                        success: function(res){
                            console.log(res.image)
                            $('#img_id').attr('src', 'http://localhost:8000/storage/'+res.image.image);
                        }
                    });
                });

                $(document).on('submit', '#formUpdate', function(e){
                    e.preventDefault();

                    $('#up_error_title').hide();
                    $('#up_error_image').hide();

                    let id = $(this).attr('image_id');

                    let url = "http://localhost:8000/image/"+id;

                    let formData = new FormData(this);

              
                    console.log(formData);

                    $.ajax({
                        type: "POST",
                        url: url,
                        data:formData,
                        processData:false,
                        contentType: false,
                        success: function(res){
                            if(res.status == 400){
                                for(let error in res.errors){
                                    let id = '#up_error_'+error;
                                    $(id).text(res.errors[error][0]);
                                    $(id).show();
                                }
                            }
                            if(res.status == 200){
                                console.log(res);
                                $('#updateModal').modal('hide');
                                $('.image_galary').load(location.href+' .image_galary');
                                toastr.success(res.message);

                            }
                        }
                    });
                });
                

                //  delete image ajax method
                $(document).on('submit', '#deleteImage', function(e){
                    e.preventDefault();

                    let url = $(this).attr('action');
                    let formData = new FormData(this);

                    $.ajax({
                        type: "POST",
                        url: url,
                        data:formData,
                        processData:false,
                        contentType: false,
                        success: function(res){
                            $('.image_galary').load(location.href+' .image_galary');
                             toastr.success(res.message);
                        }
                    });

                })
            
            });
            
        </script>
@endsection