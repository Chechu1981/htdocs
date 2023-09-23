document.getElementsByTagName('form')[0].addEventListener('submit',(e) =>{
    e.preventDefault()
    e.stopImmediatePropagation()
    const data = new FormData()
    let arrayIndex = []
    for(let i = 0;i < e.target.childNodes.length - 8;i += 6){
        const repere = e.target.childNodes[i+1].value
        const referencia = e.target.childNodes[i+5].value
        if(repere != '' || referencia != ''){
            arrayIndex.push(repere, referencia)
        }
    }

    data.append(`index`, arrayIndex)

    fetch('../api/addRepere.php',{
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(response =>{
       if(response == 'ok'){
            alert("Añadidos los rperes con éxito")
            window.location.reload()
        }else{
            alert('Ha habido un error'+e)
        }
    }).catch(functions => console.log("error: "+functions))
})