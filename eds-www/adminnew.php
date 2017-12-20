<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Style-Type" content="text/css" /> 
    <title>Create Admin User</title>
      <link rel="stylesheet" type="text/css" href="css/style2.css">
  </head>
  <body>
    <a href="landing.php" id="homelink" class="link">Home</a>
    <a href = "found.php" id="foundlink" class="link"> Found Something?</a>
    <a href = "lost.php" id="lostlink" class="link"> Lost Something?</a>
    <a href = "adminlogin.php" id="adminlink" class="link"> Admin Page</a>
    <a href = "quicklinks.php" id="quicklink" class="link"> Quick View</a>
      
      <br>
    <h1>Create an Admin</h1>
      
    <!-- Create the new admin form -->
    <form action="adminnew.php" id='admincreate' method='POST'>
        <p class="description"> Please fill out the fields below. </p>
        <p class="description">User Name*:</p> <input type="text" name="username" value ='<?php if (isset( $_POST['username']))
            echo $_POST['username']; ?>'><br><br>
        <p class="description">Email*:</p> <input type="text" name="email" value ='<?php if (isset( $_POST['email']))
            echo $_POST['email']; ?>'><br><br>
        <p class="description">Password*:</p> <input type="password" name="pass" value ='<?php if (isset( $_POST['pass']))
            echo $_POST['pass']; ?>'><br><br><br>
        <p>* fields are required.</p>
        <input class="update" type="submit" name='submit' value='Submit'>
    
    </form>
      
      <?php
        //Connect to the database and retrieve the login php functions from separate files
        require('includes/connect_db.php');
        require('includes/helpers.php');
        
        //Insert the new admin into the database
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
          $username = $_POST['username'];
          $email = $_POST['email'];
          $pass = $_POST['pass'];
          $date = date("Y-m-d H:i:s");
        
          //Check if the fields are empty
          if(!empty($username) and !empty($email) and !empty($pass)){
            
            //Hash the password before inserting it
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        
            //Insert into the users table
            $query ='INSERT INTO users (user_name, email, pass, reg_date)
            VALUES ("' . $username . '" , "' . $email . '" , "' . $hashed_pass . '" , "' . $date . '")';
            $result = mysqli_query($dbc,$query) ;
            show_query($query);
            header('Location: adminupdate.php'); 
          }
          //Give an error if all the fields are not filled in
          else{
            echo '<p style="color: blue; font-weight: bold">Please fill in the required fields!';
          }
       }
      
       //Set default values
       else if($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
          $username = '';
          $email = '';
          $pass = '';
       }
        
    ?> 