<?php 

include ('config.php');


$name = "";
$email = "";
$number = "";
$message = "";
$errorMessage = "";
if (isset($_GET['$error'])) {
    $errorMessage = $_GET['$error'];
}

if(isset($_SESSION['customer']))
{

if (isset($_POST['Send'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number =  $_POST['phone'];
    $message = $_POST['message'];
    $userId = $_SESSION['customerid'];
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['message'])) {
        $errorMessage .= "*Please fillup all the fields!";
    } elseif (strlen($number) != 11 or $number[0] != '0' or $number[1] != '1') {
        $errorMessage .= "*Invalid phone number!<br>";
    }
    if ($errorMessage == "") {
        $quer = "INSERT INTO support(userid,name,email,phone,message) VALUES('$userid','$name','$email','$number','$message')";
          $result = mysqli_query($conn, $quer);

      
    
        if ($result) {
            header("Location:index.php");
            die;
        }
    }
}
}

?>















<?php
  
    include 'config.php';
    $msg = "";

    if (isset($_GET['verification'])) {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM usering WHERE code='{$_GET['verification']}'")) > 0) {
            $query = mysqli_query($conn, "UPDATE usering SET code='' WHERE code='{$_GET['verification']}'");
            
            if ($query) {
                $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
            }
        } else {
            header("Location: signin.php");
        }
    }

    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $sql = "SELECT * FROM usering WHERE email='{$email}' AND password='{$password}'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (empty($row['code'])) {
                $_SESSION['SESSION_EMAIL'] = $email;
                header("Location: form.php");
            } else {
                $msg = "<div class='alert alert-info'>First verify your account and try again.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
        }
    }
?>

<?php
$error='';




  
 include 'config.php';
 use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
                      //Load Composer's autoloader
require 'vendor/autoload.php';

function clean_text($string)
{
    $string=trim($string);
    $string=stripcslashes($string);
    $string=htmlspecialchars($string);
    return $string;


}

if(isset($_POST['submit1']))
{
  if(empty($_POST["name"]))
    {
         $error = "<div class='alert alert-danger'>{$name} - Please Enter Your Name.</div>";

    }
    else
    {
        $name=clean_text($_POST["name"]);
        if(!preg_match("/^[a-zA-Z]*$/",$name))
        {
                 $error = "<div class='alert alert-danger'> Please Enter Your Name.</div>";
        }

    }
    
     if(empty($_POST["email"]))
    {
        $error .='<p><label class="text-danger">Please Enter Email No.</label></p>';

    }
    else
    {
        $email=clean_text($_POST["email"]);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
                $error .='<p><label class="text-danger">Invalid Email Format</label></p>';
        }

    }
       if(empty($_POST["password"]))
    {
        $error = "<div class='alert alert-danger'> Please Enter Your Email.</div>";

    }
    else
    {
        $password=clean_text($_POST["password"]);
        if(!filter_var($password, 
  FILTER_VALIDATE_REGEXP,
  array( "options"=> array( "regexp" => "/.{6,25}/"))))
        {
              $error = "<div class='alert alert-danger'>Invalid Password</div>";


    }


    
    

}
if($error=='')
{



       $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
        $code = mysqli_real_escape_string($conn, md5(rand()));

        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM mainuser WHERE email='{$email}'")) > 0) {
            $error = "<div class='alert alert-danger'>{$email} - This email address has been already exists.</div>";
        } else {
            if ($password === $confirm_password) {
                $sql = "INSERT INTO mainuser (name, email, password, code) VALUES ('{$name}', '{$email}', '{$password}', '{$code}')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'fanfair7890@gmail.com';                     //SMTP username
                        $mail->Password   = 'kjnuxzofnrxxfxss';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('fanfair7890@gmail.com');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Welcome to fanfair';
                        $mail->Body    = 'Thank you for registering into FANFAIR.<b><a href="http://localhost/ADMIN/signin.php?verification='.$code.'">CLICK HERE</a></b>';
                         $error = "<div class='alert alert-info'>We've sent a verification link on your email address.</div>";
                        $mail->send();

                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div>";
                   
                } else {
                    $error = "<div class='alert alert-danger'>Something wrong went.</div>";
                }
            } else {
                $error = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
            }
        }

               
                 

                
                 } 



                   




    





    }








