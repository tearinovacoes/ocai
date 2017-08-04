function plotRadarChart(id,data,width,height,margin) {
  /* Radar chart design created by Nadieh Bremer - VisualCinnamon.com */


  //////////////////////////////////////////////////////////////
  //////////////////// Draw the Chart //////////////////////////
  //////////////////////////////////////////////////////////////

  var color = d3.scale.ordinal()
    .range(["#EDC951","#CC333F"]);

  var radarChartOptions = {
    w: width,
    h: height,
    margin: margin,
    maxValue: 100,
    levels: 10,
    roundStrokes: true,
    color: color
  };
  //Call function to draw the Radar chart
  RadarChart(id, data, radarChartOptions);

}
