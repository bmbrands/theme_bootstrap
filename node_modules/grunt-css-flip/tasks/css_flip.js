/*
 * grunt-css-flip
 * https://github.com/twbs/grunt-css-flip
 *
 * Copyright (c) 2014 Chris Rebert
 * Licensed under the MIT License.
 */

'use strict';

var flip = require('css-flip');


module.exports = function (grunt) {
  grunt.registerMultiTask('cssflip', "Grunt plugin for Twitter's css-flip", function () {
    var options = this.options({});

    this.files.forEach(function (f) {
      var originalCss = grunt.file.read(f.src);

      var flippedCss = null;
      try {
        flippedCss = flip(originalCss, options);
      }
      catch (err) {
        grunt.fail.warn(err);
      }

      grunt.file.write(f.dest, flippedCss);

      grunt.log.writeln('File "' + f.dest.cyan + '" created.');
    });
  });
};
