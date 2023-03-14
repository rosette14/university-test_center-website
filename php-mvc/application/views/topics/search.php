<head>
<script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');
    #base{
        height:250vh;
    }
    #Topic a{
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
    #mat{
        position:relative;
        left:350px;
        top:190px;
        width:200px;    
       
    }
    h3{     
        font-family: 'EB Garamond', serif;
        font-size:25px;
    }
</style>
</head>
<body>
<div id="base">
    <div id="mat"><h3> <?php echo ucfirst($material_name); ?> </h3></div>
    <table>
        <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <th>Topic Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($topics as $topic) { ?>
                <tr>
                    <td><?php if (isset($topic->topic_name)) echo $topic->topic_name; ?></td>
                    <td id="edit"><a href=<?php echo URL."topics/editTopic/".$topic->id ?> > <img src="../public/img/edit.ico" title="edit" alt="edit"> </a> </td>
                    <td id="delete"><a href=<?php echo URL."topics/confirmTopicDelete/".$topic->id ?> > <img src="../public/img/delete.ico" title="delete" alt="delete"> </a> </td>
                </tr>
                <?php }?>
        </tbody>
    </table>
</div>
</body>