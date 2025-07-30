var optionsProfileVisit = {
  annotations: {
    position: "back",
  },
  dataLabels: {
    enabled: false,
  },
  chart: {
    type: "bar",
    height: 300,
    fontFamily: "Roboto",
    toolbar: {
      show: false,
    },
  },
  fill: {
    opacity: 1,
  },
  plotOptions: {
    bar: {
      borderRadius: 10,
      columnWidth: "50%",
    },
  },
  series: [
    {
      name: "Index K",
      data: [80, 78, 95, 90, 88, 94, 98, 93, 83, 89, 95, 83],
    },
  ],

  colors: "#49FC7B",
  xaxis: {
    categories: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "Mei",
      "Jun",
      "Jul",
      "Agu",
      "Sep",
      "Okt",
      "Nov",
      "Des",
    ],
    labels: {
      style: {
        colors: "#0EAC1D",
      },
    },
  },
  yaxis: {
    min: 20,
    max: 100,
    tickAmount: 5,
    labels: {
      style: {
        colors: "#0EAC1D",
      },
      formatter: function (val) {
        return Math.round(val / 20) * 20;
      },
    },
  },
};


var chartProfileVisit = new ApexCharts(
  document.querySelector("#chart-profile-visit"),
  optionsProfileVisit
);

chartProfileVisit.render();
