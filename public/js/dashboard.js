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

  let detachables = [
    controls,
    board,
    guideboard
  ];

  if (dashboardShouldBeFixed) {
    detachables.forEach(function(detachable) {
      detachable.classList.add("detached");
    });
  } else {
    detachables.forEach(function(detachable) {
      detachable.classList.remove("detached");
    });
  }

  handleNavigationScrollability();
}

function toggleNavigation() {
  let navigation = document.getElementsByTagName("nav")[0];
  let navigationDisplay = window.getComputedStyle(navigation).display;

  if ((navigationDisplay != "block") && (navigationDisplay != "flex")) {
    navigation.classList.add("active");
  } else {
    foldAllSubmenus();
    navigation.classList.remove("active");
  }

  handleNavigationScrollability();
}

function foldNavigation() {
  if (screenIsWide()) {
    foldAllSubmenus();
  } else {
    hideNavigation();
  }
}

function toggleSubmenu(supermenuItem) {
  let submenu = supermenuItem.nextElementSibling;
  let submenuDisplay = window.getComputedStyle(submenu).display;

  if (submenuDisplay != "block") {
    foldAllSubmenus();

    supermenuItem.classList.add("active");
    submenu.classList.add("active");
  } else {
    supermenuItem.classList.remove("active");
    submenu.classList.remove("active");
  }

  handleNavigationScrollability();
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

function hideNavigation() {
  foldAllSubmenus();

  let navigation = document.getElementsByTagName("nav")[0];

  navigation.classList.remove("active");
}

function handleNavigationScrollability()
{
  var nav = document.getElementsByTagName("nav")[0];

  if (!screenIsWide()) {
    var menuPosition = window.getComputedStyle(nav).position;
    var screenHeight = getScreenHeight();
    var controlsScreenVerticalShift;

    if (menuPosition == "fixed") {
      controlsScreenVerticalShift = getControlsHeight();
    } else {
      controlsScreenVerticalShift = getControlsHeight()
        + getHeaderAreaHeight()
        - getScrollingOffset();
    }

    var menuMaxHeight = screenHeight - controlsScreenVerticalShift;

    nav.style.maxHeight = menuMaxHeight + "px";
  } else {
    nav.style.maxHeight = "none";
  }
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

function getScreenHeight() {
  return (window.innerHeight
    || document.documentElement.clientHeight
    || document.body.clientHeight);
}

function getHeaderAreaHeight() {
  let header = document.getElementsByTagName("header")[0];
  let headerStyle = window.getComputedStyle(header);

  let headerHeight = parseInt(
    headerStyle.height
  );
  let headerBorderBottomSize = parseInt(
    headerStyle.borderBottom
  );

  return (headerHeight + headerBorderBottomSize);
}

function getScrollingOffset() {
  var offset = (window.pageYOffset || document.scrollTop) - (document.clientTop || 0);

  return (offset ? offset : 0);
}

function getControlsHeight() {
  var controls = document.getElementById("controls");
  var controlsStyle = window.getComputedStyle(controls);

  return parseInt(
    controlsStyle.height
  );
}

function screenIsWide() {
  if (window.innerWidth >= screenSizes.l) {
    return true;
  }

  return false;
}
