<html>
    <head>
    <script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
        <script>
            function validate(){
                var x=1;
                var msg="";
                var phoneformat=/09\d{8}/;
                var emailformat=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                if(document.form1.email.value.match(emailformat)){
                    
                }
                else{
                    x=0;
                    msg="The email is not valid, ";
                }
                if(document.getElementById('phone').value.trim()!='')
                {
                    if(!document.form1.phone.value.match(phoneformat)){
                    x=0;
                    msg+="The phone is not valid, ";
                    }
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
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
        #base{
            position: relative;
            left:350px;
            top:150px;
            margin-top:0;
            margin-left:0;
            height:110vh;
        }
        #primary{
            position:absolute;
            left:150px;
            margin-top:100px;
            width: 40vw;
            height: 85vh;
            background-color:rgba(4,73,128,0.5);  
            border-radius:50px;
            padding:40px;
           
        }
        label{
            font-size:18px;
        }
        h1,h3{
            color:rgba(0,0,0,1);
            font-weight: 900;
            z-index: 10000;
        }
        input{
            height: 35px;
            width: 20vw;
            position: absolute;
            border: 2px solid black;
            margin: 0;
            left:150px;
        }
        [type="file"]{
            border:none;
        }
        h1{
            margin-bottom:50px;
        }
        .input_field{
            margin: 20px;
            margin-bottom:40px;
            position: relative;
        }
        select{
            margin-top:20px; 
            height: 40px;
            width: 12vw;
        }
        #save{
            margin-left:0px;
            margin-top:20px;
            width: 12vw;
            font-weight: 500;
            font-size: larger;
            border:none;
        }
        #save:hover{
            background-color:rgba(0,0,0,0.4);
            color:white;
            cursor: pointer;
            border-radius: 8px;
            border: black solid 3px;
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
    <body>
        <div id="base">
            <div id="primary">
                <h1>User</h1>
                <form name="form1"  method="post" action="<?php echo URL."users/editUserSave"?>" onsubmit="return validate()">
                    <div class="input_field"> <label for="fname"> First Name </label> <input type="text" id="fname" name="first_name" required value="<?php echo $row['first_name'] ?>">  </div>
                    <div class="input_field"><label for="lname">Last Name </label> <input type="text" id="lname" name="last_name" required value="<?php echo $row['last_name'] ?>">  </div>
                    <div class="input_field"><label for="email"> Email </label> <input type="text" name="email" id="email" required value="<?php echo $row['email'] ?>"> </div>
                    <div class="input_field"><label for="phone"> Phone Number </label> <input type="text" name="phone"  id="phone" value="<?php echo $row['phone'] ?>"> </div>
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <div class="input_field">
                    <select required name="role_id" id="account">
                        <option value="" disabled>Choose an account type </option> 
                        <?php foreach($array as $arr) {
                            if($array2[$id]==$arr->role_name) { ?>
                            <option value=<?php echo $arr->id; ?>  selected> <?php echo $arr->role_name; ?>  </option>
                            <?php } else {  ?>
                           <option value=<?php echo $arr->id ;?> > <?php echo $arr->role_name; ?>  </option>
                        <?php }} ?>
                    </select>
                    </div>
                    <div class="input_field">
                    <label for="image">Select a photo: </label>
                    <input  type="file" name="image" id="image" accept="image/*">
                    </div>
                    <div class="input_field"> <input type="submit" name="submit" value="update user" id="save"  ></div>
                </form>
            </div>
        </div>
    </body>
</html>