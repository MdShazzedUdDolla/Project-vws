function col(box,rows,colIndex){

  //console.log("this is rows "+rows+"this is colIndex"+colIndex);
  if(box.checked)
  {
    if(rows==1)
    {
      unhideColumn(rows,colIndex);
    }
      else if(rows==2)
    {
    unhideColumn(rows,2);
    unhideColumn(rows,3);
    }
    else if(rows==3)
    {
    unhideColumn(rows,4);
    unhideColumn(rows,5);
    }
    else if(rows==4)
    {
    unhideColumn(rows,6);
    unhideColumn(rows,7);
    }
    else if(rows==5)
    {
    unhideColumn(rows,8);
    unhideColumn(rows,9);
    } 
    else if(rows==6)
    {
      unhideColumn(rows,colIndex);
    }
  }
  else
  {
    if(rows==1)
    {
      hideColumn(rows,colIndex);
    }
      else if(rows==2)
    {
    hideColumn(rows,2);
    hideColumn(rows,3);
    }
    else if(rows==3)
    {
    hideColumn(rows,4);
    hideColumn(rows,5);
    }
    else if(rows==4)
    {
    hideColumn(rows,6);
    hideColumn(rows,7);
    }
    else if(rows==5)
    {
    hideColumn(rows,8);
    hideColumn(rows,9);
    
    }
    else if(rows==6)
    {
      hideColumn(rows,colIndex);
    }
  }
  
}

function hideColumn(rows,colIndex) {
  var currentTable = document.getElementById("currentTable").value;
  var table = document.getElementById(currentTable);

  var tbody = table.querySelector('tbody'); // select the tbody element
  var rowsArr = Array.from(tbody.querySelectorAll('tr')); // select all tr elements within the tbody element and convert them to an array
  var thead = table.querySelector('thead'); // select the tbody element
  var headerRowArr = Array.from(thead.querySelectorAll('th')); // se
  var displayOpttion = document.getElementById("option2").checked;
  switch(currentTable){
    case 'table1':
    //console.log("Table1 rows"+rows+", "+colIndex);
    //console.log(headerRowArr);
    if(displayOpttion){
      headerRowArr[colIndex].style.display="none";
    }else{
      headerRowArr[colIndex+1].style.display="none";
    }
  

    break;
    case 'table5':
      //console.log("Table1 rows"+rows+", "+colIndex);
      //console.log(headerRowArr);
      if(displayOpttion){
        headerRowArr[colIndex].style.display="none";
      }else{
        headerRowArr[colIndex+1].style.display="none";
      }
      break;
    case 'table2':
    //console.log("Table2, rows"+rows);
   
    if(rows==2){
      
      var i1 = searchTagIndex(headerRowArr,"Back Scratch Test (distance in +/ - cm)" );
      hideUnhindeHeader(headerRowArr,[i1,i1+5,i1+4], "none");
    }
    if(rows==3){
      var i1 = searchTagIndex(headerRowArr,"Grip Strength (kg)" );
      hideUnhindeHeader(headerRowArr,[i1,i1+6,i1+5], "none");
    }
    if(rows==4){
   
      var i1 = searchTagIndex(headerRowArr,"Plank Test" );
      hideUnhindeHeader(headerRowArr,[i1,i1+6,i1+7], "none");
    }
    if(rows==5){
      var i1 = searchTagIndex(headerRowArr,"Half Kneeling Dorsiflexion Ankle Test" );
      hideUnhindeHeader(headerRowArr,[i1,i1+7,i1+8], "none");
    }
    
    break;   
    case 'table3':
    //console.log("Table3 rows"+rows);
    if(rows==2){
      var i1 = searchTagIndex(headerRowArr,"Tandem" );
      hideUnhindeHeader(headerRowArr,[i1,i1+5,i1+4], "none");
    }
    if(rows==3){
      var i1 = searchTagIndex(headerRowArr,"Single leg(Left)" );
      hideUnhindeHeader(headerRowArr,[i1,i1+6,i1+5], "none");
    }
    if(rows==4){
      var i1 = searchTagIndex(headerRowArr,"Single leg(right)" );
      hideUnhindeHeader(headerRowArr,[i1,i1+6,i1+7], "none");
    }
    if(rows==5){
     
      var i1 = searchTagIndex(headerRowArr,"Total time" );
      hideUnhindeHeader(headerRowArr,[i1,i1+8,i1+7], "none");
    }
    break;
    case 'table4':
    //console.log("Table4 rows"+rows);
    if(displayOpttion){
      headerRowArr[colIndex+1].style.display="none";
    }else{
      headerRowArr[colIndex+2].style.display="none";
    }
    //hideUnhindeHeader(headerRowArr,[colIndex+2], "none");
    break; 
  }
  for (i=0; i < headerRowArr.length; i++) {

    var row = headerRowArr[i];
    //console.log(row);

    
  }

  for (i=0; i < rowsArr.length; i++) {

    var row = rowsArr[i];
    if(displayOpttion){
      var cell = row.cells[colIndex-1];
    }else{
      var cell = row.cells[colIndex];
    }
   
    //console.log(cell);
    cell.style.display = "none";
    
  }
}


