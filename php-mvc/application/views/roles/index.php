<script>
    var options=new Array();
    document.getElementById('Role').className="active";
</script>

<style>
    #base{
        height:200vh;
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
    #qtext{
        width:250px;
        padding-right:0;
    }
    .dropimg {
    cursor: pointer;
    }
    .dropbtn:hover, .dropbtn:focus {
      background-color: #2980B9;
    }
    
    .dropdown {
      position: relative;
      display: inline-block;
    }
    
    .dropdown-content {
      margin-top:0;
      padding:0;
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      background-color: rgb(153, 199, 252);
      min-width: 160px;
      overflow: auto;
      border-radius:6px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }
    .dropdown-content li {
      color: black;
      text-align:left;
     
      padding: 12px 16px;
      padding-left:15px;
      border-bottom:1px solid black;
      list-style-type:none;
    }
    .show{
        display:block;
    }
    </style>
    <script>
    function myFunction(x) {
    document.getElementById(x).style.display="block";
    var str="";
    var c;
    for( c=0;c<options.length;c++)
    {
        if(options[c][0]==x)
        {
            str+="<li>"+options[c][1]+"</li>";
        }
        else {
            document.getElementById(options[c][0]).style.display="none";
        }
    }
    document.getElementById(x).innerHTML="";
    document.getElementById(x).innerHTML+=str;
    }
    window.onclick = function(event) {
    if (!event.target.matches('.dropimg'))
    {
    for(var c=0;c<options.length;c++)
    {
    document.getElementById(options[c][0]).style.display="none";
    }
}
}
</script>
<div id="base">
    <a href=<?php echo URL."roles/addRole"; ?> id="add"> <img src="../public/img/add.ico" title="add" alt="add"> </a>
    <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <th id="role_name">Role Name</th>
                <th id="permissions">Permissions</th>
            </tr>
            </thead>
            <tbody>
                <script>
                    var i=-1;
                </script>
            <?php foreach ($roles as $role) { ?>
                <tr>
                    <td><?php if (isset($role->role_name)) echo $role->role_name; ?></td>
                    <td> 
                    <script>
                        <?php foreach($arr[$role->id] as $value) {
                             ?>
                             i=i+1;
                             options[i]=["<?php echo $role->id; ?>","<?php echo  $value; ?>"];
                             <?php
                        }    ?>
                        </script>
                    <div class="dropdown">
                    <img  onclick='myFunction(<?php echo $role->id; ?>)' src="../public/img/15.ico" id="display" class="dropimg" onfocusout="fun(<?php echo $role->id ;?>)">
                        <ul id=<?php echo $role->id; ?> class="dropdown-content">
                        
                        </ul>
                    </div>
                    </td>
                    <?php if($role->role_name!='Student' && $role->role_name!='Test Center Admin' && $role->role_name!='Admin'){ ?>
                    <td id="edit"><a href=<?php echo URL."roles/editRole/".$role->id; ?> > <img src="../public/img/edit.ico" title="edit" alt="edit"> </a> </td>
                    <td id="delete"><a href=<?php echo URL."roles/confirmRoleDelete/".$role->id; ?> > <img src="../public/img/delete.ico" title="delete" alt="delete"> </a> </td>
                <?php } ?>
                    </tr>
                <?php }?>
        </tbody>
    </table> 
</div>
