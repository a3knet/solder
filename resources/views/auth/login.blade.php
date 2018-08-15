<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Solder - Login</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- @TODO really needed? -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app" class="card text-center text-white bg-primary full-height">
        <div class="card-body pt-0">
            <div class="row d-flex align-items-center h-100">
                <div class="col-lg-2 offset-lg-5 col-md-4 offset-md-4">
            <form method="post" action="{{ route('auth.login') }}" class="">
            <figure class="figure brand-image">
                    <svg class="figure-img img-fluid" viewBox="0 0 100 100" fill="whitesmoke">
                        <path d="M50.3,1.2C23.6,1.2,1.9,22.9,1.9,49.7c0,26.7,21.7,48.4,48.4,48.4c26.7,0,48.4-21.7,48.4-48.4
          C98.7,22.9,77.1,1.2,50.3,1.2z M50.3,88.2c-21.3,0-38.5-17.3-38.5-38.5c0-21.3,17.3-38.5,38.5-38.5c21.3,0,38.5,17.3,38.5,38.5
          C88.9,70.9,71.6,88.2,50.3,88.2z"></path>
                        <path d="M62.9,90.7l0.5-45.2l1.3-0.5l0.5-1.7l-14.8-3.7l-0.7,2.4c-0.8,0-2,0-3.4,0c0-6.6,0-12.3,0-12.3l0.6-0.7
          h18.8v-3.6c0,0-6.4-8.5-18-8.5c-12,0-11.8,8.8-11.8,9.7c0,0,0,6.7,0,15.3c-1.5,0-4.4,1.1-4.4,5.2c0,3.8,2,4.8,1.7,8.4
          c-0.4,4.2,0.8,4.9,2.7,5.4c0,0.9,0,1.6,0,2.5h-2.2v7.1h2.2c0,4.9,0,6.7,0,7.2c0,3.4,1.4,5.4,5,5.4c3.7,0,4.9-1.8,4.9-5.5
          c0-0.3,0,0.2,0-0.8c1.4,0,4,1.6,4,3.9l0,1.8c0,3.5,0,4.6,0.1,8.2H62.9z M49.8,61.1c0,3.6,0,7.5,0.1,11.6h-4c0-0.7,0-1.4,0-2.2h2
          v-7.1h-2c0-0.8,0-1.5,0-2.3C47.1,61.1,48.8,61.1,49.8,61.1z"></path>
                    </svg>
                </figure>

                        <h1>
                            Solder
                        </h1>
            
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        These credentials do not match our records.
                    </div>
                @endif

                
                    {{ csrf_field() }}

                    <label for="inputEmail" class="sr-only">Email Address</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="icon input-group-text bg-white border-right-0">
                                <i class="fa fa-envelope-o"></i>
                            </span>
                        </div>
                        <input type="email" id="inputEmail" class="form-control border-left-0" placeholder="Email Address" name="email" value="{{ old('email') }}" required autofocus>
                    </div>                        
                
                    <label for="inputPassword" class="sr-only">Password</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="icon input-group-text bg-white border-right-0">
                                <i class="fa fa-unlock"></i>
                            </span>
                        </div>
                        <input id="inputPassword" class="form-control border-left-0" type="password" placeholder="password" name="password" required>
                    </div>
                        
                    <button class="btn btn-outline-light btn-lg btn-primary btn-block" type="submit">Log in</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @stack('afterScripts')

</body>
</html>
