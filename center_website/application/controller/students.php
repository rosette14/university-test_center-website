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
class students extends Controller
{
    public function index()
    {
       try{
            if(isset($_SESSION['center_email']))
            {
                if(isset($_SESSION['center_id']))
                {
                    require 'application/views/_templates/headerStudent.php';
                    require 'application/views/_templates/nav_student.php';
                    require 'application/views/students/index.php';
                    require 'application/views/_templates/footer.php';
                }
                else{
                    header('location:'.URL.'students/chooseCenter');
                }
            }
            else{
                header('location:'.URL.'home/index');
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
    public function saveCenter(){
       try{
        $students_model=$this->loadModel('studentsModel');
        $students_model->saveCenter();
        header('location:'.URL.'home/index');
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
    public function chooseCenter(){
        try{
            if(isset($_SESSION['center_email']))
            {
                if(!isset($_SESSION['center_id']))
                {
                    $students_model=$this->loadModel('studentsModel');
                    $centers=$students_model->chooseCenter();
                    require 'application/views/students/chooseCenter.php';
                }
                else {
                    header('location:'.URL.'home/index');
                }
            }
            else{
                header('location:'.URL.'home/index');
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
    public function showResults(){
       try{
            if(isset($_SESSION['center_email'])){
                if(isset($_SESSION['center_id']))
                {
                    $students_model=$this->loadModel('studentsModel');
                    $tests=$students_model->assignTestsIdToName();
                    $materials= $students_model->assignMaterialsIdToNames();
                    $results=$students_model->showResults();
                    require 'application/views/_templates/headerStudent.php';
                    require 'application/views/_templates/nav_student.php';
                    require 'application/views/students/results.php';
                    require 'application/views/_templates/footer.php';
                }
                else{
                    header('location:'.URL.'students/chooseCenter');
                }
            }
            else {
                header('location:'.URL.'home/index');
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
                if(isset($_SESSION['center_id']))
                {
                    $students_model=$this->loadModel('studentsModel');
                    $materials= $students_model->assignMaterialsIdToNames();
                    require 'application/views/_templates/headerStudent.php';
                    require 'application/views/_templates/nav_student.php';
                    require 'application/views/students/chooseMaterial.php';
                    require 'application/views/_templates/footer.php';
                }
                else{
                    header('location:'.URL.'students/chooseCenter');
                }
            }
            else {
                header('location:'.URL.'home/index');
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
    public function takeTest(){
        try{
            if(isset($_SESSION['center_email'])){
                if(isset($_SESSION['center_id']))
                {
                    if(isset($_POST['submit']))
                    {
                        $students_model=$this->loadModel('studentsModel');
                        $students_model->takeTest();
                        $question_text=$students_model->question_text;
                        $question_id=$students_model->question_id;
                        $options=$students_model->options;
                        $number=$students_model->number;
                        $result_file_id=$students_model->result_file_id;
                        $duration=$students_model->duration;
                        $start=time();
                        $order=1;
                        require 'application/views/_templates/headerStudent.php';
                        require 'application/views/_templates/nav_student.php';
                        require 'application/views/students/exam.php';
                        require 'application/views/_templates/footer.php';
                    }
                    else{
                        header('location:'.URL.'students/chooseMaterial');
                    }
                }
                else{
                    header('location:'.URL.'students/chooseCenter');
                }
            }
            else {
                header('location:'.URL.'home/index');
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
    public function timeExpire($result_file_id=null){
        try{
            if(isset($_SESSION['center_email'])){
                if(isset($_SESSION['center_id']))
                {
                    if(isset($result_file_id))
                    {
                        $students_model=$this->loadModel('studentsModel');
                        $answers=$students_model->getStudentQuestionsAnswers($result_file_id);
                        $questionsOptions=$students_model->assignQuestionToOptions();
                        $questionsTexts=$students_model->assignQuestionToTexts();
                        $grade=$students_model->getStudentResult();
                        $total_grade=$students_model->getTotalGrade();
                        $expire=1;
                        require 'application/views/_templates/headerStudent.php';
                        require 'application/views/_templates/nav_student.php';
                        require 'application/views/students/examResult.php';
                        require 'application/views/_templates/footer.php';
                    }
                    else{
                        header('location:'.URL.'home/index');
                    }
                }
                else{
                    header('location:'.URL.'students/chooseCenter');
                }
            }
            else {
                header('location:'.URL.'home/index');
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
    public function displayNext() {
        try{
            if(isset($_SESSION['center_email'])){
                if(isset($_SESSION['center_id']))
                {
                    if(isset($_POST['submit']))
                    {
                        $students_model=$this->loadModel('studentsModel');
                        $students_model->updateResult();
                        $answers=$students_model->getStudentQuestionsAnswers($_POST['result_file_id']);
                        $questionsOptions=$students_model->assignQuestionToOptions();
                        $questionsTexts=$students_model->assignQuestionToTexts();
                        $grade=$students_model->getStudentResult();
                        $total_grade=$students_model->getTotalGrade();
                        $result_file_id=$_POST['result_file_id'];
                        $expire=0;
                        require 'application/views/_templates/headerStudent.php';
                        require 'application/views/_templates/nav_student.php';
                        require 'application/views/students/examResult.php';
                        require 'application/views/_templates/footer.php';
                    }
                    else {
                        if(isset($_POST['next']))
                        {
                            $students_model=$this->loadModel('studentsModel');
                            $number=$_POST['number'];
                            $order=(int)$_POST['order'];
                            $order+=1;
                            $students_model->order=$order;
                            $duration=$_POST['duration'];
                            $start=$_POST['start'];
                            $result_file_id=$_POST['result_file_id'];
                            $students_model->displayNext();
                            $question_text=$students_model->question_text;
                            $question_id=$students_model->question_id;
                            $options=$students_model->options;
                            require 'application/views/_templates/headerStudent.php';
                            require 'application/views/_templates/nav_student.php';
                            require 'application/views/students/exam.php';
                            require 'application/views/_templates/footer.php';
                        }
                        else{
                            header('location:'.URL.'home/index');
                        }
                    }
                }
                else{
                    header('location:'.URL.'students/chooseCenter');
                }
            }
            else {
                header('location:'.URL.'home/index');
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
