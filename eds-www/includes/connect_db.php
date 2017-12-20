<?php 
# CONNECT TO MySQL DATABASE.


//Connects to Limbo db or shows error if it fails.
$dbc = @mysqli_connect ( 'localhost', 'root', '', 'limbo_db' )


OR die ( mysqli_connect_error() ) ;



mysqli_set_charset( $dbc, 'utf8' ) ;
