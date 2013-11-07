/**
 * Gruntfile for Moodle theme_bootstrap.
 */

module.exports = function(grunt) {

    grunt.initConfig({
        less: {
            // Compile moodle styles.
            moodle: {
                options: {
                    compress: true
                },
                files: {
                    "style/moodle.css": "less/moodle.less",
                }
            },
            // Compile editor styles.
            editor: {
                options: {
                    compress: true
                },
                files: {
                    "style/editor.css": "less/editor.less"
                }
            }
        },
        watch: {
            // Watch for any changes to less files and compile.
            files: ["less/**/*.less"],
            tasks: ['less:moodle', 'less:editor'],
            options: {
                spawn: false
            }
        }
    });

    // Load contrib tasks.
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Register tasks.
    grunt.registerTask('default', ['watch']);
};
