
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo e(config('app.name')); ?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo e(asset('admin_dashboard/assets/css/style.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('admin_dashboard/assets/css/components.css')); ?>">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <?php if(env('LOGO') != null): ?>
            <div class="login-brand">
              <img src="<?php echo e(asset(env('LOGO'))); ?>" alt="logo" width="100%">
            </div>
            <?php else: ?>
           <div class="card-title text-center">
                   <h2> <?php echo e(config('app.name')); ?></h2>
                </div>
            <?php endif; ?>

            <div class="card card-manual">
              <div class="card-header"><h4 style="color:<?php echo e(env('COLOUR_CODE')); ?>">Login</h4></div>

              <div class="card-body">
               <form class="form-horizontal" method="POST" action="<?php echo e(route('study-center.login.submit')); ?>" novalidate>
                            <?php echo csrf_field(); ?>

                  <div class="form-group">
                    <label for="email">Email</label>
                   <input id="email" type="email"  style=" border-color:<?php echo e(env('COLOUR_CODE')); ?>" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" tabindex="1" required="required" value="<?php echo e(old('email')); ?>" autofocus>
                     <small class="text-danger"><?php echo e($errors->first('email')); ?></small>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                      
                    </div>
                   <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password"  style=" border-color:<?php echo e(env('COLOUR_CODE')); ?>" tabindex="2" required>
                    <small class="text-danger"><?php echo e($errors->first('password')); ?></small>
                  </div>

                 

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                    <?php if(Route::has('password.request')): ?>
                    
                                <?php endif; ?>
                  </div>
                </form>
                

              </div>
            </div>
           
            <div class="simple-footer">
              Copyright &copy; 2019, <?php echo e(config('app.name')); ?>. All Rights Reserved.
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="<?php echo e(asset('admin_dashboard/assets/js/stisla.js')); ?>"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="<?php echo e(asset('admin_dashboard/assets/js/scripts.js')); ?>"></script>
  <script src="<?php echo e(asset('admin_dashboard/assets/js/custom.js')); ?>"></script>

   <script>
    $(document).ready(function() {

      $(".alert").fadeOut(3000);

    });
  </script>
  <!-- Page Specific JS File -->
</body>
</html>
<?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/auth/center-login.blade.php ENDPATH**/ ?>