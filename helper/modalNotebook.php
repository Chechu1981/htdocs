<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$rows = $contacts->getNotebookId($_GET['id']);
$textoDiv = 'Arrastra aqui algún fichero';
if($rows[0][5] != '')
    $textoDiv = $rows[0][5];
?>
<form action="" method="post" title="update">
    <label>Marca</label>
        <select type='text' placeholder='marca' id='marca'>
            <option value='<?php echo $rows[0][1]; ?>' cheched><?php echo $rows[0][1]; ?></option>
            <option value='MULTIMARCA'>Multimarca</option>
            <option value='CITROEN'>Citroen</option>
            <option value='PEUGEOT'>Peugeot</option>
            <option value='OPEL'>Opel</option>
            <option value='FIAT/JEEP'>Fiat / Jeep</option>
            <option value='EUROREPAR'>Eurorepar</option>
            <option value='DOCUMENTOS'>Documentos</option>
            <option value='POWER'>Power Supply</option>
        </select>
    <label>Modelo</label><input type="text" id="modelo" placeholder="MODELO" value="<?php echo $rows[0][2]; ?>">
    <label>Descripción</label><input type="text" id="descripcion" placeholder="DESCRIPCIÓN" value="<?php echo $rows[0][3]; ?>">
    <label>Referencia</label><input type="text" id="referencia" placeholder="REFERENCIA" value="<?php echo $rows[0][4]; ?>">
    <input type='file' id='docFile' style='display:none' value="../docs/<?php echo $textoDiv ?>">
    <label>Fechero</label><div id='dropContainer'><?php echo $textoDiv ?></div>
    <input type="hidden" id="<?php echo $_GET['id']; ?>" value="<?php echo $_GET['id']; ?>">
    <label></label><input type="submit" value="Modificar">
</form>