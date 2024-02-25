document.getElementsByTagName('section')[1].addEventListener('click',e =>{
  if(e.target.nodeName.toLowerCase() == 'button'){
    const data = new FormData()
    data.append('placa', e.target.value)
    fetch('../api/getInmStatus.php',{
      method: 'POST',
      body: data
    })
    .then(inm => inm.text())
    .then(status => {
      document.getElementsByTagName('section')[2].innerHTML = status
      const btnEliminar = document.getElementsByClassName('erase')
      for (let i = 0; i < btnEliminar.length; i++) {
        btnEliminar[i].addEventListener('click', (e) =>{
          const eliminar = confirm(`Vas ha eliminar este registro ¿Estás seguro?`)
          if(!eliminar)
            return true;
          const caldate = e.target.parentNode.childNodes[9].textContent.split('-')
          const calculo = `${caldate[2].split(' ')[0]}/${caldate[1]}/${caldate[0]} ${caldate[2].split(' ')[1]}`
          const datos = new FormData()
          datos.append('id',e.target.id)
          datos.append('calculo',calculo)
          fetch('./../api/deleteSelectInmov.php',{
            method: 'POST',
            body : datos
          })
          .then(() =>{e.target.parentNode.remove()})
        })
      }
      const lista = document.getElementsByClassName('downItems')
      for(let i = 0; i < lista.length; i++) {
        lista[i].addEventListener('click',(e)=>{
          window.open(`../api/getRefDown.php?date=${e.target.title}`,"Referencias que bajan","menubar=no, scrollbars=no, width=1000, height=900")
        })
      }
    })
  }
})

$('btnSbmt').addEventListener('click', () =>{
  window.open(`../api/getRefDownByRef.php?ref=${$('searchRef').value}&cliente=${$('searchClient').value}`,"Referencias que bajan","menubar=no, scrollbars=no, width=1000, height=900")
})