<!--
Lab Partners: Alex Smith and John Litts
-->

<?php 

function load($page = 'presidents_login.php')
{
    
    header("Location: " . $page);
    exit();
}

function validate ($dbc, $lname = '')
{
    $errors = array() ;
    if( empty ($lname))
    {$errors[] = 'Enter a valid Last Name.' ; }
    
    
    if (empty($errors))
    {
        $q = "SELECT lname, id
              FROM presidents
              WHERE lname = '$lname'";
        $r = mysqli_query ($dbc, $q);
        if (mysqli_num_rows ($r) == 1)
        {
            $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
            return array(true , $row) ;
        }
        else
        {$errors[] = 'President Last Name not found.' ;}
    }
    return array( false , $errors);
}



?>