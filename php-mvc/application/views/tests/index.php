<script> document.getElementById("Test").className="active"; </script>
<style>
    #page{
        height:300vh;
    }
    table{
        position:relative;
        top:200px;
        left:400px;
        margin-top:0;
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
</style>
<div id="page">
<a href=<?php echo URL."tests/addTest" ?>> <img src="../public/img/add.ico" title="add" alt="add" id="add" onclick="myFun()"> </a>
<table>
            <thead>
            <tr>
                <th>Test Name</th>
                <th>Duration (hours)</th>
                <th>Questions Number</th>
                <th>Material Name</th>
                <th> Test Center Name </th>
                <th> Total Grade </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tests as $test) { ?>
                <tr>
                    <td><?php if (isset($test->test_name)) echo $test->test_name; ?></td>
                    <td><?php if (isset($test->duration)) echo $test->duration; ?></td>
                    <td><?php if (isset($test->questions_number)) echo $test->questions_number; ?></td>
                    <td><?php if (isset($test->material_id)) echo $materials[$test->material_id]; ?></td>
                    <td><?php if (isset($test->test_center_id)) echo $test_centers[$test->test_center_id]; ?></td>
                    <td><?php if (isset($test->total_grade)) echo $test->total_grade; ?></td>
                    <td id="view"><a href=<?php echo URL."tests/viewQuestions/".$test->id; ?>>  View Questions </a> </td>
                    <td id="edit"><a href=<?php echo URL."tests/editTest/".$test->id; ?> > <img src="../public/img/edit.ico" title="edit" alt="edit"> </a> </td>
                    <td id="delete"><a href=<?php echo URL."tests/confirmTestDelete/".$test->id; ?> > <img src="../public/img/delete.ico" title="delete" alt="delete"> </a> </td>
                </tr>
                <?php }?>
            </tbody>
</table>
            </div>
<?php 
