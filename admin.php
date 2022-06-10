<?php
error_reporting(0);
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}
if (!isset($_SESSION['username'])) {
  header('location: login.php');
}
$title="";
$content="";
$image="";
$title="";
$content="";
$item="";
$id="";
$date_var="";
$errors = array(); 
$db = mysqli_connect('localhost', 'root', '', 'psread');




/////////////// ADD ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if (isset($_POST['add'])) {
  // receive all input values from the form
  $image = mysqli_real_escape_string($db, $_POST['image']);
  $title = mysqli_real_escape_string($db, $_POST['title']);
  $content = mysqli_real_escape_string($db, $_POST['content']);
  $date = date("d/m/Y");



  $query = "SELECT * FROM post WHERE title='$title' LIMIT 1";
  $result = mysqli_query($db, $query);
  $row = mysqli_fetch_assoc($result);
  
  if ($row) { 
    if ($row['title'] === $title) {
      array_push($errors, "Objava već postoji");
    }
  }
 
  if (empty($image)) { array_push($errors, "Slika obavezna!"); }
  if (empty($title)) { array_push($errors, "Naslov obavezan!"); }
  if (empty($content)) { array_push($errors, "Sadržaj obavezan!"); }

  
  if (count($errors) == 0) {
    $query = "INSERT INTO post (image, title, content, date) VALUES ('$image','$title', '$content', '$date')";
    mysqli_query($db, $query);
    header('location: admin.php');
  }

 
}


/////////////// UPDATE ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['search_edit'])) {

  $item = mysqli_real_escape_string($db, $_POST['item']);
  $query2 = "SELECT * FROM post WHERE post_id = '$item'";
  $results2 = mysqli_query($db, $query2);
  $row2 = mysqli_fetch_assoc($results2);
  
}


if (isset($_POST['edit'])) {
  $id = mysqli_real_escape_string($db, $_POST['post_id']);
  $image = mysqli_real_escape_string($db, $_POST['image']);
  $title = mysqli_real_escape_string($db, $_POST['title']);
  $content = mysqli_real_escape_string($db, $_POST['content']);

  $query = "UPDATE post 
            SET image ='$image', title='$title', content='$content'
            WHERE post_id = '$id' ";
            
  mysqli_query($db, $query);
  header('location: admin.php');
}

/////////// DELETE ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['delete'])) {
  $id = mysqli_real_escape_string($db, $_POST['id']);
     $query = "DELETE FROM post WHERE post_id = '$id'";
            
  mysqli_query($db, $query);
  header('location: admin.php');
}


/////////// LIST ID ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$query5 = "SELECT * FROM post";
$results5 = mysqli_query($db, $query5);

/////////// MESSAGE ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$query6 = "SELECT * FROM message ORDER BY id DESC";
$results6 = mysqli_query($db, $query6);


/////////// IMAGES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$query7 = "SELECT * FROM image ORDER BY image_id DESC";
$results7 = mysqli_query($db, $query7);


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>Admin panel</title>
<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}
pre{
  font-family: myFirstFont;
  font-size:17px;
  white-space: pre-wrap;
  word-wrap: break-word;
  text-align: justify;
  padding: 10px 10px 10px 10px;
}

th, td {
  text-align: left;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: grey;
}
tr:nth-child(odd) {
  background-color: lightblue;
}
    body {
  background-image: url('images/back.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
}
p{
  color:white;
}
.container{
display: none; 
border-radius: 25px;
width: 60%;
background-color: rgba(0, 0, 0, 0.5);
}
@media screen and (max-width: 800px) {
  .container{
width: 100%;
}
}
#myInput {
  background-image: url('/css/searchicon.png'); /* Add a search icon to input */
  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}
.btnx {
  background-color: #f4511e;
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  font-size: 16px;
  margin: 4px 2px;
  opacity: 0.6;
  transition: 0.3s;
  display: inline-block;
  text-decoration: none;
  cursor: pointer;
  border-radius: 25px;
}
h2{
  color:white;
}
label{
  color:white;
}

.btnx:hover {opacity: 1}

/* Float four columns side by side */
.column {
  float: left;
  width: 50%;
  padding: 10px;
}

/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}
/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  text-align: center;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 0 0 10px;
}
.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.5);
}
img {
  border-radius: 5px 5px 0 0;
}


</style>
</head>

