<script> document.getElementById("Home").className="active"; </script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');
    #hi{
        position: relative;
        top:200px;
        left:320px;
        font-family: 'EB Garamond', serif;
    }
</style>
<h1 id="hi">
Hello <?php echo      $_SESSION['center_username']; ?>. <br>
Welcome to <?php echo $_SESSION['center_name'] ?> Center Online Exams Website,<br>
Here you can Ask for a new test, or view students results in this center.
</h1>
