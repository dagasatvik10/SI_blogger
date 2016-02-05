<?php
//to use the header function anywhere
ob_start();
//Start the session and keep it running
session_start();
//Check whether the session is set and if it is not set, then redirect to the login page
if(!isset($_SESSION['id'])){
  header("Location: login.php");
}
//variables for database connection
$servername = "localhost";
$username = "root";
$passwd = "";
$db = "blogger";
//Create Connection
$conn = mysqli_connect($servername,$username,$passwd,$db);
//Check Connection
if(!$conn)
  die("Connection Failed: ".mysqli_connect_error());

$id = $_SESSION['id'];
?>
<?php
  //Check if the form is submited
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $blog = $_POST['blog'];

    $sql = "INSERT INTO blogs (user_id,blog) VALUES ('$id','$blog')";

    mysqli_query($conn,$sql);
  }
?>
<?php
  //fetch all blogs from db
  $sql = "SELECT * FROM blogs ORDER BY created_at DESC";

  $result1 = mysqli_query($conn,$sql);

  if(mysqli_num_rows($result1) > 0){
    for($i=1;$row1 = mysqli_fetch_array($result1);$i++){
      $blogs[$i] = $row1["blog"];
      $created_at[$i] = $row1["created_at"];
      $id = $row1["user_id"];
      //fetch the name of users each blog
      $sql = "SELECT name FROM users WHERE id='$id'";
      $result2 = mysqli_query($conn,$sql);
      $row2 = mysqli_fetch_array($result2);
      $name[$i] = $row2[0] ;
    }
  }
  $n = $i;
  mysqli_close($conn);
?>
<!doctype html>
<html>
  <head>
    <title>SI Blogger</title>
    <link href='style.css' type='text/css' rel='stylesheet'></link>
  </head>
  <body>
    <h1 id='heading'>SI Blogger</h1>
    <span id='logout'>Hello <?php echo $_SESSION['name']." ";?><a href="logout.php">Logout</a></span>
    <div id='tarea'>
      <form action='blogger.php' method='post'>
        <div class='fields'>
          <label for='blog'>Blog:</label>
          <br>
          <textarea rows='10' cols='40' name=blog id='blog'></textarea>
        </div>
        <div class='fields'>
          <input type='submit' value='Create Blog'>
        </div>
      </form>
    </div>
    <div id='section'>
      <ul>
        <?php
          for($i=1;$i<$n;$i++){
            echo "<li><span>".$name[$i]."</span><span>"."  ".$created_at[$i].
            "</span><p>".$blogs[$i]."</p></li>";
          }
        ?>
      </ul>
    </div>
    <div id='si_logo'>
      <img src='logo.png'>
    </div>
  </body>
</html>
