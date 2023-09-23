document.getElementsByTagName('form')[0].addEventListener('submit',(e) =>{
  const src = success[e.target.title]
  e.preventDefault()
  e.stopImmediatePropagation()
  const data = new FormData()
  if(e.target.children[11] != undefined)
    data.append('id',e.target.children[11].value)
  
  data.append('placa', e.target.children[1].value)
  data.append('ncliente', e.target.children[3].value)
  data.append('cif', e.target.children[5].value)
  data.append('rrdi', e.target.children[7].value)
  data.append('nombre', e.target.children[9].value)

  //check for empty inputs
  if(e.target.children[1].value+e.target.children[3].value+e.target.children[5].value+e.target.children[7].value == '')
    return null
  fetch(src,{
      method: 'POST',
      body: data
  })
  .then(res => res.text())
  .then(response =>{
      if(response == 'ok'){
        for(let i = 0; i < document.getElementsByTagName('script').length; i++){
          let item = document.getElementsByTagName('script')[i].src.split('/')[4]
          if(item == 'formSoc.js' || item == 'form.js'){
            document.getElementsByTagName('script')[i].remove()
          }
        }
      }
      e.target.parentNode.parentNode.remove()
      $('menu').classList.remove('filter')
      $('contacts').parentNode.classList.remove('filter')
      loadItems(e.target.children[3].value)
  })
})