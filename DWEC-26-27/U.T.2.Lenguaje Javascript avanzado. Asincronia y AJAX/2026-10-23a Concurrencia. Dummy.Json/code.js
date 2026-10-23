const products = [1, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 33, 37];

const nTbody = document.getElementById('tTbdProducts');

/* for(const productId of products){
    const url = `https://dummyjson.com/${productId}/17?delay=1000`;
    const response = await fetch(url);
    const data  = await response.json;
    const product = data;

    const nTr = document.createElement('tr');
    nTbody.appendChild(nTr);

    const nTdId = document.createElement('td');
    nTr.appe

    const nTdName = document.createElement('td');
    nTr.appendsChild(nTdName);
    nTdName.textContent = product.title;

    const nTdPhoto = document.createElement('td');
    nTr.appendsChild(nTdPhoto);

    const nImage = document.createElement('img');
    nTdPhoto.appendChild(nTdPhoto);
    nImage.setAttribute('src', product.images[0]);
} */
/**
 * 
 * @param {number} productid 
 * @returns { Promise<Product>}
 */

/**Solucion 3. Concurrente Ordenada (Solucion a la que tenemos que buscar) */
async function getProductById(productid){
    const url = `https://dummyjson.com/products/${productid}?delay=1000`;
    const response = await fetch(url);
    const data  = await response.json();
    /** @type { Product } */
    return data;
}

const promises = products.map(productid => getProductById(productid));
const productsAux = await Promise.all(promises);

productsAux.forEach(async product => {

    const nTr = document.createElement('tr');
    nTbody.appendChild(nTr);

    const nTdId = document.createElement('td');
    nTr.appendChild(nTdId);
    nTdId.textContent = product.id;

    const nTdName = document.createElement('td');
    nTr.appendChild(nTdName);
    nTdName.textContent = product.title;

    const nTdPhoto = document.createElement('td');
    nTr.appendChild(nTdPhoto);

    const nImage = document.createElement('img');
    nTdPhoto.appendChild(nImage);
    nImage.setAttribute('src', product.images[0]);
});
    