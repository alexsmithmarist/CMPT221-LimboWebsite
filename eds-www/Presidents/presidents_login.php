
<!--
Lab Partners: Alex Smith and John Litts
-->

<!DOCTYPE html>
<html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    require( 'includes/connect_db.php' ) ;
    require( 'presidents_login_tools.php' ) ;
    
    
    
    list($check, $data) = validate($dbc, $_POST['lname']);
    if($check)
    {
        session_start();
        $_SESSION['lname'] = $data['lname'];
        $_SESSION['id'] = $data['id'];
        
        load('linkypresidents.php?id=' . $data['id']);
    }
    else 
    {
        $errors = $data;
        echo $errors[0];
    }
}


?>
    
<form action="presidents_login.php" method="POST">
    <p>Last Name:
        <input type='text' name='lname'value ='<?php if (isset( $_POST['lname']))
    echo $_POST['lname']; ?>'>
            </p>

    <p><input type="submit" ></p>
</form>
    

</html>