<?php
$formtest = "Test";
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Registration</h4>
</div>
<div class="modal-body">
    <p>The content of this modal window has been loaded form a remote source file.</p>
    <p class="text-warning"><small><strong>Note:</strong> This option is deprecated since v3.3.0 and will be removed in v4. Use client-side templating, or a data binding framework, or call jQuery.load yourself instead.</p>

    <form id="popform">
        <label color="red"><?php echo $formtest;   ?></label>
    <div>
    	<input type="text-warning" id="username" value="" name="username">
    	<button id="popupbutton" type="button" class="button">Submit</button>
    </div>
    </form>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    <button type="button" id="popupbutton" class="btn btn-primary">Save changes</button>
</div>

