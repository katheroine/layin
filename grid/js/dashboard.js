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