?>






<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Fan Based Website</title>
	<!-- CSS LINK -->
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/responsive.css">
  <link rel="stylesheet" type="text/js" href="JS/design.js">
	<!-- JAVASCRIPT LINK -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Clicker+Script&family=Josefin+Sans:wght@100&family=Merriweather:ital,wght@0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Oleo+Script+Swash+Caps:wght@400;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Signika+Negative:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/css/v4-shims.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body onload="slider()">

<!-- Navigation Bar -->

<div class="wrapper position-fixed">
    <nav>
      <input type="checkbox" id="show-search">
      <input type="checkbox" id="show-menu">
      <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>
      <div class="content">
      <div class="logo"><a href="#">FANFAIR</a></div>
        <ul class="links">
          <li><a href="#Home">Home</a></li>

          <li><a href="#Channels">Channels</a></li>
            


          <li><a href="#Tickets">Tickets</a></li>

          <li><a href="#Merch">Merch</a></li>

         

    
          
          
          <li>
            <a href="#" class="desktop-link">Settings</a>
            <input type="checkbox" id="show-features">
            <label for="show-features">Settings</label>
            <ul><div class="icons">
              <div class=".pp1 pop">
           <li><a href="mainusersignin.php"><i class="fas fa-edit" style="padding-right: 9px;"></i>Log in</a></li>
    
              <li><a href="mainusersignup.php"><i class="fas fa-edit" style="padding-right: 9px;"></i>Sign up</a></li>
              
               <li><a href="logout.php"><i class="fas fa-sign-out-alt" style="padding-right: 9px;"></i>Logout</a></li>
              </div>
            </ul>
          </li>
        </ul>
      </div>
     
    </nav>
  </div>

  <!-- Body Part -->

 <!-- Music button html -->
  <div class="music_button">
    <i class="fa fa-play play_button" aria-hidden="true"></i><input type="button" value="Play Music" onclick="playMusic()" />
  </div>
  <!-- Music button html -->

 <section id="Home"  class="main-section">

  <div class="banner">
    <div class="slider">
      <img src="Images/15.jpg" alt="" id="slideImg">
    </div>
    <div class="writting"><h5>EI OBELAY</h5>

    <button class="button_2"><i class="fa fa-bookmark" aria-hidden="true"></i>
    </button>
  <button><i class="fa fa-heart" aria-hidden="true"></i>
  </button>
  </div>

    </div>
  </div>

 </section>


<!--   <div class="tenor-gif-embed" data-postid="13404771" data-share-method="host" data-aspect-ratio="1" data-width="100%"></div><script type="text/javascript" async src="https://tenor.com/embed.js"></script> -->
<section id="Channels">
<div class="channel">
  <div class="containe">
     <h3 style="margin-left:315px"><strong>Popular Band Channels</strong></h3>
    <div class="channel-band" style="margin-left: 350px;">
      <ul class="list-channel">
       <li class="artist-item">
        <a class="HomeArtistListSlotView_artist_link__Mjm6r" href="artcell.php">
          <div class="artist-list-view">
            <div class="firstno1">
              <img src="Images/Channels/1.jpeg">
              
            </div>

            <div class="artistno-1">
              <div class="profile">
                <div class="logo2">
                  <div class="logo3">
                   
                   <img src="Images/Channels/logo1.jpg">

                    
                  </div>
                  
                </div>
              </div>
            </div>
            <div class="Home-artist">
              <strong class="artist-name">
                <div class="artist-contain">
                  <span>ARTCELL</span>

                </div>

              </strong>


            </div>
              

           
          </a>

        </li>
        <li class="artist-item">
        <a class="HomeArtistListSlotView_artist_link__Mjm6r" href="warfaze.php">
          <div class="artist-list-view">
            <div class="firstno1">
              <img src="Images/Channels/2.jpg">
              
            </div>

            <div class="artistno-1">
              <div class="profile">
                <div class="logo2">
                  <div class="logo3">
                   
                   <img src="Images/Channels/logo2.jpeg">

                    
                  </div>
                  
                </div>
              </div>
            </div>
            <div class="Home-artist">
              <strong class="artist-name">
                <div class="artist-contain">
                  <span>WARFAZE</span>

                </div>

              </strong>


            </div>
              

           
          </a>

        </li>
         <li class="artist-item">
          <a class="HomeArtistListSlotView_artist_link__Mjm6r" href="nemesis.php">
          <div class="artist-list-view">
            <div class="firstno1">
              <img src="Images/Channels/4.png">
              
            </div>
            <div class="artistno-1">
              <div class="profile">
                <div class="logo2">
                  <div class="logo3">
                    <img src="Images/Channels/logo4.png" >
                    
                  </div>
                  
                </div>
              </div>
            </div>
            <div class="Home-artist">
              <strong class="artist-name">
                <div class="artist-contain">
                  <span>NEMESIS</span>

                </div>

              </strong>


            </div>
              

           
          </a>

        </li>
        

        <div class="see"  >
         <a href="bandchannels.php" ><button style="margin-left: -406px;">SEE MORE<i class="fa fa-arrow-right more" aria-hidden="true"></i></button></a>
        </div>



        


      </ul>




    </div>


 </div>


  </div>


  

