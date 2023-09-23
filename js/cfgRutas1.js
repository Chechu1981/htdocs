document.getElementsByClassName('config-routes')[0].addEventListener('click', (e) => {
  if(e.target.tagName == 'IMG'){
    const data = new FormData()
    data.append('id', e.target.parentNode.id)
    data.append('corte', e.target.parentNode.parentNode.children[2].firstChild.value)
    data.append('salida', e.target.parentNode.parentNode.children[3].firstChild.value)
    fetch('../api/updateRoute.php',{
      method: 'POST',
      body: data
    })
    .then(r => r.text)
    .then(s => {
      notify(`!GUARDADO - ${e.target.parentNode.parentNode.children[1].firstChild.data}!`)
      e.target.parentNode.parentNode.children[2].firstChild.style.backgroundColor = '#ffd3788a'
      e.target.parentNode.parentNode.children[3].firstChild.style.backgroundColor = '#ffd3788a'
    })
  }
})