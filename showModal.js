const id = document.getElementsByClassName("id");

for (var i = 0; i < id.length; i++) {
  id[i].addEventListener(
    "click",

    (e) => {
      e.preventDefault();
      document.getElementById("Modal");
      document.getElementById("Modal").setAttribute("num", e.target.innerHTML);
    },

    false
  );
}
