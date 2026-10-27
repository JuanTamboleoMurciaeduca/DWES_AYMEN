
/* const categories = [
    {id: 'patos', name: 'Patos'},
    {id: 'gatos', name: 'Gatos'},
    {id: 'perros', name: 'Perros'},
]; */

import DummyRestService from "./dummy-rest-service.js";

await setup();

async function setup() {
    const service = new DummyRestService();
    const categories = await service.getCategories;
    renderTableCategories(categories);
}

renderTableCategories(categories);

function renderTableCategories(categories){
    const nTbody = document.querySelector('#tTabCategories>tbody');
/*     nTbody.addEventListener('click', e => console.log('<tbody>'));
    document.body.addEventListener('click', e => console.log('<body>')); */
    
    categories.forEach(({id, name}) => {
        const nTr = nTbody.appendChild(document.createElement('tr'));
       /*  nTr.setAttribute('data-category', id); */
        nTr.dataset.categoryId = id;
        nTr.addEventListener('click', categoryClickedHandler);
        /**handler - manejador */

        const nTdName = nTr.appendChild(document.createElement('td'));
        nTdName.textContent = name;

        const nTdPhoto = nTr.appendChild(document.createElement('td'));
        nTdPhoto.textContent = 'FOTO';
    });
}
async function categoryClickedHandler(e){
/*     const nTd = e.target;
    const categoryId = nTd.getAttribute('data-category'); */
    const categoryId = e.target.dataset.category;

    console.log(categoryId);

    const service = new DummyRestService();
    const products = await service.getProductsByCategory(categoryId);

    renderTableCategories();
}


function renderTableProducts(products){
    const nTbody = document.querySelector('#tTabProducts>tbody');
    nTbody.innerHTML = '';


    products.forEach(({id, name}) => {
        const nTr = nTbody.appendChild(document.createElement('tr'));

        const nTdName = nTr.appendChild(document.createElement('td'));
        nTdName.textContent = name;

        const nTdPrice = nTr.appendChild(document.createElement('td'));
        nTdPrice.textContent = price;

        const nTdPhoto = nTr.appendChild(document.createElement('td'));
        const nImg = nTdPhoto.appendChild(document.createElement('img'));
        nImg.src = image;
    });
}