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

const span = $('config-repere').getElementsByTagName('span')
for (let i = 0; i < span.length; i++) {
    span[i].addEventListener('click', (e) => {
        e.preventDefault()
        e.stopImmediatePropagation()
        const data = new FormData()
        data.append(`id`, e.target.dataset.id)

        fetch('../api/getRepereEdit.php',{
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(response =>{
            $('config-repere').innerHTML = response
        }).catch(functions => console.log(`error: ${functions}`))
    })
}