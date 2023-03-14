<head>
<script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
        #Topic a {
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
            padding-top: 30px;
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
            margin-top:15px;
        }
        label{
            font-size:18px;
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
            top:10px;
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
        #hidden{
            height: 20px;
            margin-top:0;
            position: relative;
            left:50px;
            color:rgba(255,0,0,0.7);  
            padding:0;
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
            font-size: 12px !important;
            font-family: Georgia, serif;
            border:2px solid black;
            font-weight:6px;
            background-color:rgb(245,245,245);
            font-family: 'Nanum Myeongjo', serif;
            color:black;
            }
        .swal2-title
            {
            width:400px;
            }
    </style>
    <script>
        function validate(){
            var x=1;
            var msg="";
            if(document.getElementById('topic_name').value.trim()==="")
            {
                x=0;
                msg+="topic name can not be empty, ";
            }
            if(document.getElementById('material').value.trim()==="")
            {
                x=0;
                msg+="material can not be empty, ";
            }
            if(x==0){
                Swal.fire(msg);
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
                <h2>Topic</h2>
                <form name="form1" action="<?php echo URL."topics/editTopicSave"?>" method="post" onsubmit="return validate()">
                    <div class="input_field">
                        <label for="topic_name">Topic name</label>
                        <input type="text" value="<?php echo $row['topic_name']; ?>" name="topic_name" id="topic_name" required>
                    </div>
                    <div class="input_field">
                    <select name="material_id" id="material" required>
                        <option value="" disabled >Choose a material </option> 
                        <?php foreach($array as $arr) { 
                           if($row['material_id']==$arr->id) { ?>
                           <option selected value=<?php echo $arr->id; ?> > <?php echo $arr->material_name; ?>  </option>
                        <?php } else { ?>
                            <option value=<?php echo $arr->id; ?> > <?php echo $arr->material_name; ?>  </option>
                        <?php }} ?>
                    </select>
                    </div>
                    <div class="input_field">
                        <input type="submit" id="save" name="submit" value="update topic" >
                    </div>
                    <input type="hidden" value="<?php echo $id ?>" name="id">
                </form>
            </div>
        </div>
</body>