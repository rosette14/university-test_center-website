
<?php
require 'topicsmodel.php';
class questionsModel extends BaseModel
{
  function __construct($db)
  {
    parent::__construct($db,"question");
  }
  public function getMaterials(){
    $materialModel=new materialsmodel($this->db,'material');
    $materials=$materialModel->getAllMaterials();
    return $materials;
  }
  public function getTopics(){
    $topicModel=new topicsmodel($this->db,'topic');
    $topics=$topicModel->getAllTopics();
    return $topics;
  }
  public function assignMaterialsIdToNames(){
    $materials=$this->getMaterials();
    foreach($materials as $row){
      $mat[$row->id]=$row->material_name;
    }
    return $mat;
  }
  public function assignTopicsIdToNames(){
    $topics=$this->getTopics();
    $top=null;
    foreach($topics as $row){
      $top[$row->id]=$row->topic_name;
    }
    return $top;
  }
  public function getQuestion($question_id){
    $sql = "SELECT * FROM question WHERE id =?";
    $query = $this->db->prepare($sql);
    $query->execute([$question_id]);
    $row=$query->fetch(PDO::FETCH_ASSOC);
    return $row;
  }
  public function getQuestionOptions($question_id){
    $sql = "SELECT * FROM option WHERE question_id =?";
    $query = $this->db->prepare($sql);
    $query->execute([$question_id]);
    $opt=$query->fetchAll();
    return $opt;
  }
  public function assignQuestionsOptions(){
    $options=$this->getAllOptions();
    $arr=null;
    foreach($options as $option)
    {
        if($option->is_correct=="yes")
        {
            $arr[$option->question_id][]=$option->option_text." (correct)";
        }
        else
        {
            $arr[$option->question_id][]=$option->option_text;
        }
    }
    return $arr;
  }
  public function getAllQuestions()
  {
    return $this->getAll();
  }
  public function getQuestionMT($material_name=null,$topic_name=null){
    $questions=null;
    if(isset($topic_name)){
      $topic_name=trim($topic_name);
      $topic_name=strtolower($topic_name);
    }
    if(isset($material_name)){
      $material_name=trim($material_name);
      $material_name=strtolower($material_name);
    }
    $sql="SELECT id from topic WHERE topic_name=? ";
    $query = $this->db->prepare($sql);
    $query->execute([$topic_name]);
    $topic=$query->fetch(PDO::FETCH_ASSOC);
    $sql="SELECT id from material WHERE material_name=? ";
    $query = $this->db->prepare($sql);
    $query->execute([$material_name]);
    $material=$query->fetch(PDO::FETCH_ASSOC);
    if(isset($topic['id'])&&isset($material['id'])){
      $sql="SELECT * from question WHERE topic_id=? AND material_id=? LIMIT 1";
      $query = $this->db->prepare($sql);
      $query->execute([$topic['id'],$material['id']]);
      $ques=$query->fetch(PDO::FETCH_ASSOC);
      if(isset($ques['id'])){
          $sql="SELECT * from question WHERE topic_id=? AND material_id=?";
          $query = $this->db->prepare($sql);
          $query->execute([$topic['id'],$material['id']]);
          $questions=$query->fetchAll();
        }
    }
    elseif(isset($topic['id'])){
      if(empty($material_name)){
        $sql="SELECT * from question WHERE topic_id=? LIMIT 1 ";
        $query = $this->db->prepare($sql);
        $query->execute([$topic['id']]);
        $ques=$query->fetch(PDO::FETCH_ASSOC);
        if(isset($ques['id'])){
          $sql="SELECT * from question WHERE topic_id=?";
          $query = $this->db->prepare($sql);
          $query->execute([$topic['id']]);
          $questions=$query->fetchAll();
        }
      }
    }
    elseif(isset($material['id'])){
      if(empty($topic_name)){
        $sql="SELECT * from question WHERE material_id=? LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute([$material['id']]);
        $ques=$query->fetch(PDO::FETCH_ASSOC);
        if(isset($ques['id'])){
          $sql="SELECT * from question WHERE material_id=?";
          $query = $this->db->prepare($sql);
          $query->execute([$material['id']]);
          $questions=$query->fetchAll();
        }
      }
    }
  return $questions;
    
  }
  public function getAllOptions()
  {
    $sql = "SELECT * FROM option";
    $query = $this->db->prepare($sql);
    $query->execute();
    return $query->fetchAll();
  }
  public function addQuestionSave()
  {
    $c=1;
    $correct=[];
    $opt[]=[];
    $array=[];
    foreach($_POST as $key=>$value)
    {
      $value=trim($value);
      if($key!='submit' && $key!='button' && $key!='option1' && $key!='option2'
      && $key!='option3' && $key!='option4'&& $key!='option5')
      {
        $array[$key]=$value;
      }
    }
    $this->addSave($array);
    $sql=" SELECT id FROM question ORDER BY id DESC LIMIT 1 ;" ;
    $stmt=$this->db->prepare($sql);
    $stmt->execute();
    $id=$stmt->fetch(PDO::FETCH_ASSOC);
    $idd=$id['id'];
    while($c<=$_POST['options_number'])
    {
      $correct['option'.$c]='no';
      $c=$c+1;
    }
    $correct[$_POST['button']]='yes';
    $c=1;
    $counter=0;
    foreach($_POST as $key=>$value)
    {
      if($key=='option'.$c)
      {
        $opt[$counter]=[
          'option_text'=>$_POST['option'.$c],
          'question_id'=>$idd,
          'is_correct'=>$correct['option'.$c]
        ];  $c=$c+1; $counter=$counter+1;
      }
    }
    $c=1;
    while($c<=$_POST['options_number'])
    {
      $this->addOptions($opt[$c-1]);
      $c=$c+1;
    }
    header('location: ' . URL . 'questions/index'); 
  }
    public function addOptions($array){
      try{
        $sql="INSERT INTO option (";
        foreach($array as $key=>$value)
        {
            $sql=$sql.$key.",";
        }
        $sql=rtrim($sql,",");
        $sql=$sql.") VALUES (";
        foreach($array as $key=>$value)
        {
            $sql=$sql.":".$key.",";
        }
        $sql=rtrim($sql,",");
        $sql=$sql.") ;";
        $query = $this->db->prepare($sql);
        $query->execute($array);
    }
    catch(Exception $e){

    }
  }
    public function confirmQuestionDelete($question_id)
    {
      $this->confirmDeleteById($question_id);
    }
    public function deleteQuestion($question_id)
    {
      $sql="SELECT id from test_question WHERE question_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$question_id]);
      $u=$query->fetch(PDO::FETCH_ASSOC);
      if(isset($u['id'])){
      ?>
        <script>
        Swal.fire({
        title: 'You can not delete this question because it has tests contain it, first you need to delete each test contains it.',
        confirmButtonText: 'OK',
        }).then((result) => {
        if (true) {
          window.location.replace("http://127.0.0.1:8081/php-mvc/questions/index");
        }
        });
        </script>
        <?php exit();
      }
      else{
        $sql = "DELETE FROM option WHERE question_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$question_id]);
        $sql = "DELETE FROM test_question WHERE question_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$question_id]);
        $this->deleteById($question_id);
      }
    }
    public function editQuestionSave()
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
          $query->execute([$row->result_file_id]);
        }
        $c=1;
        $correct=[];
        $opt[]=[];
        $array=[];
        foreach($_POST as $key=>$value)
        {
          $value=trim($value);
          if($key!='submit' && $key!='button' && $key!='option1' && $key!='option2'
          && $key!='option3' && $key!='option4'&& $key!='option5')
          {
            $array[$key]=$value;
          }
        }
        $idd=$_POST['id'];
        while($c<=$_POST['options_number'])
        {
          $correct['option'.$c]='no';
          $c=$c+1;
        }
        $correct[$_POST['button']]='yes';
        $c=1;
        $counter=0;
        foreach($_POST as $key=>$value)
        {
          if($key=='option'.$c)
          {
            $opt[$counter]=[
              'option_text'=>$_POST['option'.$c],
              'question_id'=>$idd,
              'is_correct'=>$correct['option'.$c]
            ];  $c=$c+1; $counter=$counter+1;
          }
        }
        $c=1;
        $sql="DELETE from option WHERE question_id=? ;";
        $query = $this->db->prepare($sql);
        $query->execute(array($idd));
        while($c<=$_POST['options_number'])
        {
          $this->addOptions($opt[$c-1]);
          $c=$c+1;
        }
        $this->editSave($array);
        header('location: ' . URL . 'questions/index');
      }
      catch (Exception $e)
      {
        ?>
        <script>
            Swal.fire({
            title: "You can not modify this question right now because it is being answered by a student in this moment, try later.",
            confirmButtonText: 'OK',
            }).then((result) => {
            if (true) {
              window.location.replace("http://127.0.0.1:8081/php-mvc/questions/editQuestion/"+<?php echo $_POST['id'] ?>);      
            }
            });
        </script>
        <?php
        exit();
      }
    }
}
