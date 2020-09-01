<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
function Redirect_to($New_Location){
    header("Location:".$New_Location);
    exit;
}


function CheckUserNameExistsOrNot($UserName){
    global $ConnectionDB;
    $sql = "SELECT username FROM admins WHERE username=:userName";
    $stmt = $ConnectionDB->prepare($sql);
    $stmt->bindValue(':userName',$UserName);

    $stmt->execute();

    $Result = $stmt->rowcount();
    if($Result==1){
        return true;
    }else{return false;}
}

function Login_Attempt($UserName,$Password){
        //code for checking username and password from database

    global $ConnectionDB;
    $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
    $stmt = $ConnectionDB->prepare($sql);
    $stmt->bindValue(':userName',$UserName);
    $stmt->bindValue(':passWord',$Password);
    $stmt->execute();

    $Result = $stmt->rowcount();
    if($Result==1){
      return $Found_Account = $stmt->fetch();
    }else{
      echo null;
    }
}

function Confirm_Login(){
  if(isset($_SESSION["UserId"])){
    return true;
  }else{
    $_SESSION["ErrorMessage"] = "Login Required";
    Redirect_to("Login.php");
  }

}
?>