var obj1 = document.getElementById("rel1");
var obj2 = document.getElementById("rel2");
var rel1 = new Chart(obj1, {
  type: "line",
  data: {
    labels: daysList,
    datasets: [
      {
        label: "Receita",
        data: revenueList,
        fill: false,
        backgroundColor: "#0000FF",
        borderColor: "#0000FF"
      },
      {
        label: "Despesas",
        data: expensesList,
        fill: false,
        backgroundColor: "#F00",
        borderColor: "#F00"
      }
    ]
  }
});
var rel2 = new Chart(obj2, {
  type: "pie",
  data: {
    labels: statusName,
    datasets: [
      {
        data: statusValues,
        backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56"]
      }
    ]
  }
});
