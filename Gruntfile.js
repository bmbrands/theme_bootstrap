/**
 * Gruntfile for compiling theme_bootstrap .less files.
 *
 * This file configures tasks to be run by Grunt
 * http://gruntjs.com/ for the current theme.
 *
 * Requirements:
 * nodejs, npm, grunt-cli.
 *
 * Installation:
 * node and npm: instructions at http://nodejs.org/
 * grunt-cli: `[sudo] npm install -g grunt-cli`
 * node dependencies: run `npm install` in the root directory.
 *
 * Usage:
 * Default behaviour is to watch all .less files and compile
 * into compressed CSS when a change is detected to any and then
 * clear the theme's caches. Invoke either `grunt` or `grunt watch`
 * in the theme's root directory.
 *
 * To separately compile only moodle or editor .less files
 * run `grunt less:moodle` or `grunt less:editor` respectively.
 *
 * To only clear the theme caches invoke `grunt decache` in the
 * theme's root directory.
 *
 * Options:
 * The following command-line options can be passed in conjunction
 * with calls to grunt:
 *
 * --dirroot=<path>   Explicitly define the path to your Moodle
 *                    root directory when your theme is not in the
 *                    standard location. Necessary for tasks which
 *                    clear the theme cache.
 *
 * @package theme
 * @subpackage bootstrap
 * @author Joby Harding www.iamjoby.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

module.exports = function(grunt) {

    // Import modules.
    var path = require('path');

    // Theme Bootstrap constants.
    var LESSDIR         = 'less',
        BOOTSWATCHDIR   = path.join(LESSDIR, 'bootswatch'),
        BOOTSWATCHFILE  = path.join(BOOTSWATCHDIR, 'custom-bootswatch.less'),
        BOOTSWATCHVARS  = path.join(BOOTSWATCHDIR, 'custom-variables.less');

    // PHP strings for exec task.
    var moodleroot = 'dirname(dirname(__DIR__))',
        configfile = '',
        decachephp = '',
        dirrootopt = grunt.option('dirroot') || '';

    // Allow user to explicitly define Moodle root dir.
    if ('' !== dirrootopt) {
        moodleroot = 'realpath("' + dirrootopt + '")';
    }

    configfile = moodleroot + ' . "/config.php"';

    decachephp += "define(\"CLI_SCRIPT\", true);";
    decachephp += "require(" + configfile  + ");";
    decachephp += "theme_reset_all_caches();";

    grunt.initConfig({
        less: {
            // Compile moodle styles.
            moodle: {
                options: {
                    compress: true,
                    sourceMap: false,
                    outputSourceFiles: true
                },
                files: {
                    "style/moodle.css": "less/moodle.less",
                }
            },
            // Compile editor styles.
            editor: {
                options: {
                    compress: true,
                    sourceMap: false,
                    outputSourceFiles: true
                },
                files: {
                    "style/editor.css": "less/editor.less"
                }
            }
        },
        exec: {
            decache: {
                cmd: "php -r '" + decachephp + "'",
                callback: function(error, stdout, stderror) {
                    // exec will output error messages
                    // just add one to confirm success.
                    if (!error) {
                        grunt.log.writeln("Moodle theme cache reset.");
                    }
                }
            }
        },
        watch: {
            // Watch for any changes to less files and compile.
            files: ["less/**/*.less"],
            tasks: ["less:moodle", "less:editor", "exec:decache"],
            options: {
                spawn: false
            }
        }
    });

    // Local task functions.
    var _bootswatch = function() {

        var swatchname = grunt.option('name') || '',
            swatchroot = grunt.option('swatches-dir') || '';

        // Required option.
        if ('' === swatchname) {
            grunt.fail.fatal('You must provide a swatch name.');
        }

        var swatchpath = path.join(BOOTSWATCHDIR, swatchname);

        // Allow user to explicitly define source swatches dir.
        if ('' !== swatchroot) {
           swatchpath = path.resolve(swatchroot);
           swatchpath = path.join(swatchpath, swatchname);
        }

        var swatchless = path.join(swatchpath, 'bootswatch.less'),
            varsless   = path.join(swatchpath, 'variables.less'),
            message    = '';

        // Ensure the swatch directory exists.
        if (!grunt.file.isDir(swatchpath)) {
            message = "The swatch directory '" + swatchpath + "' ";
            message += 'does not exist.';
            grunt.fail.fatal(message);
        }

        // Ensure the bootswatch.less file exists.
        if (!grunt.file.isFile(swatchless)) {
            message = "The required file '" + swatchless + "' ";
            message += 'does not exist or is not accessible.';
            grunt.fail.fatal(message);
        }

        // Ensure the variables.less file exists.
        if (!grunt.file.isFile(varsless)) {
            message = "The required file '" + varsless + "' ";
            message += 'does not exist or is not accessible.';
            grunt.fail.fatal(message);
        }

        // Copy in new swatch files.
        grunt.file.copy(swatchless, BOOTSWATCHFILE);
        grunt.file.copy(varsless, BOOTSWATCHVARS);
        grunt.log.writeln('Swatch files copied.');

    };

    // Load contrib tasks.
    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-exec");

    // Register tasks.
    grunt.registerTask("default", ["watch"]);
    grunt.registerTask("decache", ["exec:decache"]);

    grunt.registerTask("bootswatch", _bootswatch);
    grunt.registerTask("swatch", ["bootswatch", "less", "exec:decache"]);
};
