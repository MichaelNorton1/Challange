<?php
$servername = "localhost" ;
    $username = "root";
    
    $password = "";
    
     $dbname ="users";

if (isset($_GET['pages'])) {
    $pages = $_GET['pages'];
} else {
    $pages = 1;
}
$no_of_records_per_page = 10;
$offset = ($pages-1) * $no_of_records_per_page;

$conn=mysqli_connect($servername,$username,$password,$dbname);

if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}

$total_pages_sql = "SELECT COUNT(*) FROM transactions";
$result = mysqli_query($conn,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$sql = "SELECT * FROM transactions LIMIT $offset, $no_of_records_per_page";
$res_data = mysqli_query($conn,$sql)

?>

<div class="data-table-container">
        <table class="table">
          <thead>
            <tr>
            <th class="ui-secondary-color">ID</th>
             <th class="ui-secondary-color">amount </th> <th class="ui-secondary-color">Status </th> 
             <th class="ui-secondary-color"> Payment Type</th>
              <th class="ui-secondary-color">Date of Transaction</th>

            </tr>
          </thead>
          <tbody>
            <?php while($row = mysqli_fetch_array($res_data)){
    
    ?> 
            <tr>
              
      <td ><?php echo $row["id"]; ?></td>
      <td><?php echo $row["amount"]; ?></td>
      <td><?php echo $row["statuss"]; ?></td>
      <td><?php echo $row["method"]; ?></td>
      <td><?php echo $row["timestamp"]; ?></td>
      
     </tr>
     <?php
            }
     ?>
          </tbody>
        </table>
        <ul class="pagination">
<li><a class="page-link" href="?pages=1">First</a></li>
<li class="<?php if($pages <= 1){ echo 'disabled'; } ?>">
    <a  class="page-link"href="<?php if($pages <= 1){ echo '#'; } else { echo "?pages=".($pages - 1); } ?>">Prev</a>
</li>
<li class="<?php if($pages >= $total_pages){ echo 'disabled'; } ?>">
    <a class="page-link"href="<?php if($pages >= $total_pages){ echo '#'; } else { echo "?pages=".($pages + 1); } ?>">Next</a>
</li>
<li><a class="page-link" href="?pages=<?php echo $total_pages; ?>">Last</a></li>
</ul>
<?php echo "Current Page " . $pages . "/". $total_pages?>

      </div>