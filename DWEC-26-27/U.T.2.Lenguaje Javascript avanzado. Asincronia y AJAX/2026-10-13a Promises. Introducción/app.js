/* function devolverSiete(){
    if(true)
        return 7;
    else
        throw new Error('Hay un problema');
} */

/* Sintaxis antigua */

/* function devolverSiete() {
  const promesa = new Promise((resolve, reject) => {
    if (true) 
      resolve(7);
    else 
      reject("Hay un problema");
  });
  return promesa;
} */

/* Sintaxis moderna */
async function devolverSiete() {
  if (true) return 7;
  else throw new Error("Hay un problema");
}

/* console.clear();
const resultado = devolverSiete();
console.log(resultado);
console.log('FIN!!!'); */

/* console.clear();
devolverSiete()
    .then(resultado => console.log(resultado))
    .catch(ex => console.error(ex.message));

console.log('FIN!!!') */

try {
  console.clear();
  const resultado = await devolverSiete();
  console.log(resultado);
  console.log("FIN!!!");
} catch (e) {
  console.error(e.message);
}
