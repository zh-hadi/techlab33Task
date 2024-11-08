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

        
    });
</script>