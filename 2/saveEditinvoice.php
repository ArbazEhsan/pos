<?php
 // print_r($_REQUEST);
include("../connect.php");
/*error_reporting(0);*/
$dest  = $_REQUEST['dest'];
$orderno  = $_REQUEST['orderno'];
$sale_day  = $_REQUEST['sale_day'];
$bilty_No  = $_REQUEST['bilty_No'];
$referal   = $_REQUEST['referal'];
$amntpaid  = $_REQUEST['amntpaid'];
$remaining = $_REQUEST['remaining'];
$cst       = $_REQUEST['customer'];
$sql1      = "SELECT * FROM customer WHERE name = '$cst'";
$result1   = mysqli_query($con,$sql1);
$fetch1    = mysqli_fetch_array($result1);
$customer     = $fetch1['id'];
$packing      = $_REQUEST['packingCharges'];
$net          = $_REQUEST['net'];
$invDiscount  = $_REQUEST['invDiscount'];
$amntpaid     = $_REQUEST['amntpaid'];
$finalValue   = $_REQUEST['final'];
$code 		  = $_REQUEST['barcode'];
$price	 	  = $_REQUEST['price'];
$qty 		  = $_REQUEST['qty'];
$barcode      = json_decode($code, TRUE);
$price        = json_decode($price, TRUE);
$qty          = json_decode($qty, TRUE);
$total=0;


/*mysqli_query($con,"insert into scounter(bilty_No,customer,sale_day,referal,status,socounter_Id) VALUES ('$bilty_No','$customer','$sale_day','$referal','1','$orderno')");
$id=mysqli_insert_id($con);*/
mysqli_query($con,"UPDATE `scounter` SET `bilty_No`='$bilty_No',`customer`='$customer',`sale_day`='$sale_day',`referal`='$referal',`status`='1'  WHERE  `id`='$orderno'");
$id = $orderno;
 mysqli_query($con,"DELETE FROM sale WHERE sale_No='$orderno'");
 mysqli_query($con,"DELETE FROM customerledger WHERE invoiceNo='$orderno'");
 mysqli_query($con,"DELETE FROM shopledger WHERE invoiceNo='$orderno'");
foreach($barcode as $key => $value)
{
	$finalItem = $qty[$key]*$price[$key];
    $sql = "INSERT INTO sale (sale_No,qty,price,final,customer,barcode,packingCharges,invDiscount,netValue,finalValue,amntpaid,remaining) VALUES ('$id','$qty[$key]','$price[$key]','$finalItem','$customer','$barcode[$key]','$packing','$invDiscount','$net','$finalValue','$amntpaid','$remaining')";
 if(mysqli_query($con,$sql))
 {
    if($dest=='order')
        {
            //do nothing;
        }
        elseif($dest == 'sale')
        {
        $update_qty  =  "UPDATE products SET p_qty = p_qty-'$qty[$key]' WHERE barcode ='$barcode[$key]'";
            if(mysqli_query($con,$update_qty))
            {
                $sql2 = "SELECT * FROM products WHERE barcode = $barcode[$key]";
                $result2 = mysqli_query($con,$sql2);
                $fetch2  = mysqli_fetch_array($result2);
                if ($fetch2['p_qty']>0 && $fetch2['s_qty']>0) {
                    $total   = $fetch2['p_qty']+$fetch2['s_qty'];
                }
                else{
                   $total=0; 
                 //if sale order then update ledger
                }
            }
        }
    }
}
               if($remaining == '0' || $remaining == '')
                {                    
                    mysqli_query($con,"INSERT INTO shopledger(day,cr,invoiceNo,type,customer,remarks,invType)VALUES('$sale_day','$amntpaid','$id','cr','$customer','$referal','sale on cash')");
                    $shopMaster = mysqli_insert_id($con);
                    mysqli_query($con,"INSERT INTO cashin (amount,shopledger_Id) VALUES ('$amntpaid','$shopMaster') ");
                }
                elseif($remaining > 0 && $amntpaid > 0)
                {
                    mysqli_query($con,"INSERT INTO shopledger(day,cr,invoiceNo,type,customer,remarks,invType)VALUES('$sale_day','$amntpaid','$id','cr','$customer','$referal','sale on cash')");
                    $shopMaster = mysqli_insert_id($con);
                    mysqli_query($con,"INSERT INTO cashin (amount,shopledger_Id) VALUES ('$amntpaid','$shopMaster') ");
                                        
                 mysqli_query($con,"INSERT INTO customerledger(day,db,invoiceNo,type,customer,remarks,invType) VALUES('$sale_day','$remaining','$id','db','$customer','$referal','sale on credit')");                      
                }
                elseif($amntpaid == '0' || $amntpaid == '')
                {                    
                 mysqli_query($con,"INSERT INTO customerledger(day,db,invoiceNo,type,customer,remarks,invType)VALUES('$sale_day','$remaining','$id','db','$customer','$referal','sale on credit')");
                }
                if($fetch2['minQ']> $total)
                {
                    mysqli_query($con,"UPDATE products SET reorder=1 WHERE barcode = $barcode[$key]");
                }
 echo $id;
?>