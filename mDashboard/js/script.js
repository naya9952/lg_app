var data = [20, 40, 60, 80, 100],
  h = 30,
  w = 30,
  p = 1,
  dBm = -87;


function fillColor(v) {
  if (dBm > -70) {
    return "#00aa77";
  } else if (dBm <= -70 && dBm >= -85) {
    if (v < 100) {
      return "#00aa77";
    } else {
      return "#ccc";
    }
  } else if (dBm <= -86 && dBm >= -100) {
    if (v < 80) {
      return "#00aa77";
    } else {
      return "#ccc";
    }
  } else if (dBm < -100 && dBm >= -110) {
    if (v < 60) {
      return "#00aa77";
    } else {
      return "#ccc";
    }
  } else if (dBm < -110) {
    if (v < 40) {
      return "#00aa77";
    } else {
      return "#ccc";
    }
  }
}

var xScale = d3.scale.linear().domain([]).range([p, w]);

var yScale = d3.scale.linear().domain([0, 100]).range([h - p, p]);

var svg = d3.select('#signalBars').append('svg').attr({width: w,height: h});

svg.selectAll('rect')
  .data(data)
  .enter()
  .append('rect')
  .attr({
    x: function(d, i) {
      return i * (w / data.length);
    },
    y: function(d) {
      return yScale(d);
    },
    width: function(d, i) {
      return w / data.length - p;
    },
    height: function(d) {
      return yScale(0) - yScale(d);
    },
    fill: function(d) {
      return fillColor(d);
    }
  });

function update(v) {
  dBm = v;
  svg.selectAll('rect')
    .data(data)
    .attr({
      fill: function(d) {
        return fillColor(d);
      }
    });
}
