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

    if (event.target.type === 'submit') {
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
    if (navCont.classList.contains('active')) {
        navCont.classList.remove('active');
        event.currentTarget.querySelector('.fa-bars').classList.add('-active');
        event.currentTarget.querySelector('.fa-x').classList.remove('-active');
        navBtn.setAttribute('aria-label', 'Ouvrir le menu');
    } else {
        navCont.classList.add('active');
        navBtn.setAttribute('aria-label', 'Fermer le menu');
        event.currentTarget.querySelector('.fa-bars').classList.remove('-active');
        event.currentTarget.querySelector('.fa-x').classList.add('-active');
    }
}

const getComputedStyles = (el) => {
    return window.getComputedStyle ? getComputedStyle(el, null) : el.currentStyle;
}

/************ DÉBUT BECMA SLIDER ************/

const becmaSliderHandler = (slidesToShow, slidesToScroll) => {
    const becmaSlider = document.querySelector('[becma-slider]');
    const slides = becmaSlider.innerHTML;
    const slidesCont = '<div class="becma-slides">' + slides + '</div>';
    becmaSlider.innerHTML = slidesCont;
    const becmaSlidesTrack = document.querySelector('.becma-slides');
    const becmaSliderSlides = Array.from(becmaSlidesTrack.children);
    const becmaSlidesToScroll = slidesToScroll ? slidesToScroll : becmaSlider.getAttribute('slides-to-scroll') ? becmaSlider.getAttribute('slides-to-scroll') : -1;
    const automaticWidth = becmaSlider.hasAttribute('automatic-width');
    let biggestSlideWidth = 0;

    becmaSliderSlides.forEach(slide => {
        slide.classList.add('becma-slide');
        slideStyles = getComputedStyles(slide);
        let slideWidth = slide.offsetWidth + parseInt(slideStyles.marginLeft) + parseInt(slideStyles.marginRight);

        if (slide.clientWidth > biggestSlideWidth) {
            biggestSlideWidth = slideWidth;
        }

        if ( becmaSliderSlides.indexOf(slide) > -1 && becmaSliderSlides.indexOf(slide)  <= (slidesToShow -1) ) {
            slide.classList.add('slide-active');
        }
    })

    const becmaSliderWidth = (biggestSlideWidth * slidesToShow);

    if (automaticWidth) {
        becmaSlidesTrack.style.width = becmaSliderWidth + 'px';
    }

    becmaSetArrows(becmaSlider, becmaSlidesToScroll, becmaSliderWidth);

    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            handleResponsive(becmaSlider)
        }, 200);
    });

}

const becmaSetArrows = (slider, slidesToScroll) => {
    let becmaLeftArrow = slider.querySelector('.becma-arrow-left-btn');
    let becmaRightArrow = slider.querySelector('.becma-arrow-right-btn');
    let leftArrowCont;
    let rightArrowCont;

    if (!becmaLeftArrow) {
        let leftArrowCont = document.createElement('div');
        let leftArrow = document.createElement('button')
        leftArrowCont.className = ('becma-arrow becma-arrow-left');
        leftArrow.classList.add('becma-arrow-left-btn');
        leftArrow.innerHTML = '<i class="fa-solid fa-angle-left aria-hidden="true"></i>'
        leftArrowCont.appendChild(leftArrow);
        slider.prepend(leftArrowCont);
        becmaLeftArrow = slider.querySelector('.becma-arrow-left-btn');
    }
  
    if (!becmaRightArrow) {
        let rightArrowCont = document.createElement('div');
        let rightArrow = document.createElement('button')
        rightArrowCont.className = ('becma-arrow becma-arrow-right');
        rightArrow.classList.add('becma-arrow-right-btn');
        rightArrow.innerHTML = '<i class="fa-solid fa-angle-right aria-hidden="true"></i>'
        rightArrowCont.appendChild(rightArrow);
        slider.append(rightArrowCont);
        becmaRightArrow = slider.querySelector('.becma-arrow-right-btn');
    }

    if (slidesToScroll > 0) {
        const becmaSlidesCont = slider.querySelector('.becma-slides');
        let activeSlides = [];
        let transformVal = 0;
        let transform;

        const becmaSliderArrows = slider.querySelectorAll('[class$="btn"]');
        handleArrowsVisibility(slider.querySelector('.becma-slides'), becmaLeftArrow, becmaRightArrow);

        becmaSliderArrows.forEach((btn) => {
            btn.addEventListener('click', () => {
                let btnClass = btn.classList;
                activeSlides = slider.querySelectorAll('.becma-slides .slide-active');

                if (btnClass.contains('becma-arrow-left-btn')) {
                    prevSlide = activeSlides[0].previousElementSibling;
                    prevSlideStyles = getComputedStyles(prevSlide);
                    prevSlideWidth = prevSlide.clientWidth + parseInt(prevSlideStyles.marginLeft) + parseInt(prevSlideStyles.marginRight);
                    transformVal += Math.abs(prevSlideWidth);
                    transform = "translateX(" + transformVal + "px)";
                    activeSlides[activeSlides.length -1].classList.remove('slide-active');
                    prevSlide.classList.add('slide-active');
                } else if (btnClass.contains('becma-arrow-right-btn')) {
                    activeSlides = slider.querySelectorAll('.becma-slides .slide-active');
                    nextSlide = activeSlides[(activeSlides.length - 1)].nextElementSibling;
                    nextSlideStyles = getComputedStyles(nextSlide);
                    nextSlideWidth = nextSlide.clientWidth + parseInt(nextSlideStyles.marginLeft) + parseInt(nextSlideStyles.marginRight);
                    transformVal -= Math.abs(nextSlideWidth);
                    transform = "translateX(" + transformVal + "px)";
                    activeSlides[0].classList.remove('slide-active');
                    nextSlide.classList.add('slide-active');
                }

                becmaSlidesCont.style.transform = transform;

                handleArrowsVisibility(becmaSlidesCont, becmaLeftArrow, becmaRightArrow);
            });
        });

            // TODO: Add slidetoscroll to slide-active class handling
    }
}

