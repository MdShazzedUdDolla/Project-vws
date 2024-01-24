function initChart(element){
  my_chart = new Chart(
    element,
    {
      scales:{
        y: {
          min: 90
        }
      }
   }
  );

  
  return my_chart;
}







/*
Returns a javascript chart and renders it to screen using the chart.js library

@param {html container} element where the chart is stored in, either a canvas or a div
@param {string} name the name of the chart
@param {array} info 1 dimensional string array containing all of the data for a single piece of information i.e heart rate
@param {string} optional param containing the type of chart that will be rendered
@return {js.chart} returns the chart which can be further modified

*/
function makeChart(element, width, height) {
  const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      title: {
        display: true,
        text: "Invalid Data Entered"
      }
    }
  };

  const chartConfig = {
    type: 'line',
    data: {
      labels: [],
      datasets: [{
        label: '',
        data: []
      }]
    },
    options: chartOptions
  };

  const chart = new Chart(element, chartConfig);
  
  function resizeChart() {
    containerWidth = element.parentNode.offsetWidth;
    containerHeight = element.parentNode.offsetHeight;
    // console.log(containerWidth);
    // console.log(containerHeight);
    
    chart.resize(containerWidth, containerHeight);
  }

  resizeChart();

  window.addEventListener('resize', resizeChart);
  
  return chart;
}

    function makeUserChart(element, data, title, width, height) {
      
      // Create an array of all dates
      const allDates = data.flatMap(({ date }) => date);
      
      // Get an array of unique dates
      const uniqueDates = Array.from(new Set(allDates));
      
      // Sort the dates in ascending order
      uniqueDates.sort((a, b) => new Date(a) > new Date(b) ? 1 : -1);
      
      // Create an array of objects for each user containing date and value
      const userDatasets = data.map(({ name, values, date }) => {
        const dataset = [];
        for (let i = 0; i < date.length; i++) {
          const dataObj = { date: date[i], value: parseFloat(values[i]) };
          dataset.push(dataObj);
        }
        return { name, dataset };
      });
      
      // Combine all user datasets into a single dataset for each unique date
      const chartData = uniqueDates.map(date => {
        const dataObj = { date };
        userDatasets.forEach(({ name, dataset }) => {
          const dataPoint = dataset.find(obj => obj.date === date);
          if (dataPoint) {
            dataObj[name] = parseFloat(dataPoint.value);
          } else {
            dataObj[name] = 0;
          }
        });
        return dataObj;
      });
      
      // Create an array of label strings formatted from the unique dates
      const labels = uniqueDates.map(date => {
        const options = { year: 'numeric', month: 'numeric', day: 'numeric' };
        return new Intl.DateTimeFormat('en-US', options).format(new Date(date));
      });
      
      // Create an array of chart datasets, one for each user
      const chartDatasets = userDatasets.map(({ name }) => {
        const color = `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)})`;
        return {
          label: name,
          data: chartData.map(({ [name]: value }) => value),
          backgroundColor: color,
          borderColor: color,
          borderWidth: 1,
        };
      });
      
      // Set chart options
      const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            type: 'category',
            labels: labels,
          }
        },
        plugins: {
          title: {
            display: true,
            text: title
          }
        }
      };
      
      // Create chart config
      const chartConfig = {
        type: 'line',
        data: {
          datasets: chartDatasets
        },
        options: chartOptions
      };

      chart = new Chart(element, chartConfig);
      
      function resizeChart() {
        containerWidth = element.parentNode.offsetWidth;
        containerHeight = element.parentNode.offsetHeight;
        // console.log(containerWidth);
        // console.log(containerHeight);
        chart.resize(containerWidth, containerHeight);
      }
    
    
      resizeChart();
    
      window.addEventListener('resize', resizeChart);
      
      
      // Create and return chart instance
      return chart;
    }




  /*
  Adds more information to the chart

  @param {js.chart} mychart js chart object
  @param {string} mylabel the name of the data
  @param {array} info a 1 dimensional array of all of the information
  */
  function addToChart(mychart, mylabel, info) {
    if(info == null){
      return;
    }


    //Adds a random color
    randRed = Math.floor(Math.random() * 256);
    randGreen = Math.floor(Math.random() * 256);
    randBlue = Math.floor(Math.random() * 256);
    randBackgroundColor = 'rgba(' + randRed + ', ' + randGreen + ', ' + randBlue +  ')';
    randBorderColor = 'rgba(' + randRed + ', ' + randGreen + ', ' + randBlue + ')';
    //Push a new dataset



    const dataset = {
      label: mylabel,
      data: info,
      backgroundColor: randBackgroundColor,
      borderColor: randBorderColor
    };


    mychart.data.datasets.push(dataset);
    mychart.update();
}

/*
Removes the most recently added dataset to the chart

@param {js.chart} mychart js chart object

*/
function removeFromChart(mychart) {
    mychart.data.datasets.pop();
    mychart.update();
}

