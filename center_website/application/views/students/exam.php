<script> document.getElementById("takeTest").className="active"; </script>
<html>
<head>
      <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');
        #base{
            position: relative;
            top:200px;
            left:400px;
        }
        #primary{
            position:absolute;
            width: 42vw;
            height: 45vh;
            background-color:rgba(4,73,128,0.5);  
            border-radius:50px;
            padding:10px;
            padding-top: 20px;
            left:80px;
            top:100px;
        }
        #question_text{
            margin:15px;
            font-size:19px;

        }
        #options{
            
            font-size:18px;

        }
        .input_field{
            margin-left:19px;
            margin-bottom:9px;
        }
        h1,h3{
            color:rgba(0,0,0,1);
            font-weight: 900;
            z-index: 10000;
        }
        #submit{
            position:absolute;
            top:38vh;
            left:28vw;
            width: 10vw;
            padding:6px;
            font-weight: 500;
            font-size: larger;
            border:1px solid black;
            border-radius:10px;
        }
        #submit:hover{
            background-color:rgba(0,0,0,0.3);
            color:white;
            cursor: pointer;
            border-radius: 12px;
            border: black solid 1px;
        }
        #primary h3{
            margin-left:30px;
            font-size:18px;
        }
        #timer{
            position:absolute;
            top:70px;
            left:650px;
            font-size:25px;
        }
        #watch{
            position:absolute;
            top:0px;
            left:668px;
        }
        #ques_num{
            position:absolute;
            top:0px;
            font-size:20px;
            margin-bottom:8px;
            font-family: 'EB Garamond', serif;

        }
        #answered{
            position:absolute;
            top:30px;
            font-size:20px;
            font-family: 'EB Garamond', serif;


        }
        </style>
</head>
</html>
<html>
<head>
<script>
  var start= "<?php echo $start; ?>" ;
  var duration= "<?php echo $duration; ?>" ;
  var now = new Date().getTime()/1000;
  var d=new Date();
  d.setTime(now-start);
  var countDownDate =d.getTime();
  var distance = duration*60*60 - countDownDate;
  var x = setInterval(function() {
    if (distance < 0) {
    clearInterval(x);
    window.location.replace("http://127.0.0.1:8081/center_website/students/timeExpire/"+"<?php echo $result_file_id; ?>");
    exit();
  }
  var hours = Math.floor((distance % (60 * 60 * 24)) / (60 * 60));
  var minutes = Math.floor((distance % (60 * 60)) / (60));
  var seconds = Math.floor(distance % (60));
   document.getElementById("timer").innerHTML = hours + "h "
  + minutes + "m " + seconds + "s ";
  distance--;
}, 1000);
</script>
</head>
<body>
    <div id="base" >
    <div id="watch">
        <img src="http:\\127.0.0.1:8081\center_website\public\img\watch1.png" height="80px" width="80px">
    </div>
    <div id="timer">
        
    </div>
    <div id="ques_num"> Total number of questions: <?php echo $number;?> </div>
    <div id="answered"> You have submitted <?php echo $order-1; ?> out of <?php echo $number;?> </div>
    <form action="<?php echo URL.'students/displayNext' ?>" method="post">
        <div id="primary">
            <div id="question_text">
                
            </div>
            <div id="options">
            </div>
            <div>
                <input type='submit' id='submit' value='next' name='next'>
            </div>
        </div>
       
        <input type="hidden" name="number" value="<?php echo $number;?>">
        <input type="hidden" name="order" value="<?php echo $order;?>">
        <input type="hidden" name="duration" value="<?php echo $duration;?>">
        <input type="hidden" name="start" value="<?php echo $start;?>">
        <input type="hidden" name="question_id" value="<?php echo $question_id;?>">
        <input type="hidden" name="result_file_id" value="<?php echo $result_file_id; ?>">
        <?php
        $counter=1;
        foreach($_POST as $key=>$value)
        {
            $x='question'.$counter;
            if($key==$x)
            {
                ?>
                <input type="hidden" name="<?php echo $x; ?>" value="<?php echo $_POST[$x];?>">
                <?php
                $counter=$counter+1;
            }
        }
        ?>
    </form>  
    </div>     
</body>
<script>
         <?php 
        
            if($order==$number)
            {
                ?>
                document.getElementById('submit').name='submit';
                document.getElementById('submit').value='submit';
                <?php
            }
            ?>
            document.getElementById('question_text').style.width="38vw";
            document.getElementById('question_text').innerHTML="<?php echo $order.". ".$question_text; ?>";
            document.getElementById('options').innerHTML="";
            <?php
            foreach($options as $option)
            {
                ?>
                document.getElementById('options').innerHTML+=""+
                "<div class='input_field'> <input type='radio' name='option_id' value='<?php echo $option[0];?>'>"+
                "<?php echo $option[1]; ?>"+"</div>";
                <?php
            }
            ?>
    </script>
</html>
