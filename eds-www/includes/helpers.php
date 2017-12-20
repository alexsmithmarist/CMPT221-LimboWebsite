<?php
$debug = true;

#Lab Partners: Alex Smith and John Litts


# Shows the query as a debugging aid
function show_query($query) {
  global $debug;

  if($debug)
    echo "<p>Query = $query</p>" ;
}

# Checks the query results as a debugging aid
function check_results($results) {
  global $dbc;

  if($results != true)
    echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>'  ;
}

//Validates numbers.
function valid_number($num) {   
    if(empty($num) || !is_numeric($num)){
    return false ;   
    }
    else {
        $num = intval($num) ;      
        if($num <= 0){     
            return false ;
        }
    }
     return true ;
}
//Validates names and text.
function valid_name($fname) {
    if(empty($fname)){
        return false;
    }
    return true;
}


//Displays the full information for an item when clicked.
function show_fullrecord($dbc, $itemname) {
	       # Create a query to get the id, num, fname, and lname sorted by num descending
	       $query = 'SELECT stuff.item_name, stuff.create_date, locations.name, stuff.description, stuff.contact_fname, stuff.contact_lname, stuff.contact_phone, stuff.item_status, stuff.photo_link 
           FROM stuff, locations 
           WHERE stuff.item_name = "' . $itemname . '"
           AND locations.id = stuff.location_id' ;

	       # Execute the query
	       $results = mysqli_query( $dbc , $query ) ;
           //show_query($query);
           check_results($results) ;
	       # Show results
	       if( $results )
	       {
  		    # But...wait until we know the query succeed before
  		    # rendering the table start.
  		
            echo '<TABLE border=\"1\">';
            echo '<TR>';
            echo '<TH>Item Name</TH>';
            echo '<TH>Date / Time</TH>';
            echo '<TH>Location</TH>';
            echo '<TH>Description</TH>';
            echo '<TH>Contact First Name</TH>';
            echo '<TH>Contact Last Name</TH>';
            echo '<TH>Contact Phone Number</TH>';
            echo '<TH>Item Status</TH>';
            echo '<TH>Photo</TH>';
            echo '</TR>';

  		    # For each row result, generate a table row
  		    while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  		    {
    		  echo '<TR>' ;
    		  echo '<TD>' . $row['item_name'] . '</TD>' ;
              echo '<TD>' . $row['create_date'] . '</TD>' ;
    		  echo '<TD>' . $row['name'] . '</TD>' ;
              echo '<TD>' . $row['description'] . '</TD>' ;
              echo '<TD>' . $row['contact_fname'] . '</TD>' ;
              echo '<TD>' . $row['contact_lname'] . '</TD>' ;
              echo '<TD>' . $row['contact_phone'] . '</TD>' ;
              echo '<TD>' . $row['item_status'] . '</TD>' ;
              echo '<TD> <img src="' . $row['photo_link'] . '" height="200" width="200" Alt="No image!"></TD>' ;
    		  echo '</TR>' ;
  		    }

  		    # End the table
  		    echo '</TABLE>';
            echo '<br>';
            echo '<br>';

  		    # Free up the results in memory
  		    mysqli_free_result( $results ) ;
	       }
        }
?>

