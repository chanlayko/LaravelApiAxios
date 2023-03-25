<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- bootstrap css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-7">
                <h4>Post</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Title</td>
                            <td>Description</td>
                            <td colspan="2" style="text-align:center">Action</td>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        
                    </tbody>
                </table>
            </div>
            <div class="col-lg-5">
                <h4>Create Post</h4>
                <div>
                    <form action="">
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="desc">Descrption</label>
                            <input type="text"class="form-control" name="description" id="desc">
                        </div>
                        <input type="submit" value="Submit" class="btn btn-outline-success">
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- bootstrap Jquery --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    {{-- Axios  --}}
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

    <script>
       axios.get('/api/post')
            .then(response => {
                console.log(response.data);

                var tableBody = document.getElementById('tableBody');

                response.data.forEach(item => {
                    tableBody.innerHTML += 
                        '<tr>'+
                            '<td>'+item.id+'</td>'+
                            '<td>'+item.Title+'</td>'+
                            '<td>'+item.Description+'</td>'+
                            '<td><button class="btn btn-outline-success btn-sm">Edit</button>'+
                            '<td><button class="btn btn-outline-danger btn-sm">Detele</button>'+
                        '</tr>'
                });
            })
            .catch(error => console.log(error));
    </script>
</body>
</html>