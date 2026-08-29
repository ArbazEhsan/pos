<?php 
include('../session.php'); 
include("../header.php");
include('../connect.php');

$day1 = $_POST['day1'];
$day2 = $_POST['day2'];
$cust = $_POST['customer'];
$t    = $_POST['t'];

if($t=='vender'){
    $new = 'Vender';
} elseif($t=='customer'){
    $new = 'Customer';
}
$result = mysqli_query($con,"SELECT * FROM accounts WHERE id='$cust'");
if(mysqli_num_rows($result)<=0){
    header("location:checkpoint.php?msg=Customer Not Found. Please add this vendor first");
} else{
    $fetch = mysqli_fetch_array($result);
    $customer = $fetch['id'];
}
?>

<style type="text/css">
  .td-right {
    text-align: right;
  }
  .td-left {
    text-align: left;
  }
</style>

<nav aria-label="..." style="position: fixed;">
  <ul class="pager">
    <li class="previous"><a href="#" onClick="javascript:history.go(-1)"><span aria-hidden="true">&larr;</span> Back</a></li>
  </ul>
  <body>
</nav>

<div class="container-fluid">
<div class="row" id="printableArea">

    <center>
    <h3>
      <?php 
        $result2 = mysqli_query($con,"SELECT * FROM company");
        $fetch2 = mysqli_fetch_array($result2);
        echo $fetch2['name'];
      ?>
    </h3>
    </center>
    <center>
    <h3>
        <i class="fa fa-phone" aria-hidden="true"> 
        <?php echo $fetch2['phone1']; ?>    
        </i>
    </h3>
    </center>
    <pre><h5 style="margin-top: -03px;"><?php echo date('d/m/Y'); ?></h5><center><h5 style="margin-top: -28px;">ACCOUNT STATEMENT:</h5></center><h3>A/C# <?php echo $fetch['id'] ?>: <?php echo $fetch['name']; ?></h3>
      <h3 style="margin-top: -35px;">Address: <?php echo $fetch['address']; ?></h3></pre>
    <h4>Transaction From: <?php 
    if ($day1!='' && $day2!='') {
      echo date("d/m/Y", strtotime($day1)).'  To  '. date("d/m/Y", strtotime($day2));
    }
    else {
      echo "To";
     }?>
    </h4>
    <h4 class="pull-right" onclick="printDiv('printableArea')"accesskey="p" style="margin-top: -25px;margin-right: 5px;"><i class="fa fa-print fa-1x"></i></h4>

    <table border='0' width="100%" align="center" class="table table-striped" style="table-layout:fixed;word-break: break-all;text-align: center;">
    <thead>
    <tr style="border: 1px solid black; border-right: none; border-left: none;">
        <th width="12%" style="text-align: left; border: 1px solid black; border-right: none; border-left: none;">Date</th>
        <th width="08%" style="text-align: left; border: 1px solid black; border-right: none; border-left: none;">Type</th>
        <th width="08%" style="text-align: left; border: 1px solid black; border-right: none; border-left: none;">V-No</th>
        <th width="20%" style="text-align: left;border: 1px solid black; border-right: none; border-left: none;">Remarks</th>
        <th style="border: 1px solid black; border-right: none; border-left: none; text-align: right;">Debit</th>
        <th style="border: 1px solid black; border-right: none; border-left: none; text-align: right;">Credit</th>
        <th style="border: 1px solid black; border-right: none; border-left: none; text-align: right;">Balance</th> 
    </tr>
    </thead>
    <tr>
        <?php 
            $openBalText = '';
            $balance = $openBalAmnt = 0;
            if ($day1!='' && $day2!='') {
                $result3 = mysqli_query($con,"SELECT SUM(ledgers.dr) AS opdr,SUM(ledgers.cr) AS opcr FROM ledgers INNER JOIN trans ON ledgers.trans_id=trans.id WHERE ledgers.account_id='$customer' AND ledgers.day < '$day1'");
                $fetch3 = mysqli_fetch_array($result3);
                $openBalAmnt = $fetch3['opdr'] - $fetch3['opcr'] + 0;
                if($openBalAmnt>0){
                  $openBalText = 'DR';
                } else{
                  $openBalText = 'CR';
                }
                $balance = $openBalAmnt;
            } else {
                $openBalAmnt = 0;
                $openBalText = '';
            }
        ?>
        <td colspan="6" style="text-align: center;">Opening Balance</td>
        <td><?php echo number_format(abs($openBalAmnt),2).' '.$openBalText; ?></td>
    </tr>
    <?php
        $sum = $counter = $debit = $credit = 0;
        if($customer!='' && $day1=='' && $day2==''){ 

          $sql1 = "SELECT ledgers.*, trans.remarks, trans.invoice_id, trans.amount, trans.bill_no FROM ledgers INNER JOIN trans ON ledgers.trans_id=trans.id WHERE ledgers.account_id='$customer' ORDER BY ledgers.day";
        } else {

          $sql1 = "SELECT ledgers.*, trans.remarks, trans.invoice_id, trans.amount, trans.bill_no FROM ledgers INNER JOIN trans ON ledgers.trans_id=trans.id WHERE ledgers.account_id='$customer' AND ledgers.day BETWEEN '$day1' AND '$day2' ORDER BY ledgers.day";
        }
        $result4 = mysqli_query($con,$sql1);
         while($fetch4 = mysqli_fetch_array($result4)){
            $balText = $invoiceNo = $invoiceNo2 = $dr = $cr = $remarks = '';
            if($fecth4['dr']>0 && $fetch4['cr']=='0' || $fetch4['cr']==''){
                $balance = $balance + $fetch4['dr'];
                $debit = $debit + $fetch4['dr'];
                $dr = $fetch4['dr'];
                $cr = 0;
            } else if($fecth4['cr']>0 && $fetch4['dr']=='0' || $fetch4['dr']==''){
                $balance = $balance - $fetch4['cr'];
                $credit = $credit + $fetch4['cr'];
                $dr = 0;
                $cr = $fetch4['cr'];
            }

            if($balance>0){
              $balText = 'DR';
            }
            else {
              $balText = 'CR';
            }

            if($fetch4['type']=='PV' || $fetch4['type']=='RP' || $fetch4['type']=='SV'){
              $invoiceNo = $fetch4['invoice_id'];
              $invoiceNo2 = $fetch4['invoice_id'];
            } else{
              $result5 = mysqli_query($con,"SELECT * FROM tcounter WHERE id='".$fetch4['bill_no']."'");
              $fetch5=mysqli_fetch_array($result5);
              $invoiceNo = $fetch4['bill_no'];
              $invoiceNo2 = $fetch5['voucher_no'];
            }

            if($fetch4['type']!='CR' && $fetch4['type']!='CO'){

              if ($fetch4['type']=='RS') {
                $sql2 = "SELECT returnsale.qty, returnsale.price, products.name FROM returnsale INNER JOIN products ON returnsale.barcode=products.id WHERE returnsale.pur_No='".$fetch4['invoice_id']."'";
              } else if($fetch4['type']=='PV') {
                $sql2 = "SELECT psale.qty, psale.price, products.name FROM psale INNER JOIN products ON psale.barcode=products.id WHERE psale.sale_No='".$fetch4['invoice_id']."'";
              }  else if($fetch4['type']=='SV') {
                $sql2 = "SELECT sale.qty, sale.price, products.name FROM sale INNER JOIN products ON sale.barcode=products.id WHERE sale.sale_No='".$fetch4['invoice_id']."'";
              }
              $result6 = mysqli_query($con,$sql2);
              while($fetch6=mysqli_fetch_array($result6)){
                $remarks .= $fetch6['name'].'-'.$fetch6['qty'].'@'.$fetch6['price'].', ';
              }
            } else {
              $remarks = 'Bill#.'.$fetch4['bill_no'];
            }
     ?>
    <tr>
        <td style="text-align: left;">
            <?php echo date("d/m/Y", strtotime($fetch4['day'])); ?>
        </td>
        <td style="text-align: left;">
            <?php echo $fetch4['type']; ?>
        </td>
        <td style="text-align: left;" onclick="popup('<?php echo $fetch4['type'] ?>','<?php echo $invoiceNo ?>')">
            <a href="#"><?php echo $invoiceNo2; ?></a>
        </td>
        <td style="line-height: 120%; text-align: left;padding-left: 10px;">
            <?php echo "(".$fetch4['remarks'].") ".$remarks; ?>  
        </td>
        <td style="text-align: right;">
            <?php echo number_format($dr,2); ?>
        </td>
        <td style="text-align: right;">
            <?php echo number_format($cr,2); ?>
        </td>
        <td style="text-align: right;">
            <?php echo number_format(abs($balance),2).' '.$balText; ?>
        </td> 
    </tr>
    <?php } ?>
    <tr style="border: 1px solid black; border-right: none; border-left: none;">
        <td colspan="5" style="border: 1px solid black;border-left: none;border-right: none; text-align: right;"><b><?php echo number_format($debit,2); ?> </b>
        </td>
        <td style="border: 1px solid black;border-left: none;border-right: none; text-align: right;"><b><?php echo number_format($credit,2); ?></b>
        </td> 
        <td style="border:1px solid black;border-left: none;border-right: none;font-weight: bolder; text-align: right;" >
        <?php
            if($balance>0){
                echo number_format(abs($balance),2)."(DR)";
            } else{
                echo number_format(abs($balance),2)."(CR)";
            }
        ?>
        </td>
        </tr>
    </table>
    <br>
</div>
<div class="row">
    <input type="button" class="btn btn-primary btn-lg" onclick="printDiv('printableArea')" value="Print"/>
</div>
</div>
<?php include("../footer.php"); ?>
<script type="text/javascript">
function printDiv(divName) {
   var printContents = document.getElementById(divName).innerHTML;
   var originalContents = document.body.innerHTML;
   document.body.innerHTML = printContents;
   window.print();
   document.body.innerHTML = originalContents;
}

function popup(from,info) {
  if(from=='PV') {
    window.open('../2/purchaseInvPrint.php?pur_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
  } else if(from=='CO'){
    window.open('../trans/printcashout.php?sale_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
  } else if(from=='CR'){
    window.open('../trans/printcashin.php?sale_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
  } else if(from=='RS'){
    window.open('../2/returnSPrint.php?sale_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
  } else if(from=='SV') {
    window.open('../2/print.php?sale_No='+info,'popUpWindow','height=500,width=500,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
  } 
}
</script>