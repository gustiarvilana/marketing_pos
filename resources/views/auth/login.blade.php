<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset("assets") }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset("assets") }}/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Silahkan Login</h1>
                                    </div>
                                    <form class="user" action="{{ route("login") }}" method="post">
                                        @csrf
                                        <div class="form-group has-feedback @error('username') has-error @enderror">
                                            @error('username')
                                            <span class="help-block">Email atau Password Salah</span>
                                            @enderror
                                            <input type="username" name="username" class="form-control form-control-user"
                                                placeholder="Enter username...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                placeholder="Password">
                                        </div>
                                        <div class="col-xs-4">
                                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                        </div>
                                        
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- box password --}}
                     <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">User dan Pasword</h1>
                                        </div>
                                        
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Username</th>
                                                    <th>Password</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>tm1</td>
                                                    <td>tm1</td>
                                                </tr>
                                                <tr>
                                                    <td>tm2</td>
                                                    <td>tm2</td>
                                                </tr>
                                                <tr>
                                                    <td>tm3</td>
                                                    <td>tm3</td>
                                                </tr>
                                                <tr>
                                                    <td>gtm1</td>
                                                    <td>gtm1</td>
                                                </tr>
                                                <tr>
                                                    <td>kdiv</td>
                                                    <td>kdiv</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- box password --}}

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset("assets") }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset("assets") }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset("assets") }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset("assets") }}/js/sb-admin-2.min.js"></script>

</body>

</html>