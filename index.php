<?php

// Connect to the database
$insert = false;
$update = false;
$delete = false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn){
  die("Sorrry we failed to Connect: " . mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE  `sno` = $sno ";
  $result = mysqli_query($conn,$sql);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
 if(isset($_POST['snoEdit'])){
  //update the record
  $sno = $_POST["snoEdit"];
  $title = $_POST["titleEdit"];
  $description = $_POST["descriptionEdit"];
  $sql = "UPDATE `notes` SET  `title` = '$title' , `description` = '$description'  WHERE `notes`.`sno` = $sno";
  $result = mysqli_query($conn,$sql);
  if($result){
    $update = true;
  }
 }
 else{

        $title = $_POST["title"];
         $description = $_POST["description"];
         $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
         $result = mysqli_query($conn,$sql);
  
         if($result){
            $insert = true;
          }
     else{
           echo "The REcord Was Not SuccessFul inserted because of this error--->".mysqli_error($conn);
          }
       }
    }
             
?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    
   
    <title>PHP CRUD</title>
    
  </head>

 <body>
 <!-- Edit modal -->
 <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit modal
 </button> -->

 <!-- Modal -->
 <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action= "/crud/index.php" method = "post">
            <input type="hidden" name="snoEdit" id="snoEdit">
             <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit">
              </div>
            
            <div class="mb-3">
                <label for="desc" class="form-label">Notes Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"  rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Note</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
     </div>
    </div>
  </div>
 

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">inotes</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact us</a>
              </a>
             </li>
             
             <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"></a>
              </li>
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
      
      <?php
      
       if($insert){
         echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
         <strong>Success!</strong> Your Notes has been Inserted successfully.
         <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
       </div>" ;
       }

      ?> 

<?php
      
      if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your Notes has been Deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>" ;
      }

     ?> 
     
     <?php
      
      if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your Notes has been Updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>" ;
      }

     ?> 


      <div class="container my-5">
         <h3>Submit your details</h3>
         <br><br>
        <form action= "/crud/index.php?" method = "post">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="title" name="title">
              </div>
            
            <div class="mb-3">
                <label for="desc" class="form-label">Notes Description</label>
                <textarea class="form-control" id="description" name="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
          </form>
     </div>

     
    <div class="container">
    <table class="table" id="myTable">
    <thead>
    <tr>
      <th scope="col">S.no</th>
      <th scope="col">title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
             $sql = "SELECT * FROM `notes`";
             $result = mysqli_query($conn,$sql);
             while($row = mysqli_fetch_assoc($result)){
               echo "<tr>
               <th scope='row'>".$row['sno']."</th>
               <td>".$row['title']."</td>
               <td>".$row['description']."</td>
               <td>  <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button> </td>
             </tr>";
              }
              
    ?>
    </tbody>
    </table>
    </div>


     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
     <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
     <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          console.log("edit" ,);
          tr = e.target.parentNode.parentNode ;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title,description);
          titleEdit.value = title;
          descriptionEdit.value = description;
          snoEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
         
        })
      })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click",(e)=>{
          console.log("edit" ,);
         sno = e.target.id.substr(1,);
          if(confirm("Press a button!")){
            console.log("Yes");
            window.location = `/crud/index.php?delete=${sno}`;
          }
         else{
           console.log("No");
         }
         
        })
      })
     </script>

  </body>
</html>