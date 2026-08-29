<?php
include("../connect.php");

$from = $_REQUEST['from'];
if($from == 'SR'){
	$saleNo = $_REQUEST['saleNo'];
	$table = ''; $counter = $amnt = $i = 0;
	$result1 = mysqli_query($con,"SELECT sale.*, products.name FROM sale INNER JOIN products ON sale.barcode=products.id WHERE sale_No='$saleNo' GROUP BY id");

	while($fetch1=mysqli_fetch_array($result1)){ 	
		$counter++;$i++;
		$amnt = $fetch1["qty"]*$fetch1["price"];
		$table .='<tr>
            <td>'.$counter.'</td>
            <td><input type="number" style="width:100px;" readonly value="'.$fetch1["barcode"].'" name="barcode[]" class="form-control"></td>
            <td><input type="text" style="width:200px;" readonly value="'.$fetch1["name"].'" name="pname[]" class="form-control"></td>
            <td><input type="number" style="width:150px;" readonly value="'.$fetch1["price"].'" name="price[]" class="form-control"></td>
            <td><input type="number" style="width:150px;" value="'.$fetch1["qty"].'" name="qty[]" class="form-control qty"></td>
            <td><input type="number" style="width:150px;" value="'.$amnt.'" name="amnt[]" class="form-control amnt"></td>
            <td><input type="number" style="width:150px;" readonly value="'.$amnt.'" name="totalAmnt[]" class="form-control totalAmnt"></td>
           </tr>';   
    }
    echo $table;
}

elseif($from == 'RP'){
	$saleNo = $_REQUEST['saleNo'];
	$table = ''; $counter = $amnt = $i = 0;
	$result1 = mysqli_query($con,"SELECT psale.*, products.name FROM psale INNER JOIN products ON psale.barcode=products.id WHERE sale_No='$saleNo' GROUP BY id");

	while($fetch1=mysqli_fetch_array($result1)){ 	
		$counter++;$i++;
		$amnt = $fetch1["qty"]*$fetch1["price"];
		$table .='<tr>
            <td>'.$counter.'</td>
            <td><input type="number" style="width:100px;" readonly value="'.$fetch1["barcode"].'" name="barcode[]" class="form-control"></td>
            <td><input type="text" style="width:200px;" readonly value="'.$fetch1["name"].'" name="pname[]" class="form-control"></td>
            <td><input type="number" style="width:150px;" readonly value="'.$fetch1["price"].'" name="price[]" class="form-control"></td>
            <td><input type="number" style="width:150px;" value="'.$fetch1["qty"].'" name="qty[]" class="form-control qty"></td>
            <td><input type="number" style="width:150px;" value="'.$amnt.'" name="amnt[]" class="form-control amnt"></td>
            <td><input type="number" style="width:150px;" readonly value="'.$amnt.'" name="totalAmnt[]" class="form-control totalAmnt"></td>
           </tr>';   
    }
    echo $table;
}
?>