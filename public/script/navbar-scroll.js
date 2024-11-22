// Jika pengguna menggulir lebih jauh dari tinggi navbar-fixed-top, kelas scrolled ditambahkan. Jika tidak, kelas scrolled dihapus
$( function () {
    $(document).scroll(function (){
        var $nav = $(".navbar-fixed-top");
        $nav.toggleClass("scrolled", $(this).scrollTop() > $nav.height());
    });
});