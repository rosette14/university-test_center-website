<!DOCTYPE html>
<html>
  <head>
    <script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
    </style>
  </head>
    <head>
        <title>University of Light</title>
        <link rel="icon" type="image/x-icon" href="http:\\127.0.0.1:8081\php-mvc\public\img\favicon.ico">
        <style>  
            @import url('https://fonts.googleapis.com/css2?family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=Karma:wght@300&family=News+Cycle&family=Old+Standard+TT:ital@1&family=Roboto+Mono:wght@100&display=swap');            
            
            #cover{
                position: relative;
                top:0;
                left:0;
                right:0;
                bottom:0;
                margin:0;
                background-image: url('../public/img/login_background.jpg');
                background-size: cover;
                position: absolute;
                width: 100%;
                height:100%;
                filter:blur(4px);
            }
            body{

            }
           #primary{
            width: 30vw;
            left:500px;
            top:220px;
            height: 45vh;
            position: relative;
            padding:10px;
            border-radius:5px;
            background-color:rgba(4,73,128,0.5);
            background-color:rgba(255,255,255,0.1);
            background-color: rgba(0,0,0,0.2);
            border:1px solid black;
            border-radius: 50px;
            margin-top: 0;
            }   
            input{
            height: 40px;
            width: 25vw;
            position: relative;
            left:30px;
            border: 2px solid black;
            margin: 0;
            }
            .input_field{
            margin: 20px;
            position: relative;
            }
            #submit{
           left:6vw;
           top:20px;
           width: 15vw;
           background-color:rgba(0,0,0,0.4);
           color: white;
           font-weight: 900;
           font-size: larger;
        }
        #submit:hover{
         background-color:rgba(0,0,0,0.6);
         cursor: pointer;
         border-radius: 8px;
         border: white solid 3px;
        }
        a:visited{
            color:white;
        }
        a{
            text-decoration: none;
            color: white;
            display:none;
        }
        #ico{
            display:inline-block;
            height:25px;
            width: 1vw;
            position: absolute;
            top:0;
            left:0;
            border: 2px solid black;
            background-color: white;
            margin: 0;
            margin-right:10px;
            font-size: 15px;
            padding: 7px 11px 5px 5px;
            
            }
        span{
            display: inline-block;
            position: absolute;
            right:0;
        }
        h2{
            margin-bottom: 35px;
            font-family: 'Amiri', serif;
            font-size: 40px;
            height:40px ;
            margin-top: 0;
            top: 0px;
            display: inline-block;
            position: relative;
            left:130px;
            margin-bottom: 30px;

        }
        #welcome{
            text-align: center;
            background-color: rgba(255,255,255,0.3);
            border-radius: 20px;
            margin-bottom: 0;
            padding: 5px;
            font-family: 'Abhaya Libre', serif; 
            transform:scaleY(1.7);
            font-size: 40px;
            font-weight: lighter;
            width:50vw;
            position: relative;
            top:80px;
            left:370px;    
        }
        #icon{
          position: relative;  
          height:50px;
          width:50px;
          left:120px;
          top:7px;
          margin-right:0;
            }
        .swal2-popup {
            font-size: 12px !important;
            font-weight:6px;
            width:900px;
            height:100px;
            background-color:rgb(245,245,245);
            color:black;
            padding-top:10px;
        }
        .swal2-title{
            margin:0;
            padding:0;
            left:0;
        }
        </style>
        <script>
            function validate(){
                var x=1;
                var msg="";
                var emailformat=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if(document.form1.email.value.match(emailformat)){  
                }
                else{
                    x=0;
                    msg+="The email formula is not valid, ";
                }
                if(document.getElementById('email').value.trim()==="")
                {
                    x=0;
                    msg+="email can not be empty, ";
                }
                if(document.getElementById('password').value==="")
                {
                    x=0;
                    msg+="Password can not be empty, ";
                }
                msg=msg.trim();
                if(x==0){
                    Swal.fire({
                        title: msg,
                        confirmButtonText:'ok',
                        }).then((result) => {
                        if (true) {
                        }
                        });
                    return false;
                }
                else return true;
            }
        </script>
    </head>
    <body>
        <div id="cover"> </div>
        <h1 id="welcome"> 
            Welcome to University Online Exams Website
        </h1>  
        <div id="primary">
            <img src="http:\\127.0.0.1:8081\php-mvc\public\img\logo.png" alt="" id="icon">  
            <h2> Login </h2>
            <form method="post" name="form1" action=<?php echo URL."home/loginCheck" ?> onsubmit="return validate()" >
            <div class="input_field">
                <div id="ico"><img src="http:\\127.0.0.1:8081\php-mvc\public\img\email1.ico" height="22px" width="22px" ></div>
                <input  type="text" name="email" id="email" placeholder="Email" >
            </div>
            <div class="input_field">
                <div id="ico"><img src="http:\\127.0.0.1:8081\php-mvc\public\img\pass1.ico" height="20px" width="20px" ></div>
                <input type="password" name="password" id="password" placeholder="Password"  >
            </div>
            <div class="input_field">
                <input type="submit" id="submit" name="submit" value="Login">
            </div>
            </form>
        </div>
    </body>
</html>