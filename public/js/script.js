
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



