<?php
require 'rolesmodel.php';
class usersModel extends BaseModel
{
  function __construct($db)
  {
    parent::__construct($db,"user");
  }
  public function getRoles(){
    $roleModel=new rolesmodel($this->db,'role');
    $roles=$roleModel->getAllRoles();
    return $roles;
  }
  public function getUser($user_id)
  {
    $sql = "SELECT * FROM user WHERE id =?";
    $query = $this->db->prepare($sql);
    $query->execute([$user_id]);
    $row=$query->fetch(PDO::FETCH_ASSOC);
    return $row;
  }
  public function assignUsersToRolesNames(){
    $usersRoles=$this->getAllUsersRoles();
    $userRoleName=null;
    foreach($usersRoles as $usersRole){
      $sql="SELECT role_name FROM role where id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$usersRole->role_id]);
      $id=$usersRole->user_id;
      $name=$query->fetch(PDO::FETCH_ASSOC)['role_name'];
      $userRoleName[$id]=$name;
    }
    return $userRoleName;
  }
  public function getAllUsersRoles(){
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
  public function getAllUsers()
  {
    $sql = "SELECT * FROM user ORDER BY first_name,last_name";
    $query = $this->db->prepare($sql);
    $query->execute();
    return $query->fetchAll();
  }
  public function addUserSave()
  {
    try {
      $array=[];
      foreach($_POST as $key=>$value)
      {
        $value=trim($value);
        if(empty($value)&&($key!='phone'&&$key!='image')){
            throw new PDOException();
        }
        if($key!='role_id'&& $key!='repassword' && !empty($value) && $key!='submit')
        {
          if($key=='password') {
            $array[$key]=md5($value);
          }
          else {
            $array[$key]=$value;
          }
        }
      }
      $this->addSave($array);
      $this->addToRelatedTables();
      header('location: ' . URL . 'users/index');
    }  
    catch(PDOException $e)
     {
      
       ?>
      <script>
      Swal.fire({
      title: 'The information you entered is not valid.',
      confirmButtonText: 'OK',
      }).then((result) => {
      if (true) {
        window.location.replace("http://127.0.0.1:8081/php-mvc/users/addUser");
      }
      });
      </script>
      <?php
      }      
    }
    public function addToRelatedTables() //this function adds records to join tables (جداول كسر العلاقة) that
    //are related to user table
    {
      $sql="SELECT id FROM user where email=?";
      $stmt=$this->db->prepare($sql);
      $stmt->execute([$_POST['email']]);
      $id=$stmt->fetch(PDO::FETCH_ASSOC);
      $idd=$id['id'];
      $role_id=$_POST['role_id'];
      $sql="INSERT INTO user_has_role(user_id,role_id) VALUES (?,?);";
      $stmt=$this->db->prepare($sql);
      $stmt->execute([$idd,$role_id]);
      $sql="SELECT role_name FROM role where id=?";
      $stmt=$this->db->prepare($sql);
      $stmt->execute([$role_id]);
      $r=$stmt->fetch(PDO::FETCH_ASSOC);
      $role_name=$r['role_name'];

      if($role_name=='Student')
      {
        $sql="INSERT INTO student(user_id) VALUES (?);";
        $stmt=$this->db->prepare($sql);
        $stmt->execute([$idd]);
      }
    }
    public function confirmUserDelete($user_id)
    {
      $this->confirmDeleteById($user_id);
    }
    public function deleteUser($user_id)
    {
      $this->deleteFromRelatedTables($user_id);
    }
    public function deleteFromRelatedTables($user_id){
      $sql="SELECT id from student WHERE user_id=?";
      $stmt=$this->db->prepare($sql);
      $stmt->execute([$user_id]);
      $s=$stmt->fetch(PDO::FETCH_ASSOC);
      if(isset($s['id'])){
        $sql="SELECT id from result_file WHERE student_id=?";
        $stmt=$this->db->prepare($sql);
        $stmt->execute([$s['id']]);
        $result_files=$stmt->fetchAll();
        foreach($result_files as $res){
          $sql="DELETE FROM student_question_answer WHERE result_file_id=?";
          $stmt=$this->db->prepare($sql);
          $stmt->execute([$res->id]);
        }
        $sql="DELETE FROM result_file WHERE student_id=?";
        $stmt=$this->db->prepare($sql);
        $stmt->execute([$s['id']]);
        $sql="DELETE FROM student WHERE user_id=?";
        $stmt=$this->db->prepare($sql);
        $stmt->execute([$user_id]);
      }
      $sql="SELECT role_id from user_has_role WHERE user_id=?";
      $query=$this->db->prepare($sql);
      $query->execute([$user_id]);
      $r=$query->fetch(PDO::FETCH_ASSOC);
      $role_id=null;
      if(isset($r['role_id']))
      {
        $role_id=$r['role_id'];
      }
      $sql="SELECT role_name from role WHERE id=?";
      $query=$this->db->prepare($sql);
      $query->execute([$role_id]);
      $r=$query->fetch(PDO::FETCH_ASSOC);
      $role_name=null;
      if(isset($r['role_name']))
      {
        $role_name=$r['role_name'];
      }
      if($role_name=='Test Center Admin')
      {
        $sql="SELECT user_id from test_center WHERE user_id=?";
        $query=$this->db->prepare($sql);
        $query->execute([$user_id]);
        $r=$query->fetch(PDO::FETCH_ASSOC);
        if(isset($r['user_id']))
        {
          ?>
          <script>
          Swal.fire({
          title: 'This user is a test center admin for a test center, First you need to '+
          'assign his center to a new test center admin.',
          confirmButtonText: 'OK',
          }).then((result) => {
          if (true) {
            window.location.replace("http://127.0.0.1:8081/php-mvc/users/index");      
          }
          });
          </script>
          <?php
          exit();
        }
      }
      $sql="DELETE FROM user_has_role WHERE user_id=?";
      $stmt=$this->db->prepare($sql);
      $stmt->execute([$user_id]);
      $this->deleteById($user_id);
    }
    public function editUserSave()
    {
      try {
        $sql="SELECT role_id from user_has_role WHERE user_id=?";
        $query=$this->db->prepare($sql);
        $query->execute([$_POST['id']]);
        $r=$query->fetch(PDO::FETCH_ASSOC);
        $role_id=null;
        if(isset($r['role_id']))
        {
          $role_id=$r['role_id'];
        }
        $sql="SELECT role_name from role WHERE id=?";
        $query=$this->db->prepare($sql);
        $query->execute([$role_id]);
        $r=$query->fetch(PDO::FETCH_ASSOC);
        $role_name1=null;
        if(isset($r['role_name']))
        {
          $role_name1=$r['role_name'];
        }
        $sql="SELECT role_name from role WHERE id=?";
        $query=$this->db->prepare($sql);
        $query->execute([$_POST['role_id']]);
        $r=$query->fetch(PDO::FETCH_ASSOC);
        $role_name2=null;
        if(isset($r['role_name']))
        {
          $role_name2=$r['role_name'];
        }
        if($role_name1=='Test Center Admin' && $role_name2!='Test Center Admin')
        {
          $sql="SELECT user_id from test_center WHERE user_id=?";
          $query=$this->db->prepare($sql);
          $query->execute([$_POST['id']]);
          $r=$query->fetch(PDO::FETCH_ASSOC);
          if(isset($r['user_id']))
          {
            ?>
            <script>
            var id='<?php echo $_POST["id"]; ?>';
            Swal.fire({
            title: 'This user is a test center admin for a test center, First you need to '+
            'assign his center to a new test center admin.',
            confirmButtonText: 'OK',
            }).then((result) => {
            if (true) {
              window.location.replace("http://127.0.0.1:8081/php-mvc/users/editUser/"+id);      
            }
            });
            </script>
            <?php
            exit();
          }
        }
        $array=[];
        foreach($_POST as $key=>$value)
        {
          $value=trim($value);
          if(empty($value)&&($key!='phone'&&$key!='image')){
            throw new PDOException();
          }
          if($key!='role_id' && !empty($value) && $key!='submit')
          {
            $array[$key]=$value;
          }
      }
      $this->editSave($array);
      $this->editToRelatedTables();
      header('location:'.URL.'users/index');
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
          window.location.replace("http://127.0.0.1:8081/php-mvc/users/editUser/"+id);
        }
        });
        </script>
        <?php
       }
    }
    public function editToRelatedTables() //this function edits corresponding records in
    //join tables (جداول كسر العلاقة) that are related to user table
    {
      $sql="UPDATE user_has_role SET user_id=?,role_id=? WHERE user_id=?";
      $stmt=$this->db->prepare($sql);
      $stmt->execute([$_POST['id'],$_POST['role_id'],$_POST['id']]);
      $sql="SELECT role_name FROM role where id=?";
      $stmt=$this->db->prepare($sql);
      $stmt->execute([$_POST['role_id']]);
      $r=$stmt->fetch(PDO::FETCH_ASSOC);
      $role_name=$r['role_name'];
      if($role_name=='Student')
      {
        $sql="SELECT * FROM student WHERE user_id=?";
        $stmt=$this->db->prepare($sql);
        $stmt->execute([$_POST['id']]);
        $idd=$stmt->fetch(PDO::FETCH_ASSOC);
        if(!isset($idd['id']))
        { 
          $sql="INSERT INTO student(user_id) VALUES (?);";
          $stmt=$this->db->prepare($sql);
          $stmt->execute([$_POST['id']]);
        }
      }
    }

}
