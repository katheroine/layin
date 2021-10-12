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

function handleHistory() {
  reloadHistoryButtons();
}

function saveHistory() {
  let currentUrl = window.location.href;
  localStorage.setItem('history-next', currentUrl);
}

function reloadHistoryButtons() {
  let controls = document.getElementById("controls");
  let goBack = controls.getElementsByClassName("go-back")[0];
  let goForward = controls.getElementsByClassName("go-forward")[0];

  if (localStorage.getItem('history-previous')) {
    goBack.classList.add("active");
  } else {
    goBack.classList.remove("active");
  }
  if (localStorage.getItem('history-next')) {
    goForward.classList.add("active");
  } else {
    goForward.classList.remove("active");
  }
}

function goBack() {
  let currentUrl = window.location.href;
  localStorage.removeItem('history-previous');
  localStorage.setItem('history-next', currentUrl);
  window.history.back();
  resetHistoryButtons();
}

function goForward() {
  let currentUrl = window.location.href;
  localStorage.removeItem('history-next');
  localStorage.setItem('history-previous', currentUrl);
  window.history.forward();
  resetHistoryButtons();
}

function getDefinedBannerMarginBottom() {
  let screenSize = getScreenSize();
  let bannerMarginBottom;

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
  let size = screenSizes.s;

  if (window.innerWidth >= screenSizes.l) {
    size = screenSizes.l;
  } else if (window.innerWidth >= screenSizes.m) {
    size = screenSizes.m;
  }

  return size;
}
