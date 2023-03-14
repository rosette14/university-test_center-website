<html>
    <head>
        <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    </head>
</html>

<?php

class BaseModel
{
	protected $table;
    function __construct($db,$table)
    {
        try {
            $this->db = $db;
			$this->table = $table;
        }
        catch (PDOException $e) { ?>
            <script> Swal.fire('Database connection could not be established.'); </script>
            <?php exit();
        }
    }
    public function checkPermission($permission_name,$role_id){
        $sql="SELECT id from permission WHERE permission_name=?";
        $query=$this->db->prepare($sql);
        $query->execute([$permission_name]);
        $permission_id=$query->fetch(PDO::FETCH_ASSOC)['id'];
        if(isset($permission_id))
        {
            $sql="SELECT * from role_has_permission WHERE role_id=? AND permission_id=?";
            $query=$this->db->prepare($sql);
            $query->execute([$role_id,$permission_id]);
            $res=$query->fetch(PDO::FETCH_ASSOC);
            if(isset($res['id']))
            {
                return true;
            }
            else return false;
        }
    }
    public function getAll()
    {
        try{
            $sql = "SELECT * FROM ".$this->table;
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        }
        catch(PDOException $e){ ?>
            <script> Swal.fire('Database connection could not be established.'); </script>
            <?php exit();
        }
    }
    public function deleteById($id)
    {
        try{
            $sql = "DELETE FROM ".$this->table." WHERE id = :table_id";
            $query = $this->db->prepare($sql);
            $query->execute(array(':table_id' => $id));
        }
        catch (Exception $e){ ?>
            <script>
            var table= '<?php echo $this->table;  ?>';
            var controller=table+'s';
            Swal.fire({
            title: 'You can not delete this '+table+'.',
            confirmButtonText: 'OK',
            }).then((result) => {
            if (true) {
                window.location.replace("http://127.0.0.1:8081/php-mvc/"+controller+"/index");
            }
            });
            </script>
            <?php
            exit(); }
    }
    public function confirmDeleteById($id)
    {
        ?>
        <script>
        var x='<?php echo $id; ?>'; 
        var controller='<?php echo $this->table."s"; ?>';
        var method='<?php echo "delete".ucfirst($this->table); ?>';
        Swal.fire({
        title: 'Are you sure?',
        confirmButtonText: 'Yes',
        showCancelButton: true,
        }).then((result) => {
        if (result.isConfirmed) {
            window.location.replace("http://127.0.0.1:8081/php-mvc/"+controller+"/"+method+"/"+x);
        }
        else {
            window.location.replace("http://127.0.0.1:8081/php-mvc/"+controller+"/index");
        }
        });
        </script>
        <?php
    }
    public function editSave($array)
    {
        try{
            $sql="UPDATE ".$this->table." SET ";
            foreach($array as $key=>$value)
            {
                $sql=$sql.$key."=".":".$key.",";
            }
            $sql=rtrim($sql,",");
            $sql=$sql." WHERE id=".$_POST['id'].";";
            $query = $this->db->prepare($sql);
            $query->execute($array);
        }
        catch(Exception $e){
        ?>
        <script>
        var i="<?php echo $_POST['id']; ?>"
        var controller='<?php echo $this->table."s"; ?>';
        var method='<?php echo "edit".ucfirst($this->table); ?>';
        Swal.fire({
        title: 'The information you entered is not valid.',
        confirmButtonText: 'OK',
        }).then((result) => {
        if (true) {
          window.location.replace("http://127.0.0.1:8081/php-mvc/"+controller+"/"+method+"/"+i);
        }
        });
        </script>
        <?php exit();
        }
    }
    public function addSave($array){  
        try{
            $sql="INSERT INTO ".$this->table."(";
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
        ?>
        <script>
        var controller='<?php echo $this->table."s"; ?>';
        var method='<?php echo "add".ucfirst($this->table); ?>';
        Swal.fire({
        title: 'The information you entered is not valid.',
        confirmButtonText: 'OK',
        }).then((result) => {
        if (true) {
          window.location.replace("http://127.0.0.1:8081/php-mvc/"+controller+"/"+method);
        }
        });
        </script>
        <?php exit();
        }
}
}?>
