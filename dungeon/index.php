<?php // index.php
include("config.php");
require_once 'openid.php';
$openid = new LightOpenID("www.tupajar.com");

$openid->identity = 'https://www.google.com/accounts/o8/id';
$openid->required = array(
  'namePerson/first',
  'contact/email'
);
$openid->returnUrl = 'http://www.tupajar.com/index.php';

if (isset($_GET['logout']))
{
    session_start();
    session_destroy();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>DAIgeons &amp; DAIgons</title>
    </head>

    <body>
        <h1>DAIgeons &amp; DAIgons</h1>
        <div class="top-bar">
            <?php
                session_start();
                if(!isset($_SESSION['user'])) 
                {
                    // user not logged in
                    if ($openid->mode) 
                    {
                        if ($openid->mode == 'cancel') 
                        {
                            echo "User has canceled authentication!";
                        } 
                        elseif($openid->validate()) 
                        {
                            $data = $openid->getAttributes();
                            $email = $data['contact/email'];
                            if(in_array($email, $EMAILS))
                            {
                                session_start();
                                $_SESSION['user'] = $data;
                            }
                            else
                            {
                                echo "Sorry, but the account '".$email."' is not allowed to be here :(";
                            }
                        }
                        else 
                        {
                            echo "The user has not logged in";
                        }
                    } 
                    else 
                    {
                        echo '<a href="'.$openid->authUrl().'">Login</a>';
                    }
                }
                if (isset($_SESSION['user'])) 
                {
                    // user logged in
                    $data = $_SESSION['user'];//$openid->getAttributes();
                    $email = $data['contact/email'];
                    $first = $data['namePerson/first'];
                    echo "Bienvenido ".$first." :)";
                    echo "<a href='http://www.tupajar.com/index.php?logout'>Logout</a>";
                }
            ?>
        </div>
    </body>

</html>