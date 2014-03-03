/**
 * Gruntfile for compiling theme_bootstrap .less files.
 *
 * This file configures tasks to be run by Grunt
 * http://gruntjs.com/ for the current theme.
 *
 *
 * Requirements:
 * -------------
 * nodejs, npm, grunt-cli.
 *
 * Installation:
 * -------------
 * node and npm: instructions at http://nodejs.org/
 *
 * grunt-cli: `[sudo] npm install -g grunt-cli`
 *
 * node dependencies: run `npm install` in the root directory.
 *
 *
 * Usage:
 * ------
 * Call tasks from the theme root directory. Default behaviour
 * (calling only `grunt`) is to run the watch task detailed below.
 *
 *
 * Porcelain tasks:
 * ----------------
 * The nice user interface intended for everyday use. Provide a
 * high level of automation and convenience for specific use-cases.
 *
 * grunt watch   Watch the less directory (and all subdirectories)
 *               for changes to *.less files then on detection
 *               recompile all less files and clear the theme cache.
 *
 *               Options:
 *
 *               --dirroot=<path>  Optional. Explicitly define the
 *                                 path to your Moodle root directory
 *                                 when your theme is not in the
 *                                 standard location.
 *
 * grunt swatch  Task for working with bootswatch files. Expects a
 *               convention to be followed - bootswatch files are
 *               contained within a directory providing the name
 *               by which the swatch is identified. By default the
 *               directory these should be placed in is less/bootswatch
 *               however the user may optionally override this.
 *               e.g. swatch files contained within a directory
 *               located at less/bootswatch/squib will be associated
 *               with the swatch name 'squib'.
 *
 *               Switches the current bootswatch files compiled with
 *               the theme to those of a given bootswatch, recompiles
 *               less and clears the theme cache.
 *
 *               Options:
 *
 *               --name=<swatchname>    Required. Name (as defined by
 *                                      the convention) of the swatch
 *                                      to activate.
 *
 *               --swatches-dir=<path>  Optional. Explicitly define
 *                                      the path to the directory
 *                                      containing your bootswatches
 *                                      (default is less/bootswatch).
 *
 *               --vars-only            Optional. Copy the swatch's
 *                                      variables.less file only
 *                                      and empty custom-bootswatch.less
 *                                      Due to issues with grunt's
 *                                      handling of boolean options
 *                                      if not explicitly set e.g.
 *                                      `--vars-only=true` this option
 *                                      should be passed last.
 *
 *
 *
 * Plumbing tasks & targets:
 * -------------------------
 * Lower level tasks encapsulating a specific piece of functionality
 * but usually only useful when called in combination with another.
 *
 * grunt lessc           Compile and compress all less files.
 *
 * grunt lessc:moodlec   Compile and compress Moodle less files only.
 *
 * grunt lessc:editorc   Compile and compress editor less files only.
 *
 * grunt lessc           Compile and source map all less files.
 *
 * grunt lesssm:moodlesm Compile and source map Moodle less files only.
 *
 * grunt lesssm:editorsm Compile and source map editor less files only.
 *
 * grunt decache         Clears the Moodle theme cache.
 *
 *                       Options:
 *
 *                       --dirroot=<path>  Optional. Explicitly define
 *                                         the path to your Moodle root
 *                                            directory when your theme is
 *                                         not in the standard location.
 *
 * grunt bootswatch     Switch the theme less/bootswatch/custom-bootswatch.
 *                      less and less/bootswatch/custom-variables.less
 *                      files for those of a given bootswatch theme using
 *                      convention described in swatch task.
 *
 *                      Options:
 *
 *                      --name=<swatchname>    Required. Name (as defined by
 *                                             the convention) of the swatch
 *                                             to activate.
 *
 *                      --swatches-dir=<path>  Optional. Explicitly define
 *                                             the path to the directory
 *                                             containing your bootswatches
 *                                             (default is less/bootswatch).
 *
 *                      --vars-only            Optional. Copy the swatch's
 *                                             variables.less file only
 *                                             and empty custom-bootswatch.less
 *                                             Due to issues with grunt's
 *                                             handling of boolean options
 *                                             if not explicitly set e.g.
 *                                             `--vars-only=true` this option
 *                                             should be passed last.
 *
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
            // Compile and source map for moodle styles.
            moodlesm: {
                options: {
                    compress: false,
                    sourceMap: true,
                    outputSourceFiles: true
                },
                files: {
                    "style/moodle.css": "less/moodle.less",
                }
            },
            // Compile and compress moodle styles.
            moodlec: {
                options: {
                    compress: true
                },
                files: {
                    "style/moodle.css": "less/moodle.less",
                }
            },
            // Compile and source map for editor styles.
            editorsm: {
                options: {
                    compress: false,
                    sourceMap: true,
                    outputSourceFiles: true
                },
                files: {
                    "style/editor.css": "less/editor.less"
                }
            },
            // Compile and compress editor styles.
            editorc: {
                options: {
                    compress: true
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
            tasks: ["less:moodlec", "less:editorc", "exec:decache"],
            options: {
                spawn: false
            }
        }
    });

    // Local task functions.
    var _bootswatch = function() {

        var swatchname = grunt.option('name') || '',
            swatchroot = grunt.option('swatches-dir') || '',
            varsonly   = grunt.option('vars-only');

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
            message += 'does not exist or is not accessible.';
            grunt.fail.fatal(message);
        }

        // Ensure the bootswatch.less file exists.
        if (!varsonly) {
            if (!grunt.file.isFile(swatchless)) {
                message = "The required file '" + swatchless + "' ";
                message += 'does not exist or is not accessible.';
                grunt.fail.fatal(message);
            }
        } else {
            grunt.file.write(BOOTSWATCHFILE, '');
        }

        // Ensure the variables.less file exists.
        if (!grunt.file.isFile(varsless)) {
            message = "The required file '" + varsless + "' ";
            message += 'does not exist or is not accessible.';
            grunt.fail.fatal(message);
        }

        // Copy in new swatch files.
        if (!varsonly) {
            grunt.file.copy(swatchless, BOOTSWATCHFILE);
        }
        grunt.file.copy(varsless, BOOTSWATCHVARS);
        grunt.log.writeln('Swatch copied.');

    };

    // Load contrib tasks.
    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-exec");

    // Register tasks.
    grunt.registerTask("default", ["watch"]);
    grunt.registerTask("decache", ["exec:decache"]);
    grunt.registerTask("lessc", ["less:moodlec", "less:editorc"]);
    grunt.registerTask("lesssm", ["less:moodlesm", "less:editorsm"]);

    grunt.registerTask("bootswatch", _bootswatch);
    grunt.registerTask("swatch", ["bootswatch", "less", "exec:decache"]);
};
