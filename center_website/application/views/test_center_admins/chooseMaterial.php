<script> document.getElementById("askForTest").className="active"; </script>
<html>
    <head>
    <script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');
        #base{
        position: relative;
        top:200px;
        left:400px;
        }
        #primary{
            position:absolute;
            width: 42vw;
            height: 37vh;
            background-color:rgba(4,73,128,0.5);  
            border-radius:50px;
            padding:10px;
            padding-top: 20px;
            left:80px;
            top:50px;
        }
        h1,h3{
            color:rgba(0,0,0,1);
            font-weight: 900;
            z-index: 10000;
            font-family: 'EB Garamond', serif;

        }
        input{
            height: 40px;
            width: 20vw;
            position: relative;
            border: 2px solid black;
            margin: 0;
        }
        .input_field{
            margin: 20px;
            position: relative;
            left:30px;
        }
        select{
            height: 40px;
            width: 16vw;
            margin-left:0px;
            margin-top:15px;
        }
        #submit{
            left:170px;
            top:20px;
            width: 12vw;
            font-weight: 500;
            font-size: larger;
            border:none;
        }
        #submit:hover{
            background-color:rgba(0,0,0,0.6);
            color:white;
            cursor: pointer;
            border-radius: 8px;
            border: black solid 3px;
        }
        #description{
            border: 2px solid black;
            width: 20vw;
        }
        h2{
            width: 30px;
            margin-left:20px;
            margin-top: 0;
            margin-bottom: 30px;
        }
        #primary h3{
            margin-left:30px;
            font-size:18px;
        }
        </style>
    </head>
    <script>
            function f(){
                if(document.getElementById('material').value==="")
                {
                    Swal.fire('you should choose material');
                    return false;
                }
                return true;
            }
        </script>
    <body>
    <div id='base'>
            <div id="primary">
                <br>
                
                <form name="form1" action="<?php echo URL."test_center_admins/askForTest"?>" method="post" onsubmit="return f()">
                    <h3> Welcome  <?php echo $_SESSION['center_username']; ?>
                    Choose the material you want to provide your center with exam in it
                    </h3>
                    <div class="input_field">
                    <select name="material_id" id="material" required>
                        <option value="" disabled selected>Choose a material </option> 
                        <?php foreach($materials as $key=>$value) {  ?>
                           <option value=<?php echo $key ?> > <?php echo $value ?>  </option>
                        <?php } ?>
                    </select>
                    </div>
                    <div class="input_field">
                        <input type="submit" id="submit" name="submit" value="choose material" >
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>