function handleDashboard() {
  let header = document.querySelector("header");

  let options = {
    threshold: 0.0
  };

  let observer = new IntersectionObserver(markDetached, options);

  observer.observe(header);

  function markDetached(elements) {
    let header = elements[0];
    let dashboard = document.getElementById("dashboard");

    if (header.intersectionRatio == 0) {
      dashboard.classList.add("detached");
    } else {
      dashboard.classList.remove("detached");
    }
  }
}

function toggleNavigation() {
  let navigation = document.getElementsByTagName("nav")[0];
  let navigationDisplay = window.getComputedStyle(navigation).display;

  if ((navigationDisplay != "block") && (navigationDisplay != "flex")) {
    // handleScrollingControlsUp();

    navigation.classList.add("active");
  } else {
    foldAllSubmenus();
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
