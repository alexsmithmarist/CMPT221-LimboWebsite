<!DOCTYPE html>





<html>
  <head>
    <meta http-equiv="Content-Style-Type" content="text/css" /> 
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
  </head>
  <body>
    <a href="landing.php" id="homelink" class="link">Home</a>
    <a href = "found.php" id="foundlink" class="link"> Found Something?</a>
    <a href = "lost.php" id="lostlink" class="link"> Lost Something?</a>
    <a href = "adminlogin.php" id="adminlink" class="link"> Admin Page</a>
    <a href = "quicklinks.php" id="quicklink" class="link"> Quick View</a>
      
    <br>
    <h1 id="header">Welcome to Limbo!</h1>
    <p class="description">If you lost or found something, you're in luck: this is the place to report it.</p>
      
    <!-- Search boxes for the table. -->
    <form action="landing.php" method="POST">
      <p class="description">Search by keyword: <input type="text" name="search" placeholder="Search..." value ='<?php if (isset( $_POST['search']))
            echo $_POST['search']; ?>'>
      <p class="description">Search by location: <select name="location" >
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
        <option value=35 selected>Any Location</option>
      </select> <br>
        
      <input class="update" type="submit" value="Update Search"> 
    </form>
      
    <br>
    <?php
        //Connect to the database and retrieve the helping php functions from separate files
        require('includes/connect_db.php');
        require('includes/helpers.php');
      
        //If an item name is clicked on, get the full information for that item (show_fullrecord is in helpers.php)
        if($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
            if(isset($_GET['item_name'])) 
                show_fullrecord($dbc, $_GET['item_name']) ;
        }
    ?>
      
      
    <?php 
        //Gets the non-claimed items from the database.
        $query = 'SELECT create_date, item_status, item_name FROM stuff WHERE item_status <> "claimed" ORDER BY create_date DESC' ;
      
        //If the search function is used, change the query that retrieves from the database.
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $search = $_POST['search'];
          $loc = $_POST['location'];
          
          //If nothing input into the search... 
          if(empty($search))
          {
              //Loc 35 is Any Location, the default selection. If this isn't changed, it retrieves all locations
              if($loc == 35)
              {
                  $query = 'SELECT create_date, item_status, item_name FROM stuff ORDER BY create_date DESC' ;
              }
              else
              {
                  $query = 'SELECT create_date, item_status, item_name FROM stuff WHERE location_id = ' . $loc . ' ORDER BY create_date DESC' ;
              }
          }
            
          //If the search has an input, search for an item with input in the name
          else{
              if($loc == 35){
              $query = 'SELECT create_date, item_status, item_name FROM stuff WHERE item_name LIKE "%' . trim($search) . '%" ORDER BY create_date DESC' ;
              }
              else{
                  $query = 'SELECT create_date, item_status, item_name FROM stuff WHERE item_name LIKE "%' . trim($search) . '%" AND location_id = ' . $loc . ' ORDER BY create_date DESC' ;
              }
          }
        }

	    # Execute the query
	    $results = mysqli_query( $dbc , $query ) ;
	    check_results($results) ;

        //Create the table based on the query
	    if( $results )
	    {
          echo '<TABLE border=\"1\">';
          echo '<TR>';
          echo '<TH>Date / Time</TH>';
          echo '<TH>Status</TH>';
          echo '<TH>Stuff</TH>';
          echo '</TR>';

  		  # For each row result, generate a table row
  		  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  		  {
            $alink = '<A HREF=landing.php?item_name=' . $row['item_name']  . '>' . $row['item_name'] . '</A>' ;
    		echo '<TR>' ;
    		echo '<TD>' . $row['create_date'] . '</TD>' ;
    		echo '<TD>' . $row['item_status'] . '</TD>' ;
            echo '<TD id="links">' . $alink . '</TD>' ;
    		echo '</TR>' ;
  		  }

  		# End the table
  		echo '</TABLE>';

  		# Free up the results in memory
  		mysqli_free_result( $results ) ;
	   }
       ?>
      
    
    
    
    </body>
</html>