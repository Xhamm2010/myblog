const navItem = document.querySelector('.nav__items');
const openNavBtn = document.querySelector('#open__nav-btn');
const closeNavBtn = document.querySelector('#close__nav-btn');

//Open Nav dropdown
const openNav = () => {
    navItem.style.display = 'flex';
    openNavBtn.style.display = 'none';
    closeNavBtn.style.display = 'flex';
}

//Close Nav Dropdown
const closeNav = () => {
    navItem.style.display = 'none';
    closeNavBtn.style.display = 'none';
    openNavBtn.style.display = 'inline-block';
}

//EventListener to Menu Button
openNavBtn.addEventListener('click', openNav);
//EventListener to Close Button
closeNavBtn.addEventListener('click', closeNav);

// =======================================================================================================================

// ===========================SHOW SIDEBAR AND HIDE SIDEBAR FUNCTION ======================================
const sideBar = document.querySelector('aside');
const showSideBarBtn = document.querySelector('#show__sidebar-btn');
const hideSideBarBtn = document.querySelector('#hide__sidebar-btn');

//SHOW SIDE BAR
const showSideBar = () => {
    sideBar.style.left = '0';
    showSideBarBtn.style.display = 'none';
    hideSideBarBtn.style.display = 'inline-block';
}

//HIDE SIDE BAR
const hideSideBar = () => {
    sideBar.style.left = '-100%';
    showSideBarBtn.style.display = 'inline-block';
    hideSideBarBtn.style.display = 'none';
}

//EventListener to Show Side Bar
showSideBarBtn.addEventListener('click', showSideBar);
//EventListener to Hide Side Bar
hideSideBarBtn.addEventListener('click', hideSideBar);

