</div></div><!-- Nav bar divs-->

<div class="footer">
      
    
            <div class="row">
                <div class="col-lg-12" >
                    <center><a style="color: white; font-size: 15px;">&copy; Arbaz Ehsan; 03137747660; arbazehsan988@gmail.com</a></center>
                </div>
                
            
</body>
</html>
<script type="text/javascript">
    $(document).ready(function () {
        $("input").not($(":button")).keypress(function (evt) {
  ;     if (evt.keyCode == 13) {
                iname = $(this).val();
                if (iname !== 'Submit') {
                    var fields = $(this).parents('form:eq(0),body').find('button, input, textarea, select');
                    var index = fields.index(this);
                    if (index > -1 && (index + 1) < fields.length) {
                        fields.eq(index + 1).focus();
                    }
                    return false;
                }
            }
        });
    });
</script>