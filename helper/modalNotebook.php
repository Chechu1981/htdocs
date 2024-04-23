<link rel="stylesheet" href="../css/style28.css" type="text/css" />
<link rel="stylesheet" href="../css/chechu.css" type="text/css" />
<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$textoDiv = 'Arrastra aqui algún fichero';
$title ='new';
if($_GET['id'] != 'new'){
    $title = "update";
    $rows = $contacts->getNotebookId($_GET['id']);
    if($rows[0][5] != '')
        $textoDiv = $rows[0][5];
}
?>
<form action="" method="post" title="<?= $title ?>" class="formNotebook">
    <label>Marca</label>
        <select type='text' placeholder='marca' id='marca'>
            <option value='<?= @$rows[0][1]; ?>' cheched><?= @$rows[0][1]; ?></option>
            <option value='MULTIMARCA'>Multimarca</option>
            <option value='CITROEN'>Citroen</option>
            <option value='PEUGEOT'>Peugeot</option>
            <option value='OPEL'>Opel</option>
            <option value='FIAT/JEEP'>Fiat / Jeep</option>
            <option value='EUROREPAR'>Eurorepar</option>
            <option value='DOCUMENTOS'>Documentos</option>
            <option value='POWER'>Power Supply</option>
        </select>
    <label>Modelo</label><input type="text" id="modelo" placeholder="MODELO" value="<?= @$rows[0][2]; ?>">
    <label>Descripción</label><input type="text" id="descripcion" placeholder="DESCRIPCIÓN" value="<?= @$rows[0][3]; ?>">
    <label>Referencia</label><input type="text" id="referencia" placeholder="REFERENCIA" value="<?= @$rows[0][4]; ?>">
    <input type='file' id='docFile' style='display:none' value="../docs/<?= @$textoDiv ?>">
    <label>Fechero</label><div id='dropContainer'><?= @$textoDiv ?></div>
    <input type="hidden" id="<?= @$_GET['id']; ?>" value="<?= @$_GET['id']; ?>">
    <label></label><input type="submit" value="Modificar">
</form>
<script src="../js/formNotebook1.js?108"></script>