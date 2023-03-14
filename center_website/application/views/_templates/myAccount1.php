<style>
    #myAccount{
        position: relative;
        top:170px;
        left:320px;
    }
</style>
<div id="myAccount">
<h1> My Account </h1>
<h2> name: <?php echo $_SESSION ['center_username'] ?> </h2> 
<h2> email: <?php echo $_SESSION['center_email'] ?> </h2> 
<?php if(isset($_SESSION['center_phone'])) { ?>
<h2> phone number: <?php echo $_SESSION['center_username'] ?> </h2> <?php } ?>
<?php if(isset($_SESSION['center_image'])) {?>
<h2> image: <img src="http:\\127.0.0.1:8081\php-mvc\public\img\<?php echo $_SESSION['center_image']; ?>" />  </h2> <?php } ?>
</div>