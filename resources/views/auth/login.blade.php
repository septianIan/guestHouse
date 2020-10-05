<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Login</title>
   <!-- Font Awesome Icons -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
   <!-- overlayScrollbars -->
   <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
   <!-- Theme style -->
   <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
   <!-- Google Font: Source Sans Pro -->
   <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
   <style>
        body {
        background: #f2f2f2;
        text-align: center;
        background-size:cover;
        background-attachment: fixed;
       
        }

.hero {
    background:
    linear-gradient(to right, rgba(75, 123, 211, 0.5), rgba(22, 215, 177, 0.3)),    url('{{ asset('assets/img/bg2.jpg') }}');
    
    width: 100vw;
    height: 100vh;
    background-size: cover;
    opacity:0.9;
    
}
   </style>
</head>
<body class="hold-transition login-page bg hero">
   <div class="login-box">
      
      <!-- /.login-logo -->
      <div class="card">
      <div class="login-logo mt-3" style="color:blck;">
         <strong>Login System</strong>
      </div>
         <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form method="post" action="{{ route('login') }}">
            @csrf
               <div class="input-group mb-3">
                  <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="on">
                  <div class="input-group-append">
                     <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                     </div>
                  </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
               </div>
               <div class="input-group mb-3">
                  <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" value="{{ old('password') }}">
                  <div class="input-group-append">
                     <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                     </div>
                  </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
               </div>
               <div class="row">
                  <div class="col-8">
                     <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                           Remember Me
                        </label>
                     </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-4">
                     <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                  </div>
                  <!-- /.col -->
               </div>
            </form>
         </div>
         <!-- /.login-card-body -->
      </div>
   </div>
   <!-- /.login-box -->
   <!-- REQUIRED SCRIPTS -->
   <!-- jQuery -->
   <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
   <!-- Bootstrap -->
   <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <!-- overlayScrollbars -->
   <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
   <!-- AdminLTE App -->
   <script src="{{ asset('assets/js/adminlte.js') }}"></script>

   <!-- ChartJS -->
   <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
</body>
</html>
