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
class test_center_admins extends Controller
{
    public function index()
    {
        try{
            if(isset($_SESSION['center_email'])){
                require 'application/views/_templates/TestCenterheader.php';
                require 'application/views/_templates/nav_test_center_admin.php';
                require 'application/views/test_center_admins/index.php';
                require 'application/views/_templates/footer.php';
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
    public function chooseMaterial(){
        try{
            if(isset($_SESSION['center_email'])){
                $test_center_admins_model=$this->loadModel('test_center_adminsModel');
                $materials= $test_center_admins_model->assignMaterialsIdToNames();
                require 'application/views/_templates/TestCenterheader.php';
                require 'application/views/_templates/nav_test_center_admin.php';
                require 'application/views/test_center_admins/chooseMaterial.php';
                require 'application/views/_templates/footer.php';
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
    public function askForTest(){
        try{
            if(isset($_SESSION['center_email'])){
                $test_center_admins_model=$this->loadModel('test_center_adminsModel');
                $test_center_admins_model->askForTest();
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

    public function showStudentsResults(){
        try{
            if(isset($_SESSION['center_email'])){
                $test_center_admins_model=$this->loadModel('test_center_adminsModel');
                $materials= $test_center_admins_model->assignMaterialsIdToNames();
                $tests= $test_center_admins_model->assignTestsIdToNames();
                $students= $test_center_admins_model->assignStudentsIdToNames();
                $results=$test_center_admins_model->showStudentsResults();
                require 'application/views/_templates/TestCenterheader.php';
                require 'application/views/_templates/nav_test_center_admin.php';
                require 'application/views/test_center_admins/results.php';
                require 'application/views/_templates/footer.php';
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


}
?>