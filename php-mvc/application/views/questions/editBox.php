<script>
    var arr=new Array();
    var i=0;
    '<?php
     foreach($array2 as $ro) { ?>'
        arr[i]=["<?php echo $ro->material_id; ?>","<?php echo $ro->id; ?>","<?php echo $ro->topic_name; ?>"];
        i++;
        '<?php }
    ?>'
    i=0;
    var options=new Array();
    '<?php
    foreach($array3 as $ar) { ?>'
        options[i]=["<?php echo $ar->option_text; ?>","<?php echo $ar->is_correct; ?>"];
        i++;
    '<?php } ?>'
</script>
<head>
<script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
        #Question a{
        color:rgb(156, 195, 226);
        border-left:5px solid rgb(156, 195, 226);
        background-color: #1a1a27;
        outline:0;
        }
        #base{
            position: relative;
            left:300px;
            top:200px;
            height:105vh;
        }
        #primary{
            margin-top:30px;
            width: 33vw;
            height: 55vh;
            position:absolute;
            left:250px;
            padding:5px;
            background-color:rgba(4,73,128,0.5);  
            border-radius:50px;
            padding:10px;
           
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
        h1{
            margin-bottom:30px;
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
        label{
            font-size:18px;
            margin-left:15px;
        }
        #qtext{
            margin-top:10px;
            left:15px;
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
        function addTopics(){
            var x=document.getElementById('material_id').value;
            document.getElementById('topic_id').innerHTML=" <option selected disabled> Select a topic </option>";
            for(var i=0;i<arr.length;i++)
            {
                if(arr[i][0]==x)
                {
                    document.getElementById('topic_id').innerHTML+='<option value='+arr[i][1]+'>'+arr[i][2] +'</option>';
                }
            }
        }
        function generateOptions()
        {
            if(document.getElementById("options_number").value==2)
            {
                document.getElementById('primary').style.height='68vh';
                document.getElementById("options").innerHTML=''+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button1" class="button" required value="option1" >'+
                    '<input type="text" name="option1" id="option1" required class="option"  >'+
                '</div>'+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button2" class="button" value="option2">'+
                    '<input type="text" name="option2" id="option2" required class="option" >'+
                '</div>';
            }
            if(document.getElementById("options_number").value==3)
            {
                document.getElementById('primary').style.height='76vh';
                document.getElementById("options").innerHTML=''+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button1" class="button" required  value="option1">'+
                    '<input type="text" name="option1" id="option1" required class="option">'+
                '</div>'+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button2" class="button"  value="option2">'+
                    '<input type="text" name="option2" class="option" required id="option2">'+
                '</div>'+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button3" class="button" value="option3">'+
                    '<input type="text" name="option3" class="option" required id="option3" >'+
                '</div>';
            }
            if(document.getElementById("options_number").value==4)
            {
                document.getElementById('primary').style.height='83vh';
                document.getElementById("options").innerHTML=''+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button1" class="button" required value="option1">'+
                    '<input type="text" name="option1" class="option" required id="option1" >'+
                '</div>'+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button2" class="button" value="option2">'+
                    '<input type="text" name="option2" class="option" required id="option2" >'+
                '</div>'+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button3" class="button" value="option3">'+
                    '<input type="text" name="option3" class="option" required id="option3" >'+
                '</div>'+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button4" class="button" value="option4">'+
                    '<input type="text" name="option4" class="option" required id="option4" >'+
                '</div>';
            }
            if(document.getElementById("options_number").value==5)
            {
                document.getElementById('primary').style.height='92vh';
                document.getElementById("options").innerHTML=''+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button1" class="button" required value="option1">'+
                    '<input type="text" name="option1" class="option" required id="option1" >'+
                '</div>'+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button2" class="button" value="option2">'+
                    '<input type="text" name="option2" class="option" required id="option2" >'+
                '</div>'+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button3" class="button" value="option3">'+
                    '<input type="text" name="option3" class="option" required id="option3" >'+
                '</div>'+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button4" class="button" value="option4">'+
                    '<input type="text" name="option4" class="option" required id="option4" >'+
                '</div>'+
                '<div class="input_field">'+
                    '<input type="radio" name="button" id="button5" class="button"  value="option5">'+
                    '<input type="text" name="option5" class="option" required id="option5">'+
                '</div>';
            }
        }
    </script>
    <script>
        function validate(){
            var x=1;
            var msg=""
            if(document.getElementById('material_id').value.trim()==="")
            {
                x=0;
                msg+="chosen material can not be empty, ";
            }
            if(document.getElementById('topic_id').value.trim()==="")
            {
                x=0;
                msg+="chosen topic can not be empty, ";
            }
            if(document.getElementById('qtext').value.trim()==="")
            {
                x=0;
                msg+="question text can not be empty, ";
            }
            if(document.getElementById('options_number').value.trim()==="")
            {
                x=0;
                msg+="options number can not be empty, ";
            }
            if(document.getElementById('options_number').value.trim()!=""){
                var options=document.getElementsByClassName('option');
                var buttons=document.getElementsByClassName('button');
                var selected=0;
                for(var i=0;i<options.length;i++){
                    if(options[i].value.trim()==='')
                    {
                        x=0;
                        msg+='options texts can not be empty, ';
                        i=options.length;
                        break;
                    }
                    if(buttons[i].checked)
                    {
                        selected=1;
                    }
                }
                if(selected==0) {
                    x=0;
                    msg+='an option must be selected, ';
                }
                for(var i=0;i<options.length;i++){
                    for(var j=i+1;j<options.length;j++){
                        if(options[i].value.trim()==options[j].value.trim())
                        {
                            x=0;
                            msg+='options can not be the same';
                            i=options.length;
                            break;
                        }
                    }
                }
            }
            if(x==0){
            Swal.fire({
            title:msg,
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
        <h1 style="color:black">Question</h1>
        <form name="form1" action="<?php echo URL."questions/editQuestionSave" ?>" method="post" onsubmit="return validate();" >
            <div class="input_field">
                <label for="qtext">Question text</label>
                <input type="text" placeholder="Question Text" name="question_text" id="qtext" value="<?php echo $row['question_text']; ?>" required>
            </div>
            <div  class="selection">
                <select name="material_id" id="material_id" reqiured onChange="addTopics()" >
                    <option value="" disabled> Select a material </option>
                    <?php
                    foreach($array as $ar){
                        if($ar->id==$row['material_id']){ ?>
                        <option selected value="<?php echo $ar->id; ?>"> <?php echo $ar->material_name; ?> </option>;
                    <?php } else { ?>
                        <option value="<?php echo $ar->id; ?>"> <?php echo $ar->material_name; ?> </option>;
                    <?php }} ?>    
                </select>
            </div>
            <div  class="selection">
                <select id="topic_id" name="topic_id" required="required">
                    <option value= "" disabled> Select a topic </option>
                    <script>
                    for(var i=0;i<arr.length;i++)
                    {
                        if(arr[i][0]==<?php echo $row['material_id'] ?>)
                        {
                            if(arr[i][1]==<?php echo $row['topic_id'] ?>)
                              document.getElementById('topic_id').innerHTML+='<option selected value='+arr[i][1]+'>'+arr[i][2] +'</option>';
                            else
                              document.getElementById('topic_id').innerHTML+='<option value='+arr[i][1]+'>'+arr[i][2] +'</option>';
                        }
                    }
                    </script>
                </select>
            </div>
            <div class="input_field">
                <select onChange="generateOptions()" name="options_number" id="options_number" required>
                    <option value="" disabled> Select number of options </option>
                    <?php if($row['options_number']==2) { ?>
                        <option selected> 2 </option> <?php } else { ?>
                        <option> 2 </option> <?php }?>
                    <?php if($row['options_number']==3) { ?>
                        <option selected> 3 </option> <?php } else { ?>
                            <option> 3 </option> <?php }?>
                    <?php if($row['options_number']==4) { ?>
                        <option selected> 4 </option> <?php } else { ?>
                        <option> 4 </option> <?php }?>
                    <?php if($row['options_number']==5) { ?>
                        <option selected> 5 </option> <?php } else { ?>
                        <option> 5 </option> <?php }?>
                </select>
            </div>
            <div id="options"> 
                <script>
                    generateOptions();
                    for(var i=0;i<options.length;i++)
                    {
                        document.getElementById("option"+(i+1)).value=options[i][0];
                        if(options[i][1]=="yes")
                        {
                            document.getElementById("button"+(i+1)).checked="checked";
                        }
                    }
                </script>
            </div>
            <div class="input_field">
                <input type="submit" id="submit" name="submit" value="save question" >
            </div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        </form>
        </div>
        </div>
</body>