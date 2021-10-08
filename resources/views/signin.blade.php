<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>Login</title>
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

            @if(\Route::getCurrentRoute()->getName() == 'admin.signin')
                <form method="POST" action="{{ route('admin.login') }}">
            @else    
                <form method="POST" action="{{ route('employee.login') }}">
            @endif
            @csrf
            <p>
                <label>Email: </label>
                <input type="email" name="email">
            <p>
                <label>Password: </label>
                <input type="password" name="password">
            </p>
            <button>Submit</button>
        </form>
    </body>
</html>