<?php 
include("../connect.php");
session_start();

$head = $_REQUEST['head'];

$location = $_REQUEST['location'];
$table = "";


if (($head != '' || $head == 'All') && ($location == ''))
{

  if(!$con)
    {
     die("Conection failed".mysqli_error());
    }

    $sql52= "SELECT * FROM products WHERE name='$head'";
    //echo $sql;
         $result=mysqli_query($con,$sql52);
         $table .= '<thead>
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>New Location</th>
                  </tr>
                </thead>
                <tfoot>
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>New Location</th>
                  </tr>
                </tfoot>
                <tbody>';
}

elseif(($head == '' || $head == 'All') && ($location != ''))
{
 
  if(!$con)
    {
     die("Conection failed".mysqli_error());
    }
    $sql54= "SELECT * FROM products WHERE location='$location'";
    //echo $sql;
         $result=mysqli_query($con,$sql54);
           $table .= '<thead>
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>New Location</th>
                    
                  </tr>
                </thead>
                <tfoot>
                  <th>Sr#</th>
                    <th>Name</th>
                    <th>New Location</th>
                   
                  </tr>
                </tfoot>
                <tbody>';
}
elseif(($head == '' || $head == 'All') && ($location == ''))
{
  
  if(!$con)
    {
     die("Conection failed".mysqli_error());
    }
    $sql54= "SELECT * FROM products";
    //echo $sql;
         $result=mysqli_query($con,$sql54);
           $table .= '<thead>
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>New Location</th>
                    
                  </tr>
                </thead>
                <tfoot>
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>New Location</th>
                   
                  </tr>
                </tfoot>
                <tbody>';
}

$counter=0;
while($fetch54=mysqli_fetch_array($result))
          {
            $counter++;
            $table .='<tr>
                    
                    <td>'.$counter.'</td>
                    <td>'.$fetch54["name"].'</td>
                    <td><input name = "location[]" class="form-control" value = "'.$fetch54["location"].'">
                    <input type="hidden" name="barcode[]" value = "'.$fetch54["id"].'">
                    </td>
                  </tr>';
          }
$table .= '</tbody>';
echo $table;
$_SESSION['table'] = $table;

?>