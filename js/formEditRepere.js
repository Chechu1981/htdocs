document.getElementsByTagName('form')[0].addEventListener('submit',(e) =>{
    e.preventDefault()
    e.stopImmediatePropagation()
    const data = new FormData()
    data.append(`search`, e.target.childNodes[1].value)

    fetch('../api/getRepere.php',{
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(response =>{
        $('search-repeere').innerHTML = response
    }).catch(functions => console.log("error: "+functions))
})