// Botones del menú Compras exteriores
$('all').addEventListener('click',()=>{
  document.location.href = './orderList.php'
})

$('new').addEventListener('click',()=>{
  document.location.href = '../extbrand.php'
})

$('search-results').addEventListener('click',e =>{
  const id = e.target.closest('ul').id
  const eliminar = e.target.id.split('-')[0]
  const desplegado = document.getElementsByClassName('order-list').length
  if(id == '')
    return
  if(eliminar === 'delete'){
    confirm('¿Seguro que quieres eliminar este pedido?') && fetch(`../../api/deleteExtOrder.php?id=${id}`)
      .then(response => response.text())
      .then(data => {
        e.target.closest('ul').remove()
      })
  }else if(eliminar === 'edit'){
    document.location.href = `./editExtOrder.php?id=${id}`
  }else{
    fetch(`../../api/getExtOrder.php?id=${id}`)
    .then(response => response.text())
    .then(data => {
        for(let i = 0; i < desplegado; i++){
          document.getElementsByClassName('order-list')[0].remove()
        }
        $(`lineas${id}`).innerHTML = data
      })
  }
})