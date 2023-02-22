<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
  </head>
  <body>

    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                Choice method and token
            </div>
            <div class="card-title" role="alert" id="msg">

            </div>
            <div class="card-body">
                <div class="mb-3 form-check" >
                    <input type="checkbox" class="form-check-input" id="post" onchange="checkMethodForm()">
                    <label class="form-check-label" for="post">POST method</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="get" onchange="checkMethodForm()">
                    <label class="form-check-label" for="get">GET method</label>
                </div>
                <div class="mb-3">
                    <label for="token" class="form-label">Your token</label>
                    <input type="text" class="form-control" id="token">
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <button class="userinfo btn btn-sm btn-success my-5" style="height: 45px;" data-toggle="modal" onclick="createForm()">Create new Item</button>
        <div class="card">
            <div class="card-header">
                CRUD
            </div>
            <div class="card-body">
                <table id="table_id" class="display">
                    <thead>
                        <tr>
                            <th>item</th>
                            <th>item2</th>
                            <th>item3</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="recordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="srecordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="recordModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="theForm">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script>

        let token = document.getElementById("token").value;
        let theForm = document.getElementById("theForm");

        // Получаем чекбоксы
        let post = document.getElementById("post");
        let get = document.getElementById("get");

        let msg = document.getElementById("msg")

        let item = theForm.elements['item'];
        let item2 = theForm.elements['item2'];
        let item3 = theForm.elements['item3'];

        // Функция для выбора метода отправки формы
        function checkMethodForm() {
            // Если чекбокс post нажат
            if (post.checked) {
                theForm.method = "POST";
                // secondForm.method = "POST"
                get.checked = false;
            } else if (get.checked) {   // Если чекбокс get нажат
                theForm.method = "GET";
                // secondForm.method = "GET"
                post.checked = false;
            } else { // Если ничего не нажато
                theForm.method = "POST";
                // secondForm.method = "POST"
            }
        }


        $(document).ready( function () {
            $('#table_id').DataTable({
                ajax: {
                    url: "{{ route('indexJSON') }}",
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'item' },
                    { data: 'item2' },
                    { data: 'item3' },
                ],
                columnDefs: [
                    {
                        "targets":3,
                        "data":"id",
                        "render": function(data) {
                            return `<button type="button" class="edit btn btn-primary" data-bs-toggle="modal" data-title="Edit" onclick="editButton(${data})">Edit</button> <button type="button" class="btn btn-danger" onclick="deleteForm(${data})">Delete</button>`
                        }
                    }
                ]
            });
        })

        async function editButton(id) {
            try {
                let response = await fetch(`api/edit/${id}`, {
                    method: 'GET',
                    headers:{
                        'Content-type': 'application/json; charset=UTF-8',
                        'Authorization': `Bearer ${this.token.value}`
                    },
                });

                result = await response.json();
                console.log(result);

                $("#recordModal").modal("show");

                let item1 = `<div class="mb-3">
                    <label for="item" class="form-label">item</label>
                    <input type="text" class="form-control" id="item" value="${result.data.items.item}">
                </div>`

                let item2 = `<div class="mb-3">
                    <label for="item2" class="form-label">item2</label>
                    <input type="text" class="form-control" id="item2" value="${result.data.items.item2}">
                </div>`

                let item3 = `<div class="mb-3">
                    <label for="item3" class="form-label">item3</label>
                    <input type="text" class="form-control" id="item3" value="${result.data.items.item3}">
                </div>`

                let token_user = `<input type="hidden" class="form-control" id="token_edit" value="${result.data.token_user}">`

                let record_id = `<input type="hidden" class="form-control" id="record_id_edit" value="${id}">`

                let button = `<button type="submit" class="btn btn-primary" onclick="updateData(event)">Save</button>`;

                // Текст сообщения
                theForm.innerHTML = item1 + item2 + item3 + token_user + record_id + button;

            } catch (error) {
                alert('Error. The token has expired or it is not valid')
            }
        }

        async function updateData(e) {

            e.preventDefault();

            let record_id = theForm.elements['record_id_edit'];

            // Создаем объект для отправки
            let obj = {
                'data' : {
                    'items': {
                        'item2': {
                            'value': this.item2.value
                        },
                        'item3': [
                            this.item3.value
                        ],
                        'item': `${this.item.value}`
                    },
                },
            }

            try {
                let response = await fetch(`api/update/${record_id.value}`, {
                    method: 'PATCH',
                    headers:{
                        'Content-type': 'application/json; charset=UTF-8',
                        'Authorization': `Bearer ${this.token.value}`
                    },
                    body: JSON.stringify(obj),
                });

                // Получение результата
                result = await response.json();
                console.log(result);

                $("#recordModal").modal("hide");
                $('#table_id').DataTable().ajax.reload();
            } catch (error) {
                alert('Error. The token has expired or it is not valid')
                console.log(error);
            }

            // Задаем стили для блока сообщением
            msg.classList.add("alert");
            msg.classList.add("alert-success");
                // Текст сообщения
            msg.innerHTML = "The operation was completed successfully";

        }

        function deleteForm(id) {

            let item1 = `<div class="mb-3">
                <label for="item" class="form-label">Delete record ?</label>
            </div>`

            let record_id = `<input type="hidden" class="form-control" id="record_id_edit" value="${id}">`

            let button = `<button type="submit" class="btn btn-danger" onclick="deleteData(event)">Delete</button>`;

            theForm.innerHTML = item1 + record_id + button;

            $("#recordModal").modal("show");
        }

        async function deleteData(e) {
            e.preventDefault();

            let id = document.getElementById("record_id_edit").value

            try {
                let response = await fetch(`api/delete/${id}`, {
                    method: 'DELETE',
                    headers:{
                        'Content-type': 'application/json; charset=UTF-8',
                        'Authorization': `Bearer ${this.token.value}`
                    },
                });

                result = await response.json();
                console.log(result);

                $("#recordModal").modal("hide");
                $('#table_id').DataTable().ajax.reload();

            } catch (error) {
                alert('Error. The token has expired or it is not valid')
            }
        }

        function createForm() {

            let item1 = `<div class="mb-3">
                <label for="item" class="form-label">item</label>
                <input type="text" class="form-control" id="item">
            </div>`

            let item2 = `<div class="mb-3">
                <label for="item2" class="form-label">item2</label>
                <input type="text" class="form-control" id="item2">
            </div>`

            let item3 = `<div class="mb-3">
                <label for="item3" class="form-label">item3</label>
                <input type="text" class="form-control" id="item3">
            </div>`

            let button = `<button type="submit" class="btn btn-primary" onclick="createData(event)">Create</button>`;

            theForm.innerHTML = item1 + item2 + item3 + button;

            $("#recordModal").modal("show");
        }

        async function createData(e) {
            e.preventDefault();

            // Создаем объект для отправки
            let data = {
                'data' : {
                    'item2': {
                        'value': this.item2.value
                    },
                    'item3': [
                         this.item3.value
                    ],
                    'item': `${this.item.value}`
                },
            }

            try {
                if (theForm.method == "post") {
                    let response = await fetch(`{{ route('storeJSON') }}`, {
                        method: 'POST',
                        headers:{
                            'Content-type': 'application/json; charset=UTF-8',
                            'Authorization': `Bearer ${this.token.value}`
                        },
                        body: JSON.stringify(data),
                    });

                    // Получение результата
                    result = await response.json();
                    console.log(result);

                } else {
                    // Передаём данные через ссылку с помощью GET
                    let url = `?data=${JSON.stringify({'item2': {'value': this.item2.value}, 'item3': [this.item3.value], 'item': `${this.item.value}`})}`

                    let response = await fetch(`{{ route('storeJSON') }}/${url}`, {
                        method: 'GET',
                        headers:{
                            'Content-type': 'application/json; charset=UTF-8',
                            'Authorization': `Bearer ${this.token.value}`
                        },
                    });

                    result = await response.json();
                    console.log(result);
                }

                $("#recordModal").modal("hide");
                $('#table_id').DataTable().ajax.reload();

            } catch (error) {
                alert('Error. The token has expired or it is not valid')
                console.log(error);
            }
        }

    </script>
  </body>
</html>
