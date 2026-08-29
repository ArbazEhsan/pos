<title>Permission</title>
<?php
include('../session.php');
include('../connect.php');
include('../header.php');
?>
<div class="container-fluid">
  <h2>Permission</h2>
  <h5>Here you can perform all actions</h5><hr>
<div class="row" style="margin-bottom: 10px;">
      <div class="col-md-12">
      <form id="lockForm">
      <h4 class="category">Pages</h4>
        <form method="POST" id="lockForms">
          <table border="0" align="center" width="100%" class="table table-hover">
            <thead>
                  <?php 
                  $pages = array('Product','Stock Management','Accounts','Customer/Vendor Ledger','Cash Management','Sale Invoice','Purchase Invoice','View Sale','View Purchase','S/P Return','Report','Generate Salary');
                  for ($i=0;$i<count($pages);$i++) {
                    $none=$ve=$add=$admin='';
                    if($i==1 || $i==5 || $i==6 || $i==7 || $i==8){
                      $ve='th-display';
                    }
                    /*if($i==2 || $i==3 || $i==4 || $i==9 || $i==10){
                      $add='th-display';
                    }*/
                    /*if($i!=0){
                      $admin='th-display';
                    }*/
                  ?>
                  <tr>
                    <th class="th-width"><?php echo $pages[$i]; ?></th>
                    <th class="<?php echo $none; ?>"><input type="checkbox" name="pagenone[]" id="pagenone<?php echo $i; ?>" class="pagenone" value="<?php echo $pages[$i]; ?>/none"> None</th>
                    <th></th>
                    <th class="<?php echo $ve; ?>"><input type="checkbox" name="pageve[]" id="pageve<?php echo $i; ?>" class="pageve" value="<?php echo $pages[$i]; ?>/ve"> View & Edit</th>
                    <!-- <th class="<?php echo $add; ?>"><input type="checkbox" name="pageadd[]" id="pageadd<?php echo $i; ?>" class="pageadd" value="<?php echo $pages[$i]; ?>/add"> Add</th> -->
                    <!-- <th class="<?php echo $admin; ?>"><input type="checkbox" name="pageadmin[]" id="pageadmin<?php echo $i; ?>" class="pageadmin" value="<?php echo $pages[$i]; ?>/admin"> Admin</th> -->
                  </tr>
                  <?php } ?>
                  <tr>
                  <td colspan="2"><br><input type="button" id="sigin" class="btn btn-primary" value="Update"/></td>
                </tr>
                </thead>
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
$(document).ready(function () {
  $('#sigin').click(function () {
    alert("yes");
      /*var formData = new FormData($("#lockForms")[0]);
      $.ajax({
            url: "operation.php?from=accounts&operation=insert",
            type: 'POST',
            data: formData,
            async: false,
            success: function (info) {
          //alert(info);
          if(info==1){
            alert("Inserted Successfully");
          }
          else {
            alert("Failed try again");
          }
            },
            cache: false,
            contentType: false,
            processData: false
        });*/
  });

});

  $('body').delegate('.pagenone','click', function() 
  {
    var tr=$(this).parent().parent();
    tr.find('.pageve').prop("checked", false);/*
    tr.find('.pageadd').prop("checked", false);
    tr.find('.pageadmin').prop("checked", false);*/
  })
  $('body').delegate('.pageve','click', function() 
  {
    var tr=$(this).parent().parent();
    tr.find('.pagenone').prop("checked", false);
    tr.find('.pageadd').prop("checked", false);
    tr.find('.pageadmin').prop("checked", false);
  })
  

  result = JSON.parse('<?php echo $result ?>');
  size = Object.keys(result).length;
  var jspages = <?php echo json_encode($pages); ?>;
  for (var i=0;i<size;i++) {
    for (var j=0;j<11;j++) {
      if (result[i].pages==jspages[j]) {
        if (result[i].permission=='none') {
          $('#pagenone'+j).prop("checked", true);
          break;
        }
        if (result[i].permission=='ve') {
          $('#pageve'+j).prop("checked", true);
          break;
        }
      }
    }
  }


</script>