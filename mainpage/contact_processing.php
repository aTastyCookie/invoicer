<?php session_start(); ?>
<?php
//set your email here:
$yourEmail = 'YOUREMAIL@SOMETHING.COM';
/*
 * CONTACT FORM
 */
//If the form is submitted
if(isset($_POST['submitted'])) { 
    //Check to make sure that the name field is not empty
    if($_POST['contact-name'] === '') { 
            $hasError = true;
    } else {
            $name = $_POST['contact-name'];
    }

    //Check to make sure sure that a valid email address is submitted
    if($_POST['contact-email'] === '')  { 
            $hasError = true;
    } else if (!preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $_POST['contact-email'])) {
            $hasError = true;
    } else {
            $email = $_POST['contact-email'];
    }

    //Check to make sure comments were entered  
    if($_POST['contact-message'] === '') {
            $hasError = true;
    } else {
            if(function_exists('stripslashes')) {
                    $comments = stripslashes($_POST['contact-message']);
            } else {
                    $comments = $_POST['contact-message'];
            }
    }
    //Check to make sure that the topic field is not empty
    if($_POST['contact-topic'] === '') { 
            $hasError = true;
    } else {
            $topic = $_POST['contact-topic'];
    }

    //CHECK CAPTCHA
    include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
    $securimage = new Securimage();
    if ($securimage->check($_POST['captcha_code']) == false) { 
        $hasError = true;
    } 

    //If there is no error, send the email
    if(!isset($hasError)) {

            $emailTo = $yourEmail;
            $subject = "(From Your Website) $topic";
            $body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
            $headers = 'From : my site <'.$emailTo.'>' . "\r\n" . 'answer to : ' . $email;

            mail($emailTo, $subject, $body, $headers);

            $emailSent = true; 
    }  
}

?>
<html>
  <head>
    <meta charset="utf-8">
    <!-- PAGE TITLE -->
    <title>Sending... - HTML Template</title>
    <!-- MAKE IT RESPONSIVE -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- STYLESHEETS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/animate.min.css" rel="stylesheet" media="screen">
    <link href="css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="style.css" rel="stylesheet" media="screen">
    <link href="css/options.css" rel="stylesheet" media="screen">
    <link href="css/responsive.css" rel="stylesheet" media="screen">
    <!-- FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:900,300,400,200,800' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>
  <!-- START BODY -->
  <body>
    <div id="form_processing">
        <!-- PHP ALERTS FROM THE FORMS -->
        <?php if(isset($emailSent) && $emailSent == true) { ?>
            <div class="alert-success" >
                <h1><?php echo'Thank you, '. $name  .'.';?></h1>
                <p><?php echo'Your message was sent. We will reply really soon.' ?></p>
                <h3 class="align-center">You will be redirected in <span>5</span> seconds ...</h3>
            </div><!-- .alert -->
        <?php } ?>
        <?php if(isset($hasError) && $hasError == true) { ?>
            <div class="alert-danger">
                <h1><?php echo'Sorry,'; ?></h1>
                <p><?php echo'Otherwise it miss one of the field or the captcha is incorrect.'; ?>
                <h3 class="align-center">You will be redirected in <span>6</span> seconds ...</h3>
            </div><!-- .alert -->
        <?php } ?>
        <!-- END ALERT -->
    </div><!-- end #page -->
  </body>
</html>
<script src="http://code.jquery.com/jquery.js"></script>
<script type="text/JavaScript">
<!--
$(document).ready(function() {
    var sec = $('#form_processing h3 span').text() || 0;
    var timer = setInterval(function() { 
       $('#form_processing h3 span').text(sec--);
       if (sec == 0) {
          parent.history.back();
          clearInterval(timer);
       } 
    }, 1000);
});
-->
</script>