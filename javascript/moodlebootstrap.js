YUI().use('gallery-bootstrap');

YUI.add('gallery-bootstrap', function(Y) {

var NS = Y.namespace('Bootstrap');

NS.initializer = function(e) {
    //console.log('initializer!');
    NS.dropdown_delegation();
};

Y.on('domready', NS.initializer);

}, '@VERSION@' ,{requires:[ 'gallery-bootstrap-dropdown', 'gallery-bootstrap-engine']});
;