<?php include ('db.php') ?>;

<?php 
    if(isset ($_GET['id'])){
        $id = $_GET['id'];

    
        $query = "DELETE  from students where id= $id";

        $result = mysqli_query($connection, $query);

    if(!$result){
        die("Query Failed".mysqli_errno());
        die('query success');
        print_r($row);
    }
    else{
        header('location:index.php?delete_msg=You have deleted the record');
    }
}
?>