<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Style-Type" content="text/css" /> 
    <title>Admin Users</title>
      <link rel="stylesheet" type="text/css" href="css/style2.css">
  </head>
  <body>
      <a href="landing.php" id="homelink" class="link">Home</a>
    <a href = "found.php" id="foundlink" class="link"> Found Something?</a>
    <a href = "lost.php" id="lostlink" class="link"> Lost Something?</a>
    <a href = "adminlogin.php" id="adminlink" class="link"> Admin Page</a>
    <a href = "quicklinks.php" id="quicklink" class="link"> Quick View</a>
      
    <br>
    <h1>Admin Users</h1>
      
    <form action="adminusers.php" method="POST">
          
        <?php
          //Connect to the database and retrieve the helping php functions from separate files
          require('includes/connect_db.php');
          require('includes/helpers.php');
        
          //Get the admins in the database
          $query = 'SELECT user_name, email, pass, reg_date FROM users' ;
          $results = mysqli_query( $dbc , $query ) ;
	      check_results($results) ;
        
          //Create a table of the admins if the data retrieval was successful
          if( $results )
	      {
            echo '<TABLE border=\"1\">';
            echo '<TR>';
            echo '<TH>User Name</TH>';
            echo '<TH>Email</TH>';
            echo '<TH>Password</TH>';
            echo '<TH>Registration Date</TH>';
            echo '<TH>Purge</TH>';
            echo '</TR>';

  		    # For each row result, generate a table row
            while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) ){
              $username = 'user' . htmlspecialchars($row['user_name']);
              $purgename = 'purge' . htmlspecialchars($row['user_name']);
              $email = 'email' . htmlspecialchars($row['user_name']);
              $password = 'pass' . htmlspecialchars($row['user_name']);
            
              
    		  echo '<TR>' ;
              echo '<TD> <input type="text" id="username" name=' . $username .' value= '. htmlspecialchars($row['user_name']) .'> </TD>' ;
              echo '<TD> <input type="text" id="email" name=' . $email .' value= '. htmlspecialchars($row['email']) .'> </TD>' ;
              echo '<TD> <input type="password" id="pass" name=' . $password .' value="unchanged"> </TD>' ;
              echo '<TD>' . $row['reg_date'] . '</TD>' ;
              echo '<TD> <input type="checkbox" id="purge" name=' . $purgename .' value="purge"> </TD>' ;
    		  echo '</TR>' ;
  		    }

  		    # End the table
  		    echo '</TABLE>';
           

  		    # Free up the results in memory
  		    mysqli_free_result( $results ) ;
	      }
          
          //If there was any changes, update the users table in the database
          if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
                $query = 'SELECT user_name, email, pass, reg_date FROM users' ;

	           # Execute the query
	            $results = mysqli_query( $dbc , $query ) ;
                
                while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) ){
                    $username = $_POST["user" . htmlspecialchars($row['user_name'])];
                    $email = $_POST["email" . htmlspecialchars($row['user_name'])];
                    $pass = $_POST["pass" . htmlspecialchars($row['user_name'])];
                    $purge = $_POST["purge" . htmlspecialchars($row['user_name'])]; 
                    $userrow = $row['user_name'];
                    
                    //Updates the user name of the admin
                    $update = 'UPDATE users SET  user_name = "' .  $username . '" WHERE user_name = "' . $userrow . '"';
                    $result = mysqli_query( $dbc , $update ) ;
                    
                    //Updates the password of the admin
                    $update = 'UPDATE users SET  email = "' .  $email . '" WHERE user_name = "' . $userrow . '"';
                    $result = mysqli_query( $dbc , $update ) ;
                                    
                    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
                    
                    //unchanged is the default value. If the that password field has not been editted, then it does NOT update the password.
                    if( $pass <> 'unchanged'){
                        $update = 'UPDATE users SET  pass = "' .  $hash_pass . '" WHERE user_name = "' . $userrow . '"';
                        $result = mysqli_query( $dbc , $update ) ;
                        /*show_query($update); 
                        echo $result;*/
                    }
             
                    //If the purge box is checked, delete the admin from the table
                    if($purge == 'purge'){
                        $delete = 'DELETE FROM users WHERE user_name ="'. $row['user_name'] .'"';
                        mysqli_query( $dbc , $delete ) ; 
                        /*show_query($delete); */
                    }  
                    header("Refresh:0"); 
                 }
          }
          
        ?>
          
        <input class="update" type="submit" value='Update'>
          
          
      </form>
      
      <!-- Create a new admin -->
      <a class="submitnew" href='adminnew.php'>Create a new Admin</a>
      <br>
      <br>
      <!-- Return to the previous page -->
      <a class="submitnew" href='admininventory.php'>Return to inventory</a>
    </body>
</html>