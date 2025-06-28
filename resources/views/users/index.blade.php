@extends('layouts.app')

@section('title', 'User List')

@section('content')
  @if(session('success'))  

  @endif
  <div id="success-messages" style="display:none; text-align:center;color: green;"></div>
  <div id="error-messages" style="display:none; color: red;"></div>
  <table id="userData" class="table table-striped nowrap">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created Date</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
// Initial call

    @if(session('success'))
        $('#success-messages').show();
            $('#success-messages').html(session('message'));
            setTimeout(function () {
                $('#success-messages').hide(); // or .hide() for instant hide
            }, 3000);
    @endif
    fetchUsers();

    // Set interval to run every 5 minutes (300,000 milliseconds)
    setInterval(fetchUsers, 300000);
});

$(document).on('click','.btnDelete',function(){
    var id = $(this).data('userid');
    const url = '{{ route("users.destroy", ":id") }}'.replace(':id', id);

    if(confirm('Are you sure want to delete record ?'))
    {
        $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {

            $('#success-messages').show();
            $('#success-messages').html(response.message);
            setTimeout(function () {
                $('#success-messages').hide(); // or .hide() for instant hide
            }, 3000);
            fetchUsers();
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });

    }
});

$(document).on('click','.btnEdit',function(){
    var id = $(this).data('userid');
    const url = '{{ route("users.update", ":id") }}'.replace(':id', id);

    if(confirm('Are you sure want to edit record ?'))
    {
        $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {

            $('#success-messages').show();
            $('#success-messages').html(response.message);
            setTimeout(function () {
                $('#success-messages').hide(); // or .hide() for instant hide
            }, 3000);
            fetchUsers();
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });

    }
});

function fetchUsers() {
    const userEditUrl = "{{ route('users.update', ':id') }}";
    $.ajax({
        url: '{{ route("users.list") }}',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // console.log(response);
            let rows = '';
            if (response.data.length === 0) {
                rows = '<tr style="text-align:center"><td colspan="4">No records found</td></tr>';
            } else {
                response.data.forEach(function(user) {
                    rows += `
                        <tr>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.created_at}</td>
                            <td>
                                <a href="${userEditUrl.replace(':id', user.id)}" data-userid="${user.id}" class="btn btn-sm btn-primary btnEdit">Edit</a>
                                <a href="#" data-userid="${user.id}" class="btn btn-sm btn-danger btnDelete">Delete</a>
                            </td>
                        </tr>
                    `;
                });
            }
            $('#userData tbody').html(rows);
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
}
</script>

@endsection