<?php
include_once '../connection/data.php';
$contacts = new Contacts();

$rows = $contacts->getNotes();
?>
<textarea class="edit-notes" name="" id="txtNotes" cols="30" rows="10">
<?php echo str_replace("<br />","\r\n",$rows[0][1]); ?>
</textarea>
<input type="button" id="saveNotes" value="Guardar">