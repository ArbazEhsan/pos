<?php session_start();
if ($_SESSION['name']=='') {
  header("Location:index.php");
} ?>
<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Main Menu</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   
</head>
<body>
     
                   
    <div id="wrapper">
         <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="adjust-nav">
                <div class="navbar-header">
                    
                    <a class="navbar-brand" href="#">
                        <img src="assets/img/logo.png" style="height: 55px; width: 65px;" />
                    </a>
                </div>
                <span class="logout-spn" style="margin-top: 20px;">
                  <a href="export.php" class="btn btn-success">Backup My Data</a>
                <a href="logout.php" class="btn btn-warning">LOGOUT</a></span>
            </div>
        </div>
               <div id="" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <!-- <h2><br>DASHBOARD</h2> -->
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="alert alert-info">
                             <strong>Welcome</strong> Good Day.
                        </div>
                       
                    </div>
                    </div>
                  <!-- /. ROW  --> 
                            <div class="row text-center pad-top">
                           <!--  <a href="accounts/accounts.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-circle-o-notch fa-5x"></i>
                      <h4>Categories</h4>
                      </div>
                  </div> 
                 </a> -->
                 <a href="1/product.php">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                    <i class="fa fa-files-o fa-5x"></i>
                      <h4>Products</h4>
                   </div>
                  </div>
                  </a>
            <!--       <a href="products/viewProducts.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           
 <i class="fa fa-eye fa-5x"></i>
                      <h4>View Products</h4>
                      </div>
                  </div>
                  </a>

                  <a href="vendor/vendor.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-users fa-5x"></i>
                      <h4>Add Vendor</h4>
                      </div>
                  </div> 
                 </a> -->
                  <a href="1/check.php">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-circle-o-notch fa-5x"></i>
                      <h4>Stock Management</h4>
                      </div>
                  </div> 
                 </a>

                  <a href="1/accounts.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-clipboard fa-5x"></i>
                      <h4>Accounts</h4>
                      </div>
                  </div> 
                 </a>

                 <!-- <a href="1/customer.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-clipboard fa-5x"></i>
                      <h4>Add Customers</h4>
                      </div>
                  </div> 
                 </a>

                 <a href="1/vendor.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-users fa-5x"></i>
                      <h4>Add Vendor</h4>
                      </div>
                  </div> 
                 </a> -->
              
                 <a href="ledger/check.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-circle-o-notch fa-5x"></i>
                      <h4>Customer/Vendor ledger</h4>
                      </div>
                  </div> 
                 </a>
                 <a href="trans/accounts.php">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-adjust fa-5x" aria-hidden="true"></i>
                      <h4>Cash Management</h4>
                      </div>
                  </div> 
                 </a>
                 <!-- <a href="ledger/openingbal.php">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-caret-up fa-5x" aria-hidden="true"></i>
                      <h4>Opening Balance</h4>
                      </div>
                  </div> 
                </a>  -->
                <a href="2/saleInvoice.php">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-clipboard fa-5x"></i>
                      <h4>Sale Invoice</h4>
                      </div>
                  </div> 
                 </a>
              </div><!-- /. ROW  --> 
                 
                

                  <div class="row text-center pad-top">
                     
                                    
                 <a href="2/viewInvoices.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-columns fa-5x"></i>
                      <h4>View Sale Invoice</h4>
                      </div>
                  </div> 
                 </a>

                  <a href="2/purchaseInvoice.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-rub fa-5x" aria-hidden="true"></i>
                      <h4>Purchase Invoice</h4>
                      </div>
                  </div> 
                 </a>

                 <a href="2/viewPurchase.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-columns fa-5x"></i>
                      <h4>View Purchase</h4>
                      </div>
                  </div> 
                 </a>
              
 
            
              

             
                <!-- <a href="trans/journal.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-hand-o-right fa-5x"></i>
                      <h4>Journal Voucher</h4>
                      </div>
                  </div> 
                 </a> -->
                 <a href="trans/directProfit.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-plus-square fa-5x"></i>
                      <h4>Direct Profit Menu</h4>
                      </div>
                  </div> 
                 </a>
                     <a href="2/check.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-bars fa-5x"></i>
                      <h4>S/P Return</h4>
                      </div>
                  </div> 
                 </a>
                  
                  
 <a href="reports/checkpoint.php">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-calendar fa-5x" aria-hidden="true"></i>
                      <h4>Report</h4>
                      </div>
                  </div> 
                </a>   

           
                  <!-- /. ROW     
                 <div class="row text-center pad-top">
                   
                
                  <a href="editLocation/location.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-retweet fa-5x"></i>
                      <h4>Bulk Location Editing</h4>
                      </div>
                  </div> 
                 </a> 
                  <a href="#" >
                     <a href="transactions/check.php" > -->
                  <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
  <i class="fa fa-exchange fa-5x" aria-hidden="true"></i>
                      <h4>Transactions</h4>
                      </div>
                  </div> 
                 </a> 
                  <a href="purchaseOrders/check.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-rub fa-5x" aria-hidden="true"></i>
                      <h4>Purchase Order</h4>
                      </div>
                  </div> 
                 </a>
                 <a href="sale/saleInvoice.php">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-clipboard fa-5x"></i>
                      <h4>Sale Invoice</h4>
                      </div>
                  </div> 
                 </a> 
                 <a href="sale/check.php">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-sitemap fa-5x"></i>
                      <h4>Sale Order</h4>
                      </div>
                  </div> 
                 </a> 
                 <a href="customer/index.php" >
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
 <i class="fa fa-clipboard fa-5x"></i>
                      <h4>Add Customers</h4>
                      </div>
                  </div> 
                 </a>   -->                                           
              </div>
                 <!-- /. ROW  -->   
				  <div class="row">
                    <div class="col-lg-12 ">
					<br/>
                        <div class="alert alert-danger">
                             
                        </div>
                       
                    </div>
           </div>
                  <!-- /. ROW  --> 
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->        
        <script>

</script>
    <div class="footer">
      
    
            <div class="row">
                <div class="col-lg-12" >
                    <center><a style="color: white; font-size: 15px;">&copy; Arbaz Ehsan; 03137747660; arbazehsan988@gmail.com</a></center>
                </div>
           </div>
    </div>
          

     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>
