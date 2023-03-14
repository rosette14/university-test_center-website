
<?php
require 'basemodel.php';
class studentsModel extends BaseModel
{
  public $order=null;
  public $number=null;
  public $duration=null;
  public $result_file_id=null;
  public $question_id=null;
  public $question_text=null;
  public $options=null;
  function __construct($db) {
      parent::__construct($db,"");
  }
  public function chooseCenter(){
    $sql="SELECT id,center_name FROM test_center;";
    $query=$this->db->prepare($sql);
    $query->execute();
    $centers=$query->fetchAll();
    return $centers;
  }
  public function saveCenter(){
    $_SESSION['center_id']=$_POST['test_center_id'];
    $sql="SELECT center_name FROM test_center WHERE id=?";
    $query=$this->db->prepare($sql);
    $query->execute([$_POST['test_center_id']]);
    $stmt=$query->fetch(PDO::FETCH_ASSOC);
    $_SESSION['center_name']=$stmt['center_name'];
}
  public function getStudentQuestionsAnswers($result_file_id){
    $sql="SELECT * FROM student_question_answer WHERE result_file_id=? ";
    $query=$this->db->prepare($sql);
    $this->result_file_id=$result_file_id;
    $query->execute([$this->result_file_id]);
    $answers=$query->fetchAll();
    return $answers;
  }
  public function assignQuestionToOptions(){
    $answers=$this->getStudentQuestionsAnswers($this->result_file_id);
    $questionsOptions=null;
    foreach($answers as $answer){
      $sql="SELECT * FROM option WHERE question_id=?";
      $query=$this->db->prepare($sql);
      $query->execute([$answer->question_id]);
      $options=$query->fetchAll();
      foreach($options as $option) {
        $c='no';
        $s='no';
        if($option->is_correct=='yes')
        {
          $c='yes';
        }
        if($option->id==$answer->option_id)
        {
          $s='yes';
        }
        $questionsOptions[$answer->question_id][]=[$option->option_text,$c,$s];
      }
    }
    return $questionsOptions;
  }
  public function assignQuestionToTexts(){
    $answers=$this->getStudentQuestionsAnswers($this->result_file_id);
    $questionsTexts=null;
    foreach($answers as $answer){
      $sql="SELECT * FROM option WHERE question_id=? and is_correct=?";
      $query=$this->db->prepare($sql);
      $query->execute([$answer->question_id,'yes']);
      $correct=$query->fetch(PDO::FETCH_ASSOC)['id'];
      $sql="SELECT question_text from question WHERE id=?";
      $query=$this->db->prepare($sql);
      $query->execute([$answer->question_id]);
      $text=$query->fetch(PDO::FETCH_ASSOC)['question_text'];
      $questionsTexts[$answer->question_id]=[$text,$correct];
    }
    return $questionsTexts;
  }
  public function getTotalGrade(){
      $sql="SELECT test_id FROM result_file WHERE id=?";
      $query=$this->db->prepare($sql);
      $query->execute([$this->result_file_id]);
      $test_id=$query->fetch(PDO::FETCH_ASSOC);
      $total_grade=null;
      if(isset($test_id['test_id']))
      {
        $sql="SELECT total_grade FROM test WHERE id=?";
        $query=$this->db->prepare($sql);
        $query->execute([$test_id['test_id']]);
        $res=$query->fetch(PDO::FETCH_ASSOC);
        if(isset($res['total_grade']))
        {
          $total_grade=$res['total_grade'];
        }
      }
      return $total_grade;
  }
  public function getStudentResult(){
      $grade=null;
      $sql="SELECT result from result_file WHERE id=?";
      $query=$this->db->prepare($sql);
      $query->execute([$this->result_file_id]);
      $g=$query->fetch(PDO::FETCH_ASSOC);
      if(isset($g['result'])) $grade=$g['result'];
      return $grade;
  }
  public function takeTest()
  {
    try {
      if(isset($_SESSION['center_email']) && isset($_POST['material_id'])){
        $sql="SELECT COUNT(id) AS count from test WHERE test_center_id=? and material_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$_SESSION['center_id'],$_POST['material_id']]);
        $num=$query->fetch(PDO::FETCH_ASSOC);
        if($num['count']==0) {
          ?>
          <script>
              Swal.fire({
              title: 'There is no available test in this material in this center',
              confirmButtonText: 'OK',
              }).then((result) => {
              if (true) {
                window.location.replace("http://127.0.0.1:8081/center_website/home/index");      
              }
              });
          </script>
          <?php
          exit();
           }
        else {
          $n=mt_rand(1,$num['count']);
          $x='u'.$_SESSION['center_user_id'].session_id();
          $sql="CREATE VIEW $x AS SELECT id,ROW_NUMBER() OVER (ORDER BY id) AS row_num FROM test WHERE test_center_id=? and material_id=?;";
          $query = $this->db->prepare($sql);
          $query->execute([$_SESSION['center_id'],$_POST['material_id']]);
          $sql="SELECT id FROM $x WHERE row_num= $n";
          $query = $this->db->prepare($sql);
          $query->execute();
          $test_id=$query->fetch(PDO::FETCH_ASSOC)['id'];
          $sql="DROP VIEW $x";
          $query = $this->db->prepare($sql);
          $query->execute();
          $sql="SELECT total_grade,duration FROM test WHERE id=?";
          $query=$this->db->prepare($sql);
          $query->execute([$test_id]);
          $res=$query->fetch(PDO::FETCH_ASSOC);
          $this->duration=$res['duration'];
          $sql="SELECT * FROM test_question WHERE test_id=?;";
          $query=$this->db->prepare($sql);
          $query->execute([$test_id]);
          $tQuestions=$query->fetchAll();
          $this->number=0;
          $sql="SELECT id from student WHERE user_id=?";
          $query=$this->db->prepare($sql);
          $query->execute([$_SESSION['center_user_id']]);
          $s=$query->fetch(PDO::FETCH_ASSOC);
          $student_id=$s['id'];
          $sql="INSERT INTO result_file(test_id,test_date,student_id,test_center_id,material_id) VALUES (?,?,?,?,?)";
          $this->db->prepare($sql)->execute([$test_id,date("Y-m-d"),$student_id,$_SESSION['center_id'],$_POST['material_id']]);
          $sql="SELECT id FROM result_file WHERE test_id=? AND test_date=? AND student_id=? 
          AND test_center_id=? AND material_id=? AND result IS NULL";
          $query=$this->db->prepare($sql);
          $query->execute([$test_id,date("Y-m-d"),$student_id,$_SESSION['center_id'],$_POST['material_id']]);
          $sql="SELECT id FROM result_file WHERE test_id=? AND test_date=? AND student_id=? 
          AND test_center_id=? AND material_id=? AND result IS NULL";
          $query=$this->db->prepare($sql);
          $query->execute([$test_id,date("Y-m-d"),$student_id,$_SESSION['center_id'],$_POST['material_id']]);
          $this->result_file_id=$query->fetch(PDO::FETCH_ASSOC)['id'];
          $sql="UPDATE result_file SET result=? WHERE id=?;";
          $query=$this->db->prepare($sql);
          $query->execute(['0',$this->result_file_id]);
          foreach($tQuestions as $question) {
            if($this->number==0){
              $this->question_id=$question->question_id;
              $sql="SELECT question_text FROM question WHERE id=?";
              $query=$this->db->prepare($sql);
              $query->execute([$question->question_id]);
              $stmt=$query->fetch(PDO::FETCH_ASSOC);
              $this->question_text=$stmt['question_text'];
              $sql="SELECT * FROM option WHERE question_id=?";
              $query=$this->db->prepare($sql);
              $query->execute([$question->question_id]);
              $opt=$query->fetchAll();
              foreach($opt as $op)
              {
                $this->options[]=[$op->id,$op->option_text,$op->is_correct];
              }
            }
            $sql="INSERT INTO student_question_answer(result_file_id,question_id) VALUES(?,?);";
            $this->db->prepare($sql)->execute([$this->result_file_id,$question->question_id]);
            $this->number++;
            $_POST['question'.$this->number]=$question->question_id;
          }
        }
    }
    else { ?>
      <script> window.location.replace("http://127.0.0.1:8081/center_website/home/index"); </script>
    <?php }
    }
    catch (Exception $e){
      ?>
      <script>
          Swal.fire({
          title: '<?php echo $e->getMessage(); ?>',
          confirmButtonText: 'OK',
          }).then((result) => {
          if (true) {
            window.location.replace("http://127.0.0.1:8081/center_website/home/index");      
          }
          });
       </script>
       <?php
       exit();
    }
    catch (PDOException $e){

    }
}
  public function updateResult(){
    $this->result_file_id=$_POST['result_file_id'];
    if(isset($_POST['option_id'])) {
      $sql="UPDATE student_question_answer SET option_id=? WHERE result_file_id=? and question_id=?";
      $query=$this->db->prepare($sql);
      $query->execute([$_POST['option_id'],$this->result_file_id,$_POST['question_id']]);
      $sql="SELECT is_correct FROM option WHERE id=?; ";
      $query=$this->db->prepare($sql);
      $query->execute([$_POST['option_id']]);
      $is_correct=$query->fetch(PDO::FETCH_ASSOC)['is_correct'];
      if( $is_correct=='yes'){
        $sql="SELECT test_id,result from result_file WHERE id=?; ";
        $query=$this->db->prepare($sql);
        $query->execute([$this->result_file_id]);
        $re=$query->fetch(PDO::FETCH_ASSOC);
        $test_id=$re['test_id'];
        $grade=$re['result'];
        $sql="SELECT mark from test_question WHERE test_id=? AND question_id=?;";
        $query=$this->db->prepare($sql);
        $query->execute([$test_id,$_POST['question_id']]);
        $mark=$query->fetch(PDO::FETCH_ASSOC)['mark'];
        $grade=(int)$grade+(int)$mark;
        $grade=$grade."";
        $sql="UPDATE result_file SET result=? WHERE id=?;";
        $query=$this->db->prepare($sql);
        $query->execute([$grade,$this->result_file_id]);
      }
    }
  }
  public function displayNext(){
    $this->updateResult();
    $this->question_id=$_POST['question'.$this->order];
    $sql="SELECT question_text FROM question WHERE id=?";
    $query=$this->db->prepare($sql);
    $query->execute([$this->question_id]);
    $this->question_text=$query->fetch(PDO::FETCH_ASSOC)['question_text'];
    $sql="SELECT * FROM option WHERE question_id=?";
    $query=$this->db->prepare($sql);
    $query->execute([$this->question_id]);
    $opt=$query->fetchAll();
    foreach($opt as $op)
    {
      $this->options[]=[$op->id,$op->option_text,$op->is_correct];
    }
  }
  public function assignMaterialsIdToNames(){
    $sql="SELECT id,material_name from material;";
    $query=$this->db->prepare($sql);
    $query->execute();
    $allMaterials=$query->fetchAll();
    $materials=null;
    foreach($allMaterials as $material)
    {
      $materials[$material->id]=$material->material_name;
    }
    return $materials;
  }
  public function assignTestsIdToName(){
    $sql="SELECT id,test_name,total_grade from test WHERE test_center_id=?;";
    $query=$this->db->prepare($sql);
    $query->execute([$_SESSION['center_id']]);
    $allTests=$query->fetchAll();
    $tests=null;
    foreach($allTests as $test)
    {
      $tests[$test->id]=[$test->test_name,$test->total_grade];
    }
    return $tests;
  }
  public function showResults(){
    $sql="SELECT id from student WHERE user_id=?";
    $query=$this->db->prepare($sql);
    $query->execute([$_SESSION['center_user_id']]);
    $s=$query->fetch(PDO::FETCH_ASSOC);
    $student_id=$s['id'];
    $sql="SELECT * FROM result_file WHERE test_center_id=? AND student_id=?";
    $query=$this->db->prepare($sql);
    $query->execute([$_SESSION['center_id'],$student_id]);
    $results=$query->fetchAll();
    return $results;
  }
}