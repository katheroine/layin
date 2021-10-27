const screenSizes = {
  s: 0,
  m: 640,
  l: 1024,
};

function handleDashboard() {
  let banner = document.getElementById("banner");
  let controls = document.getElementById("controls");
  let board = document.getElementById("board");
  let guideboard = document.getElementById("guideboard");

  let bannerPosition = banner.getBoundingClientRect();
  let bannerMarginBottom = getDefinedBannerMarginBottom();

  let offset = bannerPosition.bottom + bannerMarginBottom;
  let dashboardShouldBeFixed = offset < 0;

  if (dashboardShouldBeFixed) {
    controls.classList.add("detached");
    board.classList.add("detached");
    guideboard.classList.add("detached");
  } else {
    controls.classList.remove("detached");
    board.classList.remove("detached");
    guideboard.classList.remove("detached");
  }
}

function toggleGuideboard() {
  var controls = document.getElementById("controls");
  let guideboard = document.getElementById("guideboard");

  var guideboardDisplay = window.getComputedStyle(guideboard).display;

  if (guideboardDisplay != "block") {
    guideboard.classList.add("active");
  } else {
    guideboard.classList.remove("active");
  }
}

function toggleSubmenu(supermenuItem) {
  var submenu = supermenuItem.nextElementSibling;

  var submenuDisplay = window.getComputedStyle(submenu).display;

  if (submenuDisplay != "block") {
    foldAllSubmenus();

    supermenuItem.classList.add("active");
    submenu.classList.add("active");
  } else {
    supermenuItem.classList.remove("active");
    submenu.classList.remove("active");
  }
}

function foldAllSubmenus() {
  var menu = document.getElementById("guideboard");
  var menuItems = menu.getElementsByClassName("menu-button");
  var submenus = menu.getElementsByClassName("submenu");

  Array.from(menuItems).forEach(function(menuItem) {
    menuItem.classList.remove("active");
  });

  Array.from(submenus).forEach(function(submenu) {
    submenu.classList.remove("active");
  });
}

function getDefinedBannerMarginBottom() {
  let screenSize = getScreenSize();
  let bannerMarginBottom;

  function vwToPx(size) {
    return (size * window.innerWidth / 100);
  }

  switch(screenSize) {
    case screenSizes.s:
      bannerMarginBottom = vwToPx(18);
      break;
    case screenSizes.m:
      bannerMarginBottom = vwToPx(15);
      break;
    case screenSizes.l:
      bannerMarginBottom = 168;
      break;
  }

  return bannerMarginBottom;
}

function getScreenSize() {
  let size = screenSizes.s;

  if (window.innerWidth >= screenSizes.l) {
    size = screenSizes.l;
  } else if (window.innerWidth >= screenSizes.m) {
    size = screenSizes.m;
  }

  return size;
}
