$(document).ready(function () {
    $('.delete-button').click(function () {
        return confirm($(this).data('mes-confirm'));
    });

    if ($.fn.iCheck) {
        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green'
        });
    }

    execToastr();
    loadSubCategories();
});

function changeToSlug()
{
    var title, slug;
    //Lấy text từ thẻ input title
    title = document.getElementById("name").value;
    //Đổi chữ hoa thành chữ thường
    slug = title.toLowerCase();
    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/([^0-9a-z-\s])/g, '');
    //Xóa khoảng trắng thay bằng ký tự -
    slug = slug.replace(/(\s+)/g, '-');
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    slug = slug.replace(/(-+)/g, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = slug.replace(/^-+/g, '');
    slug = slug.replace(/-+$/g, '');
    //In slug ra textbox có id “slug”
    document.getElementById('slug').value = slug;
}

function execToastr() {
    var type = $('.notification').data('type');
    var message = $('.notification').data('message');

    switch(type){
        case 'info':
            toastr.info(message);
            break;

        case 'warning':
            toastr.warning(message);
            break;

        case 'success':
            toastr.success(message);
            break;

        case 'error':
            toastr.error(message);
            break;
    }
}

function loadSubCategories() {
    $('#category').on('change', function (e) {
        var categoryId = e.target.value;
        var url = $('#category-form #url').val();
        var id = $('#category-form #subcategory-none').data('id');
        var name = $('#category-form #subcategory-none').val();
        url = url.replace('categoryId', categoryId);
        $.get(url, function (data) {
            $('#subcategory').empty();
            $('#subcategory').append('<option value="' + id + '">' + name + '</option>');
            $.each(data, function (index, element) {
                $('#subcategory').append('<option value="' + element.id + '">' + element.name + '</option>');
            });
        });
    });
}
