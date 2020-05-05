<?php

include('db_conn.php'); //db connection



    $search=mysqli_real_escape_string($conn, $_POST['user_input']);
    $sql="SELECT * FROM units WHERE unit_code LIKE'%$search%' OR unit_name LIKE '%$search%' OR unit_lecturer LIKE '%$search%'";
    $result=mysqli_query($conn, $sql);
    $queryResult= mysqli_num_rows($result);
    
    echo "There are ".$queryResult."results!";

    if($queryResult>0){
        while($row=mysqli_fetch_assoc($result)){
            echo "<tr>
    <th>Unit Code</th>
    <td>".$row["unit_code"]."</td>
    </tr>
    <tr>
    <th>Unit Name</th>
    <td>".$row["unit_name"]."</td>
    </tr>
    <tr>
    <th>Lecturer</th>
    <td>".$row["unit_lecturer"]."</td>
    </tr>
    <tr>
    <th>Semester</th>
    <td>".$row["unit_semester"]."</td>
    </tr>
    <tr>
    <th><br></th>
    <td><br></td>
    </tr>";
        }
        echo "</table>";   

    }
    else{
        echo '<script language="javascript">';
        echo 'alert("No Results Found")';
        echo '</script>';
    }


?>