<body>
<nav class="navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" target="_blank" href="index.php">p.s. read</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Objava<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="show_add()">Dodaj novu objavu</a></li>
            <li><a href="#" onclick="show_edit()">Uredi objavu</a></li>
             <li><a href="#" onclick="show_remove()">Obriši objavu</a></li>
          </ul>
        </li>
        <li><a href="#" onclick="show_mess()">Poruke</a></li>
        <li><a href="#" onclick="show_id()">ID objava</a></li>
        <li><a href="#" onclick="show_image()">Slike</a></li>
        <li><a href="#" onclick="show_galery()">Galerija</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="admin.php?logout='1'"><span class="glyphicon glyphicon-log-in"></span> Odjavi se</a></li>
      </ul>
    </div>
  </div>
</nav>


<div id="show_add" class="container">
<h2>Nova objava</h2>
<hr>
<form method="post">
<?php include('errors.php'); ?>
    <div class="form-group">
    <label>Ime slike</label>
  	  <input placeholder="Unesi ime slike" type="text" name="image" class="form-control" value="<?php echo $image; ?>">
    </div>
    <div class="form-group">
    <label>Naslov objave</label>
  	  <input placeholder="Unesi naslov objave" type="text" name="title" class="form-control" value="<?php echo $title; ?>">
    </div>
    <div class="form-group">
  	  <label>Opis</label>
  	  <textarea class="form-control" placeholder="Unesi opis" type="text" name="content" cols="30" rows="5" value="<?php echo $content; ?>"></textarea>
	  </div>
    <div class="form-group">
  	  <label>Recenzija:</label>
  	  <textarea class="form-control" placeholder="Unesi recenziju" type="text" name="review" cols="30" rows="20" value="<?php echo $review; ?>"></textarea>
	  </div>
    <div class="form-group">
    <button type="submit" class="btn" name="add">Objavi</button>
  	</div>
</form>
</div>






<div id="show_edit" class="container">
<h2>Uredi objavu</h2>
<hr>
<form method="post">
<div class="form-group">
<input placeholder="Unesi id članka" type="text" name="item" class="form-control" value="<?php echo $item; ?>">
</div>
<div class="form-group">
<button type="submit" class="btn" name="search_edit">Pretraži</button>
</div>
</form>
<form method="post">
<?php include('errors.php'); ?>
<div class="form-group">
  	  <label>Id objave</label>
  	  <input placeholder="id" type="text" name="post_id" class="form-control" readonly value="<?php echo "" . $row2['post_id'] . ""?>">
  	</div>
    <div class="form-group">
    <label>Ime slike</label>
  	  <input placeholder="Unesi ime slike" type="text" name="image" class="form-control" value="<?php echo "" . $row2['image'] . ""?>">
    </div>
    <div class="form-group">
    <label>Naslov objave</label>
  	  <input placeholder="Unesi naslov objave" type="text" name="title" class="form-control" value="<?php echo "" . $row2['title'] . ""?>">
    </div>
    <div class="form-group">
  	  <label>Opis</label>
  	  <textarea class="form-control" placeholder="Unesi opis" type="text" name="content" cols="30" rows="5"><?php echo "" . $row2['content'] . ""?></textarea>
	  </div>
    <div class="form-group">
  	  <label>Recenzija</label>
  	  <textarea class="form-control" placeholder="Unesi recenziju" type="text" name="review" cols="30" rows="20"><?php echo "" . $row2['review'] . ""?></textarea>
	  </div>
    <div class="form-group">
    <button type="submit" class="btn" name="edit">Izmjeni</button>
  	</div>
</form>
</div>






<div id="show_remove" class="container">
  <h2>Ukloni objavu</h2>
  <hr>
  <form method="post" >
  <div class="form-group">
  	  <label>Unesi id objave</label>
  	  <input placeholder="Id objave" type="text" name="id" class="form-control"value="<?php echo $id; ?>">
  	</div>
    <div class="form-group">
  	  <button type="submit" class="btn" name="delete">Ukloni</button>
  	</div>
  </form>
</div>




<div id="show_id" class="container">
<h2>Lista objava sa prikazanim ID vrijednostima</h2>
  <hr>
  <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Pretraži objave...">
  <?php
echo "
<div class='form-group'>
<table id='myTable'>
<tr>
  <th>Naslov</th>
  <th>ID</th>
