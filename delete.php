<!DOCTYPE html>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "connection.php";
?>
<?php if($_SESSION['admin']!= true):?>
    <?php header('location:index.html ');?>
<?php else:?>
    <?php if(isset($_GET['id'])):?>
        <?php $sql = "DELETE FROM projects WHERE project_id =  :project_id";
                $stmt = $konekcija->prepare($sql);
                $stmt->bindParam(':project_id', $_GET['id'], PDO::PARAM_INT);   
                $stmt->execute();
            ?>

            <script>
                    // refreshes page(better than header)
                    if ( window.history.replaceState ) {
                    window.history.replaceState( null, null, window.location.href="admin.php" );
                    }
            </script>  

    <?php else:?>
    <script>
                    // refreshes page(better than header)
                    if ( window.history.replaceState ) {
                    window.history.replaceState( null, null, window.location.href="index.html" );
                    }
            </script>  

    <?php endif;?>
<?php endif;?>

?>

