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
class Home extends Controller
{
    public function index()
    {
        if(isset($_SESSION['center_email'])){
            if($_SESSION['center_role']=='Test Center Admin')
            {
                header('location:'.URL.'test_center_admins/index');
            }
            elseif ($_SESSION['center_role']=='Student') {
                {
                    if(isset($_SESSION['center_id']))
                    {
                        header('location:'.URL.'students/index');
                    }
                    else
                    {
                        header('location:'.URL.'students/chooseCenter');
                    }
                }
            }
        }
        else {   
            require 'application/views/home/login.php';
        }
    }
    public function myAccount(){
        if(isset($_SESSION['center_email'])){
            if($_SESSION['center_role']=="Test Center Admin"){
                require 'application/views/_templates/TestCenterheader.php';
                require 'application/views/_templates/nav_test_center_admin.php';
                require 'application/views/_templates/myAccount.php';
                require 'application/views/_templates/footer.php';
            }
            else{
                require 'application/views/_templates/headerStudent.php';
                require 'application/views/_templates/nav_student.php';
                require 'application/views/_templates/myAccount.php';
                require 'application/views/_templates/footer.php';
            }
        }
        else {
            require 'application/views/home/login.php';
        }
    }
    public function logout(){
        $login_model=$this->loadModel('loginmodel');
        $login_model->logout();
        header('location: ' . URL . 'home/index');
    }
    public function loginCheck(){
        if(isset($_POST['submit'])){
            $login_model=$this->loadModel('loginmodel');
            $login_model->loginCheck();
            }
            else {
                header('location: ' . URL . 'home/index');
            }
    } 
}
