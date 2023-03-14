<style>
    @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');
    #myAccount{
        position: relative;
        top:170px;
        left:320px;
        width:75vw;
        font-family: 'EB Garamond', serif;

    }
    #imgg{
        position:absolute;
        left:0;
        width:200px;
        height:200px;
        border-radius:10%;
    }
    #info{
        position:absolute;
        left:280px;
        font-family: 'EB Garamond', serif;

    }
</style>
<div id="myAccount">
<?php if(isset($_SESSION['admin_image'])) {?>
<img id="imgg" src="http:\\127.0.0.1:8081\php-mvc\public\img\<?php echo $_SESSION['admin_image']; ?>" /> <?php } ?>
<?php  if(isset($_SESSION['admin_image'])) {?> <div id="info"> <?php }
else { ?>  <div>  <?php }
?>

<h1> My Account </h1>
<h2> name: <?php echo $_SESSION ['admin_username'] ?> </h2> 
<h2> email: <?php echo $_SESSION['admin_email'] ?> </h2> 
<?php if(isset($_SESSION['admin_phone'])) { ?>
<h2> phone number: <?php echo $_SESSION['admin_phone'] ?> </h2> <?php } ?>
</div>
</div>