<?php

// Set email variables
$email_to = 'kurl@e-service.co.ke ';
$email_subject = 'Form submission';

// Set required fields
$required_fields = array('fullname','email','comment');

// set error messages
$error_messages = array(
	'fullname' => 'Please enter a Name to proceed.',
	'email' => 'Please enter a valid Email Address to continue.',
	'comment' => 'Please enter your Message to continue.'
);

// Set form status
$form_complete = FALSE;

// configure validation array
$validation = array();

// check form submittal
if(!empty($_POST)) {
	// Sanitise POST array
	foreach($_POST as $key => $value) $_POST[$key] = remove_email_injection(trim($value));
	
	// Loop into required fields and make sure they match our needs
	foreach($required_fields as $field) {		
		// the field has been submitted?
		if(!array_key_exists($field, $_POST)) array_push($validation, $field);
		
		// check there is information in the field?
		if($_POST[$field] == '') array_push($validation, $field);
		
		// validate the email address supplied
		if($field == 'email') if(!validate_email_address($_POST[$field])) array_push($validation, $field);
	}
	
	// basic validation result
	if(count($validation) == 0) {
		// Prepare our content string
		$email_content = 'New Website Comment: ' . "\n\n";
		
		// simple email content
		foreach($_POST as $key => $value) {
			if($key != 'submit') $email_content .= $key . ': ' . $value . "\n";
		}
		
		// if validation passed ok then send the email
		mail($email_to, $email_subject, $email_content);
		
		// Update form switch
		$form_complete = TRUE;
	}
}

function validate_email_address($email = FALSE) {
	return (preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $email))? TRUE : FALSE;
}

