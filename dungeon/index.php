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
        <link rel="stylesheet" type="text/css" href="styles/main.css">
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
                echo '<div class="top-bar-menu">User has canceled authentication!<span style="letter-spacing:14px; padding-left:14px;"> | </span><a href="'.$openid->authUrl().'">LOGIN</a></div>';
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
                    echo '<div class="top-bar-menu">Sorry, but the account <b>'.$email.'</b> is not allowed to be here :(<span style="letter-spacing:14px; padding-left:14px;"> | </span><a href="'.$openid->authUrl().'">LOGIN</a></div>';
                }
            }
            else 
            {
                echo '<div class="top-bar-menu">The user has not logged in.<span style="letter-spacing:14px; padding-left:14px;"> | </span><a href="'.$openid->authUrl().'">LOGIN</a></div>';
            }
        } 
        else 
        {
            echo '<div class="top-bar-menu"><a href="'.$openid->authUrl().'">LOGIN</a></div>';
        }
    }
    if (isset($_SESSION['user'])) 
    {
        // user logged in
        $data = $_SESSION['user'];//$openid->getAttributes();
        $email = $data['contact/email'];
        $first = $data['namePerson/first'];
?>
                    <div class="top-bar-menu">
                        <a href="http://www.tupajar.com/index.php?menu=1">MIS PARTIDAS</a>
                        <span style="letter-spacing:14px; padding-left:14px;"> |</span>
                        <a href="http://www.tupajar.com/index.php?menu=2">CREAR PARTIDA</a>
                        <span style="letter-spacing:14px; padding-left:14px;"> |</span>
                        <a href="http://www.tupajar.com/index.php?menu=3">TIRAR DADOS</a>
                    
                        <div class="top-bar-login">
                            <span>
<?php
        echo 'Bienvenido '.$first.' ';
        //echo "<a href='http://www.tupajar.com/index.php?logout'>LOGOUT</a>";
?>
                             :)</span>
                            <span style="letter-spacing:14px; padding-left:14px;"> |</span>
                            <a href='http://www.tupajar.com/index.php?logout'>LOGOUT</a>
                        </div>
                    </div>
<?php
    }
?>
        </div>

        <div class="content">

<?php
    if (isset($_SESSION['user']))
    {
        if (isset($_GET['menu']))
        {
            switch($_GET['menu'])
            {
                case 1:
                    include("menus/mis-partidas.php");
                break;
                case 2:
                    include("menus/crear-partida.php");
                break;
                case 3:
                    include("menus/tirar-dados.php");
                break;
                default:
                    include("menus/default.php");
                break;
            }
        }
        else
        {
            include("menus/default.php");
        }
    }
?>
        </div>

    </body>

</html>