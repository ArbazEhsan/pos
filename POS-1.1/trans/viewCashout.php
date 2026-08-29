<title>View Cash Payment</title>
<?php
include('../session.php');
include('../connect.php');
include('../header.php');
?>
<div class="container-fluid">
  <h2>View Cash Payment</h2>
  <h5>Here you can view invoices</h5><hr>
  <div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
      <table border="0" width="100%">
        <tr>
          <td>Show
            <select name="show" id="show" onchange="show()" style="font-size: 14px;">
              <option>10</option>
              <option>25</option>
              <option>50</option>
              <option>100</option>
              <option>200</option>
            </select>
            entries </td>
          <!-- <td style="text-align: right;">Search:</td> -->
          <td><input type="text" name="search" id="myInput" class="form-control" placeholder="Search Here" autocomplete="off" autofocus="on" style="float: right; width: 40%" onkeyup="myFunction()"><span style="float: right;margin-top: 9px;">Search:&nbsp;</span>
            <div class="pull-right" style="margin-top:07px; margin-right: 15px;">Filter by
              <select name="sort" id="sort" class="" onchange="sort(this.value)">
                <option value="0">Date</option>
                <option value="1">Voucher#</option>
                <option value="2">Amount</option>
              </select><br>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped table-bordered" id="myTable">
        <thead>
          <tr>
            <th>Date</th>
            <th>Voucher#</th>
            <th>Amount</th>    
            <th>Operation</th>
          </tr>
        </thead>
        <tbody id="tableData"></tbody>
        <tfoot>
        <tr>
          <th>Date</th>
          <th>Voucher#</th>
          <th>Amount</th>    
          <th>Operation</th>
        </tr>
        <tr>
          <td colspan="4"><span id="resultCount">Showing 1 to 10 of 96 entries</span></td>
        </tr>
      </tfoot>
      </table>
    </div>
  </div>
</div>

<?php 
include('../footer.php'); 
include('../subscription.php');
?>
<script type="text/javascript">
  var z = 0;
  function sort(val) {
    z = val;
  }

  function myFunction() {
    var input, filter, table, tr, td, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[z];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      } 
    }
  }

  $(document).ready(function () {
    show();
  });

  function show() {
    var num = $('#show').val();
    $.ajax({
        url: "operation.php?from=viewCashout&operation=show&num="+num,
        type: 'GET',
        async: false,
        success: function (info) {
          // alert(info);
          var data = info.split("|");
          $('#tableData').html(data[0]);
          $('#resultCount').html('Showing 1 to '+num+' of '+data[1]+' entries')
        },
        cache: false,
        contentType: false,
        processData: false
    });
  }

  function del(id) {
    if(validate()){
      $.ajax({
          url: "operation.php?from=viewCashout&operation=del&id="+id,
          type: 'GET',
          async: false,
          success: function (info) {
            if(info=='1'){
              show();
            }
            else {
              alert(info);
            }
          },
          cache: false,
          contentType: false,
          processData: false
      });
    }
  }

  function view(info){
    window.open('printcashout.php?sale_No='+info,'popUpWindow','height=400,width=1000,left=50,top=50,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
  }

  function validate(){
    text = confirm("Are you sure you want to delete?");
    if(text == true){
      return true;
    }
    else {
      return false;
    }  
  }
</script>