<?php
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "Odabrani medij nije slika. Provjeriti i pokušati ponovno.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Slika već postoji.";
  $uploadOk = 0;
}


// Allow certain file formats
if($imageFileType != "jpg") {
  echo "Samo .jpg je dozvoljen. Konvertiraj sliku u .jpg i pokušaj ponovno.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Došlo je do greške. Slike nije poslana. Pokušati ponovno.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    header('location: admin.php');
    
    

  } else {
    echo "Došlo je do greške. Slike nije poslana. Pokušati ponovno.";
  }
}
?>