const handleArrowsVisibility = (becmaSlidesCont, becmaLeftArrow, becmaRightArrow) => {
    if (becmaSlidesCont.querySelectorAll('.slide-active')[0] === becmaSlidesCont.querySelectorAll('.becma-slide')[0]) {
        becmaLeftArrow.classList.add('arrow-disabled');
    } else {
        becmaLeftArrow.classList.remove('arrow-disabled');
    }

               
    if (document.querySelectorAll('.slide-active')[document.querySelectorAll('.slide-active').length -1] === becmaSlidesCont.querySelectorAll('.becma-slide')[becmaSlidesCont.querySelectorAll('.becma-slide').length -1]) {
        becmaRightArrow.classList.add('arrow-disabled');
    } else {
        becmaRightArrow.classList.remove('arrow-disabled');
    }
}

const handleResponsive = (slider) => {
    const breakpoints = slider.getAttribute('breakpoints').replaceAll("'", '"');
    const breakpointsObject = JSON.parse(breakpoints);
    const breakpointsObjectElements = Object.keys(breakpointsObject).sort((a, b) => parseFloat(a) - parseFloat(b));
    let slidesToShow;

    for (let breakpoint of breakpointsObjectElements) {

        if (breakpoint > window.innerWidth) {
            let slidesToShow = breakpointsObject[breakpoint]['slidesToShow'];

            killSlider(slider);
            becmaSliderHandler(slidesToShow);
            break;
        } else {
            slidesToShow = slider.getAttribute('slides-active') ? slider.getAttribute('slides-active') : -1;

            killSlider(slider);
            becmaSliderHandler(slidesToShow);
        }
    }
}

const killSlider = (slider) => {
    slides = slider.querySelector('.becma-slides').children;
    slidesArray = Array.from(slides);
    slider.querySelector('.becma-slides').remove();
    const arrows = slider.querySelectorAll('.becma-arrow');
    arrows.forEach((arrow) => {
        arrow.remove();
    })
    slidesArray.forEach((slide) => {
        slide.classList.remove('slide-active');
        slider.append(slide);
    })

}

/************ FIN BECMA SLIDER ************/

/************ DÉBUT FAQ ************/

const handleFAQ = () => {
    faqBtns = document.querySelectorAll('.faq .faq-block_question-btn');

    if (faqBtns) {
        faqBtns.forEach((faqBtn) => {

            faqBtn.addEventListener('click', () => {
                if (!faqBtn.classList.contains('active')) {
                    faqBtn.classList.add('active');
                } else {
                    faqBtn.classList.remove('active');
                }
            })

        })
    }
}

/************ FIN FAQ ************/

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

/************ DÉBUT FILTRES CAMPS ************/

let filtersActive = false;
let activeIds = [];
let activeAges = [];

const handleCampsFilters = (event) => {
    const campsFiltersSection = document.getElementById('campsFilters');
    
    campsFiltersSection.classList.toggle('active');

    if (campsFiltersSection.classList.contains('active')) {
        event.currentTarget.querySelector('h2').innerText = event.currentTarget.getAttribute('data-close-label');
    } else {
        event.currentTarget.querySelector('h2').innerText = event.currentTarget.getAttribute('data-open-label');
    }
}

const handleFilters = () => {
    const nouveauFilter = document.getElementById('nouveauCamp');
    const collaboFilter = document.getElementById('collaboCamp');
    const categoriesFilters = document.querySelectorAll('.filtres-camps-content-filters-categories input');
    const agesFilters = document.querySelectorAll('.filtres-camps-content-filters-ages input');

    nouveauFilter.addEventListener('change', filterCards);

    collaboFilter.addEventListener('change', filterCards);

    categoriesFilters.forEach((categoryFilter) => {
        categoryFilter.addEventListener('change', handleCategoriesFilter);
    })

    agesFilters.forEach((ageFilter) => {
        ageFilter.addEventListener('change', handleAgesFilter);
    })
}

const handleCategoriesFilter = (event) => {
    if (event.target.checked) {
        activeIds.push(event.target.value);
    } else {
        let idIndex = activeIds.indexOf(event.target.value);
        if (idIndex > -1) {
            activeIds.splice(idIndex, 1);
        }
    }

    filterCards();
}

