<script> document.getElementById("takeTest").className="active"; </script>
<html>
<head>
    <style>
        img{
            width:20px;
            height:20px;
        }
        #container{
            position:relative;
            top:200px;
            left:350px;
        }
        button{
            margin-top:20px;
            width: 75px;
            height:50px;
            margin-bottom:60px;
        }
    </style>
    <script>
        function back(){
            window.location.replace("http://127.0.0.1:8081/center_website/home/index");
        }
    
    </script>
</head>
<body>
    <div id="container">
    <h1 id='timeUP'> </h1>
    <h1> Your grade is <?php echo $grade."/".$total_grade; ?> </h1>
    <h2> The Questions: </h2>
    <?php
    $x=1;
    foreach($answers as $answer){
        echo $x.". ".$questionsTexts[$answer->question_id][0];
        if($answer->option_id==$questionsTexts[$answer->question_id][1])
            echo "&nbsp; &nbsp; <span style='color:green; font-size:18px;'> Correct </span>";
        else
            echo "&nbsp; &nbsp; <span style='color:red; font-size:18px;'> Wrong </span>";
        echo "<br> <br>";
        foreach($questionsOptions[$answer->question_id] as $op)
        {
            if($op[2]=='yes' && $op[1]=='yes'){
                ?>
                <div>
                    <input type='radio' checked disabled> <span> <?php echo $op[0]; ?>
                    <img src="http:\\127.0.0.1:8081\center_website\public\img\check.ico"> </span>
                </div>
                <?php
            }
            elseif($op[2]=='yes' && $op[1]=='no'){
                ?>
                <div>
                    <input type='radio' checked disabled> <?php echo $op[0]; ?>
                </div>
                <?php
            }
            elseif($op[2]=='no' && $op[1]=='yes'){
                ?>
                <div>
                    <input type='radio' disabled> <span> <?php echo $op[0]; ?>
                    <img src="http:\\127.0.0.1:8081\center_website\public\img\check.ico"> </span>
                </div>
                <?php
            }
            else {
                ?>
                <div>
                    <input type='radio' disabled> <?php echo $op[0]; ?>
                </div>
                <?php
            }
            echo "<br>";
        }
        $x=$x+1;
    }
    ?>
    <button onclick="back()"> OK </button>
    </div>
    <?php
        if($expire==1)
        {
            ?>
               <script> document.getElementById('timeUP').innerHTML="Your time has finished!"; </script>
            <?php
        }
    ?>
</body>
</html>