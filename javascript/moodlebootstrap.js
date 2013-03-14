YUI({
    //Last Gallery Build of this module
    gallery: 'gallery-2012.08.22-20-00'
}).use('gallery-bootstrap-dropdown', function(Y) {
    Y.one('.dropdown-toggle').plug( Y.Bootstrap.Dropdown )
});
