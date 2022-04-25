
/************************************
 DELETE WARNING SCRIPTING START HERE
 ************************************/
$(document.body).on("click", ".action-delete", function (ev) {
    ev.preventDefault();
    let url = $(this).attr("href");
    let table = $(this).attr("table");
    warnBeforeAction(url, table);
});

/**********************************************
 CATEGORY WISE SUBCATEGORIES ONCHANGE SELECT
 **********************************************/
$(".categoryId").change(function () {
    let route = "/admin/product/subcategories-by-category";
    subcategoriesByCategoryId(this,route);
});

/******************************
IMAGE PREVIEW SCRIP START HERE
 ******************************/

 $('.imageChange').on('change',function(){
     let parentHtml = $(this).parent().parent();
     let  viewImageId  = parentHtml.find('.viewImage');
     let  errorImageId = parentHtml.find('.imgErr');
     errorImageId .html('');
     if (this.files && this.files[0]){
      let mime_type = this.files[0].type;
      if (!(mime_type == 'image/jpeg' || mime_type == 'image/jpg' || mime_type == 'image/png')) {
          this.value = null;
          errorImageId .html("Invalid file format Only jpg jpeg png is allowed");
          return false;
      }
      let size = this.files[0].size;
      if(size > 3000000){
        this.value = null;
        errorImageId .html("Please upload image must less than 1MB!!");
        return false;
      }
      let reader = new FileReader();
      reader.onload = function (e) {
          viewImageId.attr('src', e.target.result);
      };
      reader.readAsDataURL(this.files[0]);
    }
 });

/*****************************
 EDIT MODAL EFFECT START HERE
 *****************************/
$(document.body).on('click','.AppModal',function(e){
    e.preventDefault();
    $('#ModalContent').html('<div style="text-align:center;"><h3 class="text-primary">Loading Form...</h3></div>');
    $('#ModalContent').load(
        $(this).attr('href'),
        function (response, status, xhr) {
            if (status === 'error') {
                alert('error');
                $('#ModalContent').html('<p>Sorry, but there was an error:' + xhr.status + ' ' + xhr.statusText + '</p>');
            }
            return this;
        }
    );
});

/*****************************
 FORM VALIDATION START HERE
 *****************************/
$('#dataForm').validate({
    errorPlacement: function () {
        return false;
    }
});
