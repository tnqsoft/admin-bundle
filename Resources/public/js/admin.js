function replaceAll(subject, str1, str2) {
    var re = new RegExp(str1, "gi");
    return subject.replace(re, str2);
}
function trimStr(str) {
    return str.replace(/^\s+|\s+$/g, "");
}
function slugify(str) {
    tmp = trimStr(str);
    tmp = replaceAll(tmp,' ','-');
    tmp = replaceAll(tmp,'_','-');
    tmp = tmp.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/gi, 'a');
    tmp = tmp.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/gi, 'e');
    tmp = tmp.replace(/(ì|í|ị|ỉ|ĩ)/gi, 'i');
    tmp = tmp.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/gi, 'o');
    tmp = tmp.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/gi, 'u');
    tmp = tmp.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/gi, 'y');
    tmp = tmp.replace(/(đ)/gi, 'd');
    tmp = tmp.replace(/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/gi, 'A');
    tmp = tmp.replace(/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/gi, 'E');
    tmp = tmp.replace(/(Ì|Í|Ị|Ỉ|Ĩ)/gi, 'I');
    tmp = tmp.replace(/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/gi, 'O');
    tmp = tmp.replace(/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/gi, 'U');
    tmp = tmp.replace(/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/gi, 'Y');
    tmp = tmp.replace(/(Đ)/gi, 'D');
    tmp = tmp.replace(/(%|\!|`|\.|'|"|&|@|\^|=|\+|\:|,|{|}|\?|\\|\/|quot;)/gi, '');
    tmp = tmp.toLowerCase();
    return tmp;
}
function generateMenuLinkParameters() {
    var routerName = $('#menu_routerName').val();
    var paramStr = '';
    var param = new Array();
    param['homepage'] = '';
    param['frontend_contact'] = '';
    param['frontend_news_category'] = '{"slug": ""}';
    param['frontend_news_detail'] = '{"categorySlug": "", "slug": ""}';
    param['frontend_page_detail'] = '{"slug": ""}';
    param['frontend_photo_categories'] = '';
    param['frontend_photo_category_detail'] = '{"slug": ""}';
    param['frontend_product_category'] = '';
    param['frontend_product_list_level1'] = '{"categoryParentSlug": ""}';
    param['frontend_product_list_level2'] = '{"categoryParentSlug": "", "categorySlug": ""}';
    param['frontend_product_detail'] = '{"categoryParentSlug": "", "categorySlug": "", "id": 0}';
    param['frontend_testimonial_list'] = '';
    param['frontend_map'] = '';

    if(typeof param[routerName] !== 'undefined') {
        paramStr = param[routerName];
    }

    $('#menu_parameters').val(paramStr);
}

function menuSort() {
    arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
    $('input[name="listItems"]').val(JSON.stringify(arraied));

    return true;
}
///////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.btnEmbedItemDelete', function(){
    $(this).closest(".embed-form-item").remove();
});
$('.embed-form-item-content').matchHeight();
///////////////////////////////////////////////////////////////////////////////
//Product Form
function addProductPhoto() {
    var $listPhoto = $('#listProductPhotos');
    var photoPrototype = $listPhoto.data('prototype');
    var currentIndex = parseInt($listPhoto.data('index'), 10);
    $listPhoto.data('index', currentIndex + 1);
    photoPrototype = photoPrototype.replace(/__name__/g, currentIndex);
    var photoItem = $(photoPrototype);
    $(".checkbox-switch-photo-default", photoItem).bootstrapSwitch({
        'size': 'mini',
        'onText': 'Có',
        'offText': 'Không',
        'onColor': 'success',
        'offColor': 'danger'
    });
    $("#product_listPhoto_content").append(photoItem);
    $('.embed-form-item-content').matchHeight();
}
$('#btnAddProductPhoto').click(function(){
    addProductPhoto();
});
///////////////////////////////////////////////////////////////////////////////
//Product Form
function addPhoto() {
    var $listPhoto = $('#listPhotos');
    var photoPrototype = $listPhoto.data('prototype');
    var currentIndex = parseInt($listPhoto.data('index'), 10);
    $listPhoto.data('index', currentIndex + 1);
    photoPrototype = photoPrototype.replace(/__name__/g, currentIndex);
    var photoItem = $(photoPrototype);
    $(".checkbox-switch-photo-default", photoItem).bootstrapSwitch({
        'size': 'mini',
        'onText': 'Có',
        'offText': 'Không',
        'onColor': 'success',
        'offColor': 'danger'
    });
    $("#category_listPhoto_content").append(photoItem);
    $('.embed-form-item-content').matchHeight();
}
$('#btnAddPhoto').click(function(){
    addPhoto();
});
///////////////////////////////////////////////////////////////////////////////

$('.btnGenerateSlug').click(function(){
    var $txtSrc = $('#'+$(this).data('src'));
    var $txtDes = $('#'+$(this).data('des'));
    $txtDes.val(slugify($txtSrc.val()));
});

$('.btnGenerateParameters').click(function(){
    generateMenuLinkParameters();
});

$('.btn-link-delete').click(function(e){
    e.preventDefault();
    var currentElement = $(this);
    jQuery('#modalDelete').modal('show').on('click', '.btn-confirm-delete', function() {
        jQuery('#modalDelete').modal('hide');
        window.location.href = currentElement.attr('href');
    });
});

$(".checkbox-switch-active").bootstrapSwitch({
    'size': 'small',
    'onText': 'Mở',
    'offText': 'Khóa',
    'onColor': 'success',
    'offColor': 'danger'
});

$(".checkbox-switch-photo-default").bootstrapSwitch({
    'size': 'mini',
    'onText': 'Có',
    'offText': 'Không',
    'onColor': 'success',
    'offColor': 'danger'
});

$('.summernote').summernote({
    lang: 'vi-VN',
    minHeight: 300,
});

$('#product_price').change(function(){
    $(this).val($(this).val().replace(/\./g, ''));
});

$('.dashboard-quick-menu li a').matchHeight();
