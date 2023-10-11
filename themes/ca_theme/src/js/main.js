const cityBtnsDesk = document.querySelectorAll('.site-list-content-filter button');
const cityBtnsMob = document.querySelector('.site-list-content-filter select');
const cityBtnsMobOptions = document.querySelector('.site-list-content-filter select option');
const siteCards = document.querySelectorAll('.site-card');
const navBtn = document.querySelector('.nav-btn');
const navCont = document.querySelector('.menu-header-container');

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

const openCloseMenu = (event) => {
    console.log(event.currentTarget);
    console.log(navBtn.lastChild);
    console.log(navBtn);
    if (navCont.classList.contains('active')) {
        console.log('nav was active');
        navCont.classList.remove('active');
        event.currentTarget.querySelector('.fa-bars').classList.add('-active');
        event.currentTarget.querySelector('.fa-x').classList.remove('-active');
        navBtn.setAttribute('aria-label', 'Ouvrir le menu');
    } else {
        navCont.classList.add('active');
        console.log('nav wasnt active');
        navBtn.setAttribute('aria-label', 'Fermer le menu');
        event.currentTarget.querySelector('.fa-bars').classList.remove('-active');
        event.currentTarget.querySelector('.fa-x').classList.add('-active');
    }
}

const becmaSliderHandler = () => {
    const becmaSlider = document.querySelector('[becma-slider]');
    const slides = becmaSlider.innerHTML;
    const slidesCont = '<div class="becma-slides">' + slides + '</div>';
    becmaSlider.innerHTML = slidesCont;
    const becmaSlidesTrack = document.querySelector('.becma-slides');
    const becmaSliderSlides = Array.from(becmaSlidesTrack.children);
    console.log(becmaSliderSlides);
    const slidesToShow = becmaSlider.getAttribute('slides-active');
    const slidesToScroll = becmaSlider.getAttribute('slides-to-scroll');
    const automaticWidth = becmaSlider.hasAttribute('automatic-width');
    console.log(automaticWidth);
    let biggestSlideWidth = 0;

    if (!slidesToShow) {
        slidesToShow = -1;
    }

    if (!slidesToScroll) {
        slidesActive = -1;
    }

    console.log(slidesToShow);

    becmaSliderSlides.forEach(slide => {
        console.log(slide);
        slide.classList.add('becma-slide');
        console.log(slide.clientWidth);

        if (slide.clientWidth > biggestSlideWidth) {
            biggestSlideWidth = slide.clientWidth;
        }

        console.log(becmaSliderSlides.indexOf(slide));

        if ( becmaSliderSlides.indexOf(slide) > -1 && becmaSliderSlides.indexOf(slide)  <= (slidesToScroll -1) ) {
            slide.classList.add('slide-active');
        }
    })

    const becmaSliderWidth = (biggestSlideWidth * slidesToShow + 200);

    if (automaticWidth) {
        becmaSlidesTrack.style.width = becmaSliderWidth + 'px';
    }

    becmaSetArrows(becmaSlider, slidesToScroll, becmaSliderWidth);
}

const becmaSetArrows = (slider, slidesToScroll, sliderWidth) => {
    const becmaLeftArrow = slider.querySelector('.becma-arrow-left-btn');
    const becmaRightArrow = slider.querySelector('.becma-arrow-right-btn');

    if (!becmaLeftArrow) {
        let leftArrowCont = document.createElement('div');
        let leftArrow = document.createElement('button')
        leftArrowCont.classList.add('becma-arrow-left');
        leftArrow.classList.add('becma-arrow-left-btn');
        leftArrow.innerHTML = '<i class="fa-solid fa-angle-left aria-hidden="true"></i>'
        leftArrowCont.appendChild(leftArrow);
        slider.prepend(leftArrowCont);
    }
  
    if (!becmaRightArrow) {
        let rightArrowCont = document.createElement('div');
        let rightArrow = document.createElement('button')
        rightArrowCont.classList.add('becma-arrow-right');
        rightArrow.classList.add('becma-arrow-right-btn');
        rightArrow.innerHTML = '<i class="fa-solid fa-angle-right aria-hidden="true"></i>'
        rightArrowCont.appendChild(rightArrow);
        slider.append(rightArrowCont);
    }

    if (slidesToScroll > 0) {
        becmaLeftArrow.addEventListener('click', () => {
            slider.style.translateX(-Math.abs(becmaSliderWidth));
        })

        becmaRightArrow.addEventListener('click', () => {
            slider.style.translateX(Math.abs(becmaSliderWidth));
        })
    }
}

navBtn.addEventListener('click', (event) => {
    openCloseMenu(event);
})

cityBtnsDesk.forEach((btn) => {
    btn.addEventListener('click', filterSites);
})

navBtn.addEventListener('click', () => {
    openCloseMenu();
})

/* cityBtnsMob.addEventListener('change', (e) => {
    filterSites(e);
    controlArrow();
}); */

/* cityBtnsMob.addEventListener('click', controlArrow);
 */
onload = event => {
    becmaSliderHandler();
};