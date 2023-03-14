<head>
<script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
    </style>
  </head>
<?php
session_start();
class roles extends Controller
{
    public function index()
    {
        try{
            if(isset($_SESSION['admin_email'])){
                $roles_model=$this->loadModel('rolesModel');
                if($roles_model->checkPermission('Display Roles',$_SESSION['admin_role_id']))
                {
                    $roles=$roles_model->getAllRoles();
                    $arr=$roles_model->assignPermissionsToRoles();
                    require 'application/views/_templates/header.php';
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/roles/index.php';
                    require 'application/views/_templates/footer.php';
                }
                else {
                    ?>
                    <script>
                        Swal.fire({
                        title: 'You do NOT have permission to access roles',
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
    public function addRole(){
        try{
            if(isset($_SESSION['admin_email'])){
                $roles_model=$this->loadModel('rolesModel');
                if($roles_model->checkPermission('Add Role',$_SESSION['admin_role_id']))
                {
                    $array=$roles_model->getAllPermissions();
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/_templates/header.php';
                    require 'application/views/roles/addBox.php';
                    require 'application/views/_templates/footer.php';
                }
                else {
                    ?>
                    <script>
                        Swal.fire({
                        title: 'You do NOT have permission to add roles',
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
    public function addRoleSave(){ //save the info of the new role account to role table in database.
        try{
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                $roles_model=$this->loadModel('rolesModel');
                $roles_model->addRoleSave();
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
    public function confirmRoleDelete($role_id=null){ //display a confirm alert and act depending on admin choice.
        try{
            if(isset($_SESSION['admin_email'])){
                $roles_model=$this->loadModel('rolesModel');
                if($roles_model->checkPermission('Delete Role',$_SESSION['admin_role_id']))
                {
                    if (isset($role_id))
                    {
                        $row=$roles_model->getRole($role_id);
                        if(isset($row['id']))
                        {
                            $roles_model->confirmRoleDelete($role_id);
                        }
                        else{
                            header('location: ' . URL . 'roles/index');
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
                        title: 'You do NOT have permission to delete roles',
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
    public function deleteRole($role_id=null){ //delete the info of the role if admin approved it.
        try{
            if(isset($_SESSION['admin_email'])){
                if(isset($role_id))
                {
                    $roles_model=$this->loadModel('rolesModel');
                    $row=$roles_model->getRole($role_id);
                    if(isset($row['id']))
                    {
                        $roles_model->deleteRole($role_id);
                    } 
                    header('location: ' . URL . 'roles/index');
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
    public function editRole($role_id=null){ //display the role edit form
        try{
            if(isset($_SESSION['admin_email'])){
                $roles_model=$this->loadModel('rolesModel');
                if($roles_model->checkPermission('Update Role',$_SESSION['admin_role_id']))
                {
                    if(isset($role_id))
                    {
                            $id=$role_id;
                            $array=$roles_model->getAllPermissions();
                            $array2=$roles_model->getRolePermissions($role_id);
                            $row=$roles_model->getRole($role_id);
                            if(isset($row['id']))
                            {
                                $per=null;
                                foreach($array as $arr){
                                    $per[$arr->id]=[$arr->permission_name,false];
                                }
                                foreach($array2 as $arr){
                                    $per[$arr->permission_id][1]=true;
                                }
                                require 'application/views/_templates/header.php';
                                require 'application/views/_templates/nav_admin.php';
                                require 'application/views/roles/editBox.php';
                                require 'application/views/_templates/footer.php';
                            }
                            else{
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
                        title: 'You do NOT have permission to edit roles',
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
    public function editRoleSave(){ //save the updated info of the role to role table in database.
        try{
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                $roles_model=$this->loadModel('rolesModel');
                $roles_model->editRoleSave();
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