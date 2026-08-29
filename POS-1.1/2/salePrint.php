<?php
include('../session.php');
include("../connect.php");
include("../converter.php");

if(isset($_GET['sale_No'])){

  $sale_No = $_GET['sale_No'];
  $result = mysqli_query($con,"SELECT * FROM scounter WHERE id='$sale_No'");
  $fetch = mysqli_fetch_array($result);
  $day = $fetch['sale_day']; 
  $customer = $fetch['customer'];
  $result2 = mysqli_query($con,"SELECT * FROM accounts WHERE id='$customer'");
  $fetch2 = mysqli_fetch_array($result2);
  $result3 = mysqli_query($con,"SELECT * FROM scounter WHERE id='$sale_No'");
  $fetch3 = mysqli_fetch_array($result3);

  $result44 = mysqli_query($con,"SELECT * FROM sale WHERE sale_No='$sale_No'");
  $fetch44 = mysqli_fetch_array($result44);
  $sale_type = $fetch44['sale_type']; 
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Sale Print</title>
<style type="text/css">
  .headerCenter {
    text-align: center;
  }
  .headerCenterItem {
    font-weight: bolder;
    font-size: 25px;
  }
  .headerCenterPhone {
    font-size: 13px;
  }
  .mainTable {
    border-bottom: 1px solid black; 
    border-top: 1px solid black;
    text-align: left;
  }
  .mainTable2 {
    border-bottom: 1px solid black; 
    border-top: 1px solid black;
    text-align: right;
  }
  .mainTableTd {
    text-align: right;
  }
  body {
    font-family: sans-serif;
  }
  .dateStyle {
    margin-left: 28px;
    font-size: 15px;
    font-weight: bold;
  }
  .dateStyle2 {
    margin-left: 18px;
    font-size: 15px;
    font-weight: bold;
  }
  .branding {
    font-size: 11px;
  }
</style>
</head>
<body>
  <!-- header start -->
 <table align="center" border="0">
   <tr>
     <td class="headerCenter">
      <!-- <img src="{{asset('assets/img/msm-logo.png')}}" width="100" style="margin-bottom: -10px;"> -->
     </td>
   </tr>
   <tr>
     <td class="headerCenter headerCenterItem">
      <?php 
        $result4 = mysqli_query($con,"SELECT * FROM company");
        $fetch4 = mysqli_fetch_array($result4);
        echo $fetch4['name'];
      ?>
     </td>
   </tr>
   <tr>
     <td class="headerCenter headerCenterPhone"><i><?php echo $fetch4['phone1'] ?></i></td>
   </tr>
 </table>
 <!-- header end -->

  <table width="100%" style="border-top: 1px solid black;">
    <tr>
      <td class="headerCenterPhone">
        Date: <span class="dateStyle"><?php echo date("d/m/Y", strtotime($day)) ?></span>
      </td>
      <td  class="headerCenterPhone" style="text-align:right">Time: <?php date_default_timezone_set("Asia/Karachi"); echo date("h:iA");?></td>
    </tr>
    <tr>
        <td  class="headerCenterPhone">Bill No: <span class="dateStyle2"><?php echo $sale_No ?></span></td>
        <td  class="headerCenterPhone" style="text-align:right">Salesman: <?php echo $_SESSION['name']; ?></td>
    </tr>
    
  </table>
  

 <table width="100%">
   <tr><td class="headerCenterPhone">Customer: <?php echo $fetch2['name']; ?> <?php echo $fetch2['contact']; ?> <?php echo $fetch2['address']; ?></td>
    <td  class="headerCenterPhone" style="text-align:right">Sale Type: <?php echo $sale_type; ?></td>
   </tr>
</table>

<!-- <center><h3 style="margin-top: -20px;"><u><em>Sale INVOICE</em></u></h3></center> -->
<table class="main" border="0" width="100%" cellpadding="0" cellspacing="0" style="font-size: 14px;">
 <tr>
   <!-- <th class="mainTable">Sr#</th> -->
   <th class="mainTable">Name</th>
<!--    <th class="mainTable2">Rate</th>
   <th class="mainTable2">Qty</th>   -->
   <th class="mainTable2">Amount</th>
 </tr>
 <?php 
 $gross = $counter = $discount = $finalValue = $received = $remaining  = 0; 
 $result4 = mysqli_query($con,"SELECT * FROM sale WHERE sale_No='$sale_No'");
 while($fetch4=mysqli_fetch_array($result4)){ 
  $gross = $gross+($fetch4['qty']*$fetch4['price']); $counter++;
  ?>
 <tr>
  <!-- <td><?php echo $counter;?></td> -->
  <td width="40%"><?php echo getProductName($fetch4['barcode'],$fetch4['type'],$fetch4['deal_items']);?><br><?php echo $fetch4['qty'];?> x <?php echo $fetch4['price'];?></td>
<!--   <td class="mainTableTd"><?php echo $fetch4['price'];?></td>
  <td class="mainTableTd"><?php echo $fetch4['qty'];?></td> -->
  <td class="mainTableTd"><?php echo $fetch4['qty']*$fetch4['price']; ?></td>
 </tr>
 <?php 
  $discount = $fetch4['discount'];
  $finalValue = $fetch4['finalValue'];
  $received = $fetch4['received']+0;
  $remaining  = $fetch4['remaining']+0;
  $comments  = $fetch4['comments'];
  } ?>
 <tr>
   <td style="border-top: 1px solid black;" colspan="5"></td>
 </tr>
</table><!-- <br> -->
<!-- <div style="width: 100%;float: left;"> -->
<table width="100%" cellpadding="0" border="0" cellspacing="0" style="font-size: 13px;margin-top: 6px;">
  <tr>
    <td>Total items: <?php echo $counter;?></td>
    <td class="mainTableTd">Total Amount: </td>
    <td class="mainTableTd"><?php echo $gross;?></td>
  </tr>
  <tr>
    <td></td>
    <td class="mainTableTd">Discount (%):</td>
    <td class="mainTableTd"><?php echo $discount;?></td>
  </tr>
  <tr>
    <td></td>
    <td class="mainTableTd">Net Bill:</td>
    <td class="mainTableTd" style="border-bottom: 2px solid black;font-weight: bolder;font-size: 15px;"><?php echo $finalValue;?></td>
  </tr>
  <tr>
    <td></td>
    <td class="mainTableTd">Total Recieved:</td>
    <td class="mainTableTd" style="border-bottom: 2px solid black;font-weight: bolder;"><?php echo $received;?></td>
  </tr>
  <tr>
    <td></td>
    <td class="mainTableTd">Remaining:</td>
    <td class="mainTableTd"><?php echo $remaining;?></td>
  </tr>
  <!-- <tr>
    <td></td>
    <td class="mainTableTd">Comments:</td>
    <td class="mainTableTd"><?php echo $comments;?></td>
  </tr> -->
</table>
<!-- </div> -->
<!-- <div style="width: 74%;float: right;">
  <br><br>
  <span style="float: right;">Signature:__________________</span>
</div> -->
  <div>
    <p style="font-size:15px;">Comments: <?php echo $comments;?></p>
   <p class='headerCenterPhone' id="words"></p></div>
 <div style="margin-top: -10px;border-top:1px solid black; ">
  <div style="margin-top: -5px;">
  <p class="headerCenterPhone">TERMS & CONDITIONS</p>
  <ol class="headerCenterPhone" style="margin-left: -24px;margin-top: -10px;">
    <li>
      Check cash and ensure quality & quantity before leaving.
    </li>
    <li>
      Damage Products are non Returnable.
    </li>
    <li>
      Return with Invoice.
    </li>
  </ol>
  <!-- <p class="headerCenterPhone">This is computer generated slip, stamp & signature not required</p> -->
  </div>
  <center>
    <footer class="branding">
      THANK YOU FOR SHOPPING WITH US.<br>Developer: &copy; Arbaz Ehsan 03137747660; arbazehsan988@gmail.com
    </footer>
  </center>
 </div>

<!-- <div style="width: 100%;float: left;"> -->
<table width="100%" cellpadding="0" border="0" cellspacing="0" style="font-size: 13px;margin-top: 6px;">

</body>
</html>

<script type="text/javascript">
  var a = ['','ONE ','TWO ','THREE ','FOUR ', 'FIVE ','SIX ','SEVEN ','EIGHT ','NINE ','TEN ','ELEVEN ','TWELVE ','THIRTEEN ','FOURTEEN ','FIFTEEN ','SIXTEEN ','SEVENTEEN ','EIGHTEEN ','NINETEEN '];
  var b = ['', '', 'TWENTY','THIRTY','FORTY','FIFTY', 'SIXTY','SEVENTY','EIGHTY','NINETY'];

  function inWords (num) {
      if ((num = num.toString()).length > 9) return 'overflow';
      n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
      if (!n) return; var str = '';
      str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'CRORE ' : '';
      str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'LAKH ' : '';
      str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'THOUSAND ' : '';
      str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'HUNDRED ' : '';
      str += (n[5] != 0) ? ((str != '') ? 'AND ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + '' : '';
      return str;
  }

  var num = "<?php echo $finalValue; ?>";
  document.getElementById('words').innerHTML = inWords(num)+" RUPESS ONLY";
</script>