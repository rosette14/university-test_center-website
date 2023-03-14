<?php
require 'questionsmodel.php';
class testsModel extends BaseModel
{
    function __construct($db) {
      parent::__construct($db,"test");
    }
    public function getTestCenters(){
      $test_center_model=new test_centersmodel($this->db,'test_centersmodel');
      $test_centers=$test_center_model->getAllTest_centers();
      return $test_centers;
    }
    public function getMaterials(){
      $material_model=new materialsmodel($this->db,'material');
      $materials=$material_model->getAllMaterials();
      return $materials;
    }
    public function getTopics(){
      $topic_model=new topicsmodel($this->db,'topic');
      $topics=$topic_model->getAllTopics();
      return $topics;
    }
    public function getQuestions(){
      $question_model=new questionsmodel($this->db,'question');
      $questions=$question_model->getAllQuestions();
      return $questions;
    }
    public function assignMaterialsIdToNames(){
      $materials=$this->getMaterials();
      $materialsIdToNames=null;
      foreach($materials as $material)
      {
        $id=$material->id;
        $name=$material->material_name;
        $materialsIdToNames[$id]=$name;
      }
      return $materialsIdToNames;
    }
    public function assignCentersIdToNames(){
      $test_centers=$this->getTestCenters();
      $centersIdToNames=null;
      foreach($test_centers as $test_center)
      {
        $id=$test_center->id;
        $name=$test_center->center_name;
        $centersIdToNames[$id]=$name;
      }
      return $centersIdToNames;
    }
    public function assignTopicsIdToNames(){
      $topics=$this->getTopics();
      $topicsIdToNames=null;
      foreach($topics as $topic)
      {
        $id=$topic->id;
        $name=$topic->topic_name;
        $topicsIdToNames[$id]=$name;
      }
      return $topicsIdToNames;
    }
    public function assignQuestionsIdToTexts(){
      $questions=$this->getQuestions();
      $questionsIdToTexts=null;
      foreach($questions as $question)
      {
        $id=$question->id;
        $text=$question->question_text;
        $questionsIdToTexts[$id]=$text;
      }
      return $questionsIdToTexts;
    }
    public function assignQuestionsIdToTopics() {
      $questions=$this->getQuestions();
      $questionsIdToTopics=null;
      $topicsIdToNames=$this->assignTopicsIdToNames();
      foreach($questions as $question)
      {
        $id=$question->id;
        $questionsIdToTopics[$id]=$topicsIdToNames[$question->topic_id];
      }
      return $questionsIdToTopics;
    }
    public function assignQuestionsOptions(){
      $questions=$this->getQuestions();
      $questionsOptions=null;
      foreach($questions as $question)
      {
        try{
          $sql = "SELECT * FROM option WHERE question_id=?";
          $query = $this->db->prepare($sql);
          $query->execute([$question->id]);
          $options=$query->fetchAll();
        }
        catch(PDOException $e){ ?>
            <script> Swal.fire('Database connection could not be established.'); </script>
            <?php exit();
        }
        $opt=null;
        foreach($options as $option)
        {
          if($option->is_correct=="yes")
            $opt[]=$option->option_text."(corret)";
          else
            $opt[]=$option->option_text;
        }
        $questionsOptions[$question->id]=$opt;
      }
      return $questionsOptions;
    }
    public function viewQuestions($test_id){
      $sql="SELECT * FROM test_question WHERE test_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$test_id]);
      return $query->fetchAll();
    }
    public function getAllTests()
    {
      return $this->getAll();
    }
    public function addTestSave()
    {
      try {
        $number=0;
        $sum=0;
        $array=[];
        foreach($_POST as $key=>$value)
        {
          $value=trim($value);
          if(empty($value)){
              throw new Exception('marks can not be empty');
          }
          if(!empty($value) && $key!='submit' && substr($key,0,4)!='mark' && substr($key,0,4)!='Ques')
          {
              $array[$key]=$value; 
          }
          else if(substr($key,0,4)=='mark')
          {
            if((int) $value==0) throw new Exception('marks can not be zero');
            $number++;
            $sum+=(int) $value;
          }
        }
        $array['questions_number']=$number;
        $array['total_grade']=$sum;
        $this->addSave($array);
        $this->addToRelatedTables();
        header('location: ' . URL . 'tests/index');
      }
      catch (Exception $e){
        ?>
        <script>
            Swal.fire({
            title: '<?php echo $e->getMessage(); ?>',
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
      catch(PDOException $e) {
        ?>
        <script>
        Swal.fire({
        title: <?php echo $e->getMessage(); ?>,
        confirmButtonText: 'OK',
        }).then((result) => {
        if (true) {
          window.location.replace("http://127.0.0.1:8081/php-mvc/tests/addTest");
        }
        });
        </script>
        <?php
        }      
    }
    public function addToRelatedTables()
    {
      $sql="SELECT id FROM test where test_name=?";
      $stmt=$this->db->prepare($sql);
      $stmt->execute([$_POST['test_name']]);
      $idd=$stmt->fetch(PDO::FETCH_ASSOC);
      $id=$idd['id'];
      for($i=1; $i<=$_POST['questions_number']; $i++)
      {
        $sql="INSERT INTO test_question(question_id,test_id,mark) VALUES (?,?,?);";
        $stmt=$this->db->prepare($sql);
        $stmt->execute([$_POST["Question".$i],$id,$_POST["mark".$i]]);
      }
    }
    public function generateQuestions()
    {
      $topics=$this->getTopics();
      $generatedQuestions=null;
      foreach($topics as $topic)
      {
        $sql="SELECT COUNT(id) AS count from question WHERE topic_id=? AND material_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$topic->id,$_POST['material_id']]);
        $numq=$query->fetch(PDO::FETCH_ASSOC);
        if($numq['count']==0) continue;
        $number=mt_rand(1,$numq['count']);
        $x='u'.$_SESSION['admin_id'].session_id();
        $sql="CREATE VIEW $x AS SELECT id,ROW_NUMBER() OVER (ORDER BY id) AS row_num FROM question WHERE topic_id=?;";
        $query = $this->db->prepare($sql);
        $query->execute([$topic->id]);
        $sql="SELECT id FROM $x WHERE row_num=".$number;
        $query = $this->db->prepare($sql);
        $query->execute();
        $generatedQuestions[]=$query->fetch(PDO::FETCH_ASSOC)['id'];
        $sql="DROP VIEW $x";
        $query = $this->db->prepare($sql);
        $query->execute();
      }
      return $generatedQuestions;
    }
    public function confirmTestDelete($test_id)
    {
      $this->confirmDeleteById($test_id);
    }
    public function deleteTest($test_id)
    {
      try {
        $sql="SELECT DISTINCT result_file_id FROM student_question_answer;";
        $query=$this->db->prepare($sql);
        $query->execute();
        $stmt=$query->fetchAll();
        foreach($stmt as $row){
          $sql="SELECT test_id from result_file where id=?;";
          $query=$this->db->prepare($sql);
          $query->execute([$row->result_file_id]);
          $test_id=$query->fetch(PDO::FETCH_ASSOC)['test_id'];
          $sql="SELECT duration from test where id=?;";
          $query=$this->db->prepare($sql);
          $query->execute([$test_id]);
          $duration=$query->fetch(PDO::FETCH_ASSOC)['duration'];
          $duration*=60*60;
          $sql= "DELETE FROM student_question_answer WHERE (creation_time) < DATE_ADD(NOW(),INTERVAL -$duration SECOND) and result_file_id=?";
          $query=$this->db->prepare($sql);
          $query->execute([$row->result_file_id]);  }
        $sql="DELETE from result_file WHERE test_id=? ;";
        $query = $this->db->prepare($sql);
        $query->execute([$test_id]);
        $sql="DELETE from test_question WHERE test_id=? ;";
        $query = $this->db->prepare($sql);
        $query->execute([$test_id]);
        $this->deleteById($test_id);
    }
    catch (Exception $e)
    {
      ?>
        <script>
            Swal.fire({
            title: "You can not delete this test right now because it is being tested by a student in this moment, try later.",
            confirmButtonText: 'OK',
            }).then((result) => {
            if (true) {
              window.location.replace("http://127.0.0.1:8081/php-mvc/tests/index");      
            }
            });
        </script>
        <?php
        exit();
    }	  
  }
    public function editTestSave()
    {
      try {
        $number=0;
        $sum=0;
        $array=[];
        foreach($_POST as $key=>$value)
        {
          $value=trim($value);
          if(empty($value)){
              throw new PDOException();
          }
          if(!empty($value) && $key!='submit' && substr($key,0,4)!='mark' && substr($key,0,4)!='Ques')
          {
              $array[$key]=$value; 
          }
          else if(substr($key,0,4)=='mark')
          {
            if((int) $value==0) throw new PDOException();
            $number++;
            $sum+=(int) $value;
          }
        }
        if($number>0) {
          $array['questions_number']=$number;
          $array['total_grade']=$sum;
        }
        $this->editSave($array);
        if($number>0)
          $this->editToRelatedTables();
        header('location: ' . URL . 'tests/index');
      }  
      catch(PDOException $e) {
        ?>
        <script>
        var id='<?php echo $_POST["id"]; ?>';
        Swal.fire({
        title: 'The information you entered is not valid.',
        confirmButtonText: 'OK',
        }).then((result) => {
        if (true) {
          window.location.replace("http://127.0.0.1:8081/php-mvc/tests/editTest/"+id);
        }
        });
        </script>
        <?php
        }
    }
    public function getGeneratedQuestions($test_id){
      $sql="SELECT * FROM test_question WHERE test_id=?;";
      $query = $this->db->prepare($sql);
      $query->execute([$test_id]);
      $generatedQuestions=$query->fetchAll();
      return $generatedQuestions;
    }
    public function getTest($test_id)
    {
      $sql = "SELECT * FROM test WHERE id =?";
      $query = $this->db->prepare($sql);
      $query->execute([$test_id]);
      $row=$query->fetch(PDO::FETCH_ASSOC);
      return $row;
    }
    public function editToRelatedTables(){
      $sql="DELETE from test_question WHERE test_id=? ;";
      $query = $this->db->prepare($sql);
      $query->execute(array($_POST['id']));
      for($i=1; $i<=$_POST['questions_number']; $i++)
      {
        $sql="INSERT INTO test_question(question_id,test_id,mark) VALUES (?,?,?);";
        $stmt=$this->db->prepare($sql);
        $stmt->execute([$_POST["Question".$i],$_POST['id'],$_POST["mark".$i]]);
      }
    }
}
