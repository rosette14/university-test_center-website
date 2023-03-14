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
class users extends Controller
{
    public function index()
    {
        try{
            if(isset($_SESSION['admin_email'])){
                $users_model=$this->loadModel('usersModel');
                if($users_model->checkPermission('Display Users',$_SESSION['admin_role_id']))
                {
                    $users=$users_model->getAllUsers();
                    $userRoleName=$users_model->assignUsersToRolesNames();
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/_templates/header.php';
                    require 'application/views/users/index.php';
                    require 'application/views/_templates/footer.php';
                }
                else {
                    ?>
                    <script>
                        Swal.fire({
                        title: 'You do NOT have permission to access users',
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
    public function addUser(){ //display the user add form
        try{
            if(isset($_SESSION['admin_email'])){
                $users_model=$this->loadModel('usersModel');
                if($users_model->checkPermission('Add User',$_SESSION['admin_role_id']))
                {
                    $array=$users_model->getRoles();
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/_templates/header.php';
                    require 'application/views/users/addBox.php';
                    require 'application/views/_templates/footer.php';
                }
                else {
                    ?>
                    <script>
                        Swal.fire({
                        title: 'You do NOT have permission to add users',
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
    public function addUserSave(){ //save the info of the new user account to user table in database.
        try{
            if(isset($_SESSION['admin_email']) && isset($_POST['submit'])){
                $users_model=$this->loadModel('usersModel');
                $users_model->addUserSave();
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
    public function confirmUserDelete($user_id=null){ //display a confirm alert and act depending on admin choice.
        try{
            if(isset($_SESSION['admin_email'])){
                $users_model=$this->loadModel('usersModel');
                if($users_model->checkPermission('Delete User',$_SESSION['admin_role_id']))
                {
                    if (isset($user_id))
                    {
                        $row=$users_model->getUser($user_id);
                        if(isset($row['id']))
                        {
                            $users_model->confirmUserDelete($user_id);
                        }
                        else{
                            header('location: ' . URL . 'users/index');
                        }
                    }
                    else{
                        header('location: ' . URL . 'users/index');
                    }
                }
                else {
                    ?>
                    <script>
                        Swal.fire({
                        title: 'You do NOT have permission to delete users',
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
    public function deleteUser($user_id=null){ //delete the info of the user if admin approved it.
        try{
            if(isset($_SESSION['admin_email'])){
                if(isset($user_id))
                {
                    $users_model=$this->loadModel('usersModel');
                    $row=$users_model->getUser($user_id);
                    if(isset($row['id']))
                    {
                        $users_model->deleteUser($user_id);
                    } 
                    header('location: ' . URL . 'users/index');
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
    public function editUser($user_id=null){ //display the user edit form
        try{
            if(isset($_SESSION['admin_email'])){
                $users_model=$this->loadModel('usersModel');
                if($users_model->checkPermission('Update User',$_SESSION['admin_role_id']))
                {
                    if(isset($user_id))
                    {
                        $id=$user_id;
                        $array=$users_model->getRoles();
                        $array2=$users_model->assignUsersToRolesNames();
                        $row=$users_model->getUser($user_id);
                        if(isset($row['id']))
                        {
                            require 'application/views/_templates/header.php';
                            require 'application/views/_templates/nav_admin.php';
                            require 'application/views/users/editBox.php';
                            require 'application/views/_templates/footer.php';
                        }
                        else {
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
                        title: 'You do NOT have permission to edit users',
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
    public function editUserSave(){ //save the updated info of the user to user table in database.
        try{
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                $users_model=$this->loadModel('usersModel');
                $users_model->editUserSave();
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