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
}
