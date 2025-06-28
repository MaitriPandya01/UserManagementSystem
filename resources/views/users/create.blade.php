@extends('layouts.app')

@if(isset($data))
    @section('title', 'Edit User')
@else
    @section('title', 'Add User')
@endif

@section('content')
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">{{isset($data)?'Edit':'Add'}} User</h2>
              <div id="responseMsg" style="text-align:center;display:none; color: red;"></div>
              <div id="error-messages" style="display:none; color: red;"></div>
              <form id="userForm">
                @csrf
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" name="name" id="form3Example1cg" class="form-control form-control-lg" value='{{$data->name??""}}' />
                  <label class="form-label" for="form3Example1cg">Name</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="email" name="email" value='{{$data->email??""}}' id="form3Example3cg" class="form-control form-control-lg" />
                  <label class="form-label" for="form3Example3cg">Email</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" name="password" id="form3Example4cg" class="form-control form-control-lg" />
                  <label class="form-label" for="form3Example4cg">Password</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" name="password_confirmation" id="form3Example4cdg" class="form-control form-control-lg" />
                  <label class="form-label" for="form3Example4cdg">Repeat your password</label>
                </div>

                <div class="d-flex justify-content-center">
                  <button  type="submit" data-mdb-button-init
                    data-mdb-ripple-init class="btn btn-success btn-block btn-lg gradient-custom-4 text-body data-update">{{isset($data)?"Update":"Register"}}</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>
$(document).ready(function () {
    $('#userForm').on('submit', function (e) {
        e.preventDefault();

        @if(isset($data))
            const url = "{{ route('users.edit', $data->id) }}";
        @else
            const url = "{{ route('users.store') }}";
        @endif
        $.ajax({
            url: url, // Adjust route
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                
                    $('#responseMsg').show();
                    
                    if (response.redirect) {
                        $('.data-update').css('filter', 'blur(2px)');
                        $('#responseMsg').html('<p style="color:green;">User updated successfully!</p>');
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 3000);
                        
                    }else{

                        $('#responseMsg').html('<p style="color:green;">User saved successfully!</p>');
                        setTimeout(function () {
                            $('#responseMsg').hide();
                        },3000);
                    
                        $('#userForm')[0].reset();
                    }
                    $('#error-messages').html('').hide();
                
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMsg = '<ul style="color:red;">';
                $.each(errors, function (key, value) {
                    errorMsg += '<li>' + value[0] + '</li>';
                });
                errorMsg += '</ul>';
                $('#error-messages').html(errorMsg).show();
            }
        });
    });
});
</script>
@endsection