<!DOCTYPE html>
<html>


  <header>
    <title> Lost Item Form</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
  </header>

  <body>
    <a href="landing.php" id="homelink" class="link">Home</a>
    <a href = "found.php" id="foundlink" class="link"> Found Something?</a>
    <a href = "lost.php" id="lostlink" class="link"> Lost Something?</a>
    <a href = "adminlogin.php" id="adminlink" class="link"> Admin Page</a>
    <a href = "quicklinks.php" id="quicklink" class="link"> Quick View</a>
    
    
    <h1> Lost Item Form </h1>
    <p class="description"> If you have lost an item, please fill out the form below. </p>

    
    <?php
      //Connect to the database and retrieve the helping php functions from separate files
      require('includes/connect_db.php');
      require('includes/helpers.php');
      
      if ($_SERVER['REQUEST_METHOD'] == 'POST')
      {
        $itemname = $_POST['itemname'];
        $location = $_POST['location'];
        $descr = $_POST['descr'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phonenum = $_POST['phonenum'];
        $date = date("Y-m-d H:i:s");
        $uploadOk = 0;
        
        //check if the required fields are empty and output an error if they are
        if(!empty($itemname) and !empty($location) and !empty($descr) and !empty($fname) and !empty($lname) and !empty($phonenum)){
        
        //Upload an image   
        if(!empty($_FILES["fileToUpload"]["name"])){
            
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            
            //Check if the file is an image.
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "<p class='description'>File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } 
            else {
                echo "<p class='description'>File is not an image.";
                $uploadOk = 0;
            }
            
            //Check if an image of the same name has already been uploaded.
            if (file_exists($target_file)) {
                echo "<p class='description'>Sorry, file already exists.";
                $uploadOk = 0;
            }
            
            //Check if the image size is too big
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "<p class='description'>Sorry, your file is too large.";
                $uploadOk = 0;
            }
            
            //Check if it is one of the allowed image types
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
               && $imageFileType != "gif" ) {
                    echo "<p class='description'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
            }
            
            if ($uploadOk == 0) {
                echo "<p class='description'>Sorry, your file was not uploaded.";
            } 
            
            //If there are no erros, upload the image.
            else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "<p class='description'>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } 
                else {
                    echo "<p class='description'>Sorry, there was an error uploading your file.";
                }
            }
        }
        
            //if there was an image upload, put the photo link in the database along with the other information.
            echo $uploadOk;
            if($uploadOk == 1){
            $query ='INSERT INTO stuff (item_name, location_id, description, contact_fname, contact_lname, contact_email, contact_phone, item_status, create_date, photo_link)
            VALUES ("' . $itemname . '" , "' . $location . '" , "' . $descr . '" , "' . $fname . '" , "' . $lname . '" , "' . $email . '" , "' . $phonenum . '" , "lost" , "' . $date . '" , "' . $target_file . '")';
            //show_query($query);
            $result = mysqli_query($dbc,$query) ;
            //check_results($result) ;
             header('Location: lostupdate.php'); 
            }
            else{
                $query ='INSERT INTO stuff (item_name, location_id, description, contact_fname, contact_lname, contact_email, contact_phone, item_status, create_date)
                VALUES ("' . $itemname . '" , "' . $location . '" , "' . $descr . '" , "' . $fname . '" , "' . $lname . '" , "' . $email . '" , "' . $phonenum . '" , "lost" , "' . $date . '")';
            //show_query($query);
            $result = mysqli_query($dbc,$query) ;
            //check_results($result) ;
             header('Location: lostupdate.php'); 
            }
            

        }
        //Warn the user there are unfilled required fields
        else{
            echo '<p style="color: blue; font-weight: bold">Please fill in the required fields!';
        }
    }
      
    //If it is a get method, set default values
    else if($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
        $itemname = '';
        $location = '';
        $descr = '';
        $fname = '';
        $lname = '';
        $email = '';
        $phonenum = '';
        $photo = 'none';
        }
        
    ?> 

    <!-- Create the item form -->
    <form action="lostform.php" id='lostsubmit' method='POST' enctype="multipart/form-data">
        <p class="description">Item name* (try to make this very general, for example: Iphone, Laptop, etc.):
    <input type="text" name="itemname" value ='<?php if (isset( $_POST['itemname']))
            echo $_POST['itemname']; ?>'><br><br>
        <p class="description">Location Lost*:
    <select name="location">
      <option value=1>Foy Townhouses</option>
      <option value=2>New Gartland</option>
      <option value=3>Byrne House</option>
      <option value=4>Library</option>
      <option value=5>Champagnat Hall</option>
      <option value=6>Chapel</option>
      <option value=7>Cornell Boathouse</option>
      <option value=8>Donnelly Hall</option>
      <option value=9>Dyson Center</option>
      <option value=10>Fern Tor</option>
      <option value=11>Fontaine Hall</option>
      <option value=12>Upper Fulton Street Townhouses</option>
      <option value=13>Greystone Hall</option>
      <option value=14>Hancock Center</option>
      <option value=15>Kieran Gatehouse</option>
      <option value=16>Kirk House</option>
      <option value=17>Leo Hall</option>
      <option value=18>Longview Park</option>
      <option value=19>Lowell Thomas Communications Center</option>
      <option value=20>Lower Townhouses</option>
      <option value=21>Marian Hall</option>
      <option value=22>North Campus Housing Complex</option>
      <option value=23>MidRise Hall</option>
      <option value=24>Marist Boathouse</option>
      <option value=25>McCann Center</option>
      <option value=26>St. Ann\'s Hermitage</option>
      <option value=27>St. Peter\'s</option>
      <option value=28>Science and Allied Health Building</option>
      <option value=29>Sheehan Hall</option>
      <option value=30>Steel Plant Studios and Gallery</option>
      <option value=31>Student Center/ Music Building</option>
      <option value=32>Lower West Cedar Townhouses</option>
      <option value=33>Upper West Cedar Townhouses</option>
      <option value=34>Lower Fulton Street Townhouses</option>
    </select>  <br> <br>
        <p class="description">Description (be specific about what you lost)*:</p>
    <textarea rows='4' cols='50' form_id='loginsubmit' name='descr' value ='<?php if (isset( $_POST['descr']))
            echo $_POST['descr']; ?>'></textarea><br><br>
        
        <p class="description">Select image to upload (Image must be jpg, png, or gif. Please the image 'LastnameItemname'):
    <input class="update" type="file" name="fileToUpload" id="fileToUpload" value="none">
   
    <p class="description">Please enter your contact information.</p> 
        <p class="description">First Name*: <input type="text" name="fname" value ='<?php if (isset( $_POST['fname']))
            echo $_POST['fname']; ?>'><br><br>
        <p class="description">Last Name*: <input type="text" name="lname" value ='<?php if (isset( $_POST['lname']))
            echo $_POST['lname']; ?>'><br><br>
        <p class="description">Email: <input type="text" name="email" value ='<?php if (isset( $_POST['email']))
            echo $_POST['email']; ?>'><br><br>
        <p class="description"> Phone Number*: <input type="text" name="phonenum" value ='<?php if (isset( $_POST['phonenum']))
            echo $_POST['phonenum']; ?>'><br><br><br>
    <p>* fields are required.</p>
    
    <input class="update" type="submit" name='submit' value='Submit'>
    
</form>

 
</body>

</html>