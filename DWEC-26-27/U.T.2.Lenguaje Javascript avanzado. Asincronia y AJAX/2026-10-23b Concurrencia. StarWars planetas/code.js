

const nTmain = document.getElementById('tMainPLanets');

async function getPlanetsById(planetsid){
    const url = `https://swapi.dev/api/planets`;
    const response = await fetch(url);
    const data  = await response.json();

    const planets = data.results.map(planet => ({
        name: planet.name,
        url: planet.url,

    }));

    return planets;
}

function renderPlanets(planets){
    const nSection = document.getElementById('tSctPlanets');

    planets.forEach(planet => {
        const nRadio = nSection.appendChild(document.createElement('input'));
        nRadio.setAttribute('type', 'radio');
        nRadio.setAttribute('name', 'planet');
        nRadio.setAttribute('id', 'tRad' + planet.name.substring(0,4));
        nRadio.setAttribute('value', planet.url);

        nRadio.addEventListener('change', showResidents);

        const nLabel = nSection.appendChild(document.createElement('label'));
        nLabel.setAttribute('for', 'tRad' + planet.name.substring(0,3));
        nLabel.textContent = planet.name

    })
    
}