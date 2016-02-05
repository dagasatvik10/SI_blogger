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
$error = '';
$check = true;
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = md5($_POST["password"]);

  if(!isset($name) or !isset($email) or !isset($password))
    $check = false;

  if($check){
    $sql = "INSERT INTO users (name,email,password) VALUES ('$name','$email','$password')";

    if(mysqli_query($conn,$sql)){
      header("Location: login.php");
    }
    else {
      die("Error: ".mysqli_error($conn));
    }
    mysqli_close($conn);
  }
  else{
    $error = 'All fields required';
  }
}
?>
<!doctype html>
<html>
  <head>
    <link href='style.css' type='text/css' rel='stylesheet'></link>
  </head>
  <body>
    <h1 id='heading'>Create New Blogger</h1>
    <div id='main'>
      <p id='error'><?php echo $error;?></p>
      <form  action='sign_up.php' method='post'>
        <div class='fields'>
          <label for='name'>NAME</label>
          <br>
          <input type='text' name='name' id='name' required>
        </div>
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
          <input type='submit'value='Create User'>
      </div>
      <div>
        <p>Not a New user, <a href='login.php'>Click Here</a> to Login</p>
      </div>
      </form>
    </div>
    <div id='si_logo'>
      <img src='logo.png'>
    </div>
  </body>
</html>
