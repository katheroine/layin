function handleDashboard()
{
    let header = document.getElementsByTagName("header")[0];

    let detachmentObserver = new IntersectionObserver(handleDetachment);

    detachmentObserver.observe(header);

    function handleDetachment(elements)
    {
        let header = elements[0];
        let dashboard = document.getElementById("dashboard");
        let board = document.getElementById("board");

        if (header.intersectionRatio == 0 && (! dashboard.classList.contains("detached"))) {
            let dashboardHeight = dashboard.getBoundingClientRect().height;
            dashboard.classList.add("detached");
            board.style.paddingTop = dashboardHeight + "px";
        } else if ((header.intersectionRatio < 1) && dashboard.classList.contains("detached")) {
            dashboard.classList.remove("detached");
            board.style.paddingTop = "var(--horizontal-hem)";
        }
    }
}

function toggleNavigation()
{
    let navigation = document.getElementsByTagName("nav")[0];
    let navigationDisplay = window.getComputedStyle(navigation).display;

    if ((navigationDisplay != "block") && (navigationDisplay != "flex")) {
        handleScrollingUpForGuideboardVisibility();
        navigation.classList.add("active");
    } else {
        foldAllSubmenus();
        navigation.classList.remove("active");
    }

    adjustBodyToNavigation();
}

function foldNavigation()
{
    if (window.innerWidth >= 1024) {
        foldAllSubmenus();
    } else {
        hideNavigation();
    }

    function hideNavigation()
    {
        foldAllSubmenus();

        let navigation = document.getElementsByTagName("nav")[0];

        navigation.classList.remove("active");
    }
}

function toggleSubmenu(supermenuItem)
{
    let submenu = supermenuItem.nextElementSibling;
    let submenuDisplay = window.getComputedStyle(submenu).display;

    if (submenuDisplay != "block") {
        foldAllSubmenus();

        supermenuItem.classList.add("active");
        submenu.classList.add("active");

        adjustBodyToNavigation();
    } else {
        supermenuItem.classList.remove("active");
        submenu.classList.remove("active");
    }
}

function foldAllSubmenus()
{
    let guideboard = document.getElementById("guideboard");
    let menuItems = guideboard.getElementsByClassName("menu-button");
    let submenus = guideboard.getElementsByClassName("submenu");

    [menuItems, submenus].forEach(function (elements) {
        Array.from(elements).forEach(function (element) {
            element.classList.remove("active");
        });
    });
}

function undetachDashboard()
{
    let dashboard = document.getElementById("dashboard");

    dashboard.classList.remove("detached");
    board.style.paddingTop = "var(--controls-height)";
}

function handleScrollingUpForGuideboardVisibility()
{
    let screenHeight = getScreenHeight();
    let dashboard = document.getElementById("dashboard");

    if (! dashboard.classList.contains("detached")) {
        let threshold = screenHeight / 2;
        let controlsScreenVerticalShift = getControlsHeight()
        + getHeaderAreaHeight()
        - getScrollingOffset();

        if (controlsScreenVerticalShift > threshold) {
            window.scroll(0, screenHeight);
        }
    }

    function getScreenHeight()
    {
        return (window.innerHeight
        || document.documentElement.clientHeight
        || document.body.clientHeight);
    }

    function getScrollingOffset()
    {
        var offset = (window.pageYOffset || document.scrollTop) - (document.clientTop || 0);

        return (offset ? offset : 0);
    }
}

function adjustBodyToNavigation()
{
    let body = document.getElementsByTagName("body")[0];
    let bodyHeight = body.getBoundingClientRect().height;
    let navigation = document.getElementsByTagName("nav")[0];
    let navigationHeight = navigation.getBoundingClientRect().height;
    let remainingBodyHeight = bodyHeight - getHeaderAreaHeight() - getControlsHeight();

    if (remainingBodyHeight < navigationHeight) {
        let difference = navigationHeight - remainingBodyHeight;
        body.style.height = bodyHeight + difference + "px";
    }
}

function getControlsHeight()
{
    let controls = document.getElementById("controls");
    let controlsStyle = window.getComputedStyle(controls);

    return parseInt(controlsStyle.height);
}

function getHeaderAreaHeight()
{
    let header = document.getElementsByTagName("header")[0];
    let headerStyle = window.getComputedStyle(header);

    let headerHeight = parseInt(headerStyle.height);
    let headerBorderBottomSize = parseInt(headerStyle.borderBottom);
    let headerMarginBottom = parseInt(headerStyle.marginBottom);

    return (headerHeight + headerBorderBottomSize + headerMarginBottom);
}
