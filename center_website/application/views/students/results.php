<script> document.getElementById("showResults").className="active"; </script>
<style>
    #page{
        height:600vh;
    }
    table{
        position:relative;
        top:200px;
        left:590px;
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
</style>
<div id="page">
<table>
            <thead>
            <tr>
                <th>Test Name</th>
                <th>Material Name</th>
                <th>Date </th>
                <th>Grade </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $result) { ?>
                <tr>
                    <td><?php if (isset($result->test_id)) echo $tests[$result->test_id][0]; ?></td>
                    <td><?php if (isset($result->material_id)) echo $materials[$result->material_id]; ?></td>
                    <td><?php if (isset($result->test_date)) echo $result->test_date; ?></td>
                    <td><?php if (isset($result->result)) echo $result->result."/".$tests[$result->test_id][1];  ?></td>
                </tr>
                <?php }?>
            </tbody>
</table>
            </div>
<?php 
