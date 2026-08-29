<title>Report menu</title>
<?php 
include("../header.php");
?>
<center><h1>Choose Following</h1></center><hr><br>
<div class="container">
	<div class="row">
		<div class="col-md-3 dropdown">
			<button style="font-size: 166%; border-radius: 50px;font-weight: bold;" class="alert alert-success btn-block dropdown-toggle" type="button" data-toggle="dropdown">Accounts Reports
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" style="margin-top: -20px;margin-left: 50px;">
				<li><a href="dailyTransaction.php">Daily Transaction</a></li>
				<li><a href="../ledger/check.php">Account Statement</a></li>
				<li><a href="cashBook.php">Cash Book</a></li>
				<li><a href="trialBalance.php">Trial Balance</a></li>
				<li><a href="trialBalanceByHead.php">Trial Balance By Head</a></li>
				<li><a href="chartOfAccount.php">Chart of Account</a></li>
				<li><a href="chartOfAccountByHead.php">Chart of Account By Head</a></li>
				<li><a href="printVoucher.php">Print Voucher</a></li>
				<li><a href="voucherStatementByType.php">Voucher Statement By Type</a></li>
				<li><a href="accountClosingBalance.php">Account Closing Balance</a></li>
				<li><a href="payableDue.php">Payable Due</a></li>
				<li><a href="receivableDue.php">Receivable Due</a></li>
				<li><a href="printCashSlip.php">Print Cash Slip</a></li>
				<li><a href="printCashPaymentSlip.php">Print Cash Payment Slip</a></li>
				<li><a href="profitAndLoss.php">Profit And Loss</a></li>
			</ul>
		</div>
		<div class="col-md-3 dropdown">
			<button style="font-size: 166%; border-radius: 50px;font-weight: bold;" class="alert alert-info btn-block dropdown-toggle" type="button" data-toggle="dropdown">Stock Report
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" style="margin-top: -20px;margin-left: 50px;">
				<li><a href="productValuation.php">Product Valuation Report</a></li>
				<li><a href="productStockIn.php">Product Stock In Report</a></li>
				<li><a href="productStockOut.php">Product Stock Out Report</a></li>
				<li><a href="productStockInOut.php">Stock In Out Report</a></li>
			</ul>
		</div>
		<div class="col-md-3 dropdown">
			<button style="font-size: 166%; border-radius: 50px;font-weight: bold;" class="alert alert-success btn-block dropdown-toggle" type="button" data-toggle="dropdown">Sales Report
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" style="margin-top: -20px;margin-left: 50px;">
				<li><a href="suplierWiseSale.php">Supplier Wise Sale Report</a></li>
				<!-- <li><a href="#">Group Wise Sale & Purchase Report</a></li> -->
				<!-- <li><a href="#">Group Consolidated Report</a></li>
				<li><a href="#">Group Wise Sales Report</a></li> -->
				<!-- <li><a href="#">Catgory Wise Sales Report</a></li>
				<li><a href="#">SubCatgory Wise Sales Report</a></ li>-->
				<li><a href="productWiseSale.php">Product Wise Sales Report</a></li>
				<li><a href="productSaleDetail.php">Product Sales Detail Report</a></li>
				<li><a href="partiesStationSale.php">Parties Station Sales Report</a></li>
				<li><a href="partyWiseSale.php">Party Wise Sales Report</a></li>
				<li><a href="saleReturn.php">Sales Return Report</a></li>
			</ul>
		</div>
		<div class="col-md-3 dropdown">
			<button style="font-size: 166%; border-radius: 50px;font-weight: bold;" class="alert alert-info btn-block dropdown-toggle" type="button" data-toggle="dropdown">Purchase Report
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" style="margin-top: -20px;margin-left: 50px;">
				<!-- <li><a href="#">Goods Receiving Report</a></li> -->
				<!-- <li><a href="#">Groups Purchases Report</a></li>
				<li><a href="#">Group Wise Purchases Report</a></li> -->
				<!-- <li><a href="#">Category Wise Purchases Report</a></li>
				<li><a href="#">SubCategory Wise Purchases Report</a></li> -->
				<li><a href="stationWisePurchase.php">Station Wise Purchases Report</a></li>
				<li><a href="productWisePurchase.php">Product Wise Purchases Report</a></li>
				<li><a href="partyWisePurchase.php">Party Wise Purchases Report</a></li>
				<li><a href="partyWiseLastPurchase.php">Party Wise Last Purchase Report</a></li>
				<li><a href="purchaseReturn.php">Purchase Return Report</a></li>
				<!-- <li><a href="#">Trade Offer Report</a></li> -->
			</ul>
		</div>
	</div>
<?php 
include("../footer.php");
?>