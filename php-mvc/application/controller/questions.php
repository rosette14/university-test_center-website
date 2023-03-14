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
class questions extends Controller
{
    public function index()
    {
        try{
            if(isset($_SESSION['admin_email'])){
                $question_model=$this->loadModel('questionsModel');
                if($question_model->checkPermission('Display Questions',$_SESSION['admin_role_id']))
                {
                    
                    $materials=$question_model->getMaterials();
                    $topics=$question_model->getTopics();
                    $questions=$question_model->getAllQuestions();
                    $options=$question_model->assignQuestionsOptions();
                    $mat=$question_model->assignMaterialsIdToNames();
                    $top=$question_model->assignTopicsIdToNames();
                    $arr=$question_model->assignQuestionsOptions();
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/_templates/header.php';
                    require 'application/views/questions/index.php';
                    require 'application/views/_templates/footer.php';
                }
                else {
                    ?>
                    <script> 
                        Swal.fire({
                        title: 'You do NOT have permission to access questions',
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
    public function getQuestionMT(){
        try{
            if(isset($_POST['submit']))
            {
                $material_name=$_POST['material'];
                $topic_name=$_POST['topic'];
                $question_model=$this->loadModel('questionsModel');
                $questions=$question_model->getQuestionMT($material_name,$topic_name);
                $mat=$question_model->assignMaterialsIdToNames();
                $top=$question_model->assignTopicsIdToNames();
                $arr=$question_model->assignQuestionsOptions();
                if(isset($questions)){
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/_templates/header.php';
                    require 'application/views/questions/search.php';
                    require 'application/views/_templates/footer.php';
                }
                else{
                    ?>
                    <script>
                    Swal.fire({
                    title: 'Material name or topic name are not true',
                    confirmButtonText: 'OK',
                    }).then((result) => {
                    if (true) {
                      window.location.replace("http://127.0.0.1:8081/php-mvc/questions/index");
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
    public function addQuestion(){ //display a question addition form
        try{
            if(isset($_SESSION['admin_email'])){
                $question_model=$this->loadModel('questionsModel');
                if($question_model->checkPermission('Add Question',$_SESSION['admin_role_id']))
                {
                    $array=$question_model->getMaterials();
                    $array2=$question_model->getTopics();
                    require 'application/views/_templates/nav_admin.php';
                    require 'application/views/_templates/header.php';
                    require 'application/views/questions/addBox.php';
                    require 'application/views/_templates/footer.php';
                }
                else {
                    ?>
                    <script> 
                        Swal.fire({
                        title: 'You do NOT have permission to add questions',
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
    public function addQuestionSave(){ //save the info of the new question account to question table in database.
       try {
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                $questions_model=$this->loadModel('questionsModel');
                $questions_model->addQuestionSave();
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
    public function confirmQuestionDelete($question_id=null){ //display a confirm alert and act depending on admin choice.
        try{
            if(isset($_SESSION['admin_email'])){
                $questions_model=$this->loadModel('questionsModel');
                if($questions_model->checkPermission('Delete Question',$_SESSION['admin_role_id']))
                {
                    
                    if(isset($question_id))
                    {
                        $row=$questions_model->getQuestion($question_id);
                        if(isset($row['id']))
                        {
                            $questions_model->confirmQuestionDelete($question_id);
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
                        title: 'You do NOT have permission to delete questions',
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
    public function deleteQuestion($question_id=null){ //delete the info of the question if admin approved it.
        try{
            if(isset($_SESSION['admin_email'])){
                if(isset($question_id))
                {   $questions_model=$this->loadModel('questionsModel');
                    $row=$questions_model->getQuestion($question_id);
                    if(isset($row['id']))
                    {
                        $questions_model->deleteQuestion($question_id);
                        header('location: ' . URL . 'questions/index');
                    }
                    else{
                        header('location: ' . URL . 'questions/index');
                    }  
                }
                else{
                    header('location: ' . URL . 'questions/index');
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
    public function editQuestion($question_id=null){ //display the question edit form
        try {
            if(isset($_SESSION['admin_email'])){
                $questions_model=$this->loadModel('questionsModel');
                if($questions_model->checkPermission('Update Question',$_SESSION['admin_role_id']))
                {
                    if(isset($question_id))
                    {
                        $array=$questions_model->getMaterials();
                        $array2=$questions_model->getTopics();
                        $id=$question_id;
                        $row=$questions_model->getQuestion($question_id);
                        $array3=$questions_model->getQuestionOptions($question_id);
                        if(isset($row['id']))
                        {
                            require 'application/views/_templates/header.php';
                            require 'application/views/_templates/nav_admin.php';
                            require 'application/views/questions/editBox.php';
                            require 'application/views/_templates/footer.php';
                        }
                        else{
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
                        title: 'You do NOT have permission to edit questions',
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
    public function editQuestionSave(){ //save the updated info of the question to question table in database.
        try {
            if(isset($_SESSION['admin_email'])&& isset($_POST['submit'])){
                {
                    $questions_model=$this->loadModel('questionsModel');
                    $questions_model->editQuestionSave();
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
?>