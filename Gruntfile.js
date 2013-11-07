/**
 * Gruntfile for Moodle theme_bootstrap.
 */

module.exports = function(grunt) {

    var lessfiles = {
    };

    // Project tasks config.
    grunt.initConfig({
        less: {
            dev: {
                files: {
                    "style/moodle.css": "less/moodle.less",
                    "style/editor.css": "less/editor.less"
                }
            },
            dist: {
                options: {
                    compress: true
                },
                files: {
                    "style/moodle.min.css": "less/moodle.less",
                    "style/editor.min.css": "less/editor.less"
                }
            }
        }
    });

    // Load contrib tasks.
    grunt.loadNpmTasks('grunt-contrib-less');

    // Register tasks.
    grunt.registerTask('default', ['less:dev']);
};
