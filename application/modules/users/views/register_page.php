<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Bootstrap 101 Template</title>

  <!-- Bootstrap -->
  <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <div class="container">
    <div class="row">

      <div class="col-md-8 col-md-offset-2">
        <form role="form" method="POST" action="#">

          <legend class="text-center">Register</legend>

          <fieldset>
            <legend>Account Details</legend>

            <div class="form-group col-md-6">
              <label for="first_name">First name</label>
              <input type="text" class="form-control" name="" id="first_name" placeholder="First Name">
            </div>

            <div class="form-group col-md-6">
              <label for="last_name">Last name</label>
              <input type="text" class="form-control" name="last_name" id="" placeholder="Last Name">
            </div>

            <div class="form-group col-md-12">
              <label for="">Email</label>
              <input type="email" class="form-control" name="" id="" placeholder="Email">
            </div>

            <div class="form-group col-md-6">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="" id="password" placeholder="Password">
            </div>

            <div class="form-group col-md-6">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" class="form-control" name="" id="confirm_password" placeholder="Confirm Password">
            </div>


          </fieldset>

          <fieldset>
            <legend>Optional Details</legend>

            <div class="form-group col-md-6">
              <label for="country">Country of Residence</label>
              <select class="form-control" name="" id="country">
                <option>Country 1</option>
                <option>Country 2</option>
                <option>Country 3</option>
              </select>
            </div>

            <div class="form-group col-md-12">
              <label for="found_site">How did you find out about the site?</label>
              <select class="form-control" name="" id="found_site">
                <option>Company</option>
                <option>Friend</option>
                <option>Colleague</option>
                <option>Advertisement</option>
                <option>Google Search</option>
                <option>Online Article</option>
                <option value="other">Other</option>
              </select>
            </div>

            <div class="form-group col-md-12 hidden">
              <label for="specify">Please Specify</label>
              <textarea class="form-control" id="specify" name=""></textarea>
            </div>

          </fieldset>

          <div class="form-group">
            <div class="col-md-12">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="" id=""> I accept the
                  <a href="#">terms and conditions</a>.
                </label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
              <button type="submit" class="btn btn-primary">
                Register
              </button>
              <a href="#">Already have an account?</a>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>