
// var startingRow = 
// Set the number of rows per page
var rowsPerPage = 25;
//get current table name
var tableName = document.getElementById("currentTable").value;

// Get the table element
var table = document.getElementById(tableName);


var tbody = table.querySelector('tbody'); // select the tbody element
var rows =  Array.from(tbody.querySelectorAll('tr:not([style*="display:none"])')); // select all tr elements within the tbody element and convert them to an array
//console.log(tableName);



//console.log(table);

// Get the number of rows in the table
var numRows = rows.length;

// Calculate the number of pages
var numPages = Math.ceil(numRows / rowsPerPage);
//alert(numPages);

document.getElementById('TotalNumPages').innerHTML = numPages;

//console.log("THIS IS num PAGE"+numPages);

// Set the current page to 1
var currentPage = 0;

function updateVariables(){
   // console.log("IN UPDATE");
    //get current table name
tableName = document.getElementById("currentTable").value;
//console.log(tableName);

// Get the table element
 table = document.getElementById(tableName);

//console.log(table);

// Get the number of rows in the table

 numRows = rows.length;

// Calculate the number of pages
 numPages = Math.ceil(numRows / rowsPerPage);
 //alert(numPages);
 if(numPages<=1){
  document.getElementById("nextOneBtn").style.visibility = "hidden";
  document.getElementById("nextTwoBtn").style.visibility  = "hidden";
  document.getElementById("nextButton").style.visibility  = "hidden";
  document.getElementById("lastPage").style.visibility  = "hidden";

  document.getElementById("prevOneBtn").style.visibility  = "hidden";
  document.getElementById("prevTwoBtn").style.visibility  = "hidden";
  document.getElementById("prevButton").style.visibility  = "hidden";
  document.getElementById("firstPage").style.visibility  = "hidden";
}else{
  document.getElementById("nextOneBtn").style.visibility  = "";
  document.getElementById("nextTwoBtn").style.visibility  = "";
  document.getElementById("nextButton").style.visibility  = "";
  document.getElementById("lastPage").style.visibility  = "";

  document.getElementById("prevOneBtn").style.visibility  = "";
  document.getElementById("prevTwoBtn").style.visibility  = "";
  document.getElementById("prevButton").style.visibility  = "";
  document.getElementById("firstPage").style.visibility  = "";
}

document.getElementById('TotalNumPages').innerHTML = numPages;

//console.log("THIS IS num PAGE"+numPages);

// Set the current page to 1
currentPage = 0;
}

// Add event listeners to the navigation buttons
function goBack() {
  // Go to the previous page
  currentPage--;
  document.getElementById('pageNum').value = currentPage+1;
  if (currentPage < 0) {
    //console.log('current page became negative :'+currentPage);
    currentPage = 0;
    return;
  }
  showPage(currentPage);

};

function goNext() {
  //console.log('this is the go next current page :'+currentPage);
  // Go to the next page
  currentPage++;
  document.getElementById('pageNum').value = currentPage+1;
  //console.log('go next after increasung :'+currentPage);
  if (currentPage > numPages-1) {
    currentPage = numPages-1;
   // console.log('current page exceeded the num page ');
    return;
  }
  showPage(currentPage);
 // document.getElementById('pageNum').value = currentPage+1;
};

// Function to show a specific page
function showPage(page) {
  updatePaginationButtons();

  var tbody = table.querySelector('tbody'); // select the tbody element
  //console.log(tbody);
  var rows = Array.from(tbody.querySelectorAll('tr:not(:empty)')); // select all tr elements within the tbody element and convert them to an array
  //console.log(rows);
  // Hide all the rows
  for (var i = 0; i < numRows; i++) {
    //console.log(numRows);
    //console.log(rows[i]);
    if(rows[i]!==undefined){
      rows[i].style.display = "none";
    }
  
  }

  // Show the appropriate rows for the current page
  //console.log(page);
  if(page == 0){
    upperbound = page+1;
  }else {
      upperbound = page+1;
  }
  for (var i = page * rowsPerPage; i < (upperbound) * rowsPerPage; i++){
    rows[i].style.display = "table-row";
  }
}

// Show the first page
showPage(0);

function updateRowPerPage(newRowPerPage){
   rowsPerPage = newRowPerPage;

  // Get the table element
  //var table = document.getElementById("list-table");

  // Get the number of rows in the table
   numRows = rows.length;
   //console.log('old number of rows :'+table.rows.length);

  // Calculate the number of pages
   numPages = Math.ceil(numRows / rowsPerPage);
   //console.log('onew number of pages :'+numPages);
   document.getElementById('TotalNumPages').innerHTML = numPages;
  // Set the current page to 1
   currentPage = 0;
   document.getElementById('pageNum').value = currentPage+1;
   showPage(0);


}
function updateCurrentPage()
{
    showPage(currentPage);
}



function goFirstPage() {
  currentPage = 0;
  document.getElementById('pageNum').value = currentPage+1;
  showPage(currentPage);
  
}

