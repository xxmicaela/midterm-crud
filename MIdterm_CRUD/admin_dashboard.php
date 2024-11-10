<?php
  
   //Start Session
   session_start();

   if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin')
   {
       header("Location: index.php");
       exit();
   }
   //include connection string
   include('database/connection.php');

// create variable for search query
    $search_query = '';

    //check if a search query is submitted
    if(isset($_GET['search']))
    $search_query = $con->real_escape_string($_GET['search']);


    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <?php
        echo "Welcome Admin ".$_SESSION['username'];
    ?>
    <a href="logout.php">Logout</a>
    <br> <br>
    <!--Search Form-->
    <form action="" method="get">
        <input type="text" name="search" id="" placeholder="Search by username" value="<?php echo $search_query ?>">
        <select name="search_field" id="">
            <option value="username">username</option>
            <option value="firstname">firstname</option>
            <option value="lastname">lastname</option>
        </select>
        <input type="submit" value="Search">
    </form>
    <br> 
    <!-- Create Table for list of records -->
     <table border="1" style="width: 60%;">
        <tr>
            <td>#</td>
            <td>Username</td>
            <td>Firstname</td>
            <td>Lastname</td>
            <td>Role</td>
            <td>Action</td>

        </tr>
        <?php
        //Modify SQL query based on the search input
        if(!empty($search_query))
        {
            $search = $_GET['search'];
            $search_field = $_GET['search'];
            $sql = "SELECT * FROM users WHERE role='client' AND $search_field LIKE '%$search%'";
        } 
        else{
            $sql = "SELECT * FROM users WHERE role = 'client'";
        }

        $result= $conn->query($sql);
        //Check if any client is exists
        if($result->num_rows > 0){
            //Loop to display each client account
            $count = 1;

            while($row = $result->fetch_assoc())
            {
               echo "<tr>";
               echo "<td> $count </td>";
               echo "<td>".$row['username']."</td>";
               echo "<td>".$row['firstname']."</td>";
               echo "<td>".$row['lastname']."</td>";
               echo "<td>".$row['role']."</td>";
               echo "<td>";
               echo "<a href='edit_client.php?ID=".$row['ID']."'>Edit</a> | ";
               echo "<a href='delete_client.php?ID=".$row['ID']."'onclick='return confirm(\"Are you sure want to delete this cient?\");'>Delete</a> | ";
               echo "</td>";
               echo "</tr>";
               $count++;
            }
        }
        else
        {
            echo "<tr><td colspan='5'>No clients found!</td></tr>";
        }

        ?>
                                                                                                                                                                                                



     </table>
</body>
</html>