'use strict';
$('filter').addEventListener('click', e =>{
  let vacio = e.target.title != '' ? e.target.title : null;
  if(vacio == null)
    return false
  const li = $('filter').getElementsByTagName('li')
  const cleanerFilter = (group) =>{
    for(let i = 0; i < li.length; i++){
      if(li[i].title.includes(group))
        li[i].classList.remove('active')
    }
  }
  let vol = "%%"
  let marca = "%%"
  let visco = "%%"
  if(e.target.title.includes('visco_'))
    cleanerFilter('visco_')
  if(e.target.title.includes('vol_'))
    cleanerFilter('vol_')
  if(e.target.title.includes('marca_'))
    cleanerFilter('marca_')
  e.target.classList.toggle('active')
  for(let i = 0; i < li.length; i++) {
    if(li[i].classList.value.includes('active') && li[i].title.includes('visco_')){
      visco = li[i].title.split('visco_')[1]
    }else if(li[i].classList.value.includes('active') && li[i].title.includes('vol_')){
      vol = li[i].title.split('vol_')[1]
    }else if(li[i].classList.value.includes('active') && li[i].title.includes('marca_')){   
      marca = li[i].title.split('marca_')[1]
    }
  }
  const data = new FormData()
  data. append('grado', visco)
  data. append('vol', vol)
  data. append('marca', marca)
  fetch('../api/getOilTable.php',{
    method: 'POST',
    body: data
  })
  .then(input => input.text())
  .then(rows => {
    $('oil_items').innerHTML = rows
    const ref = document.getElementsByClassName('ref')
    for (let i = 0; i < ref.length; i++) {
      ref[i].addEventListener('click',() =>{
        navigator.clipboard.writeText(ref[i].innerText)
        notify(ref[i].innerText)
      })
    }
  })
})