</tr>
";
while($row5 = mysqli_fetch_assoc($results5))
{
echo"

<tr>
  <td>" . $row5['title'] . "</td>
  <td>" . $row5['post_id'] . "</td>
</tr>
";
}
echo"</table>
</div>";
?>
</div>






<div id="show_mess" class="container">
<h2>PORUKE</h2>
<hr>

<?php
while($row6 = mysqli_fetch_assoc($results6))
{
echo"
<div class='form-group container' style='background-color: rgba(255, 192, 203, 0.2); border-radius: 25px; display:block; width:100%;'>
<br>
<div class='form-group'>
<label>Ime: " . $row6['name'] . "</label>
</div>
<div class='form-group'>
<label>Email: <a href=mailto:" . $row6['email'] . ">" . $row6['email'] . "</a></label>
</div>
<div class='form-group'>
<label>Poruka:</label>
<pre>" . $row6['message'] . "</pre>
</div>
<div class='form-group'>
<label>Datum: " . $row6['date'] . "</label>
</div>
<div class='form-group'>
<a class='btnx' id='delete_button' href=delete.php?id=".$row6['id']." >Ukloni</a>
  </div>
</div>
";
}
?>
</div>





<div id="show_image" class="container">
<h2>Slike</h2>
  <hr>
  <form action="upload.php" method="post" enctype="multipart/form-data">
<div class="form-group">
  	  <label>Odaberi sliku:</label>
  	  <input type="file" name="fileToUpload" class="form-control" id="fileToUpload">
    </div>
    <div class="form-group">
    <button type="submit" class="btn" name="add">Objavi</button>
  	</div>
</form>
<form method="post">
    <div class="form-group">
    <label>Ime slike</label>
  	  <input placeholder="Unesi ime slike" type="text" name="image" class="form-control" value="<?php echo "" . $row2['image'] . ""?>">
    </div>
    <div class="form-group">
    <button type="submit" class="btn" name="edit">Dodaj</button>
  	</div>
</form>
</div>



<div id="show_galery" class="container">
<h2>Galerija</h2>
  <hr>
  <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Pretraži slike...">
  <?php
  echo "
  <div id='myItems' class='row'>
  ";
  while( $row7 = mysqli_fetch_array($results7))
  {
    echo"
    
    <div class='column'>
      <div class='card'>
          
          <img src='images/" . $row7['name'] .  ".jpg' alt='Avatar' style='height:200px;width:100%;object-fit: cover;'>
          
        <div class='container'>
          <div class='card_container'>
              <h4 class='card-title' style='text-align: center;'><b>" . $row7['name'] . "</b></h4>
             
          </div>
        </div>
      </div>
    </div>  
  ";
}
echo"</div>";
?>
</div>












<script>

var someVarName = localStorage.getItem("someVarKey");

if(someVarName == "show_add"){
    var x = document.getElementById("show_add");
    x.style.display = "block";
}
if(someVarName == "show_edit"){
    var x = document.getElementById("show_edit");
    x.style.display = "block";
}
if(someVarName == "show_remove"){
    var x = document.getElementById("show_remove");
    x.style.display = "block";
}