function remove_email_injection($field = FALSE) {
   return (str_ireplace(array("\r", "\n", "%0a", "%0d", "Content-Type:", "bcc:","to:","cc:"), '', $field));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Booking</title>
  
	<title>Contact Form</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link href="Contact/css/contactform.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools-yui-compressed.js"></script>
	<script type="text/javascript" src="validation/validation.js"></script>
	
	<script type="text/javascript">
var nameError = '<?php echo $error_messages['fullname']; ?>';
		var emailError = '<?php echo $error_messages['email']; ?>';
		var commentError = '<?php echo $error_messages['comment']; ?>';

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

</script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="css/styles.css" rel="stylesheet" type="text/css">
  <link href="Contact/css/contactform.css" rel="stylesheet" type="text/css">
 
  <link href="csscommision.css" rel="stylesheet" type="text/css">
</head>
<body id="myPage" onLoad="MM_preloadImages('Contact/images/x.png')" data-spy="scroll" data-target=".navbar" data-offset="60"> <!--oncontextmenu="return false"-->


<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a href="INDEX.php" class="navbar-brand">E-BRIDGE</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#services">SERVICES</a></li>
       <!-- <li><a href="#portfolio">PORTFOLIO</a></li>-->
        <li><a href="#pricing">PAYMENT METHODS</a></li>
       <!-- <li><a href="#contact">CONTACT</a></li>-->
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>Welcome to E-BRIDGE</h1> 
  <p>Proceed with the booking form below.</p> 
  <form class="form-inline">
    <!--<input type="email" class="form-control" size="50" placeholder="Email Address" required>-->
  </form>
</div>
<!--Booking process-->



<form action="bookin.php" method="post" id="comments_form">

<div id="formWrap">
<h2>Whatever you need, we're here to assist!</h2>
<div id="form">
<?php if($form_complete === FALSE): ?>

	<div class="row">
	<div class="label">Your Name</div> <!-- end .label -->
    <div class="input">
    <input type="text" id="fullname" class="detail" name="fullname" value="<?php echo isset($_POST['fullname'])? $_POST['fullname'] : ''; ?>" /><?php if(in_array('fullname', $validation)): ?><span class="error"><?php echo $error_messages['fullname']; ?></span><?php endif; ?>
    </div><!-- end .input -->
    <div class="context">E.g. John Smith or Jane Doe</div><!-- end .context -->
    </div><!-- end .row -->
    
    <div class="row">
	<div class="label">Your Email Address</div> <!-- end .label -->
    <div class="input">
    <input type="text" id="email" class="detail" name="email" value="<?php echo isset($_POST['email'])? $_POST['email'] : ''; ?>" /><?php if(in_array('email', $validation)): ?><span class="error"><?php echo $error_messages['email']; ?></span><?php endif; ?>    </div><!-- end .input -->
    <div class="context">We will not spam you with messages and we will not pass on your email address to anyone</div><!-- end .context -->
    </div><!-- end .row -->
       
    
    <div class="row">
	<div class="label">Your Message & <br />Your Phone NUMBER</div> <!-- end .label -->
    <div class="input2">
   <textarea id="comment" name="comment" class="mess"><?php echo isset($_POST['comment'])? $_POST['comment'] : ''; ?></textarea><?php if(in_array('comment', $validation)): ?><span class="error"><?php echo $error_messages['comment']; ?></span><?php endif; ?>

    </div><!-- end .input -->
    </div><!-- end .row -->
    
    <div class="submit">
    <input id="submit" name="submit" value="Send Message" type="submit">
  </div><!-- end .submit -->

	<?php else: ?>
<p style="font-size:35px; font-family:Arial, Helvetica, sans-serif; color:#255e67; margin-left:25px">Thank you for your Message!<br> After this message is sent, <br>within 10 seconds this page will <br>return to main page</p>
<script type="text/javascript">
setTimeout('ourRedirect()', 10000)
function ourRedirect(){
	location.href='INDEX.php'
}
</script>
<?php endif; ?>
</div><!--end#orm-->
</div><!--end formwrap-->
    </form>
<form>
<div class="content">
<p id="text"><b><big>Our 10% commission is parmanent for all the service we provide to our clients</big></b></p>
</div>
<table class="table">
    <tr>
        <td><h3>Amount</h3></td>
        <td><input class="txt" type="text" name="txt"/></td>
    </tr>
    <tr>
        <tr id="summation">
        <td class="commision"><h3>Commission</h3></td>
        <td align="center"><span id="sum"><big>0</big></span></td>
    </tr>
</table>
<script>
    $(document).ready(function(){
 
        //handler to trigger sum event
        $(".txt").each(function() {
 
            $(this).keyup(function(){
                calculateSum();
            });
        });
 
    });
 
    function calculateSum() {
 
        var sum = 0.1;
        //iterate through each textboxes and add the values
        $(".txt").each(function() {
 
            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
                sum *= parseFloat(this.value);
            }
 
        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
        $("#sum").html(sum.toFixed(2));
    }
</script>
</form>
 <div style="clear:both;"></div>


<!-- Container (Services Section)-->
<div id="services" class="container-fluid text-center">
<div>
  <h2>SERVICES</h2>
  <h4>What we offer</h4>
  </div>
  <br>
  <div class="row slideanim">
    <div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-off logo-small"></span>-->
	  <img src="logo kenia/plumbing.png">
      <h4>Plumbing</h4>
    </div>
    <div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-heart logo-small"></span>-->
       <img src="logo kenia/cleaning.png">
	  <h4>Cleaning</h4>
    </div>
    <div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-lock logo-small"></span>-->
       <img src="logo kenia/cooking.jpg">
	  <h4>Cooking</h4>
    </div>
  </div>
  <br><br>
  <div class="row slideanim">
    <div class="col-sm-4">
     <!--<span class="glyphicon glyphicon-leaf logo-small"></span>-->
      <img src="logo kenia/interior-house-painting.jpg">
	  <h4>Home Repair & Painting</h4>
    </div>
    <div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-certificate logo-small"></span>-->
     <img src="logo kenia/carpentry.png">
	 <h4>Carpentry</h4>
    </div>
    <div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-wrench logo-small"></span>-->
     <img src="logo kenia/images.jpg">
	  <h4 style="color:#303030;">Gardening</h4>
    </div>
	<div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-wrench logo-small"></span>-->
      <img src="logo kenia/movers.png">
	  <h4 style="color:#303030;">Moving & Delivery</h4>
    </div>
	<div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-wrench logo-small"></span>-->
      <img src="logo kenia/tailoring.jpg">
	  <h4 style="color:#303030;">Tailoring</h4>
    </div>
	 <div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-wrench logo-small"></span>-->
      <img src="logo kenia/bottled-water-delivery-300x220.jpg">
	  <h4 style="color:#303030;">Clean driking water delivery</h4>
   </div>
	<div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-wrench logo-small"></span>-->
      <img src="logo kenia/tents.jpg">
	  <h4 style="color:#303030;">Tents Delivery</h4>
   </div>
   <div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-wrench logo-small"></span>-->
      <img src="logo kenia/Fumigation.jpg">
	  <h4 style="color:#303030;">Pests Fumigation</h4>
   </div>
   <div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-wrench logo-small"></span>-->
      <img src="logo kenia/workshop.jpg">
	  <h4 style="color:#303030;">Bicycle Repair</h4>
   </div>
   <div class="col-sm-4">
      <!--<span class="glyphicon glyphicon-wrench logo-small"></span>-->
      <img src="logo kenia/electrician-working.jpg">
	  <h4 style="color:#303030;">Residential Eletrician</h4>
   </div>
  </div>
</div>
<!-- Container (Portfolio Section) -->

<br>
  
  <h2 align="center">What our customers say</h2>
  <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <h4>"This company is the best. I am so happy with the result!"<br><span style="font-style:normal;">Mary.</span></h4>
      </div>
      <div class="item">
        <h4>"One word... WOW!!"<br><span style="font-style:normal;">John.</span></h4>
      </div>
      <div class="item">
        <h4>"Could I... BE any more happy with this company?"<br><span style="font-style:normal;">Ann.</span></h4>
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

<!-- Container (Payment Section) -->
<div id="pricing" class="container-fluid">
  <div class="text-center">
    <h2>Payment Methods</h2>
    <h4>Choose a payment method that works for you</h4>
  </div>
  <div class="row slideanim">
    <div class="col-sm-4 col-xs-12">
      <div class="panel panel-default text-center">
        <div class="panel-heading">
          <h1>Mpesa Till Number</h1>
        </div>
        <div class="panel-body">
          <p><strong></strong></p>
        </div>
      </div>      
    </div>     
    <div class="col-sm-4 col-xs-12">
      <div class="panel panel-default text-center">
        <div class="panel-heading">
          <h1>Bank Account Number</h1>
        </div>
        <div class="panel-body">
          <p><strong></strong></p>
        </div>
      </div>      
    </div>       
    <div class="col-sm-4 col-xs-12">
      <div class="panel panel-default text-center">
        <div class="panel-heading">
          <h1>Pay pal(comming soon)</h1>
        </div>
        <div class="panel-body">
          <p><strong></strong> </p>
        </div>
      </div>      
    </div>    
  </div>
</div>

<!-- Container (Contact Section) -->


<!-- Add Google Maps -->

<footer class="container-fluid text-center">
  <a href="#myPage" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
</footer>

<script>
$(document).ready(function(){
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

    // Prevent default anchor click behavior
    event.preventDefault();

    // Store hash
    var hash = this.hash;

    // Using jQuery's animate() method to add smooth page scroll
    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
    $('html, body').animate({
      scrollTop: $(hash).offset().top
    }, 900, function(){
   
      // Add hash (#) to URL when done scrolling (default click behavior)
      window.location.hash = hash;
    });
  });
  
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });
})
</script>

</body>
</html>
