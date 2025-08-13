document.getElementsByTagName('form')[0].addEventListener('submit',(e) =>{
    const src = success[e.target.title]
    e.preventDefault()
    const data = new FormData()
    console.log(e.target.childNodes)
    data.append('id',e.target.children[23].value)
    data.append('centro', e.target.children[2].value)
    data.append('entidad', e.target.children[4].value)
    data.append('equipo', e.target.children[6].value)
    data.append('nombre', e.target.children[8].value)
    data.append('puesto', e.target.children[10].value)
    data.append('ext', e.target.children[12].value)
    data.append('nlargo', e.target.children[14].value)
    data.append('movil', e.target.children[16].value)
    data.append('ncorto', e.target.children[18].value)
    data.append('correo', e.target.children[20].value)
    data.append('boss', e.target.children[22].checked)
    fetch(src,{
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(response =>{
        if(response == 'ok'){
            window.parent.location.reload()
        }else{
            console.error('Ha habido un error'+e.target.innerHTML)
        }
    }).catch(functions => console.log("error: "+functions))
})

const success = {
    update:"../../api/updateContact.php",
    delete:"../../api/deleteContact.php",
    new:"../../api/addContact.php"
}