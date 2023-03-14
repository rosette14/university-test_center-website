<html>
    <head>
    <script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
    <script>
        document.getElementById('Test_center').className="active";
    </script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
           #base{
                position: fixed;
                top:200px;
                left:400px;
            }
            #primary{
                position:absolute;
                top:50px;
                left:180px;
                width: 27vw;
                height: 45vh;
                background-color:rgba(4,73,128,0.5);  
                border-radius:50px;
                padding:10px;
                padding-top: 20px;
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
                margin:0;
                margin-top:15px;
            }
            .input_field{
                margin: 20px;
                position: relative;
                left:30px;
            }
            select{
                height: 40px;
                width: 12vw;
            }
            #submit{
                left:60px;
                top:10px;
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
            .swal2-popup {
            font-size: 15px !important;
            font-family: Georgia, serif;
            border:2px solid black;
            font-weight:6px;
            background-color:rgb(245,245,245);
            font-family: 'Nanum Myeongjo', serif;
            color:black;
            }
        </style>
    <script>
        function validate(){
            var x=1;
            var msg=""
            if(document.getElementById('center_name').value.trim()==="")
            {
                x=0;
                msg+="center name can not be empty, ";
            }
            if(document.getElementById('test_center_admin').value.trim()==="")
            {
                x=0;
                msg+="test center admin can not be empty, ";
            }
            if(x==0){
                Swal.fire({
                html: '<pre>' + msg + '</pre>',
                customClass: {
                popup: 'format-pre'
                },
                confirmButtonText: 'OK',
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
        <div id='base' >
            <div  id="primary">
            <h1 >Test Center</h1>
            <form  name="form1" action="<?php echo URL."test_centers/addTest_centerSave"?>" method="post" onsubmit="return validate()">
                <div class="input_field" id="input_name">
                    <input type="text" name="center_name" id="center_name" placeholder="Test Center Name" required>
                </div>
                <div class="input_field">
                    <select name="user_id" id="test_center_admin" required>
                        <option value="" selected disabled> Choose Test Center Admin </option>
                        <?php foreach($array as $key=>$value){ ?>
                            <option value=<?php echo $key; ?> > <?php echo $value ;?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input_field">
                    <input  type="submit" id="submit" name="submit" value="save Test Center" >
                </div>
            </form>
            </div>
            </div>
    </body>
</html>