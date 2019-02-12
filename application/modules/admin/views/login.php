<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= $theme_url ?>css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title><?= isset($page_title) ? $page_title : "Untitled Webpage" ?></title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1><?= isset($page_title) ? $page_title : "Untitled Webpage" ?></h1>
      </div>
      <div class="login-box">
        <form class="login-form" method="post" action="<?= base_url('admin/run') ?>">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
          <?= validation_errors('<p style="color: red;">', '</p>') ?>
          <?= $alert; ?>
          <div class="form-group">
            <label class="control-label">USERNAME</label>
            <input class="form-control" type="text" name="username" placeholder="Username" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label>
                  <input type="checkbox" name="remember"><span class="label-text">Stay Signed in</span>
                </label>
              </div>
              
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        </form>
        
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="<?= $theme_url ?>js/jquery-3.2.1.min.js"></script>
    <script src="<?= $theme_url ?>js/popper.min.js"></script>
    <script src="<?= $theme_url ?>js/bootstrap.min.js"></script>
    <script src="<?= $theme_url ?>js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= $theme_url ?>js/plugins/pace.min.js"></script>
    
  </body>
</html>