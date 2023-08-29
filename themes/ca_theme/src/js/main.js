const cityBtnsDesk = document.querySelectorAll('.site-list-content-filter button');
const cityBtnsMob = document.querySelector('.site-list-content-filter select');
const cityBtnsMobOptions = document.querySelector('.site-list-content-filter select option');
const siteCards = document.querySelectorAll('.site-card');

const controlArrow = () => {
    if (cityBtnsMob.classList.contains('active')) {
        cityBtnsMob.classList.remove('active');
    } else {
        cityBtnsMob.classList.add('active');
    }
}

const filterSites = (event) => {

    cityBtnsDesk.forEach ((btn) => {
        btn.classList.remove('active');
    });

    let chosenCity;
    console.log(event.target.type);

    if (event.target.type === 'submit') {
        console.log('button');
        chosenCity = event.target.getAttribute('data-city');
        event.target.classList.add('active');
    } else {
        chosenCity = event.target.value;
    }

    siteCards.forEach((siteCard) => {
        const siteCity = siteCard.getAttribute('data-city');

        if (siteCity === chosenCity || chosenCity === 'All') {
            siteCard.style.display = 'flex';
        } else {
            siteCard.style.display = 'none';
        }
    });


}

cityBtnsDesk.forEach((btn) => {
    btn.addEventListener('click', filterSites);
})

cityBtnsMob.addEventListener('change', (e) => {
    filterSites(e);
    controlArrow();
});

cityBtnsMob.addEventListener('click', controlArrow);