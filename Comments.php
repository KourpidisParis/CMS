<?php require_once("Includes/DB.php");  ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
// echo $_SESSION["TrackingURL"];
Confirm_Login(); ?>
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
    <title>Comments</title>
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
            <h1><i class="fas fa-comments"></i> Manage Comments</h1>
          </div>
        </div>
      </div>
    </header>
    <!-- Main Area -->
    <section class="container py-2 mb-4">
        <div class="row" style="min-height:30px;">
           <div class="col-lg-12" style="min-height:30px;">
           <h2>Un-Approved Comments</h2>

           <table class="table table-striped table-hover">
             <thead class="thead-dark">
               <tr>
                 <th>No.</th>
                 <th>Date&Time</th>
                 <th>Name</th>
                 <th>Comment</th>
                 <th>Approve</th>
                 <th>Action</th>
                 <th>Details</th>
               </tr>
             </thead>

           <?php
           $ConnectionDB;
           $sql = "SELECT* FROM comments WHERE status='OFF' ORDER BY id desc"; 
           $Execute = $ConnectionDB->query($sql);
           $SrNo = 0 ;
           while($DataRows=$Execute->fetch()){
             $CommentId = $DataRows["id"];
             $DateTimeOfComment = $DataRows["datetime"];
             $CommenterName = $DataRows["name"];
             $CommenterContent = $DataRows["comment"];
             $CommentPostId = $DataRows["post_id"];
             $SrNo++;
             if(strlen($CommenterName)>10)
             {
               $CommenterName = substr($CommenterName,0,10).'..';
             }
             if(strlen($DateTimeOfComment)>11)
             {
               $DateTimeOfComment = substr($DateTimeOfComment,0,11).'..';
             }
           
           ?>
           <tbody>
             <tr>
               <td><?php echo $SrNo; ?></td>
               <td><?php echo htmlentities($DateTimeOfComment); ?></td> 
               <td><?php echo htmlentities($CommenterName); ?></td>
               <td><?php echo htmlentities($CommenterContent); ?></td>
               <td> <a href="ApproveComment.php?id=<?php echo $CommentPostId; ?>" class="btn btn-primary">Approve Delete</a> </td>
               <td> <a href="DeleteComment.php?id=<?php echo $CommentPostId; ?>" class="btn btn-danger"> Delete Comment</a> </td>
               <td><a class="btn btn-success" href="FullPost.php?id=<?php echo $CommentPostId; ?>">Live Preview</a></td>
             </tr>
           </tbody>
           <?php } ?>
           </table>

           </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-dark text-white fixed-bottom">
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
