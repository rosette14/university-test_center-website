<style>
    #base{
        height:200vh;
    }
    #Material a{
      color:rgb(156, 195, 226);
      border-left:5px solid rgb(156, 195, 226);
      background-color: #1a1a27;
      outline:0;
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
</style>
<div id="base">
    <a href=<?php echo URL."materials/addMaterial"; ?> id="add"> <img src="../public/img/add.ico" title="add" alt="add"> </a>
    <table>
            <thead style="background-color: #ddd; font-weight: bold;">
                <tr>
                    <th>material name</th>
                    <th>description </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materials as $material) { ?>
                    <tr>
                        <td><?php if (isset($material->material_name)) echo $material->material_name; ?></td>
                        <td><?php if (isset($material->description)) echo $material->description; ?></td>
                        <td id="edit"><a href=<?php echo URL."materials/editMaterial/".$material->id ?> > <img src="../public/img/edit.ico" title="edit" alt="edit"> </a> </td>
                        <td id="delete"><a href=<?php echo URL."materials/confirmMaterialDelete/".$material->id ?> > <img src="../public/img/delete.ico" title="delete" alt="delete"> </a> </td>
                    </tr>
                    <?php }?>
            </tbody>
    </table>
</div>
<?php
require 'application/views/_templates/nav_admin.php';
require 'application/views/_templates/header.php';
?>