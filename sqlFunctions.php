
<?php
class sql_query{


// define $connection;    
//$connection = mysqli_connect('localhost','root','','cms');

function cone($query,$connection){
    $posts = mysqli_query($connection, $query);
    return $posts;
}
function checkerror($connection){
    die('Database error: ' . mysqli_error($connection));
}
function sql_userauth(){
    

}
}
?>