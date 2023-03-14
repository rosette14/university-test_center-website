<html>
    <head>
    <script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
    <script>
            document.getElementById('Role').className="active";
        </script>
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
        #base{
            position: relative;
            top:100px;
            left:200px;
            margin-top:0;
            margin-left:0;
        }
        #primary{
            position:absolute;
            margin-top:100px;
            width: 30vw;
            background-color:rgba(4,73,128,0.5);  
            border-radius:50px;
            padding:40px;
            top:20px;
            left:350px;       
        }
        h1,h3{
            color:rgba(0,0,0,1);
            font-weight: 900;
            z-index: 10000;
        }
        input{
            border: 2px solid black;
            margin: 0;
            height:30px;
            margin-left:10px;
        }
        .input_field{
            margin: 20px;
            margin-top:0px;
        }
        [type="checkbox"]{
            height:15px;
            width:15px;
            margin-bottom:5px;
            margin-top:5px;
            margin-left:30px;
        }
        label{
            font-size:18px;
        }
        #submit{
            margin-left:80px;
            margin-top:20px;
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
        #choose{
            font-size:18px;
            margin:20px;
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
        <script>
            function validate()
            {
                if(document.getElementById('role').value.trim()===''){
                    Swal.fire('Role name can not be empty');
                    return false;
                }
                var perm=document.getElementsByClassName('perm');
                for(var i=0;i<perm.length;i++)
                {
                    var r1=perm[i].value.split(" ");
                    if(r1[0]=='Display' && !(perm[i].checked) )
                    {
                        for(var j=0;j<perm.length;j++)
                        {
                            var r2=perm[j].value.split(" ");
                            if((r2[r2.length-1]+'s')!=r1[r1.length-1]) continue;
                            if(perm[j].checked)
                            {
                                Swal.fire('You can NOT select add or update or delete permissions without selecting display permission.');
                                return false;
                            }
                        }
                    }
                }
                return true;
            }
        </script>
    </head>
    <body>
        <div id='base' >
            <div  id="primary">
            <h1 >Role</h1>
            <br>
            <form  name="form1" action="<?php echo URL."roles/editRoleSave"?>" method="post" onsubmit="return validate()">
                <div class="input_field" id="input_name">
                    <label for="role_name">Role name  </label>
                    <input  type="text" name="role_name" id="role" value="<?php echo $row['role_name'] ?>" required>
                </div>
                <span id="choose">Choose permission</span>
                <br>
                <br>
                <div class="input_field">
                        <?php foreach($array as $perm) {
                            if($per[$perm->id][0]!='Ask For Test'&& $per[$perm->id][0]!='See Students Results'
                            && $per[$perm->id][0]!='Take Test'&& $per[$perm->id][0]!='See Own Results'){ ?>
                            <div> <?php
                            if ($per[$perm->id][1]==true) { ?>
                            <input type="checkbox" checked class="perm" name="<?php echo $perm->id ?>" value="<?php echo $per[$perm->id][0]; ?>" > <?php echo $per[$perm->id][0]; ?>
                        <?php } else { ?>
                            <input type="checkbox" class="perm" name="<?php echo $perm->id; ?>" value="<?php echo $per[$perm->id][0]; ?>"> <?php echo $per[$perm->id][0]; ?>
                   <?php } ?> </div> <?php }} ?>
                </div>
                <div class="input_field">
                    <input  type="submit" id="submit" name="submit" value="save role" >
                </div>
                <input type="hidden" value="<?php echo $id; ?>" name="id">
            </form>
            </div>
            </div>
    </body>
</html>