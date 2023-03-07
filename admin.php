<?php
include_once('session.php');
?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <h1>admin</h1>


    <table id="myTable" class="table table-dark">
        <thead>
            <tr>
                <th>id</th>
                <th>password</th>
                <th>role</th>
                <th>edit</th>
                <th>delete</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


    <a href="logout.php">logout</a>
</body>

</html>
<script>
    const tableBody = document.querySelector('#myTable tbody');
    fetch('control.php')
        .then(response => response.json())
        .then(data => {

            tableBody.innerHTML = '';

            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
            <td>${row.id}</td>
            <td>${row.password	}</td>
            <td>${row.role}</td>
            <td><button onclick="editRow(this)">Edit</button></td>
            <td><button onclick="deleteRow(this)">Delete</button></td>
          `;
                tableBody.appendChild(tr);
            });
        });

    function editRow(btn) {
        const row = btn.parentNode.parentNode;
        const cells = row.getElementsByTagName("td");
       
        cells[0].innerHTML = "<input type='text' value='" +cells[0].innerHTML + "'>";
        cells[1].innerHTML = "<input type='text' value='" +cells[1].innerHTML + "'>";
        cells[2].innerHTML = "<select> <option value='admin'>admin</option><option value='user'>user</option> </select>";
        cells[3].innerHTML = "<button onclick='saveRow(this)'>Save</button>";
    }

    function saveRow(btn) {
        const row = btn.parentNode.parentNode;
        const cells = row.getElementsByTagName("td");
        const newdata = {
            id: cells[0].firstChild.value,
            password: cells[1].firstChild.value,
            role: cells[2].firstChild.value,
           
        };
        update(newdata);
        for (let i = 0; i < cells.length - 2; i++) {
            cells[i].innerHTML = cells[i].firstChild.value;
        }
        cells[3].innerHTML = "<button onclick='editRow(this)'>Edit</button>";
    }
    function update(newdata) {
        console.log(newdata);
        fetch("control.php", {
                method: "PUT",
                body: JSON.stringify(newdata),
            })
            .then((response) => response.json())
            .then((data) => {
                console.log(data)
            })
            .catch((error) => console.log(error));
    }

    function deleteRow(btn) {
        const row = btn.parentNode.parentNode;
        const cells = row.getElementsByTagName("td");
        const id = cells[0].innerHTML;

        deleteRowFromDatabase(id);
        row.remove();
    }
    function deleteRowFromDatabase(id) {
    fetch("control.php?id=" + id, {
        method: "DELETE"
    })
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.log(error));
}
</script>