</section>

  







<!-- <div class="master_play">
  <div class="wave">
    <div class="wave1"></div>
    <div class="wave1"></div>
    <div class="wave1"></div>




  </div>
  <img src="Images/1.jpg">
  <h5>James Bond <br>
        <div class="subtitle">Alan Walker</div>
        

        </h5>
        <div class="icon">
          <i class="bi bi-skip-start-fill"></i>
          <i class="bi bi-play-fill"></i>
        <i class="bi bi-skip-end-fill"></i>

        </div>
        <span id="currentStart">0.00</span>
        <div class="bar">
          <input type="range" name="" id="seek" min="0" value="0" max="100"> 
          <div class="bar2" name="" id="bar2"></div>
          <div class="dot"></div>
        </div>
        <span id="currentEnd">0.00</span>
        <div class="vol">
          <i class="bi bi-volume-down-fill"></i>
          <input type="range" name="" id="vol" min="0" value="30" max="100"> 
          <div class="vol_bar"></div>
          <div class="dot" id="vol_dot"></div>
        </div>
    </div>
 -->

  




<!-- Top Singer Start -->
<!-- <div class="section bg-transparent topmargin-sm mb-0 clearfix">
  <div class="singer_heading">
  <h3 style="line-height: 2;" class="nott">Top Singers on list</h3>
  
  </div>
  <div class="singer-wrap clearfix">
  <a href="#" class="singer-bb-image big" style="background-image: url('Images/Top/artcell.png');"><span>George Lincoln D'Costa</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/minerva.jpg'); top: 0px; left: 3%;"><span>Istiak Tanvir Ishmi</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/nemesis.jpg'); top: 43%; margin-left: -49%;"><span>Zohad Reza Chowdhury</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/warfaze.jpg'); top: 34%; margin-left: -38%;"><span>Mizan</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/imagesg.jpg'); top: 0; margin-left: -33%;"><span>Arnob</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/imagesgg.jpg'); top: 0; margin-left: -20%;"><span>James</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/imagesh.jpg'); top: auto; bottom: 0%; margin-left: -42%;"><span>Shafin Ahmed</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/imagesjj.jpg'); top: 34%; margin-left: -27%;"><span>Minar</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/tahsan.jpg'); top: auto; bottom: 0; margin-left: -31%;"><span>Tahsan</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/habib.jpg'); top: auto; bottom: 5%; margin-left: -21%;"><span>Habib</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/hridoy.jpg'); top: 0px; left: auto; right: 4%;"><span>Hridoy</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/imran.jpg'); top: 44%; margin-left: 41%;"><span>Imran</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/nancy.jpg'); top: 32%; margin-left: 30%;"><span>Nancy</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/bappa.jpg'); top: auto; bottom: 2%; margin-left: 34%;"><span>Bappa Mazumder</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/porshi.jpg'); top: 1%; margin-left: 26%;"><span>Porshi</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/andrew.jpg'); top: 4%; margin-left: 14%;"><span>Andrew Kishore</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/runa.jpg'); top: auto; bottom: 0; margin-left: 23%;"><span>Runa layla</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/tuhin.jpg'); top: auto; bottom: 36%; margin-left: 19%;"><span>Tuhin</span></a>
  <a href="#" class="singer-bb-image" style="background-image: url('Images/Top/asif.jpg'); top: auto; bottom: 0; margin-left: 12.5%;"><span>Asif</span></a>
  </div>
  </div>


  <!-- Ticket Selling -->

