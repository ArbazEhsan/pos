<?php 
include("../connect.php");
$bal  =  $_REQUEST['dr'];
$cr   =  $_REQUEST['cr'];
$id   =  $_REQUEST['customerid'];
$day  =  $_REQUEST['day'];
// $ref  =  $_REQUEST['ref'];
foreach ($id as $key => $value)
	{	
		$result = mysqli_query($con,"SELECT * FROM customerledger WHERE id='$id[$key]'");
		$fetch = mysqli_fetch_array($result);
		if ($fetch['db']==$bal[$key] && $fetch['cr']==$cr[$key]) {
			// do nothing
			// echo '4';
		}
		else{
			if($bal[$key]>='0' && $cr[$key] == '') {
           
		    mysqli_query($con,"UPDATE customerledger SET cr='$cr[$key]',db='$bal[$key]', day='$day', naration='Opening Balance' , type='db' WHERE id='$id[$key]'");
		    // echo '1';
			}
	        elseif($cr[$key]>='0' && $bal[$key] == '') {
	        	
			    mysqli_query($con,"UPDATE customerledger SET cr='$cr[$key]',db='$bal[$key]' , day='$day' , type='cr' , naration='Opening Balance' WHERE id='$id[$key]'");
			    // echo '2';
			}
			elseif($bal[$key] == '' || $cr[$key] == ''){
				// echo '3';
				//remake: if both dr and cr are not empty or have 0
			}
		}
		
		
    }
?>