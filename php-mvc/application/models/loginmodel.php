<?php
class loginModel
{
    public $db;
    function __construct($db) {
      $this->db=$db;
    }
    public function logout(){
      unset($_SESSION['admin_email']);
      unset($_SESSION ['admin_username']);
      if(isset($_SESSION['admin_phone'])) unset($_SESSION['admin_phone']);
      if(isset($_SESSION['admin_image'])) unset($_SESSION['admin_image']);
      unset($_SESSION['admin_role']);
    }
    public function loginCheck(){
      $found=false;
      $email=$_POST['email'];
      $sql="SELECT email FROM user";
      $stmt=$this->db->query($sql);
      while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
      if($row['email']==$email){
      $found=true;
      break;}
      }
      if($found==false){?>
      <script>
      Swal.fire({
      title: 'The email you entered is not valid.',
      confirmButtonText: 'OK',
      }).then((result) => {
      if (true) {
        window.location.replace("http://127.0.0.1:8081/php-mvc/home/index");
        
      }
      });
      </script>
      <?php exit(); }
      else{
      $password=md5($_POST['password']);
      $sql="SELECT * FROM user where email=?";
      $stmt=$this->db->prepare($sql);
      $stmt->execute( [$_POST['email']] );
      $foundpass=false;
      while($row=$stmt->fetch(PDO::FETCH_ASSOC)){  
          if($password==$row['password']){
              $sql="SELECT role_id FROM user_has_role WHERE user_id=?";
              $query=$this->db->prepare($sql);
              $query->execute([$row['id']]);
              $role_id=$query->fetch(PDO::FETCH_ASSOC)['role_id'];
              $sql="SELECT role_name FROM role WHERE id=?";
              $query=$this->db->prepare($sql);
              $query->execute([$role_id]);
              $role_name=$query->fetch(PDO::FETCH_ASSOC)['role_name'];
              $foundpass=true;
              $roleAccess=false;
              $sql="SELECT id from permission WHERE permission_name=?";
              $query=$this->db->prepare($sql);
              $query->execute(['Enter University Website']);
              $permission_id=$query->fetch(PDO::FETCH_ASSOC)['id'];
              if(isset($permission_id))
              {
                  $sql="SELECT * from role_has_permission WHERE role_id=? AND permission_id=?";
                  $query=$this->db->prepare($sql);
                  $query->execute([$role_id,$permission_id]);
                  $res=$query->fetch(PDO::FETCH_ASSOC);
                  if(isset($res['id']))
                  {
                      $roleAccess=true;
                  }
              }
              if($roleAccess)
              {
                  $_SESSION['admin_role_id']=$role_id;
                  $_SESSION['admin_id']=$row['id'];
                  $_SESSION['admin_role']=$role_name;
                  $_SESSION['admin_username']=$row['first_name']." ".$row['last_name'];
                  $_SESSION['admin_email']=$row['email'];
                  if(isset($row['image'])) $_SESSION['admin_image']=$row['image'];
                  if(isset($row['phone'])) $_SESSION['admin_phone']=$row['phone'];
                  header('location: ' . URL . 'home/index');
              }
              else { ?>
                  <script>
                  Swal.fire({
                  title: 'There is no admin with this name',
                  confirmButtonText: 'OK',
                  }).then((result) => {
                  if (true) {
                    window.location.replace("http://127.0.0.1:8081/php-mvc/home/index");
                    
                  }
                  });
                  </script>
              <?php exit(); }
          }
      }
      if(!$foundpass){?>
      <script>
      Swal.fire({
      title: 'The password you entered is not correct.',
      confirmButtonText: 'OK',
      }).then((result) => {
      if (true) {
        window.location.replace("http://127.0.0.1:8081/php-mvc/home/index");
        
      }
      });
      </script>
      <?php exit(); }
      }
    }
    
}
