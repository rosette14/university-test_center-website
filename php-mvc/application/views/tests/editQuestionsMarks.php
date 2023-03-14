<script> document.getElementById("Test").className="active"; </script>
<script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
<style>
   @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
   #base{
       height:350vh;
      }
   #primary{
        position:relative;
        margin-left:360px;
        top:200px;
    }
    table{
        position:relative;
        margin-top:0;
        left:0px;
        top:50px;
    }
    table, th, td {
        text-align:center;
        border-collapse:collapse;
        font-family: sans-serif;
    }
    td{
        height:40px;
        padding-left:40px;
        padding-right:40px;
    }
    tr:nth-child(odd) {
        background-color: rgba(129, 182, 243,0.5);

    }
    tr:nth-child(even) {
        background-color: rgb(123, 168, 228);
    }
    th{
        background-color:rgb(0, 83, 179);
        color:white;
        height:30px;
    }
    a {
        text-decoration:none;
        color:black;
    }
    #submit{
        width: 12vw;
        font-weight: 500;
        position: sticky;
        font-size: larger;
        left:360px;
        border:none;
        }
    #submit:hover{
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
<script>
    function validate(){
            var x=1;
            var msg="";
            var marks=document.getElementsByClassName('marks');
            for(var i=0;i<marks.length;i++){
                if(marks[i].value.trim()==="")
                {
                    x=0;
                    msg+="marks values can not be empty, ";
                    break;
                }
            }
            for(var i=0;i<marks.length;i++){
                if(marks[i].value.trim()!="")
                {
                    if(isNaN(marks[i].value))
                    {
                        x=0;
                        msg+="marks are not valid, ";
                    }
                    else if(parseInt(marks[i].value)<=0){
                        x=0;
                        msg+="marks should be positive numbers, ";
                    }
                }
            }
            if(x==0){
                Swal.fire(msg);
                return false;
            }
            else return true;
        }
</script>
<div id="base">
    <form action="<?php echo URL."tests/editTestSave" ?>" method="post" onsubmit="return validate()" >
    <div id="primary">
    <input type="submit" name="submit" id="submit" value="save test">    
    <div>
        <table>
            <thead>
                <tr>
                    <th> number        </th>
                    <th> Question Text </th>
                    <th> Topic Name    </th>
                    <th> Option 1      </th>
                    <th> Option 2      </th>
                    <th> Option 3      </th>
                    <th> Option 4      </th>
                    <th> Option 5      </th>
                    <th> Edit Mark     </th>
                </tr>
            </thead>
            <tbody>
                <?php  $c=1;
                foreach ($generatedQuestions as $question) { ?>
                    <tr>
                        <input type="hidden" name=<?php echo "Question".$c; ?> id=<?php echo "Question".$c; ?> value=<?php echo $question->question_id; ?> >
                        <td> <?php echo $c; ?> </td>
                        <td id="qtext"> <?php echo $questionsIdToTexts[$question->question_id]; ?></td>
                        <td> <?php echo $questionsIdToTopics[$question->question_id]; ?></td>
                        <?php
                        $i=0;
                        foreach ($questionsOptions[$question->question_id] as $val)
                        { $i++; ?>
                        <td> <?php echo $val; ?></td> <?php }
                        while($i<5) { ?>
                            <td> </td>
                            <?php $i++; } ?>
                        <td> <input type="text" class="marks" name=<?php echo "mark".$c; ?> id=<?php echo "mark".$c;?> value=<?php echo $question->mark; ?>> </td>
                        <?php $c++;  
                    } ?>
                        </tr>
            </tbody> 
        </table>
        <input type="hidden" name="questions_number" id="questions_number" value=<?php $c--; echo $c; ?>>
        <input type="hidden" name="test_name" id="test_name" value=<?php echo $test_name; ?>>
        <input type="hidden" name="id" id="id" value=<?php echo $test_id; ?>>
        <input type="hidden" name="duration" id="duration" value=<?php echo $duration; ?>>
    </form>
</div>
