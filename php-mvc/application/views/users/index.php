<script> document.getElementById("User").className="active"; </script>
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
</style>
<div id="page">
<a href=<?php echo URL."users/addUser" ?>> <img src="../public/img/add.ico" title="add" alt="add" id="add" onclick="myFun()"> </a>
<table>
            <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th> Role </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php if (isset($user->first_name)) echo $user->first_name; ?></td>
                    <td><?php if (isset($user->last_name)) echo $user->last_name; ?></td>
                    <td><?php if (isset($user->email)) echo $user->email; ?></td>
                    <td><?php if (isset($user->phone)) echo $user->phone; ?></td>
                    <td><?php echo $userRoleName[$user->id]; ?></td>
                    <td id="edit"><a href=<?php echo URL."users/editUser/".$user->id; ?> > <img src="../public/img/edit.ico" title="edit" alt="edit"> </a> </td>
                    <td id="delete"><a href=<?php echo URL."users/confirmUserDelete/".$user->id; ?> > <img src="../public/img/delete.ico" title="delete" alt="delete"> </a> </td>
                </tr>
                <?php }?>
            </tbody>
</table>
            </div>
<?php 
