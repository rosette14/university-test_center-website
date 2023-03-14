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
class tests extends Controller
{
    public function index()
    {
        try{
            if(isset($_SESSION['admin_email']))
        {
            $test_model=$this->loadModel('testsModel');
            if($test_model->checkPermission('Display Tests',$_SESSION['admin_role_id']))
            {   
                $tests=$test_model->getAllTests();
                $materials=$test_model->assignMaterialsIdToNames();
                $test_centers=$test_model->assignCentersIdToNames();
                require 'application/views/_templates/header.php';
                require 'application/views/_templates/nav_admin.php';
                require 'application/views/tests/index.php';
                require 'application/views/_templates/footer.php';
            }
            else {
            ?>
            <script> 
                Swal.fire({
                title: 'You do NOT have permission to access tests',
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
    public function viewQuestions($test_id=null){
        try{
            if(isset($_SESSION['admin_email']) && isset($test_id))
            {
                $test_model=$this->loadModel('testsModel');
                if($test_model->checkPermission('Display Tests',$_SESSION['admin_role_id']))
                {   
                    $row=$test_model->getTest($test_id);
                    if(isset($row['id']))
                    {
                        $testQuestions=$test_model->viewQuestions($test_id);
                        $questionsIdToTexts=$test_model->assignQuestionsIdToTexts();
                        $questionsOptions=$test_model->assignQuestionsOptions();
                        $questionsIdToTopics=$test_model->assignQuestionsIdToTopics();
                        require 'application/views/_templates/header.php';
                        require 'application/views/_templates/nav_admin.php';
                        require 'application/views/tests/viewQuestions.php';
                        require 'application/views/_templates/footer.php';
                    }
                    else{
                        header('location: ' . URL . 'home/index');
                    }
                }
                else {
                ?>
                <script> 
                Swal.fire({
                title: 'You do NOT have permission to access tests',
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
    public function addTest(){
        try{
            if(isset($_SESSION['admin_email'])){
                $test_model=$this->loadModel('testsModel');
                if($test_model->checkPermission('Add Test',$_SESSION['admin_role_id']))
                {   
                    $array=$test_model->assignMaterialsIdToNames();
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/_templates/header.php';
                    require 'application/views/tests/addBox.php';
                    require 'application/views/_templates/footer.php';
                }
                else {
                ?>
                <script> 
                Swal.fire({
                title: 'You do NOT have permission to add tests',
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
    public function addTestSave(){
        try{
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                $test_model=$this->loadModel('testsModel');
                $test_model->addTestSave();
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
    public function generateQuestions(){
        try{
            if(isset($_SESSION['admin_email']) && isset($_POST['submit'])){
                $test_model=$this->loadModel('testsModel');
                $generatedQuestions=$test_model->generateQuestions();
                if(isset($generatedQuestions[0]))
                  $number=sizeof($generatedQuestions);
                else
                  $number=0;
                if($number==0){
                    ?>
                    <script> 
                    Swal.fire({
                    title: 'The available questions are not enough to make an exam',
                    confirmButtonText: 'OK',
                    }).then((result) => {
                    if (true) {
                      window.location.replace("http://127.0.0.1:8081/php-mvc/tests/addTest");      
                    }
                    });
                    </script>
                    <?php
                    exit();
                }
                else{
                    $questionsIdToTexts=$test_model->assignQuestionsIdToTexts();
                    $questionsOptions=$test_model->   assignquestionsOptions();
                    $questionsIdToTopics=$test_model->assignquestionsIdToTopics();
                    require 'application/views/_templates/header.php';
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/tests/addMarks.php';
                    require 'application/views/_templates/footer.php';
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
    public function confirmTestDelete($test_id=null){ //display a confirm alert and act depending on admin choice.
        try{
            if(isset($_SESSION['admin_email'])){
                $test_model=$this->loadModel('testsModel');
                if($test_model->checkPermission('Delete Test',$_SESSION['admin_role_id']))
                {   
                    if (isset($test_id))
                    {
                        $row=$test_model->getTest($test_id);
                        if(isset($row['id']))
                        {
                            $test_model->confirmTestDelete($test_id);
                        }
                        else{
                            header('location: ' . URL . 'tests/index');
                        }
                    }
                    else{
                        header('location: ' . URL . 'tests/index');
                    }
                }
                else {
                ?>
                <script> 
                Swal.fire({
                title: 'You do NOT have permission to delete tests',
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
    public function deleteTest($test_id=null){ //delete the info of the test if admin approved it.
        try{
            if(isset($_SESSION['admin_email'])){
                if(isset($test_id))
                {
                    $test_model=$this->loadModel('testsModel');
                    $row=$test_model->getTest($test_id);
                    if(isset($row['id']))
                    {
                        $test_model->deleteTest($test_id);
                    } 
                    header('location: ' . URL . 'tests/index');
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
    public function editTest($test_id=null){
        try{
            if(isset($_SESSION['admin_email'])){
                $test_model=$this->loadModel('testsModel');
                if($test_model->checkPermission('Update Test',$_SESSION['admin_role_id']))
                {   
                    if(isset($test_id))
                    {
                        $id=$test_id;
                        $row=$test_model->getTest($test_id);
                        if(isset($row['id']))
                        {
                            require 'application/views/_templates/header.php';
                            require 'application/views/_templates/nav_admin.php';
                            require 'application/views/tests/editBox.php';
                            require 'application/views/_templates/footer.php';
                        }
                        else {
                            header('location: ' . URL . 'home/index');
                        }
                    }
                    else {
                        header('location: ' . URL . 'home/index');
                    }
                }
                else {
                ?>
                <script> 
                Swal.fire({
                title: 'You do NOT have permission to edit tests',
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
    public function editTestSave(){
        try{
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                $test_model=$this->loadModel('testsModel');
                $test_model->editTestSave();
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
    public function editQuestionsMarks($test_id=null,$test_name=null,$duration=null){
        try{
            if(isset($_SESSION['admin_email']) && isset($test_id) && isset($test_name) && isset($duration)){
                $test_model=$this->loadModel('testsModel');
                $row=$test_model->getTest($test_id);
                if(isset($row['id']))
                {
                    if($row['test_name']==$test_name && $row['duration']==$duration )
                    {
                        $questionsIdToTopics=$test_model->assignQuestionsIdToTopics();
                        $questionsOptions=$test_model->assignQuestionsOptions();
                        $questionsIdToTexts=$test_model->assignQuestionsIdToTexts();
                        $generatedQuestions=$test_model->getGeneratedQuestions($test_id);
                        require 'application/views/_templates/header.php';
                        require 'application/views/_templates/nav_admin.php';
                        require 'application/views/tests/editQuestionsMarks.php';
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
