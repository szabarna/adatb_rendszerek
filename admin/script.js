// Get the modal
let modals = document.querySelectorAll('.modal');

console.log(modals)
// Get the button that opens the modal
let triggers = document.querySelectorAll('.table');

console.log(triggers)
// Get the <span> element that closes the modal
let spans = document.querySelectorAll('.close');

console.log(spans);

for(let i = 0; i < modals.length; i++) {
    triggers[i].addEventListener('click', (e) => {
        modals[i].style.display = "flex";
    });

    spans[i].addEventListener('click', (e) => {
        modals[i].style.display = "none";
    });

    window.addEventListener('click', (e) => {
        if (event.target == modals[i]) {
            modals[i].style.display = "none";
          }
    });
}