<section id="Tickets" class="movie-ticket" style="          margin-top: -199px;
}margin-bottom: -289px;">
  <!-- <div class="movie-image">

    
  </div> -->
  
  <div class="ticket-flex">
   
  <h2>PICK YOUR VENUE!</h2>
 <?php

                    $sql = "SELECT * FROM ticket";
if(isset($_GET['id'])){
    $ticketID = $_GET['id'];
    $sql .= " WHERE ticket_id = '$ticketID'";
}

//$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql); 
while($row = mysqli_fetch_assoc($result)) {
// echo $row['id'] ." ". $row['name'] ." ". $row['image'] ." ". $row['price']."<br>";
?>


  
  <div class="ticket-display">
   <div class="ticket-header">
      
       <div class="date-ticket">
          <h6><?php echo  $row["ticket_name"] ?></h6>
        </div>
        <div class="date-ticket">
          <h6><?php echo  $row["ticket_date"] ?></h6>
        </div>
        <div class="stadium-ticket">
          <h6><?php echo  $row["ticket_venue"] ?></h6>
        </div>
         <div class="stadium-ticket">
          <h6><?php echo  $row["ticket_price"] ?></h6>
        </div>
        <div>
          <button class="ticket-button" style="vertical-align:middle"><span> Buy Tickets </span></button>
        </div>
        
      
    </div>
     
  </div>
     <?php
                      }
                  
                  
                  ?>
  
</div>
  

<div  class="movie-button"><a href="ticket.php">
         <button>SEE ALL EVENTS<i class="fa fa-arrow-right more" aria-hidden="true"></i></button></a>
        </div>



</section>




  
<section class="balu" style="    margin-top: -289px;">
  
  

<!-- Hot Track Start -->
<div class="row g-0 hot_track" style="padding-top: 48px;">
  <div class="col-lg-6">
  <div class="heading-block border-0 dark" style="margin-bottom: 15px;">
  <h3>Hot Tracks</h3>
 
  </div>
  
  <div class="songs-lists-wrap">
  <?php

                    $sql = "SELECT * FROM songs";
if(isset($_GET['id'])){
    $songID = $_GET['id'];
    $sql .= " WHERE song_id = '$songID'";
}

//$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql); 
while($row = mysqli_fetch_assoc($result)) {
// echo $row['id'] ." ". $row['name'] ." ". $row['image'] ." ". $row['price']."<br>";
?>
  <div class="songs-list">
  <div class="songs-number col-auto"><?php echo  $row["song_id"] ?></div>
  <div class="songs-image track-image col-auto">
  <a href="<?php echo  $row["song_link"] ?>" class="track-list" data-track="" data-poster="demos/music/tracks/poster-images/ibelieveinyou.jpg" data-title="i Believe In You" data-singer="Lost European">
  <img src="Images/channels4_profile.jpg" alt="Image 1"><span><i class="icon-play"></i></span>
  </a>
  </div>
  <div class="songs-name track-name flex-grow-1 col-auto"><a href="#"><?php echo  $row["song_name"] ?><br><span><?php echo  $row["song_band"] ?></span></a></div>
  <div class="songs-time col-auto"><?php echo  $row["song_time"] ?>/div>
  
  </div>
   
 
  </div>
  <?php
                      }
                  
                  
                  ?>
  </div>
