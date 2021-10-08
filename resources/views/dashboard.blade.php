<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <title>Dashboard</title>
    </head>
    <body>

    @if($errors->any())
       {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif

    @if ($message = Session::get('message'))

        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>

    @endif


    @if ($message = Session::get('error'))

        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
            <strong>{{ $message }}</strong>
        </div>

    @endif 
    
    @if($user && $user->user_type == 'admin')
        <div class="container">
            <p>
                Welcome to Admin dashboard!
            </p>
            <a href="javascript:void(0)" class="btn btn-info ml-3" id="add-employee">Add Employee</a>
            <br><br>

            <table class="table table-bordered table-striped" id="datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Designation</th>
                        <th>Salary</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

            <div class="modal fade" id="employee-crud" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="employeeCrudModal"></h4>                           
                        </div>
                        <div class="modal-body">
                        <div class="alert-danger" id="error-mess"></div>
                            <form id="employeeForm" name="employeeForm" class="form-horizontal">
                                <input type="hidden" name="employee_id" id="employee_id">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="name" name="name" value="" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="email" name="email" value="" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Mobile Number</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="mobile_number" name="mobile_number" value="" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Designation</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="designation" name="designation" value="" required="">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Salary</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" id="salary" name="salary" value="" required="">
                                    </div>
                                </div>

                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save
                                    </button>
                                </div>
                            </form>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    @else 
        <p>
            Welcome to Employee dashboard!
        </p>
    @endif
    </body>
</html>
<script>
$(document).ready( function () {
   $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
 
$('#datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
        url: "{{ route('dtable-employees.index') }}",
        type: 'GET',
    },
    columns: [
        { data: 'id', name: 'id', 'visible': false},
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'mobile_number', name: 'mobile_number' },
        { data: 'designation', name: 'designation' },
        { data: 'salary', name: 'salary' },
        {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
});
 
$('#add-employee').click(function () {
    $('#btn-save').val("create-employee");
    $('#employee_id').val('');
    $('#employeeForm').trigger("reset");
    $('#employeeCrudModal').html("Add Employee");
    $('#employee-crud').modal('show');
});
 
   
$('body').on('click', '.edit-emp', function () {
    var emp_id = $(this).data('id');
    $.get('dtable-employees/'+emp_id+'/edit', function (data) {
       
        // $('#name-error').hide();
        // $('#email-error').hide();
        $('#employeeCrudModal').html("Edit Employee");
        $('#btn-save').val("edit-emp");
        $('#employee-crud').modal('show');
        $('#employee_id').val(data.id);
        $('#name').val(data.name);
        $('#email').val(data.email);
        $('#mobile_number').val(data.mobile_number);
        $('#designation').val(data.designation);
        $('#salary').val(data.salary);
    })
});
    
$('body').on('click', '#delete-emp', function () {
    var employee_id = $(this).data("id");
    confirm("Are You sure want to delete !");
        $.ajax({
            type: "get",
            url: "dtable-employees/destroy/"+employee_id,
            success: function (data) {
            var oTable = $('#datatable').dataTable(); 
            oTable.fnDraw(false);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });   
});
 
if ($("#employeeForm").length > 0) {
    $("#employeeForm").validate({
        submitHandler: function(form) {
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Sending..');
        
            $.ajax({
                data: $('#employeeForm').serialize(),
                url: "{{ route('dtable-employees.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    console.log("data::", data);

                    if(data.status == 'error'){
                        var error_messages = data.messages;
                        $.each(error_messages, function(key,val){
                            // console.log("key : "+key+" ; value : "+val);
                            $('#error-mess').html(val);
                        });
                        return false;
                    }
                    $('#employeeForm').trigger("reset");
                    $('#employee-crud').modal('hide');
                    $('#btn-save').html('Save Changes');
                    var oTable = $('#datatable').dataTable();
                    oTable.fnDraw(false);
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#btn-save').html('Save Changes');
                }
            });
        }
    })
}
</script>