const handleAgesFilter = (event) => {
    if (event.target.checked) {
        activeAges.push(event.target.value);
    } else {
        let ageIndex = activeAges.indexOf(event.target.value);
        if (ageIndex > -1) {
            activeAges.splice(ageIndex, 1)
        }
    }

    filterCards();
}

const filterCards = () => {
    const campCards = document.querySelectorAll('.carte-camp');
    const hasToBeNew = document.getElementById('nouveauCamp').checked;
    const hasCollabo = document.getElementById('collaboCamp').checked; 

    console.log(campCards);

    campCards.forEach((campCard) => {
        campCard.classList.add('hidden');
        let isNew = campCard.getAttribute('data-new') === "1";
        let isCollabo = campCard.getAttribute('data-collabo') !== null;
        console.log(isCollabo);

        const categories = campCard.getAttribute('data-categories').split(',');
        const ages = campCard.getAttribute('data-age').split(',');

        if (activeIds.length > 0 && activeAges.length <= 0) {
            console.log('juste categorie');
            categories.forEach((category) => {
                activeIds.forEach((activeId) => {
                    if (hasToBeNew) {
                        console.log('hasToBeNew');
                        if (category === activeId && isNew) {
                            campCard.classList.remove('hidden');
                        }
                    } else if (hasCollabo) {
                        if (category === activeId && isCollabo) {
                            campCard.classList.remove('hidden')
                        }
                    } else if (hasCollabo && hasToBeNew) {
                        if (category === activeId && isCollabo && isNew) {
                            campCard.classList.remove('hidden');
                        }
                    } else {
                        if (category === activeId) {
                            campCard.classList.remove('hidden');
                        }
                    }
                });
            })
        }

        if (activeAges.length > 0 && activeIds.length <= 0) {
            console.log('juste age');

            ages.forEach((age) => {
                activeAges.forEach((activeAge) => {
                    console.log(activeAge);
                    if (hasToBeNew) {
                        console.log('hasToBeNew');
                        if (age === activeAge && isNew) {
                            campCard.classList.remove('hidden');
                        }
                    } else if (hasCollabo) {
                        if (age === activeAge && isCollabo) {
                            campCard.classList.remove('hidden')
                        }
                    } else if (hasCollabo && hasToBeNew) {
                        if (age === activeAge && isCollabo && isNew) {
                            campCard.classList.remove('hidden');
                        }
                    } else {
                        if (age === activeAge) {
                            campCard.classList.remove('hidden');
                        }
                    }
                })
            })
        }

        if (activeIds.length > 0 && activeAges.length > 0) {
            console.log('les 2');

            categories.forEach((category) => {
                activeIds.forEach((activeId) => {
                    if (hasToBeNew) {
                        if (category === activeId && isNew) {
                            ages.forEach((age) => {
                                activeAges.forEach((activeAge) => {
                                    if (age === activeAge) {
                                        campCard.classList.remove('hidden');
                                    }
                                })
                            })
                        }
                    } else if (hasCollabo) {
                        if (category === activeId && isCollabo) {
                            ages.forEach((age) => {
                                activeAges.forEach((activeAge) => {
                                    if (age === activeAge) {
                                        campCard.classList.remove('hidden');
                                    }
                                })
                            })
                        }
                    } else if (hasCollabo && hasToBeNew) {
                        if (category === activeId && isCollabo && isNew) {
                            ages.forEach((age) => {
                                activeAges.forEach((activeAge) => {
                                    if (age === activeAge) {
                                        campCard.classList.remove('hidden');
                                    }
                                })
                            })
                        }
                    } else {
                        if (category === activeId) {
                            ages.forEach((age) => {
                                activeAges.forEach((activeAge) => {
                                    if (age === activeAge) {
                                        campCard.classList.remove('hidden');
                                    }
                                })
                            })
                        }
                    }
                });
            })

        }
    })

    if (activeIds.length <= 0 && activeAges.length <= 0 && !hasToBeNew && !hasCollabo) {
        campCards.forEach((campCard) => {
            campCard.classList.remove('hidden');
        })
    } else if (activeIds.length <= 0 && activeAges.length <= 0 && (hasToBeNew || hasCollabo)) {
        campCards.forEach((campCard) => {
            if (hasToBeNew && hasCollabo) {
                if (campCard.getAttribute('data-new') === "1" && campCard.getAttribute('data-collabo') !== null) {
                    campCard.classList.remove('hidden');
                }
            } else if (hasToBeNew) {
                if (campCard.getAttribute('data-new') === "1") {
                    campCard.classList.remove('hidden');
                }
            } else if (hasCollabo) {
                if (campCard.getAttribute('data-collabo') !== null) {
                    campCard.classList.remove('hidden');
                }
            }
        })
    }
}

const filterCampsSectionHandler = document.getElementById('campsFiltersHandler');

filterCampsSectionHandler.addEventListener('click', handleCampsFilters);


/************ FIN FILTRES CAMPS ************/

onload = event => {
    becmaSliderHandler();
    handleResponsive(document.querySelector('[becma-slider]'));
    handleFAQ();
    handleFilters();
};