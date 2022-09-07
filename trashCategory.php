<?php

 include('config.php');
 

 if(isset($_GET['id'])){
   $catid = $_GET['id'];
  $sql = "UPDATE categories set delete_ID= 1  WHERE cat_iD='$catid'";
   $result = mysqli_query($conn, $sql);
  header('location:form.php');


}
?>