function unhideColumn(rows,colIndex) {
  var currentTable = document.getElementById("currentTable").value;
  var table = document.getElementById(currentTable);
  var tbody = table.querySelector('tbody'); // select the tbody element
  var rowsArr = Array.from(tbody.querySelectorAll('tr')); // select all tr elements within the tbody element and convert them to an array
  var thead = table.querySelector('thead'); // select the tbody element
  var headerRowArr = Array.from(thead.querySelectorAll('th')); // se
  var displayOpttion = document.getElementById("option2").checked;

  switch(currentTable){
    case 'table1':
    //console.log("Table1 rows"+rows+", "+colIndex);
    //console.log(headerRowArr);
    if(displayOpttion){
      headerRowArr[colIndex].style.display="";
    }else{
      headerRowArr[colIndex+1].style.display="";
    }
    

    break;
    case 'table5':
    //console.log("Table1 rows"+rows+", "+colIndex);
    //console.log(headerRowArr);
    if(displayOpttion){
      headerRowArr[colIndex].style.display="";
    }else{
      headerRowArr[colIndex+1].style.display="";
    }
    

    break;
    case 'table2':
    //console.log("Table2, rows"+rows);
   
    if(rows==2){
      
      var i1 = searchTagIndex(headerRowArr,"Back Scratch Test (distance in +/ - cm)" );
      hideUnhindeHeader(headerRowArr,[i1,i1+5,i1+4], "");
    }
    if(rows==3){
      var i1 = searchTagIndex(headerRowArr,"Grip Strength (kg)" );
      hideUnhindeHeader(headerRowArr,[i1,i1+6,i1+5], "");
    }
    if(rows==4){
   
      var i1 = searchTagIndex(headerRowArr,"Plank Test" );
      hideUnhindeHeader(headerRowArr,[i1,i1+6,i1+7], "");
    }
    if(rows==5){
      var i1 = searchTagIndex(headerRowArr,"Half Kneeling Dorsiflexion Ankle Test" );
      hideUnhindeHeader(headerRowArr,[i1,i1+8,i1+7], "");
    }
    
    break;   
    case 'table3':
    //console.log("Table3 rows"+rows);
    if(rows==2){
      var i1 = searchTagIndex(headerRowArr,"Tandem" );
      hideUnhindeHeader(headerRowArr,[i1,i1+5,i1+4], "");
    }
    if(rows==3){
      var i1 = searchTagIndex(headerRowArr,"Single leg(Left)" );
      hideUnhindeHeader(headerRowArr,[i1,i1+6,i1+5], "");
    }
    if(rows==4){
      var i1 = searchTagIndex(headerRowArr,"Single leg(right)" );
      hideUnhindeHeader(headerRowArr,[i1,i1+6,i1+7], "");
    }
    if(rows==5){
     
      var i1 = searchTagIndex(headerRowArr,"Total time" );
      hideUnhindeHeader(headerRowArr,[i1,i1+8,i1+7], "");
    }
    break;
    case 'table4':
    //console.log("Table4 rows"+rows);
    if(displayOpttion){
      headerRowArr[colIndex+1].style.display="";
    }else{
      headerRowArr[colIndex+2].style.display="";
    }
    //hideUnhindeHeader(headerRowArr,[colIndex+2], "none");
    break; 
  }
    for (i=0; i < headerRowArr.length; i++) {

      var row = headerRowArr[i];
      //console.log(row);
      //var cell = row.cells[colIndex];
      // ////console.log(cell);
      // cell.style.display = "";
      
    }
    for (i=0; i < rowsArr.length; i++) {

      var row = rowsArr[i];
      if(displayOpttion){ 
        var cell = row.cells[colIndex-1];}
      else{
        var cell = row.cells[colIndex];
      }
     
      //console.log(cell);
      cell.style.display = "";
      
    }
  
 
}


function hideUnhindeHeader(headerRowArr,ColumnNumArr, display) {

  //console.log(ColumnNumArr);

  for(var i=0; i<ColumnNumArr.length; i++){
    //console.log(headerRowArr[i]);
    //console.log("============");
    headerRowArr[ColumnNumArr[i]].style.display=display;
  }
}

function searchTagIndex(array, search) {
  for (let i = 0; i < array.length; i++) {

    //console.log(array[i].textContent+""+i);
    //console.log(search);
    if (array[i].textContent.includes(search)==true) {
      return i;
    }
  }
  return -1; // Return -1 if tag is not found in the array
}