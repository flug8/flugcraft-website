//
// BS3 adapter
//

$(document).render(function(){
    $('[data-toggle=dropdown]:not([data-bs-toggle])').attr('data-bs-toggle', 'dropdown');
    $('[data-dismiss=modal]:not([data-bs-dismiss])').attr('data-bs-dismiss', 'modal');
    $('.fade.in:not(.show)').addClass('show');
});
