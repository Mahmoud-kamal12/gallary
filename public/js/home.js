
$(document).on("click" , "#btn-add" , ()=>{
    const form = $('#add-form')
    var url = form.attr('action');
    var name = $("#album-name").val()
    console.log(name)
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data : {name:name},
        url: url,
        success: function (data){
            console.log(data)
            window.location.reload();
            console.log("Album has been successfully removed!!");
        },
        error: function(e) {
            console.log("error")
            console.log(e);
        }});
})
const DeleteModal = document.getElementById('DeleteModal')
DeleteModal.addEventListener('show.bs.modal', event => {
    $("#DeleteModal #model-contecxt").html(``)
    const button = event.relatedTarget
    const id = button.getAttribute('data-bs-album-id')
    const count = button.getAttribute('data-bs-album-count')
    if(count > 0){
        $("#DeleteModal #model-contecxt").html(`
                            <div class="row justify-content-center text-center mb-4">
                                <h3 class="">This Album Not Null</h3>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col">
                                    <button class="btn btn-danger" id="btn-delete-all">Delete All Photos Then Delete Album</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-success" id="btn-move">Move All Photos To Another Album Then Delete Albums</button>
                                </div>
                            </div>
                            <div class="row mt-4" id="row-select" style="display: none" >
                                <div class="col">
                                    <select name="album" id="select-album-id" class="form-control">

                                    </select>
                                    <button class="btn btn-success mt-3" id="btn-move-req">Move</button>
                                </div>
                            </div>
                `)
    }
    else {
        var url = $("#delete-all-url").val()
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url :url,
            type: 'post',
            data: {id: id},
            success: function (data){
                console.log(data)
                window.location.reload();
            },
            error: function(e) {
                console.log("error")
                console.log(e);
            }
        });
        return event.preventDefault()
    }
    const modalBodyInput = DeleteModal.querySelector('.modal-body input')
    modalBodyInput.value = id
})


$(document).on("click" , "#btn-move" ,function (){
    var url = $("#stsrt-all").val()
    console.log(url)
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url :url,
        type: 'get',
        success: function (data){
            var html = "";
            data.albums.forEach((album)=>{
                html += `<option value="${album.id}">${album.name}</option>`;
            })
            $("#select-album-id").append(html)
            $("#row-select").css("display", "block");
            $('#select-album-id').select2({
                dropdownParent: $('#DeleteModal')
            });
        },
        error: function(e) {
            console.log("error")
            console.log(e);
        }
    });

})

$(document).on("click" , "#btn-move-req" ,function (){
    var url = $("#move-url").val()
    var id = $("#album-id").val()
    var newAlbum = $("#select-album-id").val()

    console.log(url)
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url :url,
        type: 'post',
        data: {new: newAlbum , old: id},
        success: function (data){
            console.log(data)
            window.location.reload();
        },
        error: function(e) {
            console.log("error")
            console.log(e);
        }
    });

})

$(document).on("click" , "#btn-delete-all" ,function (){
    var url = $("#delete-all-url").val()
    var id = $("#album-id").val()

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url :url,
        type: 'post',
        data: {id: id},
        success: function (data){
            console.log(data)
            window.location.reload();
        },
        error: function(e) {
            console.log("error")
            console.log(e);
        }
    });

})
