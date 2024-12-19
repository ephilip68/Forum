
function menuMobile() {
    const btn = document.querySelector('.burger');
    const header = document.querySelector('.header');
    const links = document.querySelectorAll('.navbar a');
  
    btn.addEventListener('click', () => {
      header.classList.toggle('show-nav');
    });
  
    links.forEach(link => {
      link.addEventListener('click', () => {
        header.classList.remove('show-nav');
      });
    });
  }

  menuMobile();  


    var image = document.getElementById("image");
        
    // La fonction previewPicture
    var previewPicture  = function (e) {

      // e.files contient un objet FileList
        const [picture] = e.files

      // "picture" est un objet File
        if (picture) {

            // L'objet FileReader
            var reader = new FileReader();

            // L'événement déclenché lorsque la lecture est complète
            reader.onload = function (e) {
                // On change l'URL de l'image (base64)
                image.src = e.target.result
            }

            // On lit le fichier "picture" uploadé
            reader.readAsDataURL(picture)

        }
    } 




// function delete_field(obj, elem) {
//     $(obj).closest(elem).fadeOut().remove();
//     return false;
// }

// let check_id  = 0;
// function add_extra_field(obj) {
    
//     check_id++;
   
//     let parent = $(obj).data('parent');
//     let clone = $(obj).data('clone');
//     let html = $(clone).clone();
   
//     $(parent).append(html.attr('id', '').fadeIn());
//     html.find('.upload-file').attr('id', `uploadfile${check_id}`);

// }

// $('#modelId').on('shown.bs.modal', function(){

// $(function() {
// $("html").on("dragover", function(e) { e.preventDefault(); e.stopPropagation(); });
// $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });


  
// $(".add-dup-parent").on('dragenter', '.upload-area', function (e){
//     e.preventDefault();
//     $(this).find("p").css('background', '#BBD5B8')
// });

// $(".add-dup-parent").on('dragover', '.upload-area', function(e) {
//     e.preventDefault();
//     $(this).find("p").text("Drop")
// });

// $('.add-dup-parent').on('drop', '.upload-area', function (e) {
    
//     e.stopPropagation();
//     e.preventDefault();
    
//     $(this).find("p").hide();
    
//     let file = e.originalEvent.dataTransfer.files;
//     let imageData = file[0];
//     if( imageData){
//     let preview_img = $(this).find('.card-img-top');
//     if (file && file[0]) {
//         var reader = new FileReader();
//         reader.onload = function (e) {
//             preview_img.attr('src', e.target.result);
//         };
//         reader.readAsDataURL(file[0]);
//     }
//     preview_img.fadeIn();
//     }
// });
    

// $(".add-dup-parent").on('click', '.upload-area', function(){
//     $(this).siblings('.fileUpload').click()
// });

//   $(".add-dup-parent").on('change', '.fileUpload', function(e){
//       let imageData = e.target.files[0];
//       if(imageData){
//           $(".fileUpload p.card-text").remove(); 
//           img_preview(this, 'single');    
//       }    
//     });
  
//   });
// })