</div>

  <div class="w-100 d-block d-md-block d-lg-none topmargin-lg clear"></div>
  <div class="col-lg-6 hot_track_right">
  <div class="heading-block border-0 dark" style="margin-bottom: 15px;">
  <h3>Latest Tracks</h3>
  
  </div>
  <div class="songs-lists-wrap">
  
  <div class="songs-list">
  <div class="songs-number col-auto">01</div>
  <div class="songs-image track-image col-auto">
  <a href="#" class="track-list" data-track="demos/music/tracks/searchin-lost-european.mp3" data-poster="demos/music/tracks/poster-images/searchin-lost-european.jpg" data-title="Searchin Lost European" data-singer="Lost European">
  <img src="Images/channels4_profile.jpg" alt="Image 1"><span><i class="icon-play"></i></span>
  </div>
  <div class="songs-name track-name flex-grow-1 col-auto"><a href="#">Ei Obelay<br><span>Shironamhin</span></a></div>
  <div class="songs-time col-auto">02:54</div>
  
  </div>
  
  <div class="songs-list">
  <div class="songs-number col-auto">02</div>
  <div class="songs-image track-image col-auto">
  <a href="#" class="track-list" data-track="demos/music/tracks/fallin-extended-mix.mp3" data-poster="demos/music/tracks/poster-images/fallin-extended-mix.jpg" data-title="Fallin Extended Mix" data-singer="Justin">
  <img src="Images/channels4_profile.jpg" alt="Image 1"><span><i class="icon-play"></i></span>
  </div>
  <div class="songs-name track-name flex-grow-1 col-auto"><a href="#">Hashimukh<br><span>Shironamhin</span></a></div>
  <div class="songs-time col-auto">03:21</div>
 
  </div>
  
   <div class="songs-list">
  <div class="songs-number col-auto">03</div>
  <div class="songs-image track-image col-auto">
  <a href="#" class="track-list" data-track="demos/music/tracks/maq-amor.mp3" data-poster="demos/music/tracks/poster-images/maq-amor.jpg" data-title="Maq Amor" data-singer="The Universe">
  <img src="Images/channels4_profile.jpg" alt="Image 1"><span><i class="icon-play"></i></span>
  </div>
  <div class="songs-name track-name flex-grow-1 col-auto"><a href="#">Aurthohin<br><span>Epitaph</span></a></div>
  <div class="songs-time col-auto">04:08</div>

  </div>
  
  <div class="songs-list">
  <div class="songs-number col-auto">04</div>
  <div class="songs-image track-image col-auto">
  <a href="#" class="track-list" data-track="demos/music/tracks/i-need-you-now.mp3" data-poster="demos/music/tracks/poster-images/i-need-you-now.jpg" data-title="I Need You Now" data-singer="Skelton">
  <img src="Images/channels4_profile.jpg" alt="Image 1"><span><i class="icon-play"></i></span>
  </div>
  <div class="songs-name track-name flex-grow-1 col-auto"><a href="#">60's LOVE<br><span>LEVEL FIVE</span></a></div>
  <div class="songs-time col-auto">03:33</div>
  
  </div>
  
  <div class="songs-list">
  <div class="songs-number col-auto">05</div>
  <div class="songs-image track-image col-auto">
  <a href="#" class="track-list" data-track="demos/music/tracks/something-about-love.mp3" data-poster="demos/music/tracks/poster-images/something-about-love.jpg" data-title="Something About Love" data-singer="Sian">
  <img src="Images/channels4_profile.jpg" alt="Image 1"><span><i class="icon-play"></i></span>
  </div>
  <div class="songs-name track-name flex-grow-1 col-auto"><a href="#">Srotoshinni<br><span>Encore</span></a></div>
  <div class="songs-time col-auto">03:43</div>
   
  </div>
  
  <div class="songs-list">
  <div class="songs-number col-auto">06</div>
  <div class="songs-image track-image col-auto">
  <a href="#" class="track-list" data-track="demos/music/tracks/ibelieveinyou.mp3" data-poster="demos/music/tracks/poster-images/ibelieveinyou.jpg" data-title="i Believe In You" data-singer="Lost European">
  <img src="Images/channels4_profile.jpg" alt="Image 1"><span><i class="icon-play"></i></span>
  </a>
  </div>
  <div class="songs-name track-name flex-grow-1 col-auto"><a href="#">E Hawa<br><span>Meghdol</span></a></div>
  <div class="songs-time col-auto">03:28</div>
  
  </div>
  </div>
  
  </div>
  </div>
</section>
<!-- Hot Track End --><section  id="Merch" class="banding">
  <div class="gif">
  <a href="product.php"><button>CLICK HERE</button></a>
 
  </div>
  <div class="banding-op">
     
  </div>



