<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Style-Type" content="text/css" /> 
    <title>Admin View</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
  </head>
  <body>
    <a href="landing.php" id="homelink" class="link">Home</a>
    <a href = "found.php" id="foundlink" class="link"> Found Something?</a>
    <a href = "lost.php" id="lostlink" class="link"> Lost Something?</a>
    <a href = "adminlogin.php" id="adminlink" class="link"> Admin Page</a>
    <a href = "quicklinks.php" id="quicklink" class="link"> Quick View</a>
      
    <br>
    <h1>Admin Inventory</h1>
      
    <br>
      
    <form action="admininventory.php" method="POST">
          
        <?php
        //Connect to the database and retrieve the helping php functions from separate files
        require('includes/connect_db.php');
        require('includes/helpers.php');
        
        //If an item name is clicked on, get the full information for that item (show_fullrecord is in helpers.php)
        if($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
            if(isset($_GET['item_name'])) 
                show_fullrecord($dbc, $_GET['item_name']) ;
        }
        
        //Get the information from the database to create the table
        $query = 'SELECT create_date, item_status, item_name FROM stuff ORDER BY create_date DESC' ;
	    $results = mysqli_query( $dbc , $query ) ;
	    check_results($results) ;
        
        //Update status or delete and item
        if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
            $query = 'SELECT create_date, item_status, item_name FROM stuff' ;
	        $results = mysqli_query( $dbc , $query ) ;
                
            while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) ){
                    $status = $_POST["status" . htmlspecialchars($row['item_name'])];
                    $purge = $_POST["purge" . htmlspecialchars($row['item_name'])]; 
                    $itemrow = $row['item_name'];
                    
                    //Updates all of the items in the table, even if they have not been changed
                    $update = 'UPDATE stuff SET  item_status = "' .  $status . '" WHERE item_name = "' . $itemrow . '"';
                    /*show_query($update); */
                    $result = mysqli_query( $dbc , $update ) ;
                
                    //Deletes items if the checkbox is checked, setting the value to 'purge'
                    if($purge == 'purge'){
                        $delete = 'DELETE FROM stuff WHERE item_name ="'. $row['item_name'] .'"';
                        mysqli_query( $dbc , $delete ) ; 
                        /*show_query($delete); */
                    }  
            }
            header("Refresh:0");
        }
          
       //If the query successfully gets data from the database, create the table.
	   if( $results )
	   {
        echo '<TABLE border=\"1\">';
        echo '<TR>';
        echo '<TH>Date / Time</TH>';
        echo '<TH>Status</TH>';
        echo '<TH>Stuff</TH>';
        echo '<TH>Purge</TH>';
        echo '</TR>';

  		//For each row result, generate a table row
        while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) ){
            $purgename = 'purge' . htmlspecialchars($row['item_name']);
            $statusname = 'status' . htmlspecialchars($row['item_name']);
            $selected = htmlspecialchars($row['item_status']);
            
            $alink = '<A HREF=admininventory.php?item_name=' . $row['item_name']  . '>' . $row['item_name'] . '</A>' ;
    		echo '<TR>' ;
    		echo '<TD>' . $row['create_date'] . '</TD>' ;
            //The selected attribute is echoed on the status taken from the database
            echo '<TD> <select name=' . $statusname .'> 
                    <option value="lost" ';  if($selected == "lost"){echo("selected");} echo'>Lost</option>
                    <option value="found" '; if($selected == "found"){echo("selected");} echo'>Found</option>
                    <option value="claimed" '; if($selected == "claimed"){echo("selected");} echo'>Claimed</option>
                    </select>
                   </TD>';
            echo '<TD>' . $alink . '</TD>' ;
            echo '<TD> <input type="checkbox" id="purge" name=' . $purgename .' value="purge"> </TD>' ;
    		echo '</TR>' ;
  		}

  		# End the table
  		echo '</TABLE>';
           

  		# Free up the results in memory
  		mysqli_free_result( $results ) ;
	   }
       

    
        ?>
      
    
      <input class="update" type="submit" value='Update'>
          
          
      </form>
      
      <!-- Goes to admin user page -->
      <a class="submitnew" href='adminusers.php'>View Admin Users</a>
      
    
    
    </body>
</html>