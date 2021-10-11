const screenSizes = {
  s: 0,
  m: 640,
  l: 1024,
};

function handleNavigation() {
  var banner = document.getElementById("banner");
  var controls = document.getElementById("controls");
  // var den = document.getElementById("den");
  // var menu = document.getElementById("menu");
  var main = document.getElementsByTagName("main")[0];

  var bannerPosition = banner.getBoundingClientRect();
  var bannerMarginBottom = getDefinedBannerMarginBottom();

  let offset = bannerPosition.bottom + bannerMarginBottom;
  console.log(offset);
  var navigationShouldBeFixed = offset < 0;

  if (navigationShouldBeFixed) {
    controls.classList.add("detached");
    // den.classList.add("detached");
    // menu.classList.add("detached");
    main.classList.add("detached");
  } else {
    controls.classList.remove("detached");
    // den.classList.remove("detached");
    // menu.classList.remove("detached");
    main.classList.remove("detached");
  }
}

function getDefinedBannerMarginBottom() {
  var screenSize = getScreenSize();

  var bannerMarginBottom;

  switch(screenSize) {
    case screenSizes.s:
      bannerMarginBottom = 19 * window.innerWidth / 100;
      break;
    case screenSizes.m:
      bannerMarginBottom = 16 * window.innerWidth / 100;
      break;
    case screenSizes.l:
      bannerMarginBottom = 168;
      break;
  }

  return bannerMarginBottom;
}

function getScreenSize() {
  var size = screenSizes.s;

  if (window.innerWidth >= screenSizes.l) {
    size = screenSizes.l;
  } else if (window.innerWidth >= screenSizes.m) {
    size = screenSizes.m;
  }

  return size;
}
