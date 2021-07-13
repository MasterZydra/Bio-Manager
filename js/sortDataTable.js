/*
* This function is neccessary to sort the entries in the table
* @Link to original soure code: https://www.w3schools.com/howto/howto_js_sort_table.asp
*
* @Author: David Hein
*/
function sortTable(elementId, columnIndex, invert = false) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(elementId);
    switching = true;
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
      //start by saying: no switching is done:
      switching = false;
      rows = table.rows;
      /*Loop through all table rows (except the
      first, which contains table headers):*/
      for (i = 1; i < (rows.length - 1); i++) {
        //start by saying there should be no switching:
        shouldSwitch = false;
        /*Get the two elements you want to compare,
        one from current row and one from the next:*/
        x = rows[i].getElementsByTagName("TD")[columnIndex];
        y = rows[i + 1].getElementsByTagName("TD")[columnIndex];
        //check if the two rows should switch place:
        if (!invert && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase() ||
            invert && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
      if (shouldSwitch) {
        /*If a switch has been marked, make the switch
        and mark that a switch has been done:*/
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
      }
    }
  }