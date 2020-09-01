<?php require_once("Includes/DB.php");  ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if(isset($_SESSION["UserId"])){
  Redirect_to("Dashboard.php");
}

if(isset($_POST["Submit"])){
  $UserName = $_POST["Username"];
  $Password = $_POST["Password"];
  if(empty($UserName) || empty($Password)){
    $_SESSION["ErrorMessage"] = "All fields must be filled out";
    Redirect_to("Login.php");
  }else{
    $Found_Account = Login_Attempt($UserName,$Password);
    if($Found_Account){
      $_SESSION["UserId"] = $Found_Account["id"];
      $_SESSION["Username"] = $Found_Account["username"];
      $_SESSION["AdminName"] = $Found_Account["aname"];

      $_SESSION["SuccessMessage"] = "Welcome ".$_SESSION["AdminName"];
      if(isset($_SESSION["TrackingURL"])){
        Redirect_to($_SESSION["TrackingURL"]);
      }else{
        Redirect_to("Dashboard.php");
      }
  }else{
      $_SESSION["ErrorMessage"]="Incorrect username or password";
      Redirect_to("Login.php");
  }
  }

}  

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
      integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/Styles.css" />
    <title>Login</title>
  </head>

  <body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white">
      <div class="container">
        <a href="#" class="navbar-brand text-white">JAZEBAKRAM.COM</a>
        <button
          class="navbar-toggler"
          data-toggle="collapse"
          data-target="#navbarcollapseCMS"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
          
        </div>
      </div>
    </nav>

    <!-- HEADER -->
    <header class="bg-dark text-white py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          </div>
        </div>
      </div>
    </header>
    <!-- Main Area -->
    <br><br><br><br><br>
    <?php 
    echo ErrorMessage();
    echo SuccessMessage();
    ?>

    <section class="container py-2 mb-4">
        <div class="row">
            <div class=" offset-sm-3 col-sm-6" style="min-height:400px; ">
            <div class="card bg-secondary text-light">
                <div class="card-header">
                    <h4>Welcome back</h4>
                </div>
                    <div class="card-body bg-dark">
                        <form action="Login.php" method="post">
                            <div class="form-group">
                                <label for="usaername">Username</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="Username" id="Username" value="">
                                </div>
                            </div>
                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="Password" id="password" value="">
                                </div>
                            </div>
                            <!-- Login button -->
                            <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>

    </section>
    <!-- FOOTER -->
    <footer class="bg-dark text-white">
      <div class="container">
        <div class="row">
          <div class="col">
            <p class="lead text-center">
              Paris Kourpidis &copy;<span id="year"></span>
            </p>
          </div>
        </div>
      </div>
    </footer>

    <script
      src="http://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
      integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
      integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
      crossorigin="anonymous"
    ></script>

    <script>
      // Get the current year for the copyright
      $("#year").text(new Date().getFullYear());
    </script>
  </body>
</html>
