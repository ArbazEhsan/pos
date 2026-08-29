<?php
     function getHeadId($headName)
     {
     	include('connect.php');
     	 $result1=mysqli_query($con,"SELECT *FROM head WHERE head='$headName'");
	     $fetch1=mysqli_fetch_array($result1);
	     return $fetch1['id'];
     }
     function getHeadName($headId)
     
     {
     	include('connect.php');
     	 $result1=mysqli_query($con,"SELECT * FROM head WHERE id='$headId'");
	     $fetch1=mysqli_fetch_array($result1);
	     return $fetch1['head'];
     }

     function getProductId($productName)
     {
        include ('connect.php');
        $result1=mysqli_query($con,"SELECT *FROM products WHERE name='$productName'");
        $fetch1=mysqli_fetch_array($result1);
        return $productid=$fetch1['id'];
         
      }

      function getProductName($productId)
    {

       include('connect.php');
       $result1=mysqli_query($con,"SELECT *FROM products WHERE id='$productId'");
	     $fetch1=mysqli_fetch_array($result1);
	     return $fetch1['name'];


      }

    function getSizeId($sizeName)
    {
      include('connect.php');
     $result1=mysqli_query($con,"SELECT * FROM size WHERE size='$sizeName'");
     $fetch1=mysqli_fetch_array( $result1);
     return $sizeid=$fetch1['id'];
     }
    

     function getSizeName($sizeid)
     
     {
        include('connect.php');
        $result1=mysqli_query($con,"SELECT *FROM size WHERE id='$sizeid'");
        $fetch1=mysqli_fetch_array($result1);
        return $fetch1['size'];

       }

       function getCustomerId($customer_Name)
       {
           include('connect.php');
           $result1=mysqli_query($con,"SELECT *FROM accounts WHERE name='$customer_Name'");
           $fetch1=mysqli_fetch_array( $result1);
           return $customerid=$fetch1['id'];      

        }
    

      function getCustomerName($customer_Id)
      {
          include('connect.php');
          $result1=mysqli_query($con,"SELECT * FROM accounts WHERE id='$customer_Id'");
          $fetch1=mysqli_fetch_array( $result1);
          return $fetch1['name'];  
      }

       function getSubId($subName)
     {
      include('connect.php');
       $result1=mysqli_query($con,"SELECT *FROM sub WHERE   subhead='$subName'");
       $fetch1=mysqli_fetch_array($result1);
       return $subid=$fetch1['id'];
     }
     function getSubName($subid)
     
     {
      include('connect.php');
       $result1=mysqli_query($con,"SELECT * FROM sub WHERE id='$subid'");
       $fetch1=mysqli_fetch_array($result1);
       return $fetch1['subhead'];
     }
      function getServiceFinalValue($id)
     {      
      include('connect.php');
       $result1 = mysqli_query($con,"SELECT * FROM service WHERE sale_No='$id' GROUP BY itemid");
       $fetch1=mysqli_fetch_array($result1); 
       return $fetch1['finalValue']."/".$fetch1['amountPaid'];
     }
   


 


      // function getsum($a)
      // {

      
      //   echo $a/700*100;
       

      // }

      // getsum(450);

      //  function getmul($a,$b)
      // {

      
      //   echo $a*$b;
       

      // }

      // getmul(10,10);
      




 ?>
