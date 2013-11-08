/**
 * Gruntfile for compiling theme_bootstrap .less files.
 *
 * Requirements: nodejs, npm, grunt-cli.
 *
 * Installation:
 * node and npm: instructions at http://nodejs.org/
 * grunt-cli: `[sudo] npm install -g grunt-cli`
 * node dependencies: run `npm install` in the root directory.
 *
 * Usage:
 * Default behaviour is to watch all .less files and compile
 * into compressed CSS when a change is detected to any. Invoke
 * either `grunt` or `grunt watch` in the theme's root directory.
 *
 * To separately compile only moodle or editor .less files
 * run `grunt less:moodle` or `grunt less:editor` respectively.
 *
 * @package Moodle Bootstrap theme
 * @author Joby Harding www.iamjoby.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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
