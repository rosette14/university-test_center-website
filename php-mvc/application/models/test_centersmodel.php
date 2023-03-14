
<?php
require 'usersmodel.php';
class test_centersModel extends BaseModel
{
  function __construct($db)
  {
    parent::__construct($db,"test_center");
  }
  public function getUsers(){
    $userModel=new usersmodel($this->db,'user');
    $users=$userModel->getAllUsers();
    return $useres;
  }
  public function getRoles(){
    $roleModel=new rolesmodel($this->db,'role');
    $roles=$roleModel->getAllRoles();
    return $roles;
  }
  public function getTestCenter($center_id)
  {
    $sql = "SELECT * FROM test_center WHERE id =?";
    $query = $this->db->prepare($sql);
    $query->execute([$center_id]);
    $row=$query->fetch(PDO::FETCH_ASSOC);
    return $row;
  }
  public function getUserName($id){
    $sql="SELECT first_name,last_name FROM user WHERE id=?";
    $query=$this->db->prepare($sql);
    $query->execute([$id]);
    $name=$query->fetch(PDO::FETCH_ASSOC);
    if(isset($name['first_name']) && isset($name['last_name']))
    {
      return $name['first_name']." ".$name['last_name'];
    }
    return null;
  }
  public function getAvailableCenterAdmins(){
    $roles=$this->getRoles();
    $rolesusers=$this->getUsersRoles();
    $test_centerAdmins=null;
    foreach($roles as $role)
    {
      if($role->role_name=='Test Center Admin')
      {
        $role_id=$role->id;
        break;
      }
    }
    foreach($rolesusers as $rolesuser)
    {
      if($rolesuser->role_id==$role_id)
      {
        $sql="SELECT user_id from test_center WHERE user_id=?";
        $query = $this->db->prepare($sql);
        $query->execute([$rolesuser->user_id]);
        $check=$query->fetch(PDO::FETCH_ASSOC);
        if(isset($check['user_id']))
        {

        }
        else{
          $sql="SELECT first_name, last_name FROM user where id=? ;";
          $query = $this->db->prepare($sql);
          $query->execute([$rolesuser->user_id]);
          $name=$query->fetch(PDO::FETCH_ASSOC);
          $test_centerAdmins[$rolesuser->user_id]=$name['first_name']." ".$name['last_name'];
        } 
      }
    }
    return $test_centerAdmins;
  }
  public function assignCentersAdminsIdToNames(){
    $roles=$this->getRoles();
    $rolesusers=$this->getUsersRoles();
    $test_centerAdmins=null;
    foreach($roles as $role)
    {
      if($role->role_name=='Test Center Admin')
      {
        $role_id=$role->id;
        break;
      }
    }
    foreach($rolesusers as $rolesuser)
    {
      if($rolesuser->role_id==$role_id)
      {
          $sql="SELECT first_name, last_name FROM user where id=? ;";
          $query = $this->db->prepare($sql);
          $query->execute([$rolesuser->user_id]);
          $name=$query->fetch(PDO::FETCH_ASSOC);
          $test_centerAdmins[$rolesuser->user_id]=$name['first_name']." ".$name['last_name'];
        } 
    }
    return $test_centerAdmins;
  }
  public function getUsersRoles()
  {
    try{
      $sql = "SELECT * FROM user_has_role";
      $query = $this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }
    catch(PDOException $e){ ?>
        <script> Swal.fire('Database connection could not be established.'); </script>
        <?php exit();
    }
  }
  public function getAllTest_centers()
  {
    return $this->getAll();
  }
  public function addTest_centerSave()
  {
    try {
      $array=[];
      foreach($_POST as $key=>$value)
      {
        $value=trim($value);
        if(empty($value)){
            throw new PDOException();
        }
        if($key!='submit')
        {
            $array[$key]=$value;
        }
      }
      $this->addSave($array);
      header('location: ' . URL . 'test_centers/index');
    }  
    catch(PDOException $e) {
      ?>
      <script>
      Swal.fire({
      title: 'The information you entered is not valid.',
      confirmButtonText: 'OK',
      }).then((result) => {
      if (true) {
        window.location.replace("http://127.0.0.1:8081/php-mvc/test_centers/addTest_center");
      }
      });
      </script>
      <?php
      }      
    }
    public function confirmTest_centerDelete($center_id)
    {
      $this->confirmDeleteById($center_id);
    }
    public function deleteTest_center($center_id)
    {
      try{
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
          $query->execute([$row->result_file_id]);}
        $sql="DELETE FROM result_file WHERE test_center_id=?";
        $query=$this->db->prepare($sql);
        $query->execute([$center_id]);
        $sql="SELECT id from test where test_center_id=?;";
        $query=$this->db->prepare($sql);
        $query->execute([$center_id]);
        $tests=$query->fetchAll();
        foreach($tests as $test){
          $sql="DELETE FROM test_question WHERE test_id=?";
          $query=$this->db->prepare($sql);
          $query->execute([$test->id]);
        }
        $sql="DELETE FROM test WHERE test_center_id=?";
        $query=$this->db->prepare($sql);
        $query->execute([$center_id]);
        $this->deleteById($center_id);
      }
      catch (Exception $e)
      {
        ?>
        <script>
            Swal.fire({
            title: "You can not delete this test center right now because there is a student taking test in it at this moment, try later.",
            confirmButtonText: 'OK',
            }).then((result) => {
            if (true) {
              window.location.replace("http://127.0.0.1:8081/php-mvc/test_centers/index");      
            }
            });
        </script>
        <?php
        exit();
      }
    }
    public function editTest_centerSave()
    {
      try {
        $array=[];
        foreach($_POST as $key=>$value)
        {
          $value=trim($value);
          if(empty($value)){
              throw new PDOException();
          }
          if($key!='submit')
          {
              $array[$key]=$value;
          }
        }
        $this->editSave($array);
        header('location: ' . URL . 'test_centers/index');
      }  
      catch(PDOException $e) {
        ?>
        <script>
        Swal.fire({
        title: 'The information you entered is not valid.',
        confirmButtonText: 'OK',
        }).then((result) => {
        if (true) {
          window.location.replace("http://127.0.0.1:8081/php-mvc/test_centers/addTest_center");
        }
        });
        </script>
        <?php
        }  
    }
}
