<!DOCTYPE html>
<html lang="en">

<head>
  <title>CRMdopa</title>
  <meta charset="UTF-8">
  <meta name="baseUrl" content='<?php echo base_url(); ?>'>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="<?php echo $this->config->item('assets_login'); ?>images/icons/favicon.ico" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_login'); ?>vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_login'); ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_login'); ?>fonts/iconic/css/material-design-iconic-font.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_login'); ?>vendor/animate/animate.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_login'); ?>vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_login'); ?>vendor/animsition/css/animsition.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_login'); ?>vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_login'); ?>vendor/daterangepicker/daterangepicker.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_login'); ?>css/util.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_login'); ?>css/main.css">
  <!--===============================================================================================-->
</head>

<body>

  <div class="limiter">
    <div class="container-login100" style="background-image: url('<?php echo $this->config->item('assets_login'); ?>images/bg-01.jpg');">
      <div class="wrap-login100">
        <form class="login100-form validate-form" id="login-form" autocomplete="off">
          <input type="hidden" name="<?php echo $csrf['name']; ?>" value="<?php echo $csrf['hash']; ?>" id="token"/>
          <p class="p-b-20 p-t-10" style="font-size: 38px; color:white; text-align:center;">
            CRMdopa
          </p>
          <span class="login100-form-title p-b-20 p-t-20">
            Log in
          </span>

          <div class="alert alert-danger" id="error_message" style="display:none; text-align:center;margin-bottom: 27px;"></div>
            <div class="wrap-input100 validate-input" data-validate="Enter username">
              <input class="input100" type="text" name="username" placeholder="Username" autocomplete="off">
              <span class="focus-input100" data-placeholder="&#xf207;"></span>
            </div>

            <div class="wrap-input100 validate-input" data-validate="Enter password">
              <input class="input100" type="password" name="password" placeholder="Password" autocomplete="off">
              <span class="focus-input100" data-placeholder="&#xf191;"></span>
            </div>

            <!-- <div class="contact100-form-checkbox">
              <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember_me">
              <label class="label-checkbox100" for="ckb1">
                Remember me
              </label>
            </div> -->

            <div class="container-login100-form-btn">
              <button class="login100-form-btn">
                Login
              </button>
            </div>

            <!-- <div class="text-center p-t-90">
						<a class="txt1" href="#">
							Forgot Password?
						</a>
					</div> -->
        </form>
      </div>
    </div>
  </div>

  <div id="dropDownSelect1"></div>

  <!--===============================================================================================-->
  <script src="<?php echo $this->config->item('assets_login'); ?>vendor/jquery/jquery-3.2.1.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?php echo $this->config->item('assets_login'); ?>vendor/animsition/js/animsition.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?php echo $this->config->item('assets_login'); ?>vendor/bootstrap/js/popper.js"></script>
  <script src="<?php echo $this->config->item('assets_login'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?php echo $this->config->item('assets_login'); ?>vendor/select2/select2.min.js"></script>
  <!--===============================================================================================-->
  <script src="<?php echo $this->config->item('assets_login'); ?>vendor/daterangepicker/moment.min.js"></script>
  <script src="<?php echo $this->config->item('assets_login'); ?>vendor/daterangepicker/daterangepicker.js"></script>
  <!--===============================================================================================-->
  <script src="<?php echo $this->config->item('assets_login'); ?>vendor/countdowntime/countdowntime.js"></script>
  <!--===============================================================================================-->
  <script src="<?php echo $this->config->item('assets'); ?>dist/js/global.js"></script>
  <script src="<?php echo $this->config->item('assets_login'); ?>js/main.js"></script>

</body>

</html>