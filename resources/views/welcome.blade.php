<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-7">
                <h4>Post</h4>
                <span id="succMsg"></span>
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
                <span id="succMsg"></span>
                <div>
                    <form action="" id="myForm">
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" >
                            <span id="titleError"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="desc">Descrption</label>
                            <textarea name="description" id="desc" class="form-control" cols="30" rows="5" ></textarea>
                            <span id="descriptionError"></span>
                        </div>
                        <input type="submit" value="Submit" class="btn btn-outline-success">
                    </form>
                </div>
            </div>        
        </div>
    </div>
  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" id="editForm">
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" >
                    <span id="titleError"></span>
                </div>
                <div class="form-group mb-3">
                    <label for="desc">Descrption</label>
                    <textarea name="description" id="desc" class="form-control" cols="30" rows="5" ></textarea>
                    <span id="descriptionError"></span>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
      </div>
    </div>
  </div>
    {{-- bootstrap Jquery --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    {{-- Axios  --}}
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>

    <script>
        // INDEX
        var tableBody = document.getElementById('tableBody');
        var titleList = document.getElementsByClassName('titleList');
        var descList = document.getElementsByClassName('descList');
        var idList = document.getElementsByClassName('idList');
        var btnList1 = document.getElementsByClassName('btnList1');
        var btnList2 = document.getElementsByClassName('btnList2');
        // console.log(titleList);

       axios.get('/api/post')
            .then(response => {
                // console.log(response.data);

                response.data.posts.forEach(item => {
                    displayData(item);
                });
            })
            .catch(error => {
                // console.log(error.response);
                // console.log(error.response.status);
                // console.log(error.response.statusText);
                // console.log(error.response.config.method);
                // console.log(error.response.config.url);

                if(error.response.status == 404){
                    console.log('"'+ error.response.config.url +'"' + ' Url is not Found');
                }
            });

            // CREATE
            var myForm = document.forms['myForm'];
            var titleInput = myForm['title'];
            var descriptionInput = myForm['description'];

            myForm.onsubmit = function(e){
                e.preventDefault();

                axios.post('/api/post', {
                    title : titleInput.value,
                    description : descriptionInput.value,
                })
                     .then(response => {
                        console.log(response.data);
                        var titleErr = document.getElementById('titleError');
                        var descErr = document.getElementById('descriptionError');
                        if (response.data.msg == 'Data Create Successfully') {
                            alertMsg(response.data.msg);
                            myForm.reset();
                            displayData(response.data.createPost);
                            titleErr.innerHTML = descErr.innerHTML = '';
                        } else {
                            titleErr.innerHTML = titleInput.value == '' ? '<i class="text-danger">'+response.data.msg.title+'</i>':'';
                            descErr.innerHTML = descriptionInput.value == '' ? '<i class="text-danger">'+response.data.msg.description+'</i>':'';
                        }  
                     })
                     .catch(error => {
                        // console.log(error.response);
                     });

                // console.log('hello world');
            }
            
            // Edit 
            var editForm = document.forms['editForm'];
            var editTitleInput = editForm['title'];
            var editDescInput = editForm['description'];
            var postIdInput, oldTitle, oldDesc;
            function editBtn(postId){
                postIdInput = postId;
                axios.get('/api/post/'+postId)
                     .then( response => {
                       editTitleInput.value = oldTitle = response.data.posts.Title;
                       editDescInput.value = oldDesc = response.data.posts.Description; 
                     })
                     .catch( error => {
                        console.log(error);
                     });
            }

            // Update
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
                keyboard: false
            })
            editForm.onsubmit = function(e){
                e.preventDefault();
                axios.put('/api/post/'+postIdInput, {
                    title : editTitleInput.value,
                    description : editDescInput.value,
                    })  
                     .then(response => {
                        console.log(response.data);
                        alertMsg(response.data.msg);
                        myModal.hide();

                        for (var i = 0; i < titleList.length; i++) {
                            if (titleList[i].innerHTML == oldTitle) {
                                    titleList[i].innerHTML = editTitleInput.value;
                                    descList[i].innerHTML = editDescInput.value;
                            }
                            
                        }
                     })
                     .catch(error => {
                        console.log(error);
                     });
            }

            // Delete
            function deleteBtn(postId){
                if (confirm('Are you sure Delete!')) {
                    axios.delete('/api/post/'+postId)
                     .then( response => {
                        // console.log(response.data.deletedPost.Title);
                        alertMsg(response.data.msg);
                        for (var i = 0; i < titleList.length; i++) {
                            if (titleList[i].innerHTML == response.data.deletedPost.Title) {
                                titleList[i].style.display = 'none';
                                descList[i].style.display = 'none';
                                idList[i].style.display = 'none';
                                btnList1[i].style.display = 'none';
                                btnList2[i].style.display = 'none';
                            }
                            
                        }
                     })
                     .catch(error => {
                        console.log(error);
                     })
                }
            }

            // HELPPER FUNCTION
            function displayData(funData){
                tableBody.innerHTML += 
                    '<tr>'+
                        '<td class="idList">'+funData.id+'</td>'+
                        '<td class="titleList">'+funData.Title+'</td>'+
                        '<td class="descList">'+funData.Description+'</td>'+
                        '<td class="btnList1"><button class="btn btn-outline-success btn-sm" onclick="editBtn('+funData.id+')" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>'+
                        '<td class="btnList2"><button class="btn btn-outline-danger btn-sm" onclick="deleteBtn('+funData.id+')">Detele</button>'+
                    '</tr>'
            }

            function alertMsg(msg){
                document.getElementById('succMsg').innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+ msg +'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
            }
    </script>
</body>
</html>