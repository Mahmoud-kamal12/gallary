

let AllUrls = [];
const init = () => {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: $('#init-url').val(),
        success: function (data){
            var html = ''
            console.log(data)
            data.urls.forEach((url)=>{
                AllUrls.push(url)
                html += `<img class="img-thumbnail m-3" src="${url}"  width="200" height="200">`;
            })
            $("#images-container").append(html)
            console.log("File has been successfully removed!!");
        },
        error: function(e) {
            console.log("error")
            console.log(e);
        }});
}

init()

Dropzone.options.dropzone =
{
   maxFilesize: 12,
   renameFile: function(file) {
       var dt = new Date();
       var time = dt.getTime();
      return time+file.name;
   },
   acceptedFiles: ".jpeg,.jpg,.png,.gif",
   addRemoveLinks: true,
   timeout: 5000,
   success: function(file, response)
   {
       console.log(response);
   },
   error: function(file, response)
   {
      return false;
   },
   removedfile: function(file)
       {
           var name = file.upload.filename;
           $.ajax({
               headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                       },
               type: 'POST',
               url: $('#delete-url').val(),
               data: {filename: name , album : $('#album').val()},
               success: function (data){
                   console.log(data)
                   console.log("File has been successfully removed!!");
                   AllUrls = AllUrls.filter(element => element !== data.url);
                   $('img.img-thumbnail').map(function () {
                       if($(this).attr("src") === data.url){
                           $(this).remove()
                       }
                   }).toArray();

               },
               error: function(e) {
                   console.log("remove error")
                   console.log(e);
               }});
               var fileRef;
               return (fileRef = file.previewElement) != null ?
               fileRef.parentNode.removeChild(file.previewElement) : void 0;
       },

       success: function(file, response)
       {
           AllUrls.push(response.url)
           $("#images-container").last().append(`<img class="img-thumbnail m-2" src="${response.url}"  width="200" height="200">`);
       },
       error: function(file, response)
       {
           console.log("add error")
          return false;
       }
};
