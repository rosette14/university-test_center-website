
<head>
<script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>

    <style>
            @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
            #Material a{
                color:rgb(156, 195, 226);
                border-left:5px solid rgb(156, 195, 226);
                background-color: #1a1a27;
                outline:0;
            }
            #base{
                position: relative;
                top:200px;
                left:400px;
            }
            #primary{
                position:absolute;
                width: 27vw;
                height: 50vh;
                background-color:rgba(4,73,128,0.5);  
                border-radius:50px;
                padding:10px;
                padding-top: 20px;
                left:80px;
                top:50px;
            }
            label{
                font-size:18px;
            }
            h1,h3{
                color:rgba(0,0,0,1);
                font-weight: 900;
            }
            input{
                height: 40px;
                width: 20vw;
                position: relative;
                border: 2px solid black;
                margin: 0;
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
            #save{
                left:60px;
                top:0px;
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
            #description{
                border: 2px solid black;
                width: 20vw;
                margin-top:15px;
            }
            h2{
                width: 30px;
                margin-left:20px;
                margin-top: 0;
                margin-bottom: 30px;
            }
            .swal2-popup {
            font-size: 15px !important;
            border:2px solid black;
            font-weight:6px;
            background-color:rgb(245,245,245);
            color:black;
            padding:5px;
            }
    </style>
    <script>
        function validate(){
            var x=1;
            var msg="";
            if(document.getElementById('material_name').value.trim()==="")
            {
                x=0;
                msg="material name can not be empty";
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
        <div id='base'>
            <div id="primary">
                <br>
                <h2>Material</h2>
                <form name="form1" action="<?php echo URL."materials/editMaterialSave"?>" method="post" onsubmit="return validate()" >
                    <div class="input_field">
                        <label for="material_name">Material name</label>
                        <input type="text" placeholder="Material Name" id="material_name"  value="<?php echo $row['material_name']; ?>" name="material_name" id="material_name" required>
                    </div>
                    <div class="input_field">
                        <label for="description">Description</label>
                        <textarea name="description" id="description"  maxlength="500"><?php echo $row['description']; ?> </textarea>
                    </div>
                    <div class="input_field">
                        <input type="submit" id="save" name="submit" value="update material" >
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                </form>
            </div>
        </div>
</body>