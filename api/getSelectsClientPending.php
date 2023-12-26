<link rel="stylesheet" href="../css/style28.css?114">
<link rel="stylesheet" href="../css/blue.css?114">
<?php
include_once '../connection/data.php';
$contacts = new Contacts();
$day = '';

$rows = $contacts->selectsClientPendingGroupDay();

$htmlList = "
<div class='bodyContent'>
    <table class='listPendig'>
        <tr>
            <th>Día</th>
            <th>Consultas</th>
            <th></th>
        </tr>";
foreach($rows as $consults){
    $htmlList .= "
    <tr>
        <td>".$consults[0]."</td>
        <td>".$consults[1]."</td>
        <td class='btn-inmov'><img alt='🔽' src='../img/expand_more_FILL0_wght400_GRAD0_opsz48.png' class='btn-inmov-normal' id='".$consults[2]."'></td>
    </tr>";
}; 

echo $htmlList . "
    </table>
    <div id='secondTable'></div>
</div>";
?>

<script>
const btnArrows = document.getElementsByClassName('btn-inmov-normal')
const btnArrowsClick = document.getElementsByClassName('btn-inmov-180')
const clearArrows = () =>{
    for(var i=0; i<btnArrowsClick.length; i++){
        btnArrowsClick[i].parentNode.parentNode.classList.remove('listPendigActive')
        btnArrowsClick[i].className = "btn-inmov-normal"
    }
}

for(var i=0; i<btnArrows.length; i++){
    btnArrows[i].addEventListener('click',item =>{
        if(item.target.className == "btn-inmov-180"){
            document.getElementById('secondTable').innerHTML = ''
            clearArrows()
            return false
        }
        clearArrows()
        item.target.className = "btn-inmov-180"
        item.target.parentNode.parentNode.classList.add("listPendigActive")
        const dayNum = item.srcElement.id
        const data = new FormData()
        data.append('day', dayNum)
        fetch('./getSelectsByDays.php',{
            method: 'POST',
            body : data
        })
        .then(item => item.text())
        .then(table => {
            document.getElementById('secondTable').innerHTML = table
        })
    })
}
</script>