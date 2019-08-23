/*
* This function is neccessary to enable the filtering with an input box.
*
* @Author: David Hein
*/
function filterData(id) {
    var input, filter, table, tr, td, i;
    input = document.getElementById("filterInput-" + id);
    filter = input.value.toUpperCase();
    table = document.getElementById("dataTable-" + id);
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        var maxFilter = -1;
        for(var j = 0; j < tr[i].getElementsByTagName("td").length; j++) {
            td = tr[i].getElementsByTagName("td")[j];
            if (td) {
                var innerHTML = td.innerHTML.toUpperCase();
                if(innerHTML.trim().startsWith('<DIV CLASS="DROPDOWN"')) continue;
                //maxFilter = Math.max(maxFilter, innerHTML.indexOf(filter));
                if(innerHTML.indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}