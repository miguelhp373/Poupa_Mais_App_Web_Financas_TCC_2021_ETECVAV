function addRow() {
    var table = document.getElementById("table_add");
    var td1 = document.createElement("td");
    var td2 = document.createElement("td");
    var td3 = document.createElement("td");
    var td4 = document.createElement("td");
    var td5 = document.createElement("td");
    var td6 = document.createElement("td");
    var row = document.createElement("tr");

    td1.innerHTML = document.getElementById("tipo").value;
    td2.innerHTML = document.getElementById("data").value;
    td3.innerHTML = document.getElementById("categ").value;
    td4.innerHTML = document.getElementById("desc").value;
    td5.innerHTML = document.getElementById("valor").value;

    row.appendChild(td1);
    row.appendChild(td2);
    row.appendChild(td3);
    row.appendChild(td4);
    row.appendChild(td5);
    row.appendChild(td6);

    table.appendChild(row);
  }