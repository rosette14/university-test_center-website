<html>
  <head>
    <script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
    </style>
  </head>
</html>
<?php
session_start();
class topics extends Controller
{
    public function index()
    {
        try{
            if(isset($_SESSION['admin_email'])){
                $topics_model=$this->loadModel('topicsModel');
                if($topics_model->checkPermission('Display Topics',$_SESSION['admin_role_id']))
                {
                    $topics=$topics_model->getAllTopics();
                    $arr=$topics_model->assignMaterialsIdToNames();
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/_templates/header.php';
                    require 'application/views/topics/index.php';
                    require 'application/views/_templates/footer.php';
                }
                else {
                    ?>
                    <script> 
                        Swal.fire({
                        title: 'You do NOT have permission to access topics',
                        confirmButtonText: 'OK',
                        }).then((result) => {
                        if (true) {
                          window.location.replace("http://127.0.0.1:8081/php-mvc/home/index");      
                        }
                        });
                    </script>
                    <?php
                    exit();
                }
            }
            else {
                    header('location: ' . URL . 'home/index');
            }
        }
        catch(PDOException $e){?>
            <script> Swal.fire('An error happened during the process, try later.'); </script>
            <?php exit();
        } 
        catch(Exception $e){?>
            <script> Swal.fire("<?php echo $e->getMessage();?>"); </script>
            <?php exit();
        }
    }
    public function getMaterialTopics(){
        try{
            if(isset($_POST['submit']))
            {
                $material_name=$_POST['material'];
                $topic_model=$this->loadModel('topicsModel');
                $topics=$topic_model->getMaterialTopics($material_name);
                if(isset($topics)){
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/_templates/header.php';
                    require 'application/views/topics/search.php';
                    require 'application/views/_templates/footer.php';
                }
                else{
                    ?>
                    <script>
                    Swal.fire({
                    title: 'There is no material with this name.',
                    confirmButtonText: 'OK',
                    }).then((result) => {
                    if (true) {
                      window.location.replace("http://127.0.0.1:8081/php-mvc/topics/index");
                    }
                    });
                    </script>
                    <?php
                    exit();
                }  
    
                }
                else{
                    header('location: ' . URL . 'home/index');
            }
        }
        catch(PDOException $e){?>
            <script> Swal.fire('An error happened during the process, try later.'); </script>
            <?php exit();
        } 
        catch(Exception $e){?>
            <script> Swal.fire("<?php echo $e->getMessage();?>"); </script>
            <?php exit();
        }
    }
    public function addTopic(){ //display a topic registeration form
        try{
            if(isset($_SESSION['admin_email'])){
                $topic_model=$this->loadModel('topicsModel');
                if($topic_model->checkPermission('Add Topic',$_SESSION['admin_role_id']))
                {
                    $array=$topic_model->getMaterials();
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/_templates/header.php';
                    require 'application/views/topics/addBox.php';
                    require 'application/views/_templates/footer.php';
                }
                else {
                    ?>
                    <script> 
                        Swal.fire({
                        title: 'You do NOT have permission to add topics',
                        confirmButtonText: 'OK',
                        }).then((result) => {
                        if (true) {
                          window.location.replace("http://127.0.0.1:8081/php-mvc/home/index");      
                        }
                        });
                    </script>
                    <?php
                    exit();
                }
            }
            else {
                require 'application/views/home/login.php';
            }
        }
        catch(PDOException $e){?>
            <script> Swal.fire('An error happened during the process, try later.'); </script>
            <?php exit();
        } 
        catch(Exception $e){?>
            <script> Swal.fire("<?php echo $e->getMessage();?>"); </script>
            <?php exit();
        }
    }
    public function addTopicSave(){ //save the info of the new topic account to topic table in database.
        try{
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                $topics_model=$this->loadModel('topicsModel');
                $topics_model->addTopicSave();
            }
            else {
                header('location: ' . URL . 'home/index');
            } 
        }
        catch(PDOException $e){?>
            <script> Swal.fire('An error happened during the process, try later.'); </script>
            <?php exit();
        } 
        catch(Exception $e){?>
            <script> Swal.fire("<?php echo $e->getMessage();?>"); </script>
            <?php exit();
        }
    }
    public function confirmTopicDelete($topic_id=null){ //display a confirm alert and act depending on admin choice.
        try{
            if(isset($_SESSION['admin_email'])){
                $topics_model=$this->loadModel('topicsModel');
                if($topics_model->checkPermission('Delete Topic',$_SESSION['admin_role_id']))
                {
                    if (isset($topic_id))
                    {
                        $row=$topics_model->getTopic($topic_id);
                        if(isset($row['id']))
                        {
                            $topics_model->confirmTopicDelete($topic_id);
                        }
                        else{
                            header('location: ' . URL . 'topics/index');
                        }
                    }
                    else{
                        header('location: ' . URL . 'topics/index');
                    }
                }
                else {
                    ?>
                    <script> 
                        Swal.fire({
                        title: 'You do NOT have permission to delete topics',
                        confirmButtonText: 'OK',
                        }).then((result) => {
                        if (true) {
                          window.location.replace("http://127.0.0.1:8081/php-mvc/home/index");      
                        }
                        });
                    </script>
                    <?php
                    exit();
                }
            }
            else {
                header('location: ' . URL . 'home/index');
            }
        }
        catch(PDOException $e){?>
            <script> Swal.fire('An error happened during the process, try later.'); </script>
            <?php exit();
        } 
        catch(Exception $e){?>
            <script> Swal.fire("<?php echo $e->getMessage();?>"); </script>
            <?php exit();
        }
    }
    public function deleteTopic($topic_id=null){ //delete the info of the topic if admin approved it.
        //try{
            if(isset($_SESSION['admin_email'])){
                if(isset($topic_id))
                {
                    $topics_model=$this->loadModel('topicsModel');
                    $row=$topics_model->getTopic($topic_id);
                    if(isset($row['id']))
                    {
                        $topics_model->deleteTopic($topic_id);
                    } 
                    header('location: ' . URL . 'topics/index');
                }
                else {
                    header('location: ' . URL . 'home/index');
                }
            }
            else {
                header('location: ' . URL . 'home/index');
            }
        //}
        /*catch(PDOException $e){?>
            <script> Swal.fire('An error happened during the process, try later.'); </script>
            <?php exit();
        } 
        catch(Exception $e){?>
            <script> Swal.fire("<?php echo $e->getMessage();?>"); </script>
            <?php exit();
        }*/

    }
    public function editTopic($topic_id=null){ //display the topic edit form
        try{
            if(isset($_SESSION['admin_email'])){
                $topic_model=$this->loadModel('topicsModel');
                if($topic_model->checkPermission('Update Topic',$_SESSION['admin_role_id']))
                {
                    if(isset($topic_id))
                    {
                        $id=$topic_id;
                        $array=$topic_model->getMaterials();
                        $row=$topic_model->getTopic($topic_id);
                        if(isset($row['id']))
                        {
                            require 'application/views/_templates/header.php';
                            require 'application/views/_templates/nav_admin.php';
                            require 'application/views/topics/editBox.php';
                            require 'application/views/_templates/footer.php';
                        }
                        else
                        {
                            header('location: ' . URL . 'home/index');
                        }
                    }
                    else{
                        header('location: ' . URL . 'home/index');
                    }
                }
                else {
                    ?>
                    <script> 
                        Swal.fire({
                        title: 'You do NOT have permission to edit topics',
                        confirmButtonText: 'OK',
                        }).then((result) => {
                        if (true) {
                          window.location.replace("http://127.0.0.1:8081/php-mvc/home/index");      
                        }
                        });
                    </script>
                    <?php
                    exit();
                }
            }
            else {
                require 'application/views/home/login.php';
            }
        }
        catch(PDOException $e){?>
            <script> Swal.fire('An error happened during the process, try later.'); </script>
            <?php exit();
        } 
        catch(Exception $e){?>
            <script> Swal.fire("<?php echo $e->getMessage();?>"); </script>
            <?php exit();
        }
    }
    public function editTopicSave(){ //save the updated info of the topic to topic table in database.
        try{
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                $topics_model=$this->loadModel('topicsModel');
                $topics_model->editTopicSave();
            }
            else {
                header('location: ' . URL . 'home/index');
            }
        }
        catch(PDOException $e){?>
            <script> Swal.fire('An error happened during the process, try later.'); </script>
            <?php exit();
        } 
        catch(Exception $e){?>
            <script> Swal.fire("<?php echo $e->getMessage();?>"); </script>
            <?php exit();
        }
    }
}
?>