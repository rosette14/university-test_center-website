<script> document.getElementById("Test").className="active"; </script>
<head>
<script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
        #base{
            position: relative;
            left:300px;
            top:200px;
            height:77vh;
        }
        #primary{
            margin-top:30px;
            width: 33vw;
            height:62vh;
            position:absolute;
            left:250px;
            padding:5px;
            background-color:rgba(4,73,128,0.5);  
            border-radius:50px;
            padding:10px;
        }
        label{
            font-size:18px;
        }
        input{
            height: 40px;
            width: 25vw;
            position: relative;
            left:30px;
            border: 2px solid black;
            margin: 0;
            margin-top:20px;
        }
        .input_field{
            margin: 20px;
            position: relative;
        }
        h1{
            margin-bottom:40px;
        }
        select{
            height: 40px;
            width: 12vw;
            position: relative;
            left: 30px;
        }
        #submit{
            left:9vw;
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
        .button{
            width: auto;
            height: auto;
        }
        .option{
            width:24vw;
        }
        .selection{
            margin-left:20px;
            display:inline;
        }
        h3{
            margin-bottom:0;
        }
        #topic_id{
            width:11.5vw;
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
        function validate(){
            var x=1;
            var msg="";
            if(document.getElementById('test_name').value.trim()==="")
            {
                x=0;
                msg+="test name can not be empty, ";
            }
            if(document.getElementById('duration').value.trim()==="")
            {
                x=0;
                msg+="duration can not be empty, ";
            }
            else {
                if(isNaN(document.getElementById('duration').value))
                {
                    x=0;
                    msg+="duration is not valid, ";
                }
                else if(parseFloat(document.getElementById('duration').value)<=0){
                    x=0;
                    msg+="duration must be positive number, ";
                }
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
        <h1 style="color:black">Test</h1>
        <form name="form1" action="<?php echo URL."tests/editTestSave" ?>" method="post" onsubmit="return validate()">
            <div class="input_field">
                <label for="test_name">Test name</label> <input type="text" value="<?php echo $row['test_name']; ?>" name="test_name" id="test_name" required>
            </div>
            <div class="input_field">
            <label for="duration">Duration </label> <input type="text" value="<?php echo $row['duration'];  ?>" name="duration" id="duration" required>
            </div>
            <div class="input_field"> Questions Numebr of this test: <?php echo $row['questions_number']; ?> </div>
            <div class="input_field">
                <a href="<?php echo URL."tests/editQuestionsMarks/".$id."/".$row['test_name']."/".$row['duration']; ?>"> Edit Questions Marks </a>
            </div>
            <div class="input_field">
                <input type="submit" id="submit" name="submit" value="save test" >
            </div>
            <input type="hidden" name="id" id="id" value=<?php echo $id; ?>>
        </form>
        </div>
        </div>
</body>