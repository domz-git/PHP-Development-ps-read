<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$db = mysqli_connect('localhost', 'root', '', 'psread');



$name="";
$email="";
$message="";

  $query = "SELECT * FROM post ORDER BY post_id DESC";
  $results = mysqli_query($db, $query);


  /////////////// MESSAGE ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if (isset($_POST['send'])) {
  // receive all input values from the form
  $name = mysqli_real_escape_string($db, $_POST['name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $message = mysqli_real_escape_string($db, $_POST['message']);
  $date = date("d/m/Y");

    $query = "INSERT INTO message (name, email, message, date) VALUES ('$name','$email', '$message', '$date')";
    mysqli_query($db, $query);
    header('location: index.php');

}
?>



<!DOCTYPE html>
<html>
<head>
<title>ps. read</title>
<link rel="icon" href="images/owl.svg">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">


<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif;}
body, html {
  height: 100%;
  color: #777;
  line-height: 1.8;
}

/* Create a Parallax Effect */
.bgimg-1, .bgimg-2, .bgimg-3 {
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

/* First image (Logo. Full height) */
.bgimg-1 {
  background-image: url('images/image2.jpg');
  min-height: 40%;
}

.w3-wide {letter-spacing: 10px;}
.w3-hover-opacity {cursor: pointer;}

/* Turn off parallax scrolling for tablets and phones */
@media only screen and (max-device-width: 500px) {
  .bgimg-1, .bgimg-2, .bgimg-3 {
    background-attachment: scroll;
    min-height: 250px;
  }
}
.button {
  display: inline-block;
  border-radius: 4px;
  background-color: lightblue;
  color:black;
  border: none;
  text-align: center;
  font-size: 18px;
  width: 50%;
  padding: 5px;
  transition: all 0.5s;
  cursor: pointer;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
  
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
  color: white;
}

.button:hover span {
  padding-right: 25px;
  color: white;
}
.button:hover{
background-color: darkslategrey;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}
@font-face {
  font-family: myFirstFont;
  src: url(aleg.ttf);
}
pre{
  font-family: myFirstFont;
  font-size:17px;
  white-space: pre-wrap;
  word-wrap: break-word;
  text-align: justify;
  padding: 10px 10px 10px 10px;
}
#nava{
  text-decoration:none;
  color:black;
}
a{
  color:red;
}

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
#banner {
  border-radius: 0px 0px 0 0;
}
#myFilter {
  width: 250px;
  box-sizing: border-box;
  border: 0px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  padding: 8px 20px 12px 40px;
  -webkit-transition: width 0.4s ease-in-out;
  transition: width 0.4s ease-in-out;
}

#myFilter:focus {
  width: 30%;
  outline: none;
}
@media screen and (max-width: 550px) {
  #myFilter:focus {
  width: 100%;
  outline: none;
  }
}
p{
  color: lightslategrey;
  font-size: 13px;
}
</style>
</head>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar" id="myNavbar">
    <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
      <i class="fa fa-bars"></i>
    </a>
    <a href="index.php" id="nava" class="w3-bar-item w3-button"> PS. READ</a>
    
    <a href="index.php#about" id="nava" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i> RECENZIJE</a>
    <a href="index.php#contact" id="nava" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-envelope"></i> KONTAKT</a>
    
  </div>

  <!-- Navbar on small screens -->
  <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
    <a href="index.php#about" id="nava" class="w3-bar-item w3-button" onclick="toggleFunction()"> RECENZIJE</a>
    <a href="index.php#contact" id="nava" class="w3-bar-item w3-button" onclick="toggleFunction()"> KONTAKT</a>
  </div>
</div>

<!-- First Parallax Image with Logo Text -->
<div class="bgimg-1 w3-display-container w3-opacity-min" id="home">
  <div class="w3-display-middle" style="white-space:nowrap;">
    <span class="w3-center w3-padding-large w3-xlarge w3-wide w3-animate-opacity"> <img src="images/image.png" alt="Avatar" style="width:100%"> </span>
  </div>
