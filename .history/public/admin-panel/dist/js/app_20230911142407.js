var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: function(toast) {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

var Swal = Swal.mixin({
    // confirmButtonText: 'تایید',
    // cancelButtonText: 'انصراف',
    showCancelButton: true,
});

$(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    bsCustomFileInput.init()

    $('.mobile-input').on('input', function(event) {
        this.value = this.value.replace(/[^0-9۰-۹]/g, '');
    });

    setTimeout(function() {
        $(".alert").alert('close');
    }, 5000);

    initSelect2();

    $('.editor').each(function() {
        CKEDITOR.replace(this.name, {
            filebrowserUploadUrl: baseUrl() + "admin/upload-image?_token=" + $('meta[name="csrf-token"]').attr('content'),
            filebrowserUploadMethod: 'form'
        });
    });

    $('.filter-toggle').on('click', function() {
        $('.filter-section').slideToggle();
    });

    $('select[name="limit"]').on('change', function() {
        $('form.frm-filter').submit();
    });
    $('select[name="admin"]').on('change', function() {
        $('form.frm-filter').submit();
    });
});

function initCkeditor() {
    $('.editor').each(function() {
        CKEDITOR.replace(this.id, {
            filebrowserUploadUrl: baseUrl() + "admin/upload-image?_token=" + $('meta[name="csrf-token"]').attr('content'),
            filebrowserUploadMethod: 'form'
        });
    });
}

function initSelect2() {
    $('.select2').select2({
        placeholder: 'Select an option',
        allowClear: true
    });
}

function baseUrl() {
    var pathparts = location.pathname.split('/');
    if (location.host == 'localhost') {
        var url = location.origin + '/' + pathparts[1].trim('/') + '/';
    } else {
        var url = location.origin + '/';
    }
    return url;
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $(input).closest('.form-group').find('.pic-preview').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function readURL2(input) {
    if (input.files && input.files[0]) {

        var fileUrl = window.URL.createObjectURL(input.files[0]);
        console.log(fileUrl)
        $(input).closest('.form-group').find('.video-preview').attr("src", fileUrl);

    }
}

function numberFormat(x) {
    var parts = Number(x).toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

function swalConfirmDelete(elm, title = 'Are you sure?', text = '') {
    event.preventDefault();
    form = $(elm).closest('form');

    Swal.fire({
        title: title,
        text: text,
    }).then(function(result) {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}