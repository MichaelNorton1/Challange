<?php




$servername2 = "localhost" ;
    $username2 = "root";
    
    $password2 = "";
    
     $dbname2 ="users";

if (isset($_GET['pages2'])) {
    $pages2 = $_GET['pages2'];
} else {
    $pages2 = 1;
}
$no_of_records_per_page2 = 10;
$offset2 = ($pages2-1) * $no_of_records_per_page2;

$conn2=mysqli_connect($servername2,$username2,$password2,$dbname2);

if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}

$total_pages_sql2 = "SELECT COUNT(*) FROM users";
$result2 = mysqli_query($conn2,$total_pages_sql2);
$total_rows2 = mysqli_fetch_array($result2)[0];
$total_pages2 = ceil($total_rows2 / $no_of_records_per_page2);

$sql2 = "SELECT * FROM users LIMIT $offset2, $no_of_records_per_page2";
$res_data2 = mysqli_query($conn2,$sql2)

?>
  

<div class="data-table-container">
        <table class="table">
          <thead>
            <tr>
            <th scope="col">Name</th>
             <th scope="col">ID </th> 
             <th scope="col"> Location</th>
              <th scope="col">Date of Birth</th>
              


            </tr>
          </thead>
          <tbody>
            <?php while($row2 = mysqli_fetch_array($res_data2)){
    
    ?> <div class="modal fade Modal<?php echo $row2["id"]?>" " num id="Modal<?php echo $row2["id"]?>"" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><?php echo$row2["name"]  ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <img src=<?php echo$row2["picture"]  ?>   alt="headshot"> 
        Location:<?php echo$row2["location"]  ?>  <br> 
         Email: <?php echo$row2["email"]  ?>  <br>
           Date Joined:<?php
           $date = new DateTime($row2["registered"]);
           echo $date->format('m-d-Y');
           
           
           
             ?>  <br> 
           Phone:<?php echo$row2["phone"]  ?>  <br>
           Cell: <?php echo$row2["cell"]  ?>  <br>
             <br>
         Transactions:
         <br>

          <?php
          
          $mod =$row2["id"];

          $transQuery = "SELECT * FROM transactions WHERE id =$mod";
          $result3 = $conn->query($transQuery);
         while( $info = $result3->fetch_assoc()){
             echo "Date: "  . $info["timestamp"] . " Amount:$" .$info["amount"] ." Status: " . $info["statuss"] . " Method: " . $info["method"];
         }
           
           
        ?>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
  </div>
    
            <tr>
             
      <td ><?php echo $row2["name"]; ?></td>
      <td data-target="#Modal<?php echo $row2["id"]?>"" data-toggle="modal" class="id <?php echo $row2["id"]; ?>"><a href=""><?php echo $row2["id"]; ?></a> </td>
      <td><?php echo $row2["location"]; ?></td>
      <td><?php echo $row2["dob"]; ?></td>
      
      
     </tr>
     <?php
            }
     ?>
          </tbody>
        </table>
        
<!-- Modal -->

        <nav aria-label="Page navigation"><ul class="pagination">
<li class="page-item" ><a class="page-link" href="?pages2=1">First</a></li>
<li class="<?php if($pages2 <= 1){ echo 'disabled'; } ?>">
    <a class="page-link" href="<?php if($pages2 <= 1){ echo '#'; } else { echo "?pages2=".($pages2 - 1); } ?>">Prev</a>
</li>
<li class="<?php if($pages2 >= $total_pages2){ echo 'disabled'; } ?>">
    <a class="page-link" href="<?php if($pages2 >= $total_pages2){ echo '#'; } else { echo "?pages2=".($pages2 + 1); } ?>">Next</a>
</li>
<li><a class="page-link" href="?pages2=<?php echo $total_pages2; ?>">Last</a></li>
</ul></nav>
<?php echo "Current Page " . $pages2 . "/". $total_pages2?>

      
      