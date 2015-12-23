require(['core/first'], function() {
    require(['theme_bootstrap/bootstrap', 'core/log'], function(b, log) {
        log.debug('Bootstrap JavaScript initialised');
    });
});
