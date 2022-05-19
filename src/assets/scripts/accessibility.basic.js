const maxFontSize = 22;
const minFontSize = 10;

function restoreAccessibility()
{
  restoreFontSize();
  restoreContrast();
}

function increaseFontSize() {
  updateFontSize(function (currentSize){
    if (currentSize < maxFontSize) {
      return currentSize + 1;
    }
  });
}

function decreaseFontSize() {
  updateFontSize(function (currentSize){
    if (currentSize > minFontSize) {
      return currentSize - 1;
    }
  });
}

function toggleContrast() {
  let body = document.getElementsByTagName('body')[0];
  body.classList.toggle("contrast");
  let contrast = (localStorage.getItem("contrast") === "true") ? "false" : "true";
  saveContrast(contrast);
}

function restoreFontSize()
{
  let size = localStorage.getItem("size");
  if (size) {
    let body = document.getElementsByTagName('body')[0];
    body.style.fontSize = size + 'px';
  }
}

function restoreContrast()
{
  let contrast = localStorage.getItem("contrast");
  let body = document.getElementsByTagName('body')[0];
  if (contrast === "true") {
    body.classList.add("contrast");
  } else {
    body.classList.remove("contrast");
  }
}

function updateFontSize(callback) {
  let body = document.getElementsByTagName('body')[0];
  let currentSize = getCurrentFontSize(body);
  let newSize = callback(currentSize);

  if (newSize) {
    body.style.fontSize = newSize + 'px';
    saveFontSize(newSize);
  }
}

function getCurrentFontSize(element) {
  let style = window.getComputedStyle(element, null).getPropertyValue('font-size');
  return parseFloat(style);
}

function saveContrast(contrast)
{
  localStorage.setItem("contrast", contrast);
}

function saveFontSize(size)
{
  localStorage.setItem("size", size);
}

function reset()
{
  localStorage.removeItem("size");
  localStorage.removeItem("contrast");
  location.reload();
}
