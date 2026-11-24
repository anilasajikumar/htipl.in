<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800&display=swap" rel="stylesheet">
<link rel="icon" href="<?php echo e(asset('web_dashboard/images/favicon.png')); ?>" type="image/x-icon" />

<!--tittle -->
<title><?php echo e(config('app.name')); ?></title>

<!--style CSS -->
<link href="<?php echo e(asset('web_dashboard/css/style.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('web_dashboard/css/responsive.css')); ?>" rel="stylesheet">
</head>
<body>
  <div class="login-area">
    <form class="form-login form-horizontal" method="POST" action="<?php echo e(route('student.login.submit')); ?>" novalidate>
      <?php echo csrf_field(); ?>
      <img src="<?php echo e(asset('web_dashboard/images/logo.svg')); ?>" class="img-fluid mb-5" alt="Responsive image">
      <label for="inputEmail" class="sr-only">Register Number</label>
      <input type="text" name="register_number" class="form-control <?php echo e($errors->has('register_number') ? ' is-invalid' : ''); ?>" placeholder="Register Number" required="" autofocus="">
      <small class="text-danger"><?php echo e($errors->first('email')); ?></small>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="password" class="form-control <?php echo e($errors->has('Password') ? ' is-invalid' : ''); ?>" placeholder="Password" required="">
      <small class="text-danger"><?php echo e($errors->first('password')); ?></small>
      <!-- <div class="checkbox mb-3 mt-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div> -->
      <br>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
     <!--  <p class="mt-5 mb-3 text-muted ">&copy All right Reversed.<a class="text-green ml-2" href="#" target="_blank">ICRQ</a></p> -->
    </form>
  </div>
</body>



<!-- jQuery v3.3.1 --> 
<script src="<?php echo e(asset('web_dashboard/js/jquery-3.3.1.min.js')); ?>"></script> 
<script src="<?php echo e(asset('web_dashboard/js/bootstrap.min.js')); ?>"></script> 
<!-- Theme js / Custom js --> 
<script src="<?php echo e(asset('web_dashboard/js/theme.js')); ?>"></script>

<script>
    $(document).ready(function() {

      $(".alert").fadeOut(3000);

    });
</script>
</html><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/auth/student-login.blade.php ENDPATH**/ ?>