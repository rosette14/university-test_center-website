<html>
    <head>
        <script>
            function validate(){
                var x=1;
                var msg="";
                var phoneformat=/09\d{8}/;
                var emailformat=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if(!document.form1.email.value.match(emailformat)){
                    x=0;
                    msg="The email is not valid, ";
                }
                if(document.getElementById('phonenumber').value.trim()!='')
                {
                    if(!document.form1.phone.value.match(phoneformat)){
                    x=0;
                    msg+="The phone is not valid, ";
                    }
                }
                if(document.getElementById('password').value!=document.getElementById('repassword').value)
                {
                    x=0;
                    msg+="The password and confirm passowrd are not identical, ";
                }
                if(document.getElementById('fname').value.trim()==="")
                {
                    x=0;
                    msg+="First name can not be empty, ";
                }
                if(document.getElementById('lname').value.trim()==="")
                {
                    x=0;
                    msg+="Last name can not be empty, ";
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
                if(document.getElementById('repassword').value==="")
                {
                    x=0;
                    msg+="Confirn Password can not be empty, ";
                }
                if(document.getElementById('account').value==="")
                {
                    x=0;
                    msg+="Account type can not be empty, ";
                }
                if(x==0){
                    Swal.fire(msg);
                    return false;
                }
                else return true;
            }
        </script>
        <script> document.getElementById("User").className="active"; </script>
        <script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
        #base{
            position: relative;
            left:350px;
            top:150px;
            margin-top:0;
            margin-left:0;
            width:73vw;
            height: 120vh;
        }
        #primary{
            position:absolute;
            left:200px;
            margin-top:100px;
            width: 30vw;
            height: 100vh;
            background-color:rgba(4,73,128,0.5);  
            border-radius:50px;
            padding:40px;
            margin-bottom:200px;
        }
        label{
            font-size:18px;
        }
        h1,h3{
            font-weight: 900;
        }
        .input_field{
            margin: 20px;
        }
        input{
            height: 35px;
            width: 20vw;
            border: 2px solid black;
            margin: 0;
            left:150px;
        }
        [type="file"]{
            border:none;
            margin-top:10px;
        }
        h1{
            margin-bottom:20px;
        }
      
        select{
            margin-top:20px; 
            height: 40px;
            width: 12vw;
        }
        #submit{
            margin-left:80px;
            margin-top:10px;
            width: 12vw;
            font-weight: 500;
            font-size: larger;
            border:none;
        }
        #submit:hover{
            background-color:rgba(0,0,0,0.4);
            color:white;
            cursor: pointer;
            border-radius: 8px;
            border: black solid 3px;
        }
        #ima{
            margin-top:30px;
        }
        .swal2-popup {
            font-size: 12px !important;
            font-family: Georgia, serif;
            border:2px solid black;
            font-weight:6px;
            background-color:rgb(245,245,245);
            font-family: 'Nanum Myeongjo', serif;
            color:black;
            }
        </style>
    </head>
        <div id='base' >
            <div  id="primary">
            <h1 >User</h1>
            <br>
            <form  name="form1" action="<?php echo URL."users/addUserSave"?>" method="post" onsubmit="return validate()" >
                <div class="input_field">
                    <input  type="text" placeholder="First Name" name="first_name" id="fname" required >
                </div>
                <div  class="input_field">
                    <input  stype="text" placeholder="Last Name" name="last_name" id="lname" required>
                </div>
                <div class="input_field" id="input_email">
                    <input  type="text" name="email" id="email" placeholder="Email" required onfocusout="validateEmail()">
                </div>
                <div class="input_field" >
                  <input type="password" name="password" id="password"  placeholder="Password"  required>
                </div>
                <div class="input_field" >
                    <input type="password" name="repassword" id="repassword" placeholder="Confirm password" required>
                </div>
                <div class="input_field">
                    <input type="text" id="phonenumber" name="phone" placeholder="Phonenumber" >
                </div>
                <div class="input_field" >
                    <select name="role_id" id="account"  required>
                        <option value="" disabled selected>Choose an account type </option> 
                        <?php foreach($array as $row) {  ?>
                           <option value=<?php echo $row->id ?> > <?php echo $row->role_name ?>  </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input_field" id="ima" >
                    <label  for="image">Select a photo: </label>
                    <input  type="file" name="image" id="image" accept="image/*" value="Select a photo">
                </div>
                <div class="input_field">
                    <input  type="submit" id="submit" name="submit" value="save user" >
                </div>
                <div id="hidden" style="display:none">
                </div>
            </form>
            </div>
            </div>
</html>