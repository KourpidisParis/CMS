<?php require_once("Includes/DB.php");  ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
// echo $_SESSION["TrackingURL"];
Confirm_Login(); ?>
<?php
if(isset($_POST["Submit"])){
    $UserName = $_POST["Username"];
    $Name = $_POST["Name"];
    $Password = $_POST["Password"];
    $ConfirmPassword = $_POST["ConfirmPassword"];
    $Admin = $_SESSION["UserName"];
    date_default_timezone_set("Europe/Athens");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

    if(empty($UserName) || empty($Password) || empty($ConfirmPassword)){
      $_SESSION["ErrorMessage"] = "All fields must be filled out";
      Redirect_to("Admin.php");
    }elseif (strlen($Password)<4){
      $_SESSION["ErrorMessage"] = "Password should be greater than 3 charachters";
      Redirect_to("Admin.php");
    }elseif(!($Password == $ConfirmPassword)){
      $_SESSION["ErrorMessage"]= "Password and Confirm password sould be match";
      Redirect_to("Admin.php");
    }elseif(CheckUserNameExistsOrNot($UserName)){
      $_SESSION["ErrorMessage"] = "The username already exist";
      Redirect_to("Admin.php");
    }
    else{
      global $ConnectionDB;
      $sql = "INSERT INTO admins(datetime,username,password,aname,addedby)";
      $sql .= "VALUES(:dateTime,:userName,:password,:aName,:adminName)";
      $stmt = $ConnectionDB->prepare($sql);
      $stmt->bindValue(':dateTime',$DateTime);
      $stmt->bindValue(':userName',$UserName);
      $stmt->bindValue(':password',$Password);
      $stmt->bindValue(':aName',$Name);
      $stmt->bindValue(':adminName',$Admin);


      $Execute = $stmt->execute();
      if($Execute){
        $_SESSION["SuccessMessage"]= "New Admin Added Successfully";
        Redirect_to("Admin.php");
      }else{
        $_SESSION["ErrorMessage"] = "Something went wrong. Try again !";
        Redirect_to("Admin.php");
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
    <title>Admin</title>
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
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a href="#" class="nav-link text-white"
                ><i class="fas fa-user text-success"></i> My profile</a
              >
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-white">Dashboard</a>
            </li>
            <li class="nav-item">
              <a href="Posts.php" class="nav-link text-white">Posts</a>
            </li>
            <li class="nav-item">
              <a href="Categories.php" class="nav-link text-white"
                >Categories</a
              >
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-white">Categories</a>
            </li>
            <li class="nav-item">
              <a href="Admins.php" class="nav-link text-white">Manage Admins</a>
            </li>
            <li class="nav-item">
              <a href="Comments.php" class="nav-link text-white">Comments</a>
            </li>
            <li class="nav-item">
              <a href="Blog.php?page=1" class="nav-link text-white"
                >Live Blog</a
              >
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a href="Logout.php" class="nav-link text-white">
                <i class="fas fa-user-times text-danger"></i> Logout</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- HEADER -->
    <header class="bg-dark text-white py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1> <i class="fas fa-edit"></i> Manage Admin</h1>
          </div>
        </div>
      </div>
    </header>
    <!-- Main Area -->
    <section class="container py-2 my-4 bg-dark ">
        <div class="row" >
        <div class="offset-lg-1 col-lg-10" style="min-height:440px;" >
        <?php
         echo ErrorMessage();
         echo SuccessMessage(); ?>
            <form class="" action="Admin.php" method="post">
                <div class="card mb-3">
                    <div class="card-header">
                        <h1>Add new Admin</h1>
                    </div>
                </div>
                <div class="card-body text-white">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input class="form-control" type="text" name="Username" id="uesername" value="" placeholder="Type here the title">
                    </div>
                    <div class="form-group">
                        <label for="Name">Name:</label>
                        <input class="form-control" type="text" name="Name" id="Name" value="">
                        <small class="text-warning text-muted">Optional</small>
                    </div>
                    <div class="form-group">
                        <label for="password">Passsword:</label>
                        <input class="form-control" type="password" name="Password" id="password" value="">
                    </div>
                    <div class="form-group">
                        <label for="ConfirmPassword">Confirm Password:</label>
                        <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" value="" >
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-2">
                            <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left">Back To Dashboard</i></a>
                        </div> 
                        <div class="col-lg-6 mb-2">
                            <button type="submit" name="Submit" class="btn btn-success btn-block">
                                <i class="fas fa-check"></i>Publish
                            </button>
                        </div>
                    </div>
                </div>
            </form>

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
