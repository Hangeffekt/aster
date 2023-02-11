<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Scripts -->
    <script src="{{asset('js/jquery-3.5.1.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
	
    
    <!-- Styles -->
    <link href="/css/b_style.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
            @include("admin.menu")
            @if(Session::get('fail'))
                <div class="alert alert-danger">{{ Session::get('fail') }}</div>
            @endif
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Email</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $LoggedUserInfo->name }}</td>
                        <td>{{ $LoggedUserInfo->email }}</td>
                        <td><a href="logout">Log out</a></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</body>
</html>