<?php
class loginModel
{
    public $db;
    function __construct($db) {
      $this->db=$db;
    }
    public function logout(){
        unset($_SESSION['center_name']);
        unset($_SESSION['center_id']);
        unset($_SESSION['center_email']);
        unset($_SESSION['center_user_id']);
        unset($_SESSION['center_role']);
        unset($_SESSION['center_username']);
        unset($_SESSION['center_email']);
        unset($_SESSION['center_image']);
        unset($_SESSION['center_phone']);
    }
    public function loginCheck(){
        if(isset($_POST['submit'])){
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
              window.location.replace("http://127.0.0.1:8081/center_website/home/index");
            }
            });
            </script>
            <?php }
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
                    if($role_name=='Test Center Admin' || $role_name=='Student')
                    {
                        if($role_name=='Student'){
                            $_SESSION['center_user_id']=$row['id'];
                            $_SESSION['center_role']=$role_name;
                            $_SESSION['center_username']=$row['first_name']." ".$row['last_name'];
                            $_SESSION['center_email']=$row['email'];
                            if(isset($row['image'])) $_SESSION['center_image']=$row['image'];
                            if(isset($row['phone'])) $_SESSION['center_phone']=$row['phone'];
                        }
                        if($role_name=='Test Center Admin')
                        {
                            $sql="SELECT id,center_name FROM test_center WHERE user_id=?";
                            $query=$this->db->prepare($sql);
                            $query->execute([$row['id']]);
                            $stm=$query->fetch(PDO::FETCH_ASSOC);
                            if(isset($stm['id'])){
                                $_SESSION['center_user_id']=$row['id'];
                                $_SESSION['center_role']=$role_name;
                                $_SESSION['center_username']=$row['first_name']." ".$row['last_name'];
                                $_SESSION['center_email']=$row['email'];
                                if(isset($row['image'])) $_SESSION['center_image']=$row['image'];
                                if(isset($row['phone'])) $_SESSION['center_phone']=$row['phone'];
                                $_SESSION['center_name']=$stm['center_name'];
                                $_SESSION['center_id']=$stm['id'];
                                header('location: ' . URL . 'home/index');
                            }
                            else{
                                ?>
                                <script>
                                Swal.fire({
                                title: 'You should be an admin to a test center to enter the site of this center.',
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
                        elseif($role_name=='Student'){
                            header('location:'.URL.'students/chooseCenter');
                        }
                    }
                    else { ?>
                        <script>
                                Swal.fire({
                                title: 'There is no test center admin or student with this name.',
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
            }
            if(!$foundpass){?>
            <script>
            Swal.fire({
            title: 'The password you entered is not correct.',
            confirmButtonText: 'OK',
            }).then((result) => {
            if (true) {
              window.location.replace("http://127.0.0.1:8081/center_website/home/index");
            }
            });
            </script>
            <?php }
            }
            }
            else { ?>
                <script>  window.location.replace("http://127.0.0.1:8081/center_website/home/index"); </script>
                <?php
            }
    } 
}
