function sortTable(colobj, order) {
    var col = colobj.parentNode.cellIndex;
    var currentTable = document.getElementById("currentTable").value;
    var table = document.getElementById(currentTable);
    var tbody = table.querySelector('tbody'); // select the tbody element
    var rows = Array.from(tbody.querySelectorAll('tr:not([style*="display:none"])')); // select all tr elements within the tbody element and convert them to an array
  
    function quickSort(rows, left, right) {
        if (left >= right) {
          return;
        }
        var pivotIndex = Math.floor((left + right) / 2);
        var pivot = rows[pivotIndex].getElementsByTagName("TD")[col].innerHTML.toLowerCase();
        var i = left;
        var j = right;
        var collator = new Intl.Collator(undefined, {numeric: true, sensitivity: 'base'});
        while (i <= j) {
          while (collator.compare(rows[i].getElementsByTagName("TD")[col].innerHTML.toLowerCase(), pivot) < 0) {
            i++;
          }
          while (collator.compare(rows[j].getElementsByTagName("TD")[col].innerHTML.toLowerCase(), pivot) > 0) {
            j--;
          }
          if (i <= j) {
            var temp = rows[i];
            rows[i] = rows[j];
            rows[j] = temp;
            i++;
            j--;
          }
        }
        quickSort(rows, left, j);
        quickSort(rows, i, right);
      }
      
      
  
    quickSort(rows, 0, rows.length - 1);
  
    if (order === "desc") {
      rows.reverse();
    }
  
    for (var i = 0; i < rows.length; i++) {
      tbody.appendChild(rows[i]);
    }
    updateCurrentPage();
  }
  