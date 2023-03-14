<?php
require 'basemodel.php';
class rolesModel extends BaseModel
{
    function __construct($db) {
        parent::__construct($db,"role");
    }
    public function getRolePermissions($role_id=null){
      try{
        if(!isset($role_id))
        {
          $sql = "SELECT * FROM role_has_permission";
          $query = $this->db->prepare($sql);
          $query->execute();
          return $query->fetchAll();
        }
        else{
          $sql = "SELECT * FROM role_has_permission WHERE role_id=?";
          $query = $this->db->prepare($sql);
          $query->execute([$role_id]);
          return $query->fetchAll();
        }
      }
      catch(PDOException $e){ ?>
          <script> Swal.fire('Database connection could not be established.'); </script>
          <?php exit();
      }
    }
    public function getAllPermissions(){
      try{
        $sql = "SELECT * FROM permission";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
      }
      catch(PDOException $e){ ?>
          <script> Swal.fire('Database connection could not be established.'); </script>
          <?php exit();
      }
    }
    public function assignPermissionsIdToNames(){
      $per=null;
      $permissions=$this->getAllPermissions();
      foreach($permissions as $permission)
      {
          $per[$permission->id]=$permission->permission_name;
      }
      return $per;
    }
    public function getRole($role_id){
      $sql = "SELECT * FROM role WHERE id =?";
      $query = $this->db->prepare($sql);
      $query->execute([$role_id]);
      $row=$query->fetch(PDO::FETCH_ASSOC);
      return $row;
    }
    public function assignPermissionsToRoles(){
      $arr=null;
      $rolepermissions=$this->getRolePermissions();
      $per=$this->assignPermissionsIdToNames();
      foreach($rolepermissions as $rolepermission)
        {
            $arr[$rolepermission->role_id][]=$per[$rolepermission->permission_id];
        }
      return $arr;
    }
    public function getAllRoles()
    {
        return $this->getAll();
    }
    public function addRoleSave(){
      try {
        $array=[];
        $value=$_POST['role_name'];
        $value=trim($value);
        if(empty($value)){
          throw new PDOException();
        }
        $array['role_name']=$value;
        $this->addSave($array);
        $this->addToRelatedTables();
        header('location: ' . URL . 'roles/index');
      }
      catch(PDOException $e) {
        ?>
        <script>
        Swal.fire({
        title: 'The information you entered is not valid.',
        confirmButtonText: 'OK',
        }).then((result) => {
        if (true) {
          window.location.replace("http://127.0.0.1:8081/php-mvc/roles/addRole");
        }
        });
        </script>
        <?php
        } 
    }
    public function addToRelatedTables() //this function adds records to join tables (جداول كسر العلاقة) that
    //are related to role table
    {
      $sql="SELECT id FROM role where role_name=?";
      $stmt=$this->db->prepare($sql);
      $stmt->execute([$_POST['role_name']]);
      $id=$stmt->fetch(PDO::FETCH_ASSOC);
      $idd=$id['id'];
      foreach($_POST as $key=>$value)
      {
        if($key!='submit' && $key!='role_name')
        {
          $permission_id=$key;
          $sql="INSERT INTO role_has_permission(role_id,permission_id) VALUES (?,?);";
          $stmt=$this->db->prepare($sql);
          $stmt->execute([$idd,$permission_id]);
        }
      }
    }
    public function editToRelatedTables(){
      $sql="DELETE from role_has_permission WHERE role_id=? ;";
      $query = $this->db->prepare($sql);
      $query->execute(array($_POST['id']));
      foreach($_POST as $key=>$value)
      {
        if($key!='submit' && $key!='role_name' && $key!='id')
        {
          $permission_id=$key;
          $sql="INSERT INTO role_has_permission(role_id,permission_id) VALUES (?,?);";
          $stmt=$this->db->prepare($sql);
          $stmt->execute([$_POST['id'],$permission_id]);
        }
      }
    }
    public function deleteFromRelatedTables($role_id){
      $sql="DELETE from role_has_permission WHERE role_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$role_id]);
      $this->deleteById($role_id);
    }
    public function confirmRoleDelete($role_id)
    {
      $this->confirmDeleteById($role_id);
    }
    public function deleteRole($role_id)
    {
      $sql="SELECT * from user_has_role WHERE role_id=?";
      $query = $this->db->prepare($sql);
      $query->execute([$role_id]);
      $u=$query->fetch(PDO::FETCH_ASSOC);
      if(isset($u['id'])){
        ?>
        <script>
        Swal.fire({
        title: 'You can not delete this role because it has users attached to it, first you need to change their roles.',
        confirmButtonText: 'OK',
        }).then((result) => {
        if (true) {
          window.location.replace("http://127.0.0.1:8081/php-mvc/roles/index");
        }
        });
        </script>
        <?php exit();
      }
      else{
        $this->deleteFromRelatedTables($role_id);
      }
		  
    }
    public function editRole($role_id)
    {
      $this->editById($role_id,$this->permissions,$this->rolepermissions);
    }
    public function editRoleSave()
    {
      try {
        $array=[];
        $value=$_POST['role_name'];
        $value=trim($value);
        if(empty($value)){
          throw new PDOException();
        }
        $array['role_name']=$value;
        $array['id']=$_POST['id'];
        $this->editSave($array);
        $this->editToRelatedTables();
        header('location: ' . URL . 'roles/index');
      }
      catch(PDOException $e) {
        ?>
        <script>
        Swal.fire({
        title: 'The information you entered is not valid.',
        confirmButtonText: 'OK',
        }).then((result) => {
        if (true) {
          window.location.replace("http://127.0.0.1:8081/php-mvc/roles/editRole/".$_POST['id']);
        }
        });
        </script>
        <?php
        } 
    }

}
