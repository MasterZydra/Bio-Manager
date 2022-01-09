/*
* This function is neccessary to enable the filtering with an input box.
*
* @Author: David Hein
*/
function filterData(id)
{
    "use strict";
    var input, filter, table, tr, td, i, j, maxFilter, innerHTML;
    input = document.getElementById("filterInput-" + id);
    filter = input.value.toUpperCase();
    table = document.getElementById("dataTable-" + id);
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i += 1) {
        maxFilter = -1;
        for (j = 0; j < tr[i].getElementsByTagName("td").length; j += 1) {
            td = tr[i].getElementsByTagName("td")[j];
            if (td) {
                innerHTML = td.innerHTML.toUpperCase();
                if (innerHTML.trim().startsWith('<DIV CLASS="DROPDOWN"')) {
                    continue;
                }
                //maxFilter = Math.max(maxFilter, innerHTML.indexOf(filter));
                if (innerHTML.indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}