if(someVarName == "show_id"){
    var x = document.getElementById("show_id");
    x.style.display = "block";
}
if(someVarName == "show_mess"){
    var x = document.getElementById("show_mess");
    x.style.display = "block";
}
if(someVarName == "show_image"){
    var x = document.getElementById("show_image");
    x.style.display = "block";
}
if(someVarName == "show_galery"){
    var x = document.getElementById("show_galery");
    x.style.display = "block";
}
function show_add() {
    
    var someVarName = localStorage.getItem("someVarKey");

    var x = document.getElementById("show_add");
    var y = document.getElementById("show_edit");
    var z = document.getElementById("show_remove");
    var x3 = document.getElementById("show_id");
    var x4 = document.getElementById("show_mess");
    var x5 = document.getElementById("show_image");
    var x6 = document.getElementById("show_galery");
    
      x.style.display = "block";
      y.style.display = "none";
      z.style.display = "none";
      x3.style.display = "none";
      x4.style.display = "none";
      x5.style.display = "none";
      x6.style.display = "none";
    
      window.scrollBy(0, -1000);
      
      someVarName = "show_add";
      localStorage.setItem("someVarKey", someVarName);
    }
    function show_edit() {
    
    var someVarName = localStorage.getItem("someVarKey");
    
    var x = document.getElementById("show_edit");
    var y = document.getElementById("show_add");
    var z = document.getElementById("show_remove");
    var x3 = document.getElementById("show_id");
    var x4 = document.getElementById("show_mess");
    var x5 = document.getElementById("show_image");
    var x6 = document.getElementById("show_galery");

      x.style.display = "block";
      y.style.display = "none";
      z.style.display = "none";
      x3.style.display = "none";
      x4.style.display = "none";
      x5.style.display = "none";
      x6.style.display = "none";

      window.scrollBy(0, -1000);
      
      someVarName = "show_edit";
      localStorage.setItem("someVarKey", someVarName);
    }
    function show_remove() {
    
    var someVarName = localStorage.getItem("someVarKey");
    
    var x = document.getElementById("show_remove");
    var y = document.getElementById("show_add");
    var z = document.getElementById("show_edit");
    var x3 = document.getElementById("show_id");
    var x4 = document.getElementById("show_mess");
    var x5 = document.getElementById("show_image");
    var x6 = document.getElementById("show_galery");
    
      x.style.display = "block";
      y.style.display = "none";
      z.style.display = "none";
      x3.style.display = "none";
      x4.style.display = "none";
      x5.style.display = "none";
      x6.style.display = "none";
    
      window.scrollBy(0, -1000);
      
      someVarName = "show_remove";
      localStorage.setItem("someVarKey", someVarName);
    }
  
    function show_id() {
    
    var someVarName = localStorage.getItem("someVarKey");
    
    var x = document.getElementById("show_id");
    var y = document.getElementById("show_add");
    var z = document.getElementById("show_edit");
    var x3 = document.getElementById("show_remove");
    var x4 = document.getElementById("show_mess");
    var x5 = document.getElementById("show_image");
    var x6 = document.getElementById("show_galery");
    
      x.style.display = "block";
      y.style.display = "none";
      z.style.display = "none";
      x3.style.display = "none";
      x4.style.display = "none";
      x5.style.display = "none";
      x6.style.display = "none";

      window.scrollBy(0, -1000);
      
      someVarName = "show_id";
      localStorage.setItem("someVarKey", someVarName);
    }
    function show_mess() {
    
    var someVarName = localStorage.getItem("someVarKey");
    
    var x = document.getElementById("show_mess");
    var y = document.getElementById("show_add");
    var z = document.getElementById("show_edit");
    var x3 = document.getElementById("show_remove");
    var x4 = document.getElementById("show_id");
    var x5 = document.getElementById("show_image");
    var x6 = document.getElementById("show_galery");
    
      x.style.display = "block";
      y.style.display = "none";
      z.style.display = "none";
      x3.style.display = "none";
      x4.style.display = "none";
      x5.style.display = "none";
      x6.style.display = "none";
    
      window.scrollBy(0, -1000);
      
      someVarName = "show_mess";
      localStorage.setItem("someVarKey", someVarName);
    }
    function show_image() {
    
    var someVarName = localStorage.getItem("someVarKey");
    
    var x = document.getElementById("show_image");
    var y = document.getElementById("show_add");
    var z = document.getElementById("show_edit");
    var x3 = document.getElementById("show_remove");
    var x4 = document.getElementById("show_mess");
    var x5 = document.getElementById("show_id");
    var x6 = document.getElementById("show_galery");
    
      x.style.display = "block";
      y.style.display = "none";
      z.style.display = "none";
      x3.style.display = "none";
      x4.style.display = "none";
      x5.style.display = "none";
      x6.style.display = "none";
    
      window.scrollBy(0, -1000);
      
      someVarName = "show_image";
      localStorage.setItem("someVarKey", someVarName);
    }
    function show_galery() {
    
    var someVarName = localStorage.getItem("someVarKey");
    
    var x = document.getElementById("show_galery");
    var y = document.getElementById("show_add");
    var z = document.getElementById("show_edit");
    var x3 = document.getElementById("show_remove");
    var x4 = document.getElementById("show_mess");
    var x5 = document.getElementById("show_id");
    var x6 = document.getElementById("show_image");
    
    
      x.style.display = "block";
      y.style.display = "none";
      z.style.display = "none";
      x3.style.display = "none";
      x4.style.display = "none";
      x5.style.display = "none";
      x6.style.display = "none";
    
      window.scrollBy(0, -1000);
      
      someVarName = "show_galery";
      localStorage.setItem("someVarKey", someVarName);
    }




    function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
<!-- </body> -->
</body>
</html>