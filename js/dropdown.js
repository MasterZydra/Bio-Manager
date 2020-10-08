/*
* This logic is used to enable the dropdown buttons.
*
* @Author: David Hein
*/

/* When the user clicks on the button,
 toggle between hiding and showing the dropdown content */
function openDropdown(id) {
    "use strict";
    document.getElementById("dropdown-" + id).classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    "use strict";
    if (!event.target.matches('.dropbtn')) {
        var i, openDropdown, dropdowns = document.getElementsByClassName("dropdown-content");
        for (i = 0; i < dropdowns.length; i += 1) {
            openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
};