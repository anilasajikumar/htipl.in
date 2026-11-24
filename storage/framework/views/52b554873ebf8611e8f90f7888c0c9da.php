<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo e(config('app.name')); ?> | Admin Login</title>
  <link rel="icon" href="<?php echo e(asset('admin_dashboard/assets/img/favicon.ico')); ?>" type="image/x-icon">

  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">

  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    body { font-family: 'Source Sans 3', 'Source Sans Pro', sans-serif; }
    .login-page { background: linear-gradient(135deg, #1a2a4a 0%, #2c3e6b 60%, #3d5a8a 100%); }
    .login-box { width: 380px; }
    .login-logo a { color: #fff; font-size: 1.8rem; font-weight: 700; letter-spacing: 1px; }
    .login-logo small { display: block; font-size: 0.85rem; font-weight: 300; color: rgba(255,255,255,0.75); letter-spacing: 2px; text-transform: uppercase; }
    .login-card-body { border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.25); }
    .login-card-body .input-group .form-control { border-left: none; }
    .login-card-body .input-group-text { background: #fff; border-right: none; color: #aaa; }
    .btn-primary { background: #3d5a8a; border-color: #3d5a8a; font-weight: 600; letter-spacing: .5px; }
    .btn-primary:hover { background: #2c3e6b; border-color: #2c3e6b; }
    .login-footer { color: rgba(255,255,255,0.55); font-size: 0.8rem; margin-top: 1.5rem; text-align: center; }
  </style>
</head>

<body class="hold-transition login-page">
<div class="login-box">

  
  <div class="login-logo mb-1">
    <?php if(env('LOGO') != null): ?>
      <img src="<?php echo e(asset(env('LOGO'))); ?>" alt="<?php echo e(config('app.name')); ?>" style="max-width:180px;">
    <?php else: ?>
      <a href="#">
        <i class="fas fa-graduation-cap mr-2"></i><?php echo e(config('app.name')); ?>

        <small>Admin Portal</small>
      </a>
    <?php endif; ?>
  </div>

  
  <div class="card login-card-body">
    <div class="card-body">

      <p class="login-box-msg" style="font-size:1rem;font-weight:600;color:#333;">Sign in to start your session</p>

      <?php if(session('status')): ?>
        <div class="alert alert-success"><?php echo e(session('status')); ?></div>
      <?php endif; ?>

      <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>

        
        <div class="input-group mb-3">
          <input type="email"
                 name="email"
                 value="<?php echo e(old('email')); ?>"
                 class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>"
                 placeholder="Email address"
                 autofocus required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
          <?php if($errors->has('email')): ?>
            <span class="invalid-feedback"><?php echo e($errors->first('email')); ?></span>
          <?php endif; ?>
        </div>

        
        <div class="input-group mb-3">
          <input type="password"
                 name="password"
                 id="password"
                 class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>"
                 placeholder="Password"
                 required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
          <?php if($errors->has('password')): ?>
            <span class="invalid-feedback"><?php echo e($errors->first('password')); ?></span>
          <?php endif; ?>
        </div>

        
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">
              <i class="fas fa-sign-in-alt mr-1"></i> Sign In
            </button>
          </div>
        </div>

        <?php if(Route::has('password.request')): ?>
          <div class="text-center mt-3">
            <a href="<?php echo e(route('password.request')); ?>" class="text-muted" style="font-size:0.85rem;">
              <i class="fas fa-key mr-1"></i>Forgot your password?
            </a>
          </div>
        <?php endif; ?>

      </form>
    </div>
  </div>

  <div class="login-footer">
    Copyright &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All Rights Reserved.
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
  $(document).ready(function() { $(".alert").fadeOut(4000); });
</script>
</body>
</html>
<?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>