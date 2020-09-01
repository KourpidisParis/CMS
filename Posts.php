<?php require_once("Includes/DB.php");  ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
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
    <title>Posts</title>
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
    <div style="height:20px; width:100%; background: red;"> </div>

    <!-- HEADER -->
    <header class="bg-dark text-white py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1><i class="fas fa-blog"></i> Blog Posts</h1>
          </div>
          <div class="col-lg-3">
              <a href="AddNewPost.php" class="btn btn-primary btn-block mb-1">
                  <i class="fas fa-edit">Add New Post</i>
              </a>
          </div>
          <div class="col-lg-3">
              <a href="Categories.php" class="btn btn-info btn-block mb-1">
                  <i class="fas fa-folder-plus"></i>Add New Category
              </a>
          </div>
          <div class="col-lg-3">
              <a href="Admins.php" class="btn btn-warning btn-block mb-1">
                  <i class="fas fa-user-plus"></i>Add New Admin
              </a>
          </div>
          <div class="col-lg-3">
              <a href="Comments.php" class="btn btn-success btn-block mb-1">
                  <i class="fas fa-check"></i>Approve Comments
              </a>
          </div>
        </div>
      </div>
    </header>
    


    <!-- Main Area -->
    <div style="height:20px; width:100%; background: red;">BEFORE NAV</div>
    <div class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-12">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date&Time</th>
                        <th>Author</th>
                        <th>Banner</th>
                        <th>Comments</th>
                        <th>Action</th>
                        <th>Live Preview</th>
                    </tr>
                    </thead>

                    <?php
                    global $ConnectionDB;
                    $sql = "SELECT * FROM posts";
                    $stmt = $ConnectionDB->query($sql);
                    $Sr = 0;
                    while($DataRows = $stmt->fetch()){
                        $Id = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $PostTitle= $DataRows["title"];
                        $Category =$DataRows["category"];
                        $Admin=$DataRows["author"];
                        $Image=$DataRows["image"];
                        $PostText =$DataRows["post"];
                        $Sr++;
                    ?>
                    
                    <tbody>
                    <tr>
                        <td><?php echo $Sr ?></td>
                        <td class="table-danger">
                          <?php if(strlen($PostTitle) >20) {$PostTitle= substr($PostTitle,0,13).'..'; } ?>    
                          <?php echo $PostTitle ?></td>
                        <td>
                        <?php if(strlen($Category) >8) {$Category= substr($Category,0,8).'..'; } ?>
                            <?php echo $Category ?>
                        </td>
                        <td>
                            <?php if(strlen($DateTime) >11) {$DateTime= substr($DateTime,0,13).'..'; } ?>
                            <?php echo $DateTime ?>
                        </td>
                        <td class="table-primary">
                        <?php if(strlen($Admin) >6) {$Admin= substr($Admin,0,6).'..'; } ?>
                            <?php echo $Admin ?>
                        </td>
                        <td><img src="Upload/<?php echo $Image; ?>" widht="170px"; height="50px "; /></td>
                        <td>Comments</td>
                        <td>
                            <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                            <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                        </td>
                        <td><a href="FullPost.php?id=<?php echo $Id?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
                <?php } ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>



    </div>



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
