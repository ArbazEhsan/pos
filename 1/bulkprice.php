<title>Bulk Price Editing</title>
<?php
include('../session.php');
include('../connect.php');
include('../header.php');
?>
<div class="container-fluid">
  <h2>Bulk Price Editing</h1>
  <h5>Here you can perform all actions</h6><hr>
  <div class="row" style="margin-bottom: 10px;">
    <div class="col-md-12">
      <table border="0" width="100%">
        <tr>
          <td><input type="submit" name="update" id="update" class="btn btn-primary" value="Update">
          &nbsp;&nbsp;Show
            <select name="show" id="show" onchange="show()" style="font-size: 14px;">
              <option>10</option>
              <option>25</option>
              <option>50</option>
              <option>100</option>
              <option>200</option>
            </select>
            entries </td>
          <!-- <td style="text-align: right;">Search:</td> -->
          <td><input type="text" name="search" id="myInput" class="form-control" placeholder="Search By Name" autocomplete="off" autofocus="on" style="float: right; width: 50%" onkeyup="myFunction()"><span style="float: right;margin-top: 9px;">Search:&nbsp;</span></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <form method="POST" id="lockForms">
      <table class="table table-striped table-bordered" id="myTable">
        <thead>
          <tr>
            <th>PID</th>
            <th>Name</th>
            <th>Liter/Gram</th>
            <th>Qty</th>
            <th style="width:20%">Purchase Price</th>
            <th style="width:20%">Wholesale Price</th>
            <th style="width:20%">Retail Price</th>
          </tr>
        </thead>
        <tbody id="tableData"></tbody>
        <tfoot>
          <tr>
            <th>PID</th>
            <th>Name</th>
            <th>Liter/Gram</th>
            <th>Qty</th>
            <th style="width:20%">Purchase Price</th>
            <th style="width:20%">Wholesale Price</th>
            <th style="width:20%">Retail Price</th>
          </tr>
          <tr>
            <td colspan="8"><span id="resultCount">Showing 1 to 10 of 96 entries</span></td>
          </tr>
        </tfoot>
      </table>
      </form>
    </div>
  </div>
</div>
<?php 
include('../footer.php'); 
include('../subscription.php');
?>
<script type="text/javascript">
function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
  td = tr[i].getElementsByTagName("td")[1];
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
  $('#update').click(function () {
    var formData = new FormData($("#lockForms")[0]);
    $.ajax({
          url: "operation.php?from=bulkpriceEditing&operation=update",
          type: 'POST',
          data: formData,
          async: false,
          success: function (info) {
            // alert(info);
            if(info==1){
              alert("Updated Successfully");
              show();
            }
            else {
              alert("Failed try again");
            }
          },
          cache: false,
          contentType: false,
          processData: false
      });
    });
  show();
});

  function show() {
    var num = $('#show').val();
    $.ajax({
          url: "operation.php?from=bulkpriceEditing&operation=show&num="+num,
          type: 'GET',
          async: false,
          success: function (info) {
        //alert(info);
        var data = info.split("|");
        $('#tableData').html(data[0]);
        $('#resultCount').html('Showing 1 to '+num+' of '+data[1]+' entries')
          },
          cache: false,
          contentType: false,
          processData: false
      });
  }
</script>