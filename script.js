document.addEventListener("DOMContentLoaded", function (event) {
  let menu = document.querySelector("#menu-menu-principal");

  function resizedw() {
    if (window.innerWidth <= 960) {
      menu.style.height = "1px";
    } else {
      menu.style.height = "auto";
    }
  }

  function scrolldw() {
    if (window.innerWidth <= 960) {
      menu.style.height = "1px";
    }
  }

  let condition = !!document.querySelector(".page-id-134");
  if (condition) {
    menu.style.height = "1px";
    menu.style.overflow = "hidden";
    menu.insertAdjacentHTML('beforebegin', '<div id="toggle-menu" style="color:black;font-size:2rem;padding: 2px 15px; line-height:1.1;">&equiv;<span style="font-size:1.2rem;font-family:Arial, sans-serif;vertical-align:middle;padding-left:10px;">MENÚ</span></div>');

    // set menu height on loading
    resizedw();

    document.querySelector("#toggle-menu").addEventListener("click", function () {
      if (menu.style.height == "1px") {
        menu.style.height = "auto";
      } else {
        menu.style.height = "1px";
      }
    });
  }

  var doit;
  window.onresize = function () {
    clearTimeout(doit);
    doit = setTimeout(resizedw, 200);
  };

  var scrolled;
  window.onscroll = function () {
    clearTimeout(scrolled);
    scrolled = setTimeout(scrolldw, 200);
  }
});
