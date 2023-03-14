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
class materials extends Controller
{
    public function index()
    {
       try
       {
            if(isset($_SESSION['admin_email']))
            {
                $materials_model=$this->loadModel('materialsModel');
                if($materials_model->checkPermission('Display Materials',$_SESSION['admin_role_id']))
                {
                    $materials=$materials_model->getAllMaterials();
                    require 'application/views/_templates/header.php';
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/materials/index.php';
                    require 'application/views/_templates/footer.php';
                }
                else {
                    ?>
                    <script>
                        Swal.fire({
                        title: 'You do NOT have permission to access materials',
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
    public function addMaterial(){ //display material addition form
        try
        {
            if(isset($_SESSION['admin_email'])){
                $materials_model=$this->loadModel('materialsModel');
                if($materials_model->checkPermission('Add Material',$_SESSION['admin_role_id']))
                {       
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/_templates/header.php';
                    require 'application/views/materials/addBox.php';
                    require 'application/views/_templates/footer.php';  
                }
                else {
                    ?>
                    <script> 
                        Swal.fire({
                        title: 'You do NOT have permission to add materials',
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
    public function addMaterialSave(){ //save the info of the new material to material table in database.
        try{
            if(isset($_SESSION['admin_email']) && isset($_POST['submit'])){
                $materials_model=$this->loadModel('materialsModel');
                $materials_model->addMaterialSave();
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
    public function confirmMaterialDelete($material_id=null){ //display a confirm alert and act depending on admin choice.
        try{
            if(isset($_SESSION['admin_email'])){
                $materials_model=$this->loadModel('materialsModel');
                if($materials_model->checkPermission('Delete Material',$_SESSION['admin_role_id']))
                {
                    if (isset($material_id))
                    {
                        
                        $row=$materials_model->getMaterial($material_id);
                        if(isset($row['id']))
                        {
                            $materials_model->confirmMaterialDelete($material_id);
                        }
                        else
                        {
                            header('location: ' . URL . 'materials/index');
                        }
                    }
                    else{
                        header('location: ' . URL . 'materials/index');
                    }
                }   
                else {
                ?>
                <script> 
                        Swal.fire({
                        title: 'You do NOT have permission to delete materials',
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
    public function deleteMaterial($material_id=null){ //delete the info of the material if admin approved it.
       try{
        if(isset($_SESSION['admin_email'])){
            if(isset($material_id))
            {
                $materials_model=$this->loadModel('materialsModel');
                $row=$materials_model->getMaterial($material_id);
                if(isset($row['id']))
                {
                    $materials_model->deleteMaterial($material_id);
                } 
                header('location: ' . URL . 'materials/index');
            }
            else {
                header('location: ' . URL . 'home/index');
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
    public function editMaterial($material_id=null){ //display the material edit form
        try{
            if(isset($_SESSION['admin_email']))
            {
                $materials_model=$this->loadModel('materialsmodel');
                if($materials_model->checkPermission('Update Material',$_SESSION['admin_role_id']))
                {
                    if(isset($material_id))
                    {
                       
                        $id=$material_id;
                        $row=$materials_model->getMaterial($material_id);
                        if(isset($row['id']))
                            {
                                require 'application/views/_templates/header.php';
                                require 'application/views/_templates/nav_admin.php';
                                require 'application/views/materials/editBox.php';
                                require 'application/views/_templates/footer.php';
                            }
                        else {
                            header('location: ' . URL . 'home/index');
                        }
                    }
                    else {
                        header('location: ' . URL . 'materials/index');
                    }
                }
                else {
                    ?>
                    <script> 
                        Swal.fire({
                        title: 'You do NOT have permission to edit materials',
                        confirmButtonText: 'OK',
                        }).then((result) => {
                        if (true) {
                          window.location.replace("http://127.0.0.1:8081/php-mvc/home/index");
                          
                        }
                        });
                    </script>
                    <?php
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
    public function editMaterialSave(){ //save the updated info of the material to material table in database.
        try{
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                $materials_model=$this->loadModel('materialsModel');
                $materials_model->editMaterialSave();
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
