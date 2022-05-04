function handleDashboard() {
  let header = document.querySelector("header");

  let options = {
    threshold: 0.0
  };

  let observer = new IntersectionObserver(markDetached, options);

  observer.observe(header);

  function markDetached(elements) {
    let header = elements[0];

    if (header.intersectionRatio == 0) {
      dashboard.classList.add("detached");
    } else {
      dashboard.classList.remove("detached");
    }
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

  // handleNavigationScrollability();
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
