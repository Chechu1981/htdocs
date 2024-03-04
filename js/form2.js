const rutas = {
    update:'../api/updatePass.php',
    delete:'../api/deletePass.php',
    new:'../api/addPass.php'
  }

document.getElementsByTagName('form')[0].addEventListener('submit',(e) =>{
    const src = rutas[e.target.title]
    e.preventDefault()
    e.stopImmediatePropagation()
    const data = new FormData()
    data.append('tipo',e.target.children[1].value)
    data.append('id',e.target.children[16].value)
    data.append('web', e.target.children[3].value)
    data.append('marca', e.target.children[5].value)
    data.append('placa', e.target.children[7].value)
    data.append('cuenta', e.target.children[9].value)
    data.append('usr', e.target.children[11].value)
    data.append('pswd', e.target.children[13].value)
    data.append('phone', e.target.children[15].value)
    fetch(src,{
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(response =>{
        if(response == 'ok'){
            window.location.reload()
        }else{
            alert('Ha habido un error'+e)
        }
    }).catch(functions => console.log("error: "+functions))
})