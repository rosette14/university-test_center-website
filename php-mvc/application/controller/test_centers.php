<head>
    <script src="http:\\127.0.0.1:8081\php-mvc\public\js\sweetalert2.js"> </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@500&family=Adamina&family=Amiri&family=Cormorant+Garamond:ital,wght@1,300&family=EB+Garamond&family=Karla:wght@200&family=Karma:wght@300&family=Lora&family=Nanum+Myeongjo&family=News+Cycle&family=Old+Standard+TT:ital@1&family=PT+Sans&family=Playfair+Display&family=Roboto+Mono:wght@100&family=Source+Sans+Pro:wght@200&display=swap');        
    </style>
</head>
<?php
session_start();
class test_centers extends Controller
{
    public function index()
    {
        try{
            if(isset($_SESSION['admin_email']))
            {
                $test_centers_model=$this->loadModel('test_centersModel');
                if($test_centers_model->checkPermission('Display Test Centers',$_SESSION['admin_role_id']))
                {
                    $test_centers=$test_centers_model->getAllTest_centers();
                    $test_centerAdmins=$test_centers_model->assignCentersAdminsIdToNames();
                    require 'application/views/_templates/header.php';
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/test_centers/index.php';
                    require 'application/views/_templates/footer.php';
        
                }
                else {
                    ?>
                    <script> 
                        Swal.fire({
                        title: 'You do NOT have permission to access test centers',
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
    public function getAllTest_centers()
    {
        try{
            if(isset($_SESSION['admin_email'])){
                return $this->getAllTest_centers();
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
    public function addTest_center(){
        try{
            if(isset($_SESSION['admin_email']))
        {
            $test_center_model=$this->loadModel('test_centersModel');
            if($test_center_model->checkPermission('Add Test Center',$_SESSION['admin_role_id']))
            {
                $array=$test_center_model->getAvailableCenterAdmins();
                require 'application/views/_templates/nav_admin.php';
                require 'application/views/_templates/header.php';
                require 'application/views/test_centers/addBox.php';
                require 'application/views/_templates/footer.php';
            }
            else {
                ?>
                <script> 
                    Swal.fire({
                    title: 'You do NOT have permission to add test centers',
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
    public function addTest_centerSave(){
        try{
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                $test_center_model=$this->loadModel('test_centersModel');
                $test_center_model->addTest_centerSave();
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
    public function confirmTest_centerDelete($test_center_id=null){
        try{
            if(isset($_SESSION['admin_email'])){
                $test_center_model=$this->loadModel('test_centersModel');
                if($test_center_model->checkPermission('Delete Test Center',$_SESSION['admin_role_id']))
                {
                    if (isset($test_center_id))
                    {
                        $row=$test_center_model->getTestCenter($test_center_id);
                        if(isset($row['id']))
                        {
                            $test_center_model->confirmTest_centerDelete($test_center_id);
                        }
                        else
                        {
                            header('location: ' . URL . 'test_centers/index');
                        }
                    }
                    else
                    {
                        header('location: ' . URL . 'test_centers/index');
                    }
           
                }
                else {
                     ?>
                    <script> 
                    Swal.fire({
                    title: 'You do NOT have permission to delete test centers',
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
    public function deleteTest_center($test_center_id=null){
        try{
            if(isset($_SESSION['admin_email'])){
                if(isset($test_center_id))
                {
                    $test_center_model=$this->loadModel('test_centersModel');
                    $row=$test_center_model->getTestCenter($test_center_id);
                    if(isset($row['id']))
                    {
                        $test_center_model->deleteTest_center($test_center_id);
                    }
                    header('location: ' . URL . 'test_centers/index');
                }
                else {
                    header('location: ' . URL . 'test_centers/index');
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
    public function editTest_center($center_id=null){
        try{
            if(isset($_SESSION['admin_email'])){
                $test_center_model=$this->loadModel('test_centersModel');
                if($test_center_model->checkPermission('Update Test Center',$_SESSION['admin_role_id']))
                {
                    if(isset($center_id))
                    {
                        $id=$center_id;
                        $array=$test_center_model->getAvailableCenterAdmins();
                        $row=$test_center_model->getTestCenter($center_id);
                        $name=$test_center_model->getUserName($row['user_id']);
                        if(isset($row['id']))
                        {
                            require 'application/views/_templates/header.php';
                            require 'application/views/_templates/nav_admin.php';
                            require 'application/views/test_centers/editBox.php';
                            require 'application/views/_templates/footer.php';
                        }
                        else{
                            header('location: ' . URL . 'home/index');
                        }
                    }
                    else
                     {
                            header('location: ' . URL . 'home/index');
                        }
           
                }
                else 
                {
                     ?>
                    <script> 
                    Swal.fire({
                    title: 'You do NOT have permission to edit test centers',
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
    public function editTest_centerSave(){
        try{
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                $test_center_model=$this->loadModel('test_centersModel');
                $test_center_model->editTest_centerSave(); }
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
