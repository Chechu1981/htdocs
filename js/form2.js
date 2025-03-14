const rutas = {
    update:'../api/updatePass.php',
    delete:'../api/deletePass.php',
    new:'../api/addPass.php'
  }

document.getElementsByTagName('form')[0].addEventListener('submit',(e) =>{
    const src = window.location.href.includes('idItem=') ? rutas['update'] : rutas['new']
    const idItem = window.location.href.includes('idItem=') ? document.location.search.split('=')[2] :''
    const id = window.location.href.includes('idItem=') ? document.location.search.split('=')[1].replace('&idItem','') : document.location.search.split('=')[1]
    e.preventDefault()
    e.stopImmediatePropagation()
    const data = new FormData()
    data.append('tipo',e.target.children[1].value)
    data.append('id',idItem)
    data.append('web', e.target.children[3].value)
    data.append('marca', e.target.children[5].value)
    data.append('placa', e.target.children[7].value)
    data.append('cuenta', e.target.children[9].value)
    data.append('usr', e.target.children[11].value)
    data.append('pswd', e.target.children[13].value)
    data.append('phone', e.target.children[15].value)
    data.append('private', e.target.children[17].children[1].checked)
    data.append('ssId', id)
    fetch(src,{
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(response =>{
        if(response == 'ok'){
            window.parent.location.reload()
        }else{
            alert('Ha habido un error'+e)
        }
    }).catch(functions => console.log("error: "+functions))
})