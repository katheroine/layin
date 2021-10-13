const screenSizes = {
  s: 0,
  m: 640,
  l: 1024,
};

function handleDashboard() {
  let banner = document.getElementById("banner");
  let controls = document.getElementById("controls");
  let main = document.getElementsByTagName("main")[0];

  let bannerPosition = banner.getBoundingClientRect();
  let bannerMarginBottom = getDefinedBannerMarginBottom();

  let offset = bannerPosition.bottom + bannerMarginBottom;
  let navigationShouldBeFixed = offset < 0;

  if (navigationShouldBeFixed) {
    controls.classList.add("detached");
    main.classList.add("detached");
  } else {
    controls.classList.remove("detached");
    main.classList.remove("detached");
  }
}

function getDefinedBannerMarginBottom() {
  let screenSize = getScreenSize();
  let bannerMarginBottom;

  function vwToPx(size) {
    return size * window.innerWidth / 100;
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
