<!DOCTYPE html>
<head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=Karma:wght@300&family=News+Cycle&family=Old+Standard+TT:ital@1&display=swap');
    footer{
        position:fixed;
        bottom:0;
        font-family: 'Karma', serif;
        margin-bottom:0;
        font-size: large;
        z-index:999;
        width: 100vw;
        height:50px;
        left:0;
        right:0; 
        background-color:#213150;
        color:white;
    }
   footer #foo{
        text-align:center;
        padding-top:13px;
    }
</style>
</head>
<footer>
<div id="foo">
    You are logged in as <?php echo $_SESSION['center_username']?> 
</div>
</footer>
</html>