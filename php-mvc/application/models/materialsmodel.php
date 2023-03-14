<?php
require 'test_centersmodel.php';
class materialsModel extends BaseModel
{
    function __construct($db) {
      parent::__construct($db,"material");
    }
    public function getAllMaterials()
    {
      return $this->getAll();
    }
    public function addMaterialSave()
    {
      $array=[];
      foreach($_POST as $key=>$value)
      {
        $value=trim($value);
        $value=strtolower($value);
        if(!empty($value) && $key!='submit')
        {
          $array[$key]=$value;
        }
      }
      $this->addSave($array);
      header('location: ' . URL . 'materials/index');   
    }
    public function confirmMaterialDelete($material_id)
    {
      $this->confirmDeleteById($material_id);
    }
    public function deleteMaterial($material_id)
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
      $sql = "SELECT * FROM topic WHERE material_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$material_id]);
      $topics=$query->fetchAll();
      foreach($topics as $topic){
        $sql="SELECT id FROM question WHERE material_id=? and topic_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$material_id,$topic->id]);
        $res=$query->fetchAll();
        foreach($res as $re){
        $sql = "DELETE FROM option WHERE question_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$re->id]);
        $sql = "DELETE FROM test_question WHERE question_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$re->id]);
        }
      }
      $sql = "DELETE FROM question WHERE material_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$material_id]);
      $sql = "DELETE FROM topic WHERE material_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$material_id]);
      $sql="SELECT * FROM result_file WHERE material_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$material_id]);
      $res=$query->fetchAll();
      $sql = "DELETE FROM result_file WHERE material_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$material_id]);
      $sql="SELECT id FROM test WHERE material_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$material_id]);
      $res=$query->fetchAll();
      foreach($res as $re){
        $sql = "DELETE FROM test_question WHERE question_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$re->id]);
      }
      $sql = "DELETE FROM test WHERE material_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$material_id]);
		  $this->deleteById($material_id);
    }
    catch (Exception $e)
      {
        ?>
        <script>
            Swal.fire({
            title: "You can not delete this material right now because it is being tested by a student in this moment, try later.",
            confirmButtonText: 'OK',
            }).then((result) => {
            if (true) {
              window.location.replace("http://127.0.0.1:8081/php-mvc/materials/index");      
            }
            });
        </script>
        <?php
        exit();
      }
  }
    public function getMaterial($material_id)
    {
      $sql = "SELECT * FROM material WHERE id =?";
      $query = $this->db->prepare($sql);
      $query->execute([$material_id]);
      $row=$query->fetch(PDO::FETCH_ASSOC);
      return $row;
    }
    public function editMaterialSave()
    {
      $array=[];
      foreach($_POST as $key=>$value)
      {
        $value=trim($value);
        $value=strtolower($value);
        if(!empty($value) && $key!='submit')
        {
          $array[$key]=$value;
        }
      }
      $this->editSave($array);
      header('location:'.URL.'materials/index');
    }
}
