<?php
    require 'databaseconnect.php';
    session_start();
?>
<?php
    
      if(isset($_POST['sign_in'])){
        $id = $_POST['Username'];
        $password = $_POST['Password'];
          $sql1 = "SELECT * FROM `student` WHERE `Collage_id` = '".$id."'";
          $Student = mysqli_query($conn , $sql1);
          $obj = mysqli_fetch_assoc($Student);
          $No_of_row = mysqli_num_rows($Student);

          if($No_of_row == 1){
            if(password_verify($password ,$obj['Password'] )){
              $_SESSION['collage_id'] = $id; // assigning session an id
              $_SESSION['Designation'] = 'student';
              header("location:Student/dashboard_student.php"); //direct to student dashboard
            }
          }
          else{
              $sql2 = "SELECT * FROM `faculty` WHERE `Name` = '".$id."' AND `Password` = '".$password."' ";
              $faculty = mysqli_query($conn , $sql2);
              $No_of_row = mysqli_num_rows($faculty);
              
              if($No_of_row == 1){
                $id = mysqli_fetch_assoc($faculty);
                $_SESSION['Designation'] = 'faculty';
                $_SESSION['user_id'] = $id['id'];
                header("location:Admin/includes/dashboard.php");
              }
              else{
                $message = "Invalid Username or Password!";
                echo "<script>alert('$message');</script>";
              }
          }
      }
    


?>