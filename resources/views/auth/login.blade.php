<!DOCTYPE html>
<html lang="es">
<!-- <html lang="{{ app()->getLocale() }}"> -->

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset( '/img/apple-icon.png' ) }}">
    <link rel="icon" type="image/png" href="{{ asset('/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('/css/now-ui-dashboard.css?v=1.0.1')}}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('/demo/demo.css')}}" rel="stylesheet" />
    <style type="text/css">
        .positionCenter {
            top:50%;
            left: 50%;
            position: absolute;
            transform: translate(-50%,-50%); /*centrar en la mitad*/
            box-sizing: border-box;
            padding: 70px 30px;
        }

        .allCenter {

        }
    </style>
</head>

<body class="">
<!-- <div class="panel-header">
</div> -->
<div class="container">
    <div class="row">
        <div class="col-md-4 positionCenter">
            <div class="card">
                <!-- <div class="panel-heading">Login</div> -->
                <div class="card-header">
                    <h5 class="title text-center">Iniciar Sesión</h5>
                </div>

                <div class="card-body">
                    <form class="allCenter" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label for="email" class="col-md-5 control-label">Correo Electronico</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-6 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-md-12 pr-1">
                                <div class="form-group">
                                    <label for="password" class="col-md-5 control-label">Contraseña</label>
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
