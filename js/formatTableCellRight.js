function formatTableCellRight(tableName, colId) {
    var tableRef = document.getElementById(tableName);
    for(var i = 1; i < tableRef.rows.length; i++) {
        tableRef.rows[i].cells[colId].setAttribute("style", "text-align: right");
    }
}