</section>
<div class="conta">
      
      
      <div class="form-design">
        <div class="contact-info">

          <h5 class="title-name">Let's get in touch</h5>
          <p class="text">
            Our Location, Email Address and Phone Number is given below...



          </p>

          <div class="info">
            <div class="information">
              <img src="Images/location.png" class="icon" alt="" />
              <p>92 Cherry Drive Uniondale, NY 11553</p>
            </div>
            <div class="information">
              <img src="Images/email.png" class="icon" alt="" />
              <p>FANFAIR@gmail.com</p>
            </div>
            <div class="information">
              <img src="Images/phone.png" class="icon" alt="" />
              <p>123-456-789</p>
            </div>
          </div>

          <div class="social-media-site">
            <p>Connect with us :</p>
            <div class="social-icons-site">
              <a href="#">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="#">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="contact-form">
          

          <form method="post" autocomplete="off" class="form-style">
            <h3 class="title-name">Contact us</h3>
            <div class="inputting-container">

              <input type="text" name="name" placeholder="Enter Username" class="inputting" />
              
              
            </div>
            <div class="inputting-container">
              <input type="email" name="email"  placeholder="Enter Email" class="inputting" />
              
              
            </div>
            <div class="inputting-container">
              <input type="tel" name="phone" placeholder="Enter Contact Number" class="inputting" />
              
              
            </div>
            <div class="inputting-container textarea">
              <textarea name="message" placeholder="Write a Message" class="inputting"></textarea>
             
              
            </div>
            <input type="submit" value="Send" name="Send" class="button-class" />
          </form>
        </div>
      </div>
    </div>

<!-- FOOTER -->
<footer class="footer-distributed">

        <div class="footer-left">
            <h3>FANFAIR</h3>

            <p class="footer-links">
                <a href="#">Home</a>
                |
                <a href="#">Contact Us</a>
                
            </p>

            <p class="footer-company-name">Copyright © 2022 <strong>FANFAIR</strong> All rights reserved</p>
        </div>

        <div class="footer-center">
            <div>
                <i class="fa fa-map-marker"></i>
                <p><span>Mohammadpur</span>
                    Dhaka</p>
            </div>

            <div>
                <i class="fa fa-phone"></i>
                <p>01755221663</p>
            </div>
            <div>
                <i class="fa fa-envelope"></i>
                <p><a href="mailto:Fairuznaba03@gmail.com">FANFAIR@gmail.com</a></p>
            </div>
        </div>
        <div class="footer-right">
            <p class="footer-company-about">
                <span>About the Website</span>
                <strong>FANFAIR</strong> is an e-commerce site for fans all around the world. Official artist merch to exclusive CDs, DVDs and products as well as concert tickets will be accessible on this website. This website also focuses on the artist-to-fan communications for musicians and bands.
            </p>
            <div class="footer-icons">
                <a href="#"><i  class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
                <a href="#"><i class="fa fa-youtube"></i></a>
            </div>
        </div>
    </footer> 


  
        





  


    






    






		
		




<!-- For Music Button js -->
<script>
  function playMusic(){
  var music = new Audio('Songs/Ei Obelay - Shironamhin(sumirbd.mobi).mp3');
  music.play();
  }
</script>



<script type="text/javascript" src="JS/design.js"></script>

<script>
 var slideImg = document.getElementById("slideImg");
 var Images = new Array(
      "Images/21.jpg",
      "Images/uki.jpg",
      "Images/33.jpg"
);

var len = Images.length;
var i = 0;

function slider(){
    if(i > len-1){
      i = 0;
    }
    slideImg.src = Images[i];
    i++;
    setTimeout('slider()',3000);
}

</script>
<script >
  filterSelection("all") // Execute the function and show all columns
function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("column");
  if (c == "all") c = "";
  // Add the "show" class (display:block) to the filtered elements, and remove the "show" class from the elements that are not selected
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "show");
    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
  }
}

// Show filtered elements
function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {
      element.className += " " + arr2[i];
    }
  }
}

// Hide elements that are not selected
function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);
    }
  }
  element.className = arr1.join(" ");
}

// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function(){
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}




</script>

	<!-- JS Link up -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>  

</body>
</html>

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {
  var myDropdown = document.getElementById("myDropdown");
    if (myDropdown.classList.contains('show')) {
      myDropdown.classList.remove('show');
    }
  }
}
</script>

</body>