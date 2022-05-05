function handleDashboard() {
  let header = document.getElementById("header");

  let detachmentObserver = new IntersectionObserver(handleDetachment);

  detachmentObserver.observe(header);

  function handleDetachment(elements) {
    let header = elements[0];
    let dashboard = document.getElementById("dashboard");
    let board = document.getElementById("board");

    if (header.intersectionRatio == 0 && (! dashboard.classList.contains("detached"))) {
      let dashboardHeight = dashboard.getBoundingClientRect().height;
      dashboard.classList.add("detached");
      board.style.paddingTop = dashboardHeight + "px";
    } else if ((header.intersectionRatio < 1) && dashboard.classList.contains("detached")) {
      dashboard.classList.remove("detached");
      board.style.paddingTop = "42px";
    }
  }
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
