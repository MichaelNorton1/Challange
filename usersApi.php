<?php 

     
     
 function getUsers(){
        $contents= file_get_contents("https://randomuser.me/api/?results=500&nat=us&exc=login,id,nat");
        $objects =json_decode($contents);
      
        return $objects->results;
      }

       
    

    

     

    

class Users{
public $customers;

function __construct($customers){
    
    $this->customers =$customers;
}

function get_customers(){
   return  $this->customers;
}

function formatDate($customers){
  
        foreach( $customers as $customer){
            $date = date_create($customer->dob->date);
            $customer->dob->date = date_format($date, "F, d Y");
        }
        
    }

     

  function addUsers($customers){
    $servername = "localhost" ;
    $username = "root";
    
    $password = "";
    
     $dbname ="users";

     $conn = new mysqli($servername,$username,$password,$dbname);
     if ($conn->connect_error) {
         echo ("Connection Failed" . $conn->connect_error);};
   
foreach($customers as $customer){
    $conn->query("START TRANSACTION");
    $email = strval($customer->email);
    $dob =$customer->dob->date;
    $name=$customer->name->first ." ". $customer->name->last;
    $location=$customer->location->state;
    $date= $customer->registered->date;
    $phone=$customer->phone;
    $cell =$customer->cell;
    $picture =$customer->picture->medium;
    $sql= "INSERT INTO USERS (gender,name,location,email,dob,registered,phone,cell,picture)
    VALUES ('$customer->gender','$name ','  $location', ' $email ','$dob','$date','$phone','$cell','$picture' )";
    
    
    if ($conn->query($sql) === TRUE) {
        
        $conn->query("COMMIT");
      } else {
          $conn->query("ROLLBACK");
        echo "Error:  " . $sql . "<br>" . $conn->error;
      } 
      
}

  }


  function createTransaction(){
    $servername = "localhost" ;
    $username = "root";
    
    $password = "";
    
     $dbname ="users";

    $conn = new mysqli($servername,$username,$password,$dbname);
    $conn->query("START TRANSACTION");
    $sql="SELECT * FROM USERS";
     $result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        $id= $row["id"];
        $amount= rand(1,200);
        $status_array= array("complete","incomplete");

        $status= array_rand($status_array);
$payments = array("Visa", "Mastercard", "Discover", "American Express", "eCheck","Cyrptocurrency","Vemno");
$payment = array_rand($payments);
$finalstatus = $status_array[$status];
$finalpay =$payments[$payment];
$timestamp = mt_rand(1, time());


$randomDate = date("m/d/Y", $timestamp);

        
        $tsql= "INSERT INTO TRANSACTIONS (id, timestamp, amount,statuss,method)
        VALUES ('$id','$randomDate','$amount', '$finalstatus', '$finalpay' )";
        
        
        
        if ($conn->query($tsql) === TRUE) {
        
            $conn->query("COMMIT");
          } else {
              print_r($conn->query($tsql));
              $conn->query("ROLLBACK");
            echo "Error:  " . $tsql . "<br>" . $conn->error;
          } 
          
}

;}


  }
  
  
  
  }

  $request = getUsers();
  $myUsers= new Users($request);
  
  $myUsers->formatDate($request);
  //$myUsers->createTransaction();
   //$myUsers->addUsers($request);
 
?>

