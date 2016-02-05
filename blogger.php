<?php
ob_start();
session_start();

if(!isset($_SESSION['id'])){
  header("Location: login.php");
}
$servername = "localhost";
$username = "root";
$passwd = "";
$db = "blogger";
//Create Connection
$conn = mysqli_connect($servername,$username,$passwd,$db);
//Check Connection
if(!$conn)
  die("Connection Failed: ".mysqli_connect_error());

@$id = $_SESSION['id'];
?>
<?php
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $blog = $_POST['blog'];

    $sql = "INSERT INTO blogs (user_id,blog) VALUES ('$id','$blog')";

    mysqli_query($conn,$sql);
  }
?>
<?php
  $sql = "SELECT * FROM blogs";

  $result = mysqli_query($conn,$sql);
  //print_r($result);
  $i=1;
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result)){
      $blogs[$i] = $row["blog"];
      $created_at[$i] = $row["created_at"];
      $id = $row["user_id"];
      $sql = "SELECT name FROM users WHERE id='$id'";
      $result1 = mysqli_query($conn,$sql);
      $row1 = mysqli_fetch_array($result1);
      $name[$i] = $row1[0] ;
      $i++;
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
  </body>
</html>
