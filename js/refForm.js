try{
  const form = document.getElementsByTagName('form')
  form[1].addEventListener('submit',e =>{
    e.preventDefault()
    e.stopPropagation()
    const data = new FormData
    for(let i = 0; i < e.target.length; i++){
      const id = e.target[i].id
      const clave = e.target[i].value
      data.append(`id${i}`,id)
      data.append(`clave${i}`,clave)
    }
  
    fetch('../api/updateFrasesRef.php',{
      method: 'POST',
      body: data
    })
    .then(item => document.location.reload())
  })
}catch(e){
  console.log(e)
}