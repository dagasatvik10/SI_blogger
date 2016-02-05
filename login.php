<?php
ob_start();
$servername = "localhost";
$username = "root";
$passwd = "";
$db = "blogger";
//Create Connection
$conn = mysqli_connect($servername,$username,$passwd,$db);
//Check Connection
if(!$conn)
  die("Connection Failed: ".mysqli_connect_error());
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $email = $_POST["email"];
  $password = md5($_POST["password"]);

  $sql = "SELECT * FROM users WHERE email='$email'";

  $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));

  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result)){
      if($row["password"] == $password){
        echo "hey";
        session_start();
        $_SESSION['id'] = $row["id"];
        $_SESSION["name"] = $row["name"];
        header("Location: blogger.php");
      }
      else
        echo "Wrong password";
    }
  }
  else {
    echo "Wrong email";
  }

  mysqli_close($conn);
}
?>
<!doctype html>
<html>
  <head>
    <title>SI Blogger</title>
    <link href='style.css' type='text/css' rel='stylesheet'></link>
  </head>
  <body>
    <h1 id='heading'>Sign in</h1>
    <div id='main'>
      <form action='login.php' method='post'>
        <div class='fields'>
          <label for='email'>EMAIL</label>
          <br>
          <input type='text' name='email' id='email' required>
        </div>
        <div class='fields'>
          <label for='password'>PASSWORD</label>
          <br>
          <input type='password' name='password' id='password' required>
        </div>
        <div class='fields'>
          <input type='submit' value='Login'>
        </div>
        <div>
          <p>New user, <a href='sign_up.php'>Click Here</a> to join</p>
        </div>
      </form>
    </div>
    <div id='si_logo'>
      <img src='logo.png'>
    </div>
  </body>
</html>
