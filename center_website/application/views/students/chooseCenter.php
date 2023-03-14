<html>
    <head>
        <script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
        <title>University of Light</title>
        <link rel="icon" type="image/x-icon" href="http:\\127.0.0.1:8081\center_website\public\img\favicon.ico">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=News+Cycle&family=Old+Standard+TT:ital@1&display=swap');
            
            header h1{
                color: white;
                font-weight: lighter;
                font-family: 'News Cycle', sans-serif;
                margin-top: 55px;
                margin-bottom: 0;
                height: 40px;
            }
            header h1:hover{
                text-shadow:1px 1px white ;
            }

            header{
                width: 100vw; height:170px;
                margin-left: 0;
                background-color:#044980;
                margin-top:0;
                top:0;
                left:0;
                position: fixed;
            }
            header #logout{
                float: right;
                margin-right:30px;
                margin-top: 20px;
                border: 1px solid white;
                padding:12px;
                border-radius: 200px;
            }
            header #logout:hover{
                box-sizing: border-box;
                border:2px solid white;
                background-color: #055291;
                color:white;
                font-size: 17px;
            }
            header a{
                font-family: 'Cormorant Garamond', serif;
                text-decoration: none;
                color:white;
                font-size:22px;
                font-weight:bold;
            }
            header #logo{
                width:70px;
                height:70px;
                margin-top:30px;
                margin-left:20px;
                float:left;
            }
        </style>
    </head>
    <body>
        <header>
            <img src="http:\\127.0.0.1:8081\center_website\public\img\logo.png" id="logo">
            <a href="<?php echo URL.'home/logout' ?>" id="logout"> Log out</a>
            <h1 style="display: inline-block;"> University of Light </h1>
        </header>
    </body>
</html>
<html>
<head>
    <style>
    * {
       box-sizing: border-box;
      }
    .nav-container {
      left:0;
      top:170px;
      position: fixed; 
      height:100%;
      width: 300px;
      background-color: rgb(22, 39, 78);
      transition: all 0.5s linear;
      z-index: 100;
    }
    .nav-container .nav {
      height:100%;
      list-style-type: none;
      margin:0;
      padding:0;
    }
    @media only screen and (max-width : 860px){
      .text{
        display:none;
        max-width : 860px
      }
    }
    </style>
      <style>
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
    <script>
            function f(){
                if(document.getElementById('material').value==="")
                {
                    Swal.fire('you should choose center');
                    return false;
                }
                return true;
            }
    </script>
</head>
<body>
<div class="nav-container" id="nav-container">
 
</div>

</body>
</html>

        <div id='base'>
            <div id="primary">
                <br>
                
                <form name="form1" action="<?php echo URL."students/saveCenter"?>" method="post" onsubmit="return f()" >
                    <h3> Welcome  <?php echo $_SESSION['center_username']; ?>
                    Choose the center you want to take your exam in
                    </h3>
                    <div class="input_field">
                    <select name="test_center_id" id="material" required>
                        <option value="" disabled selected>Choose a center </option> 
                        <?php foreach($centers as $center) {  ?>
                           <option value=<?php echo $center->id ?> > <?php echo $center->center_name ?>  </option>
                        <?php } ?>
                    </select>
                    </div>
                    <div class="input_field">
                        <input type="submit" id="submit" name="submit" value="choose center" >
                    </div>
                </form>
            </div>
        </div>