</div>

<div class="w3-content w3-container w3-padding-64" id="about">
  <h3 class="w3-center">NASLOV</h3>
  <?php
echo"<pre>hdfjghfdkjghjkdfhgfdkg

jkghdfjkghjfdkghdkjfg
jgfhkjfdhgkjdfg


fdkgjhkdfghkjfd</pre>"

?>


  </div>
</div>


<!-- Container (Contact Section) -->
<div class="w3-content w3-container w3-padding-64" id="contact">
  <p class="w3-center"><em>Kontaktiraj nas!</em></p>

  <div class="w3-row w3-padding-32 w3-section">
    <div class="w3-col m4 w3-container">
      <img src="images/contact.jpg" class="w3-image w3-round" style="width:100%">
    </div>
    <div class="w3-col m8 w3-panel">
      <form method="post">
        <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
          <div class="w3-half">
            <input class="w3-input w3-border" type="text" placeholder="Ime" name="name"required name="Name">
          </div>
          <div class="w3-half">
            <input class="w3-input w3-border" type="email" placeholder="Email" name="email"required name="Email">
          </div>
        </div>
        
        <textarea class="w3-input w3-border" type="text" placeholder="Ovdje upiši svoju poruku" name ="message" required name="Message" cols="30" rows="10"></textarea>
        <button class="w3-button w3-black w3-right w3-section" onclick="fu()" name="send" type="submit">
          <i class="fa fa-paper-plane"></i> POŠALJI
        </button>
      </form>
    </div>
  </div>

  <!-- INFORMACIJE-->
  <!-- Container (Contact Section) 
  <div class="w3-content w3-container w3-padding-64" id="info">
            <h3 class="w3-center">Dodatne informacije</h3>
            <p>*U cijenu bookmarkera nije uračunata cijena poštarine.</p>
            <p>Trošak poštarine može ovisiti o državi i obujmu narudžbe te se obračunava po narudžbi.</p>
  </div>
        -->
</div>

<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64">
  <a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
  <div class="w3-xlarge w3-section">
    <i class="fa fa-facebook-official w3-hover-opacity"></i>
    <a href="https://www.instagram.com/p_s_read/"><i class="fa fa-instagram w3-hover-opacity"></i></a>
    <i class="fa fa-snapchat w3-hover-opacity"></i>
    <i class="fa fa-pinterest-p w3-hover-opacity"></i>
    <i class="fa fa-twitter w3-hover-opacity"></i>
    <i class="fa fa-linkedin w3-hover-opacity"></i>
  </div>
  <p>Made by <a href="https://github.com/domz-git" target="_blank" style="text-decoration: none;"class="w3-hover-text-green">Dominik Filipović</a></p>
</footer>
 
<script>
// Change style of navbar on scroll
window.onscroll = function() {myFunction()};
function myFunction() {
    var navbar = document.getElementById("myNavbar");
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        navbar.className = "w3-bar" + " w3-card" + " w3-animate-top" + " w3-white";
    } else {
        navbar.className = navbar.className.replace(" w3-card w3-animate-top w3-white", "");
    }
}

// Used to toggle the menu on small screens when clicking on the menu button
function toggleFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}


function myFunctionFilter() {
    var input, filter, cards, cardContainer, h4, title, i;
    input = document.getElementById("myFilter");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementById("myItems");
    cards = cardContainer.getElementsByClassName("card");
    for (i = 0; i < cards.length; i++) {
        title = cards[i].querySelector(".card_container");
        if (title.innerText.toUpperCase().indexOf(filter) > -1) {
            cards[i].style.display = "";
        } else {
            cards[i].style.display = "none";
        }
    }
}
function fu() {
  alert("Tvoja narudžba je zaprimljena!\n\nOčekuj naš odgovor u kratkom roku.\n\nDo tad, sretno čitanje!");
}
</script>
<!-- </body> -->
</body>
</html>
