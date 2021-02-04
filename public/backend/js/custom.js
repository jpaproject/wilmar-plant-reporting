$(function () {
    'use strict';
    $('#datatable1').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        }
    });
    $('.datatable1').DataTable({
        responsive: true,
        paginate: false,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        }
    });
    $('.datatable2').DataTable({
        bLengthChange: false,
        searching: false,
        responsive: true,
        paginate: false,


    });
    // Select2
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity
    });
});

$(document).ready(function () {
    $('#preloader').attr('style', 'display:none;');

    // $(".img-profile").each(function () {
    //     var img = $(this);
    //     var image = new Image();
    //     image.src = $(img).attr("src");
    //     var no_image =
    //         "https://www.ommel.fi/content/uploads/2019/03/dummy-profile-image-male.jpg";
    //     if (image.naturalWidth == 0 || image.readyState == 'uninitialized') {
    //         $(img).unbind("error").attr("src", no_image).css({
    //             height: $(img).css("height"),
    //             width: $(img).css("width"),
    //         });
    //     }
    // });
});

$('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    startView: 2,
    minViewMode: 0,
    language: "id",
    daysOfWeekHighlighted: "0",
    autoclose: true,
    todayHighlight: true,
    toggleActive: true,
    container: '#datepicker-area'
});