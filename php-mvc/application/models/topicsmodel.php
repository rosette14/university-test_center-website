
<?php
require 'materialsmodel.php';
class topicsModel extends BaseModel
{
  function __construct($db)
  {
    parent::__construct($db,"topic");
  }
  public function getTopic($topic_id){
    $sql = "SELECT * FROM topic WHERE id =?";
    $query = $this->db->prepare($sql);
    $query->execute([$topic_id]);
    $row=$query->fetch(PDO::FETCH_ASSOC);
    return $row;
  }
  public function getMaterialTopics($material_name){
    $topics=null;
    $material_name=trim($material_name);
    $material_name=strtolower($material_name);
    $sql="SELECT id from material WHERE material_name=?";
    $query = $this->db->prepare($sql);
    $query->execute([$material_name]);
    $row=$query->fetch(PDO::FETCH_ASSOC);
    if(isset($row['id'])){
      $sql = "SELECT * FROM topic WHERE material_id =?";
      $query = $this->db->prepare($sql);
      $query->execute([$row['id']]);
      $topics=$query->fetchAll();
    }
    return $topics;
  }
  public function getMaterials(){
    $materialModel=new materialsmodel($this->db);
    $materials=$materialModel->getAllMaterials();
    return $materials;
  }
  public function assignMaterialsIdToNames(){
    $materials=$this->getMaterials();
    $arr=null;
    foreach($materials as $row){
      $arr[$row->id]=$row->material_name;
    }
    return $arr;
  }
  public function getAllTopics()
  {
    return $this->getAll();
  }
  public function addTopicSave()
  {
    try {
      $array=[];
      foreach($_POST as $key=>$value)
      {
        $value=trim($value);
        $value=strtolower($value);
        if(empty($value)){
            throw new PDOException();
        }
        if(!empty($value) && $key!='submit')
        {
            $array[$key]=$value; 
        }
      }
      $this->addSave($array);
      header('location: ' . URL . 'topics/index');
    }  
    catch(PDOException $e) {
      ?>
      <script>
      Swal.fire({
      title: 'The information you entered is not valid.',
      confirmButtonText: 'OK',
      }).then((result) => {
      if (true) {
        window.location.replace("http://127.0.0.1:8081/php-mvc/topics/addTopic");
      }
      });
      </script>
      <?php
      exit();
      }      
    }
    public function confirmTopicDelete($topic_id)
    {
      $this->confirmDeleteById($topic_id);
    }
    public function deleteTopic($topic_id)
    {
      $sql="SELECT id from question WHERE topic_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$topic_id]);
      $ques=$query->fetchAll();
      foreach($ques as $q){
        $sql="SELECT id from test_question WHERE question_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$q->id]);
        $u=$query->fetch(PDO::FETCH_ASSOC);
        if(isset($u['id'])){
        ?>
          <script>
          Swal.fire({
          title: 'You can not delete this topic because there is a test covers it, first you need to delete each test covers it.',
          confirmButtonText: 'OK',
          }).then((result) => {
          if (true) {
            window.location.replace("http://127.0.0.1:8081/php-mvc/questions/index");
          }
          });
          </script>
          <?php exit();
        }
      }
      foreach($ques as $q) {
        $sql = "DELETE FROM option WHERE question_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$q->id]);
        $sql = "DELETE FROM test_question WHERE question_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$q->id]);
        $sql="DELETE FROM question WHERE id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$q->id]);
      }
		  $this->deleteById($topic_id);
    }
    public function editTopicSave()
    {
      try {
        $array=[];
        foreach($_POST as $key=>$value)
        {
          $value=trim($value);
          $value=strtolower($value);
          if(empty($value)){
            throw new PDOException();
          }
          if(!empty($value) && $key!='submit')
          {
            $array[$key]=$value;
          }
      }
      $this->editSave($array);
      header('location:'.URL.'topics/index');
      }
      catch(PDOException $e){
        ?>
        <script>
        var id='<?php echo $_POST["id"]; ?>';
        Swal.fire({
        title: 'The information you entered is not valid.',
        confirmButtonText: 'OK',
        }).then((result) => {
        if (true) {
          window.location.replace("http://127.0.0.1:8081/php-mvc/topics/editTopic/"+id);
        }
        });
        </script>
        <?php
        exit();
       }
    }
    
}
