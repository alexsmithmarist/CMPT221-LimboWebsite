<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Style-Type" content="text/css" /> 
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
  </head>
  <body>
        <a href="landing.php" id="homelink" class="link">Home</a>
        <a href = "found.php" id="foundlink" class="link"> Found Something?</a>
        <a href = "lost.php" id="lostlink" class="link"> Lost Something?</a>
        <a href = "adminlogin.php" id="adminlink" class="link"> Admin Page</a>
        <a href = "quicklinks.php" id="quicklink" class="link"> Quick View</a>
      <br>
      <h1>Admin Login</h1>
      
      <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //Connect to the database and retrieve the login php functions from separate files
            require( 'includes/connect_db.php' ) ;
            require( 'includes/limbo_login.php' ) ;
            
            //Check if the username is empty
            if(empty($_POST['username']))
            {
                echo '<p style="color: blue; font-weight: bold">Please enter a Username!';
            }
                
            //Check if the password is empty
            if(empty($_POST['pw']))
            {
                echo '<p style="color: blue; font-weight: bold">Please enter a Password!';
            }
                
            if(!empty($_POST['pw'] and !empty($_POST['username'])))
            {
                //Check the database for the username and password combination
                list($check, $data) = validate($dbc, $_POST['username'], $_POST['pw']);
                if($check)
                {
                     session_start();
                     $_SESSION['username'] = $data['username'];
                     $_SESSION['pw'] = $data['pw'];
        
                     load('admininventory.php');
                }
                else 
                {
                    echo '<p style="color: blue; font-weight: bold">Username and Password combination not found.</p>';
                }
             }
         }
      ?>
      
      <form action="adminlogin.php" method="POST">
          <p class="description">User Name:
            <input type='text' name='username'
           value ='<?php if (isset( $_POST['username']))
            echo $_POST['username']; ?>'> </p>
          
          <p class="description">Password:
            <input type='password' name='pw'
           value ='<?php if (isset( $_POST['pw']))
            echo $_POST['pw']; ?>'> </p>
          
          <p><input class="update" type="submit" value="Login" ></p>
          <br>
          <br>
          
          <!-- Contact an admin to change item information -->
          <p>Contact an admin:      admin@gmail.com</p>
       </form>
   </body>
</html>
          