jQuery(function( $ ){

    $( ".sidebar .widget_nav_menu li.menu-item-has-children" ).collapse({
        open: function() {
            this.slideDown(150);
        },
        close: function() {
            this.slideUp(150);
        }
    });

});