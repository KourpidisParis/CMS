<?php require_once("Includes/DB.php");  ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $SearchQueryParameter = $_GET["id"]; ?>

<?php

if(isset($_POST["Submit"])){
  $Name = $_POST["CommenterName"];
  $Email = $_POST["CommenterEmail"];
  $Comment = $_POST["CommenterThoughts"];
  //Time and date
  date_default_timezone_set("Europe/Athens");
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
  
  if(empty($Name) || empty($Email) || empty($Comment)){
    $_SESSION['ErrorMessage'] = "All Fields must be filled out";
    Redirect_to("FullPost.php?id={$SearchQueryParameter}");
  }elseif(strlen($Comment)>500){
    $_SESSION["ErrorMessage"] ="Comment lenght should be less than 50 charachters";
    Redirect_to("FullPost.php?id={$SearchQueryParameter}");
  }else{
    //Query to insert comment in DB when everything is fine
    global $ConnectionDB;
    $sql = "INSERT INTO comments(datetime,name ,email,comment,approvedBy,status,post_id)";
    $sql .= "VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";

    $stmt = $ConnectionDB->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':name',$Name);
    $stmt->bindValue(':email',$Email); 
    $stmt->bindValue(':comment',$Comment);
    $stmt->bindValue(':postIdFromURL',$SearchQueryParameter);

    $Execute = $stmt->execute();

    if($Execute){
      $_SESSION["SuccessMessage"]= "Commet submitted successfuly";
      Redirect_to("FullPost.php?id={$SearchQueryParameter}");
    }else{
      $_SESSION["ErrorMessage"] = "Something went wrong. Try again !";
      Redirect_to("FullPost.php?id={$SearchQueryParameter}");
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
    <title>Blog Page</title>
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
              <a href="Blog.php" class="nav-link text-white">Home</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-white">About us</a>
            </li>
            <li class="nav-item">
              <a href="Blog.php" class="nav-link text-white"
                >Blog</a
              >
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-white"> Contact us</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link text-white">Features</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
              <form class="form-inline d-none d-sm-block" action="Blog.php">
                  <div class="form-group">
                      <input class="form-control mr-2" type="text" name="Search" placeholder="Type Here" value="">
                    <button class="btn btn-primary" name="SearchButton" >Go</button>  
                   </div>
              </form>
          </ul>
        </div>
      </div>
    </nav>
    <div style="height:20px; width:100%; background: red;"> </div>

    <!-- HEADER -->
    <div class="container">
        <div class="row mt-4">
            <!-- Main Area Start -->
            <div class="col-sm-8">
                <h1>The Complte responsive CMS Blog</h1>
                <h1 class="lead">The main aria here</h1>
                <?php 
                  echo ErrorMessage();
                  echo SuccessMessage();
                ?>
                <?php
                global $ConnectionDB;

                if(isset($_GET["SearchButton"])){
                  $Search = $_GET["Search"];
                  $sql = "SELECT * FROM posts
                  WHERE datetime LIKE :search 
                  OR title LIKE :search
                  OR category LIKE :search
                  OR post LIKE :search";

                  $stmt = $ConnectionDB->prepare($sql);
                  $stmt->bindValue(":search",'%'.$Search.'%');
                  $stmt->execute();
                }
                else
                {
                  $PostIdFromUrl = $_GET["id"];
                  if(!isset($PostIdFromUrl)){
                    $_SESSION["ErrorMessage"] = "Bad Request";
                    Redirect_to("Blog.php");
                  }
                  $sql = "SELECT * FROM posts WHERE id = '$PostIdFromUrl'";
                  $stmt = $ConnectionDB->query($sql);

                }
                while($DataRows = $stmt->fetch()){
                    $PostId = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $PostTitle = $DataRows["title"];
                    $Category = $DataRows["category"];
                    $Admin = $DataRows["author"];
                    $Image = $DataRows["image"];
                    $PostDescription = $DataRows["post"];

                ?>

                <div class="card mb-1">
                    <img class="img-fluid card-img-top" style="max-height:450px;" src="Upload/<?php echo htmlentities($Image);  ?>" alt="">
                    <div class="card-body">
                         <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                        <small class="text-muted">Written By <?php echo $Admin; ?> On <?php echo htmlentities($DateTime); ?></small>
                        <span style="float:right;" class="badge badge-dark text-light">Comments 20</span>
                        
                        <hr>
                        <p class="card-text" >
                            <?php echo $PostDescription; ?></p>
                    </div>
                </div>
                    <?php }?>

                <h2>Comments</h2>
                <br><br>
                <?php 
                global $ConnectionDB;
                $sql = "SELECT * FROM comments
                 WHERE post_id='$SearchQueryParameter' AND status = 'ON' ";
                $stmt = $ConnectionDB->query($sql);
                while($DataRows = $stmt->fetch()){
                  $CommentDate = $DataRows['datetime'];
                  $CommenterName = $DataRows['name'];
                  $CommentContent = $DataRows['comment'];
      
                ?>

                <div>
                <div class="media border p-3 CommentBlock">
                <img style="width: 50px; height: 50px;" class="mr-3 mt-3 rounded-circle" src="images/comment.png" alt="">
                  <div class="media-body ml-2">
                     <h6 class="lead"><?php echo $CommenterName ?></h6>
                     <p class="small"><?php echo $CommentDate ?></p>
                     <p><?php echo $CommentContent ?></p>
                  </div>
                </div>
                </div>
                <?php  } ?>

                <div class="">
                  <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter?>" method="post">
                    <div class="card my-3">
                        <div class="card-header">
                           <h5>Share your thoughts about this post</h5>
                        </div>
                        <div class="card-body">
                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                   <i class="fas fa-user"></i>
                                </span>
                                <input class="form-control"  type="text" name="CommenterName" placeholder="Name" value="">
                             </div>
                           </div>               
                          </div>

                          <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                   <i class="fas fa-envelope"></i>
                                </span>
                                <input class="form-control"  type="text" name="CommenterEmail" placeholder="Email" value="">
                             </div>
                           </div>               
                          </div>

                          <div class="form-group">
                             <textarea name="CommenterThoughts" class="form-control" id="" cols="30" rows="10"></textarea>
                          </div>

                          <div class="">
                            <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                        
                    </div>
                    
                  </form>
                  
                  
                </div>

                

                   
            </div>
            <!-- Side Area Start -->
            <!-- Comment Part Start -->
            <div class="col-sm-4">
                <h1>Here is the dark side</h1>


            </div>
        </div>
    </div>
    <div style="height:20px; width:100%; background: red;"> </div>

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
