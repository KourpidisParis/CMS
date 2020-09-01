<?php require_once("Includes/DB.php");  ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php

$SearchQueryParameter =$_GET['id'];
if(isset($_POST["Submit"])){
    $PostTitle = $_POST["PostTitle"];
    $Category = $_POST["Category"];
    $Image = $_FILES["Image"]["name"];
    $Target = "Upload/".basename($_FILES["Image"]["name"]);
    $PostText = $_POST["PostDecription"];
    $Admin = "Paris";
    date_default_timezone_set("Europe/Athens");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

    if(empty($PostTitle)){
      $_SESSION["ErrorMessage"] = "Title cant be empty";
      Redirect_to("Posts.php");
    }elseif (strlen($PostTitle)<5){
      $_SESSION["ErrorMessage"] = "Post tile should be greater than 5 charachters";
      Redirect_to("Posts.php");
    }elseif(strlen($PostText)>999){
      $_SESSION["ErrorMessage"]= "Post description should be less than 1000 charaters";
      Redirect_to("Posts.php");
    }else{
      //Query to update post in DB when everything is fine
      global $connectionDB;
      if(!empty($_FILES["Image"]["name"])){
        $sql =  "UPDATE posts
        SET title = '$PostTitle',category = '$Category',image = '$Image',post = '$PostText'
        WHERE id ='$SearchQueryParameter' ";
      }else{
        $sql =  "UPDATE posts
        SET title = '$PostTitle',category = '$Category',post = '$PostText'
        WHERE id ='$SearchQueryParameter' ";
      }

 

      $Execute = $ConnectionDB->query($sql);
      move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

      // var_dumb($Execute);
      if($Execute){
        $_SESSION["SuccessMessage"]= "Post updated Successfully";
        Redirect_to("Posts.php");
      }else{
        $_SESSION["ErrorMessage"] = "Something went wrong. Try again !";
        Redirect_to("Posts.php");
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
    <title>Edit Post</title>
  </head>

  <body>
    <div style="height:20px; width:100%; background: red;">BEFORE NAV</div>
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
            <h1> <i class="fas fa-edit"></i>Edit Post</h1>
          </div>
        </div>
      </div>
    </header>
    <div style="height:20px; width:100%; background: red;">BEFORE NAV</div>

    <!-- Main Area -->
    <section class="container py-2 my-4 bg-dark ">
        <div class="row" >
        <div class="offset-lg-1 col-lg-10" style="min-height:440px;" >
        <?php
         echo ErrorMessage();
         echo SuccessMessage();
         global $ConnectionDB;
         $SearchQueryParameter = $_GET["id"];
         $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter' ";
         $stmtPost = $ConnectionDB->query($sql);
         while($DataRows =$stmtPost->fetch()){
             $TitleToBeUpdated = $DataRows['title'];
             $CategoryToBeUpdated = $DataRows['category'];
             $ImageToBeUpdated = $DataRows['image'];
             $PostToBeUpdated = $DataRows['post']; 
         }
         ?>
            <form class="" action="EditPost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                <div class="card mb-3">
                    <div class="card-header">
                        <h1>Edit Post</h1>
                    </div>
                </div>
                <div class="card-body text-white">
                    <div class="form-group">
                        <label for="title">Post title:</label>
                        <input class="form-control" type="text" name="PostTitle" id="title" value="<?php echo $TitleToBeUpdated;  ?>" placeholder="Type here the title">
                    </div>
                    <div class="form-group">
                        <span>Existing Category: </span>
                        <br>
                        <?php echo $CategoryToBeUpdated; ?>
                        <label for="CategoryTitle ">Choose Category</label>
                        <select class="form-control" name="Category" id="CategoryTitle">
                            <?php 
                             $sql = "SELECT * FROM categories";
                             $stmt = $ConnectionDB->query($sql);
                             while($DateRows = $stmt->fetch()){
                                 $Id = $DateRows["id"];
                                 $CategoryName = $DateRows["title"];  
                             
                            ?>
                            <option><?php echo $CategoryName; ?></option>
                            <?php }?> 
                            <!-- <option value="">1</option>
                            <option value="">2</option>
                            <option value="">3</option> -->
                        </select>
                    </div>
                    <div class="form-group mb-1" >
                        <span>Existing Image:</span>
                        <img class="mb-1" src="Upload/<?php echo $ImageToBeUpdated; ?>" alt="" width="170px"; height="70px";>
                        <br>
                        <label for="imageSelect">Select Image</label>
                        <div class="custom-file">
                            <input class="custom-file-input" type="File" name="Image" id="imageSelect">
                            <label for="imageSelect" class="custom-file-label">Select Image</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="Post">Post </label>
                        <textarea class="form-control text-black" name="PostDecription" id="Post" cols="80" rows=8>
                            <?php echo $PostToBeUpdated;?>
                        </textarea>

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
