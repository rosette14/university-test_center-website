<script> document.getElementById("Test").className="active"; </script>
<style>
    #base{
        height:350vh;
    }
    table{
        position:relative;
        margin-top:0;
        top:250px;
        left:400px;
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
    #edit, #delete{
        border:none;
        background-color:white;
        padding:8px;

    }
    #edit{
        padding-left:12px;
    }
    a{
        text-decoration:none;
        color:black;
    }
    #add{
        position:relative;
        top:200px;
        left:330px;
        margin:0;
        padding:0;
    }
    #view{
        background-color:white;
    }
    
    #back {
        display:block;
        position: relative;
        top:200px;
        left:350px;
        height:50px;
        width:200px;
        text-align:center;
        padding:15px 10px 10px 10px;
        border-radius:5px;
        background-color:rgb(0, 83, 179);
        font-weight:bold;
        font-family: sans-serif;
        color:white;
    }
    #qtext {
        width:150px;
    }
</style>
<div id="base">
<a id="back" href="<?php echo URL."tests/index" ?>"> Back to tests </a>
<div id="page">
    <table>
        <thead>
            <tr>
                <th> number </th>
                <th > Question Text </th>
                <th> Topic Name    </th>
                <th> Mark          </th>
                <th> Option 1      </th>
                <th> Option 2      </th>
                <th> Option 3      </th>
                <th> Option 4      </th>
                <th> Option 5      </th>
            </tr>
        </thead>
        <tbody>
            <?php  $c=1;
            foreach ($testQuestions as $question) { ?>
                <tr>
                    <td> <?php echo $c; $c++; ?> </td>
                    <td id="qtext"> <?php echo $questionsIdToTexts[$question->question_id]; ?></td>
                    <td> <?php echo $questionsIdToTopics[$question->question_id]; ?></td>
                    <td> <?php echo $question->mark; ?></td>
                    <?php
                    $i=0;
                    foreach ($questionsOptions[$question->question_id] as $value)
                    { $i++; ?>
                    <td> <?php echo $value; ?></td> <?php }
                    while($i<5) { ?>
                    <td> </td>
                    <?php $i++; } ?>
                </tr>
                <?php } ?>
        </tbody>
      </table>
    </div>
</div>

