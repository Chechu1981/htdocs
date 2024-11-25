"use strict";

export default function updateCounterAssignment(){
  const googles = document.getElementsByClassName('round')
    let CesUser = googles[0]
    let CesNew = googles[1]
    let CesReady = googles[2]
    let CesAll = ''
  if(googles.length > 3){
    CesAll = googles[2]
    CesReady = googles[3]
  }
  const data = new FormData()
  data.append('id',window.location.search.split('?id=')[1])
  fetch('../../api/updateCounterAssig.php',{
    method: 'POST',
    body: data
  })
  .then(numbers => numbers.json())
  .then(itemsNumbers =>{
    CesNew.innerHTML = itemsNumbers.nuevas > 100 ? '+99' : itemsNumbers.nuevas
    CesReady.innerHTML = itemsNumbers.enCurso > 100 ? '+99' : itemsNumbers.enCurso
    if(googles.length > 3)
      CesAll.innerHTML = itemsNumbers.todas
  })
}