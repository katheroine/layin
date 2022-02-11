function handleDashboard() {
  let banner = document.getElementById("banner");
  let controls = document.getElementById("controls");
  let board = document.getElementById("board");
  let guideboard = document.getElementById("guideboard");

  let bannerPosition = banner.getBoundingClientRect();
  let bannerMarginBottom = getDefinedBannerMarginBottom();

  let bannerAreaOffset = bannerPosition.bottom + bannerMarginBottom;
  let dashboardShouldBeFixed = bannerAreaOffset < 0;

  let detachables = [
    controls,
    guideboard,
    board
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

  function getDefinedBannerMarginBottom() {
    let screenSize = getScreenSize();
    let bannerMarginBottom;

    let vwToPx = function (size) {
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

    function getScreenSize() {
      let size;

      if (window.innerWidth >= screenSizes.l) {
        size = screenSizes.l;
      } else if (window.innerWidth >= screenSizes.m) {
        size = screenSizes.m;
      } else {
        size = screenSizes.s
      }

      return size;
    }
  }
}

function toggleNavigation() {
  let navigation = document.getElementsByTagName("nav")[0];
  let navigationDisplay = window.getComputedStyle(navigation).display;

  if ((navigationDisplay != "block") && (navigationDisplay != "flex")) {
    handleScrollingControlsUp();

    navigation.classList.add("active");
  } else {
    foldAllSubmenus();
    navigation.classList.remove("active");
  }

  handleNavigationScrollability();

  function handleScrollingControlsUp() {
    let screenHeight = getScreenHeight();
    let controls = document.getElementById("controls");
    let controlsPosition = window.getComputedStyle(controls).position;

    if (controlsPosition != "fixed") {
      let threshold = screenHeight / 2;
      let controlsScreenVerticalShift = getControlsHeight()
        + getHeaderAreaHeight()
        - getScrollingOffset();

      if (controlsScreenVerticalShift > threshold) {
        window.scroll(0, screenHeight);
      }
    }

    function getScreenHeight() {
      return (window.innerHeight
        || document.documentElement.clientHeight
        || document.body.clientHeight);
    }

    function getHeaderAreaHeight() {
      let header = document.getElementsByTagName("header")[0];
      let headerStyle = window.getComputedStyle(header);

      let headerHeight = parseInt(headerStyle.height);
      let headerBorderBottomSize = parseInt(headerStyle.borderBottom);
      let headerMarginBottom = parseInt(headerStyle.marginBottom);

      return (headerHeight + headerBorderBottomSize + headerMarginBottom);
    }

    function getScrollingOffset() {
      var offset = (window.pageYOffset || document.scrollTop) - (document.clientTop || 0);

      return (offset ? offset : 0);
    }
  }
}

function foldNavigation() {
  if (screenIsWide()) {
    foldAllSubmenus();
  } else {
    hideNavigation();
  }

  function hideNavigation() {
    foldAllSubmenus();

    let navigation = document.getElementsByTagName("nav")[0];

    navigation.classList.remove("active");
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
  let guideboard = document.getElementById("guideboard");
  let menuItems = guideboard.getElementsByClassName("menu-button");
  let submenus = guideboard.getElementsByClassName("submenu");

  [menuItems, submenus].forEach(function (elements) {
    Array.from(elements).forEach(function(element) {
      element.classList.remove("active");
    });
  });
}

function handleNavigationScrollability()
{
  let nav = document.getElementsByTagName("nav")[0];

  if (screenIsWide()) {
    nav.style.maxHeight = "none";

    return;
  }

  let menuPosition = window.getComputedStyle(nav).position;
  let screenHeight = getScreenHeight();
  let controlsScreenVerticalShift;

  if (menuPosition == "fixed") {
    controlsScreenVerticalShift = getControlsHeight();
  } else {
    controlsScreenVerticalShift = getControlsHeight()
      + getHeaderAreaHeight()
      - getScrollingOffset();
  }

  let menuMaxHeight = screenHeight - controlsScreenVerticalShift;

  nav.style.maxHeight = menuMaxHeight + "px";

  function getScreenHeight() {
    return (window.innerHeight
      || document.documentElement.clientHeight
      || document.body.clientHeight);
  }

  function getHeaderAreaHeight() {
    let header = document.getElementsByTagName("header")[0];
    let headerStyle = window.getComputedStyle(header);

    let headerHeight = parseInt(headerStyle.height);
    let headerBorderBottomSize = parseInt(headerStyle.borderBottom);

    return (headerHeight + headerBorderBottomSize);
  }

  function getScrollingOffset() {
    let offset = (window.pageYOffset || document.scrollTop) - (document.clientTop || 0);

    return (offset ? offset : 0);
  }
}

function getControlsHeight() {
  let controls = document.getElementById("controls");
  let controlsStyle = window.getComputedStyle(controls);

  return parseInt(controlsStyle.height);
}

function screenIsWide() {
  if (window.innerWidth >= screenSizes.l) {
    return true;
  }

  return false;
}

const screenSizes = {
  s: 0,
  m: 640,
  l: 1024,
};
