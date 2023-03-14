
<?php
require 'basemodel.php';
class test_center_adminsModel extends BaseModel
{ 
  function __construct($db) {
      parent::__construct($db,"");
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
  public function askForTest(){
     try
     {
      if(isset($_POST['material_id'])&& isset($_SESSION['center_email']) )
      {
        $sql="SELECT id FROM test WHERE test_center_id IS NULL AND material_id=? LIMIT 1;";
        $query=$this->db->prepare($sql);
        $query->execute([$_POST['material_id']]);
        $stmt=$query->fetch(PDO::FETCH_ASSOC);
        $sql="UPDATE test SET test_center_id=? WHERE id=?";
        $query=$this->db->prepare($sql);
        if(!isset($stmt['id'])) throw new Exception('There is no available test');
        $query->execute([$_SESSION['center_id'],$stmt['id']]);
        ?>
        <script>
          Swal.fire({
          title: 'The process has been done successfully!',
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
      else { ?>
        <script> window.location.replace("http://127.0.0.1:8081/center_website/home/index"); </script>
      <?php }
     }
     catch (PDOException $e)
     {


     }
     catch (Exception $e)
     { 
       ?>
       <script>
          Swal.fire({
          title: "<?php echo $e->getMessage(); ?>",
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
   }
   public function assignStudentsIdToNames(){
    $sql="SELECT id,first_name,last_name from user;";
    $query=$this->db->prepare($sql);
    $query->execute();
    $allUsers=$query->fetchAll();
    $students=null;
    foreach($allUsers as $user)
    {
      $sql="SELECT id from student WHERE user_id=?";
      $query=$this->db->prepare($sql);
      $query->execute([$user->id]);
      $idd=$query->fetch(PDO::FETCH_ASSOC);
      if(isset($idd['id'])){    
      $student_id=$idd['id'];
      $students[$student_id]=$user->first_name." ".$user->last_name;
      }
    }
    return $students;
   }
   public function assignTestsIdToNames(){
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
   public function showStudentsResults(){
     $sql="SELECT * FROM result_file WHERE test_center_id=? AND result IS NOT NULL";
     $query=$this->db->prepare($sql);
     $query->execute([$_SESSION['center_id']]);
     $results=$query->fetchAll();
     return $results;
  }
}