function goLastPage() {
  currentPage = numPages-1;
  document.getElementById('pageNum').value = currentPage+1;

  document.getElementById("nextOneBtn").innerText = currentPage+1;
  document.getElementById("nextTwoBtn").innerText = currentPage+1;
  document.getElementById("nextOneBtn").disabled = true;
  document.getElementById("nextTwoBtn").disabled = true;
  document.getElementById("prevOneBtn").innerText = currentPage;
    document.getElementById("prevTwoBtn").innerText = currentPage-1;
    document.getElementById("prevOneBtn").disabled = false;
    document.getElementById("prevTwoBtn").disabled = false;
    document.getElementById("nextButton").disabled = true;
    document.getElementById("nextOneBtn").style.display = "none";
    document.getElementById("prevOneBtn").style.display = "";
    document.getElementById("nextTwoBtn").style.display = "none";
    document.getElementById("prevTwoBtn").style.display = "";
    document.getElementById("prevButton").disabled = false;
    
  showPage(currentPage);
 
}



function goNextOne() {
  // Go to the next page
  currentPage++;
  document.getElementById('pageNum').value = currentPage+1;
  if (currentPage > numPages-1) {
    currentPage = numPages-1;
    return;
  }
  showPage(currentPage);
};

function goNextTwo() {
  // Go to the next page
  currentPage += 2;
  document.getElementById('pageNum').value = currentPage+1;
  if (currentPage > numPages-1) {
    currentPage = numPages-1;
    return;
  }
  showPage(currentPage);
};
function goPrevOne() {
  // Go to the previous page
  currentPage--;
  
  if (currentPage < 0) {
    currentPage = 0;
    return;
  }
  document.getElementById('pageNum').value = currentPage+1;
  showPage(currentPage);
 
};

function goPrevTwo() {
  // Go to the page two before the current page
  currentPage -= 2;
  if (currentPage < 0) {
    currentPage = 0;
    return;
  }
  document.getElementById('pageNum').value = currentPage+1;
  showPage(currentPage);

};
// Update the pagination buttons
function updatePaginationButtons() {
  var prevOneBtn = document.getElementById("prevOneBtn");
  var prevTwoBtn = document.getElementById("prevTwoBtn");
  var prevBtn = document.getElementById('prevButton');
  var nextBtn = document.getElementById('nextButton');
  var nextOneBtn = document.getElementById('nextOneBtn');
  var nextTwoBtn = document.getElementById('nextTwoBtn');
  
  
  document.getElementById('lastPage').innerText = numPages;
  
  // inner text for when current page = 0 or 1
  console.log(currentPage);
  if (currentPage == 0){
    document.getElementById("prevOneBtn").innerText = 1;
    document.getElementById("prevTwoBtn").innerText = 1;
  }
  else if (currentPage == 1)
  {
    document.getElementById("prevOneBtn").innerText = 1;
    document.getElementById("prevTwoBtn").innerText = 1;
  }
  else
  {
    document.getElementById("prevOneBtn").innerText = currentPage;
    document.getElementById("prevTwoBtn").innerText = currentPage-1;
  }



  if (currentPage == numPages-1) {
    console.log("this is last page");
    document.getElementById("nextOneBtn").innerText = currentPage;
    document.getElementById("nextTwoBtn").innerText = currentPage+1;
  
  } else if (currentPage == numPages-2) {
    document.getElementById("nextOneBtn").innerText = currentPage+2;
    document.getElementById("nextTwoBtn").innerText = currentPage+2;
 
  } else {
    document.getElementById("nextOneBtn").innerText = currentPage+2;
    document.getElementById("nextTwoBtn").innerText = currentPage+3;
 
  }


  if (currentPage == 0) {
    
    prevOneBtn.disabled = true;
    prevOneBtn.style.display = "none";
    prevTwoBtn.disabled = true;
    prevTwoBtn.style.display = "none";
    prevBtn.disabled = true;
    
  } else if (currentPage == 1) {
    prevOneBtn.disabled = false;
    prevOneBtn.style.display = "";
    prevTwoBtn.disabled = true;
    prevTwoBtn.style.display = "none";
    prevBtn.disabled = false;
  } else {
    
    prevOneBtn.disabled = false;
    prevTwoBtn.disabled = false;
    prevOneBtn.style.display = "";
    prevTwoBtn.style.display = "";
    prevBtn.disabled = false;
  }
  
  if (currentPage == numPages-1) {
    nextOneBtn.disabled = true;
    nextTwoBtn.disabled = true;
    nextOneBtn.style.display = "none";
    nextTwoBtn.style.display = "none";
    nextBtn.disabled =true;
   
  } else if (currentPage == numPages-2) {
    nextOneBtn.disabled = false;
    nextTwoBtn.disabled = true;
    nextOneBtn.style.display = "";
    nextTwoBtn.style.display = "none";
    nextBtn.disabled =false;
  } else {
    nextOneBtn.disabled = false;
    nextTwoBtn.disabled = false;
    nextOneBtn.style.display = "";
    nextTwoBtn.style.display = "";
    nextBtn.disabled =false;
  }
  
}