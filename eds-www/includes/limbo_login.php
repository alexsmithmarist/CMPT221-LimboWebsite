<?php 

//Upon successful login, load the admin page for the user
function load($page = 'adminlogin.php')
{
    
    header("Location: " . $page);
    exit();
}

//Validate the password and username
function validate ($dbc, $uname = '', $pass = '')
{
    $hashed_pw = password_hash($pass, PASSWORD_DEFAULT);
    
    $errors = array() ;
    //Make sure the username is filled in
    if( empty ($uname))
    {$errors[] = 'Enter a valid User Name.' ; }
    
    //Make sure the password is filled in
    if( empty ($pass))
    {$errors[] = 'Enter a valid Password.' ; }
    
    
    //If there are no previous errors, check the users table for matches
    if (empty($errors))
    {
        $query = "SELECT pass, user_name FROM users";
        $result = mysqli_query($dbc, $query);
        while ($hashrow = mysqli_fetch_array($result, MYSQLI_ASSOC))
            //If there is a password in the database that matches the inputted password, check the username
            if (password_verify($pass, $hashrow['pass']))
            {
                //if the username is associated with the password, return login success.
                $dbuser = $hashrow['user_name'];
                if($dbuser == $uname)
                {
                    $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
                    return array(true , $row) ;
                }
            
            }
    
    return array( false , $errors);
    }
}



?>