document.getElementsByTagName('form')[0].addEventListener('submit',(e) =>{
    e.preventDefault()
    e.stopImmediatePropagation()
    const data = new FormData()
    data.append(`search`, e.target.childNodes[1].value)

    fetch('../api/getRepereEdit.php',{
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(response =>{
        $('config-repere').innerHTML = response
    }).catch(functions => console.log(`error: ${functions}`))
})

$('config-repere').addEventListener('click', (e) => {
    const search = $('search-repere').value
    const repere = e.target.parentNode.childNodes[1].value
    const referencia = e.target.parentNode.childNodes[3].value
    if(e.target.id.includes('edit')){
        const id = e.target.id.split('edit')[1]
        const data = new FormData()
        data.append(`id`, id)
        data.append(`repere`, repere)
        data.append(`ref`, referencia)
        data.append(`search`, search)

        fetch(`${src}api/updateRepere.php`,{
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(response =>{
            customAlert(response)
            fetch(`${src}api/getRepereEdit.php`,{
                method: 'POST',
                body: data})
            .then(response => response.text())
            .then(response => {
                $('config-repere').innerHTML = response
            })
        }).catch(functions => console.log(`error: ${functions}`))
    }else if(e.target.id.includes('delete')){
        const id = e.target.id.split('delete')[1]
        const data = new FormData()
        data.append(`id`, id)
        data.append(`search`, search)
        fetch(`${src}api/deleteRepere.php`,{
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(response =>{
            customAlert("El repere ha sido eliminado con éxito")
            fetch(`${src}api/getRepereEdit.php`,{
                method: 'POST',
                body: data})
            .then(response => response.text())
            .then(response => {
                $('config-repere').innerHTML = response
            })
        }).catch(functions => console.log(`error: ${functions}`))
    }
})
