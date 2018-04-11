
</div>
</div>
<!-- Required -->
<script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script src="assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="assets/js/main.js" type="text/javascript"></script>
<script src="assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/lib/alertifyjs/alertify.js" type="text/javascript"></script>
<script src="assets/lib/tinycolor/tinycolor-min.js"></script>
<script src="assets/lib/jquery.gritter/js/jquery.gritter.js" type="text/javascript"></script>
<script src="js/sorttable.js"></script>
<script>
    var current = location.pathname;

    current = current.split("/");
    $('#nav li a').each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current[current.length-1]) !== -1){
            $this.parent().addClass('active');
        }
    });
</script>
<?php
if (isset($alert_success)) :?>
    <script>
        alertify.success('<?php echo $alert_msj; ?>');
    </script>
<?php endif;
?>

<?php if( isset($modal) ): ?>
    <div class="modal-overlay"></div>
    <!-- Modal -->
    <script src="assets/lib/jquery.niftymodals/dist/jquery.niftymodals.js" type="text/javascript"></script>

    <script type="text/javascript">
        $.fn.niftyModal('setDefaults',{
            overlaySelector: '.modal-overlay',
            closeSelector: '.modal-close',
            classAddAfterOpen: 'modal-show',
        });
    </script>
<?php endif; ?>

<?php if( isset($form_elements) ): ?>

    <script src="assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="assets/lib/select2/js/select2.min.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap-slider/js/bootstrap-slider.js" type="text/javascript"></script>
    <script src="assets/js/app-form-elements.js" type="text/javascript"></script>
    <script src="assets/lib/parsley/parsley.min.js" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function(){
            //initialize the javascript
            App.formElements();
            <?php if(isset($form_id)): ?>
            $('<?php echo $form_id ?>').parsley();

            <?php endif; ?>
        });
    </script>

<?php endif; ?>

<?php if(isset($form_mask)): ?>

    <script src="assets/lib/jquery.maskedinput/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="assets/js/app-form-masks.js" type="text/javascript"></script>


    <script type="text/javascript">
        $(document).ready(function(){
            //initialize the javascript
            App.masks();

        });
    </script>
<?php endif; ?>

<?php if(isset($data_tables)): ?>

    <script src="assets/lib/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/dataTables.buttons.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/buttons.html5.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/buttons.flash.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/buttons.print.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/buttons.colVis.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/buttons.bootstrap.js" type="text/javascript"></script>

<?php endif; ?>
<script src="horario/horario.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //initialize the javascript
        App.init();
        var pathname = window.location.pathname;
        pathname = pathname.split("/");
        $('.nav > li > a[href="'+pathname[pathname.length - 1]+'"]').parent().addClass('active');

    });
</script>
<script src="js/node_modules/print-this/printThis.js" type="text/javascript"></script>
<script src="js/script.js"></script>