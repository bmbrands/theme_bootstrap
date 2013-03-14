YUI.add('gallery-bootstrap-modal', function(Y) {

var CONTENT_BOX   = 'contentBox',
    BOUNDING_BOX  = 'boundingBox',
    HIDDEN_CLASS  = 'hide',
    SHOWING_CLASS = 'in',
    HEADER        = 'header',
    BODY          = 'body',
    FOOTER        = 'footer',
    PREFIX        = 'modal-',

    Lang          = Y.Lang,
    isFunction    = Lang.isFunction,

    NS            = Y.namespace('Bootstrap');

BootstrapPanel = Y.Base.create('BootstrapPanel', Y.Panel,
    [
        // Other Widget extensions depend on these two.
        Y.WidgetPosition,
        Y.WidgetStdMod,

        Y.WidgetAutohide,
        Y.WidgetButtons,
        Y.WidgetModality,
        Y.WidgetPositionAlign,
        Y.WidgetPositionConstrain,
        Y.WidgetStack
    ],
    {
        initializer : function() {
            this.bindUI();
        },

        bindUI : function() {
            this.after('visibleChange', this._visibleChangeFn, this);
        },

        _visibleChangeFn : function(e) {
            if ( e.newVal ) {
                this._show();
            } else {
                this._hide();
            }
        },

        _show: function() {
            var bb = this.get(BOUNDING_BOX),
                cb = this.get(CONTENT_BOX);

            bb.removeClass( HIDDEN_CLASS );
            bb.addClass( SHOWING_CLASS );

            cb.removeClass( HIDDEN_CLASS );
            cb.addClass( SHOWING_CLASS );
        },

        _hide: function() {
            var bb = this.get(BOUNDING_BOX);

            bb.addClass( HIDDEN_CLASS );
            bb.removeClass( SHOWING_CLASS );
        },

        show : function() {
            var cb = this.get(CONTENT_BOX);

            /* Get rid of the Bootstrap positioning styles when we show, start using YUI styles */
            cb.removeClass('modal');
            cb.removeClass('fade');
            cb.setStyle('backgroundColor', '#ffffff');

            this.set('visible', true);
            this.set('align', {
                node  : null,
                points: [ Y.WidgetPositionAlign.CC, Y.WidgetPositionAlign.CC]
            });

            if ( this.transitionDone ) {
                this.transitionDone.detach();
                this.transitionDone = null;
            }
        },

        hide : function(e) {
            this.set('align', {
                node  : null,
                points: [ Y.WidgetPositionAlign.BC, Y.WidgetPositionAlign.TC]
            });

            if ( this.transitionDone ) {
                this.transitionDone.detach();
                this.transitionDone = null;
            }
            this.transitionDone = this.once('transitionDone',
                function() { this.set('visible', false); }, this );
        },

        move: function () {
            var args  = arguments,
                coord = (Lang.isArray(args[0])) ? args[0] : [args[0], args[1]],
                box   = this.get( BOUNDING_BOX ),
                self  = this;

            box.transition({
                duration : 0.5,
                top:  coord[1] + 'px',
                left: coord[0] + 'px'
            }, function() {
                self.set('xy', coord);
                self.fire('transitionDone');
            });
        },

        _findStdModSection: function(section) {
            var node = this.get(CONTENT_BOX).one("> ." + PREFIX + section);
            return node;
        }
    },
    {
        HTML_PARSER : {
            headerContent : function(contentBox) {
                return this._parseStdModHTML( HEADER );
            },
            bodyContent : function(contentBox) {
                return this._parseStdModHTML( BODY );
            },
            footerContent : function(contentBox) {
                return this._parseStdModHTML( FOOTER );
            },
            buttons : function(srcNode) {
                var buttonSelector = 'button,.btn',
                    sections       = [ 'header', 'body', 'footer' ],
                    buttonsConfig  = null;
                Y.Array.each( sections, function(section) {
                    var container = this.get(CONTENT_BOX).one('.' + PREFIX + section),
                        buttons   = container && container.all(buttonSelector),
                        sectionButtons;
                    if ( !buttons || buttons.isEmpty() ) { return; }

                    sectionButtons = [];
                    buttons.each( function(button) {
                        sectionButtons.push({ srcNode: button });
                    });
                    buttonsConfig || ( buttonsConfig = {} );
                    buttonsConfig[section] = sectionButtons;
                }, this);

                return buttonsConfig;
            }
        },

        SECTION_CLASS_NAMES : {
            header : PREFIX + HEADER,
            body   : PREFIX + BODY,
            footer : PREFIX + FOOTER
        },

        CLASS_NAMES : {
            button  : 'btn',
            primary : 'btn-primary'
        },

        TEMPLATES : {
            header : '<div class="' + PREFIX + HEADER + '"></div>',
            body   : '<div class="' + PREFIX + BODY + '"></div>',
            footer : '<div class="' + PREFIX + FOOTER + '"></div>'
        }
    }
);

function ModalPlugin(config) {
    ModalPlugin.superclass.constructor.apply(this, arguments);
}

ModalPlugin.NAME = 'Bootstrap.Modal';
ModalPlugin.NS   = 'modal';

Y.extend(ModalPlugin, Y.Plugin.Base, {
    defaults : {
        backdrop  : 'static',
        keyboard  : true,
        visible   : false,
        //modal     : true,
        render    : true,
        show      : false,
        width     : '560px',
        hideOn    : [
            { eventName : 'clickoutside' }
        ]
    },

    initializer : function(config) {
        this._node = config.host;

        this.config = Y.mix( config, this.defaults );

        this.publish('show', { preventable : true, defaultFn : this.show });
        this.publish('hide', { preventable : true, defaultFn : this.hide });

        this.config.srcNode  = this._node;
        this.config.centered = false;

        var oldClass = Y.ButtonCore.CLASS_NAMES.BUTTON;
        Y.ButtonCore.CLASS_NAMES.BUTTON = 'btn';
        var panel = this.panel = new BootstrapPanel(this.config);
        panel.render();

        Y.ButtonCore.CLASS_NAMES.BUTTON = oldClass;

        panel.get(BOUNDING_BOX).delegate('click',
            function(e) {
                var target = e.currentTarget,
                    action = target.getData('dismiss');
                if ( action && action === 'modal' ) {
                    e.preventDefault();
                    this.fire('hide');
                }
            },
            '.btn', this
        );

        // Set the alignment off the screen in the initial view.
        panel.set('align', {
            node  : null,
            points: [ Y.WidgetPositionAlign.TC, Y.WidgetPositionAlign.BC]
        });

        if ( this.config.show ) {
            this.fire('show');
        }
    },

    /* Add open and close methods */
    hide: function(e) {
        this.panel.hide();
    },

    show: function(e) {
        this.panel.show();
    }
});

NS.Modal = ModalPlugin;



}, '@VERSION@' ,{requires:['panel','plugin','transition','event','event-delegate']});
;