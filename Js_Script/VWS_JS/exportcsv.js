
/*
function to export all particpant and all health measure
@param filename - name of the csv file that is exported
return-  exported csv file
*/
function exportTableToallCSV(filename) {
  var csv = [];
  var rows = document.querySelectorAll('table tr');
  
  for (var i = 0; i < rows.length; i++) {
    var row = [], cols = rows[i].querySelectorAll('td, th');
    
    for (var j = 0; j < cols.length; j++) {
      
      var cellText = cols[j].innerText;
              if (cols[j].querySelector('span[id^="asc"], span[id^="desc"]') !== null){ 
                cellText = cellText.slice(0,-2);}
          row.push(cellText);
    }
    
    csv.push(row.join(','));
  }

  // Download CSV file
  var csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
  
  if (window.navigator.msSaveOrOpenBlob) {
    window.navigator.msSaveOrOpenBlob(csvFile, filename);
  } else {
    var downloadLink = document.createElement('a');
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.download = filename;
    downloadLink.style.display = 'none';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
  }
}


/*
function that calls the function exportTableToCSV() to export the csv file of the selected option 
@param exportOption - type of csv file to export
*/

function exportCSV(exportOption) {
  var filename = '';
  if (exportOption === 'all') {
    filename = 'All Participant-All Health Measure.csv';
    exportTableToCSV(filename,'1'); // call function exportTableToCSV()
  } else if (exportOption === 'allParticipants-currentMeasure') {
    filename = 'All Participant-Current Health Measure.csv';
    exportTableToCSV(filename,'2'); // call function exportTableToCSV()
  } else if (exportOption === 'currentParticipants-currentMeasure') {
    filename = 'Current Participant-Current Health Measure.csv';
    exportTableToCSV(filename, '3'); // call function exportTableToCSV()
  }else if (exportOption === 'currentParticipants-All') {
    filename = 'Current Participant-All Measure.csv';
    exportTableToCSV(filename, '4'); // call function exportTableToCSV()
  }
}


/*
function that export the csv file of the selected option 
@param filename - type/name of csv file to export
@param exportAll - the selected option of the csv file
*/

function exportTableToCSV(filename, exportAll) {
  var csv = [];
 
   if(exportAll == "1") // All Particpant and All Health Measure
  {
    exportTableToallCSV(filename); // Call function exportTableToallCSV() 
  }
  else if(exportAll =="2") // All Participant and Current Measure
  {
   
    var rows = table.querySelectorAll('tr');
    var tables = document.querySelectorAll('table[name="table"]');
    tables.forEach(function(table) {
       // cheacking table where the diplay/ visiblity is shown
        if(table.style.display !== 'none'){
      var targetRows = rows;
       targetRows.forEach(row => {
    var rowData = [];
    var cells = row.querySelectorAll('td, th');
    
    cells.forEach(cell => {
        if(cell.style.display !=='none')
      {var cellText = cell.innerText;
        if (cell.querySelector('span[id^="asc"], span[id^="desc"]') !== null){ 
          cellText = cellText.slice(0,-2);}
    rowData.push(cellText);}
    });
    
    csv.push(rowData.join(','));
  });
  }});
    // Download CSV file
    var csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
  
    if (window.navigator.msSaveOrOpenBlob) {
      window.navigator.msSaveOrOpenBlob(csvFile, filename);
    } else {
      var downloadLink = document.createElement('a');
      downloadLink.href = window.URL.createObjectURL(csvFile);
      downloadLink.download = filename;
      downloadLink.style.display = 'none';
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    }
  }else if(exportAll =="3") // Current Participant and Current Measure
  {
    var tables = document.querySelectorAll('table[name="table"]');
    tables.forEach(function(table) {
        var rows = table.querySelectorAll('tr');
  // cheacking table where the diplay/ visiblity is shown
    if( table.style.display !== 'none'){
    var targetRows = Array.from(rows).filter(function(row) {
        return row.style.display !== 'none';
      });

      targetRows.forEach(function(row) {
        var rowData = [];
        var cells = row.querySelectorAll('td, th');
        
        cells.forEach(function(cell) {
            if(cell.style.display !== 'none')   // cheacking cell where the diplay/ visiblity is shown
            {
              var cellText = cell.innerText;
              if (cell.querySelector('span[id^="asc"], span[id^="desc"]') !== null){ 
                cellText = cellText.slice(0,-2);}
          rowData.push(cellText);}
        });
        
        csv.push(rowData.join(','));
      });
    } });

    // Download CSV file
    var csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
  
    if (window.navigator.msSaveOrOpenBlob) {
      window.navigator.msSaveOrOpenBlob(csvFile, filename);
    } else {
      var downloadLink = document.createElement('a');
      downloadLink.href = window.URL.createObjectURL(csvFile);
      downloadLink.download = filename;
      downloadLink.style.display = 'none';
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    }
  }
  else if(exportAll =="4") // Current Participant and All Health Measure
  {
    var tables = document.querySelectorAll('table[name="table"]');

  // Loop through each table
  tables.forEach(function(table,tablenumber) {
    var rows = table.querySelectorAll('tr');

    var targetRows = Array.from(rows).filter(function(row) {
        var cols = [];
        var column = row.querySelectorAll('td, th');
        column.forEach(function(col)
        {
            if(col.style.display !== 'none')
            {
                cols.push(col);
            }
        });
      return cols;
    });
    
    targetRows.forEach(function(row,index) {
      var rowData = [];
      // adding headers of the table to csv file
      if (index === 0 || index === 1 )
      {
        var cells = row.querySelectorAll('td, th');
      
      cells.forEach(function(cell) {
        var cellText = cell.innerText;
              if (cell.querySelector('span[id^="asc"], span[id^="desc"]') !== null){ 
                cellText = cellText.slice(0,-2);}
          rowData.push(cellText);
      });
      
      csv.push(rowData.join(','));
      }
      // adding headers of the table which has more than 2 rows of headers
      else if ((index === 0 || index === 1 || index === 2) && (tablenumber == 1 || tablenumber == 2 || tablenumber == 3))
      {
        var cells = row.querySelectorAll('td, th');
      
      cells.forEach(function(cell) {
        var cellText = cell.innerText;
              if (cell.querySelector('span[id^="asc"], span[id^="desc"]') !== null){ 
                cellText = cellText.slice(0,-2);}
          rowData.push(cellText);
      });
      
      csv.push(rowData.join(','));
      };
      // adding the searched participant to the csv file
      if (row.innerText.toUpperCase().includes(searchValue.toUpperCase())) {
      var cells = row.querySelectorAll('td, th');
      
      cells.forEach(function(cell) {
        var cellText = cell.innerText;
              if (cell.querySelector('span[id^="asc"], span[id^="desc"]') !== null){ 
                cellText = cellText.slice(0,-2);}
          rowData.push(cellText);
      });
      
      csv.push(rowData.join(','));
    }

    });
  });
  var csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
  
    if (window.navigator.msSaveOrOpenBlob) {
      window.navigator.msSaveOrOpenBlob(csvFile, filename);
    } else {
      var downloadLink = document.createElement('a');
      downloadLink.href = window.URL.createObjectURL(csvFile);
      downloadLink.download = filename;
      downloadLink.style.display = 'none';
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    }
}
  


}

