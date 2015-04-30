# grunt-css-flip

[![NPM version](https://badge.fury.io/js/grunt-css-flip.svg)](http://badge.fury.io/js/grunt-css-flip)
[![Build Status](https://travis-ci.org/twbs/grunt-css-flip.svg?branch=master)](https://travis-ci.org/twbs/grunt-css-flip)
[![Dependency Status](https://david-dm.org/twbs/grunt-css-flip.svg?theme=shields.io)](https://david-dm.org/twbs/grunt-css-flip)
[![devDependency Status](https://david-dm.org/twbs/grunt-css-flip/dev-status.svg?theme=shields.io)](https://david-dm.org/twbs/grunt-css-flip#info=devDependencies)

> Grunt plugin for [Twitter's css-flip](https://github.com/twitter/css-flip)

## Getting Started

This plugin requires Grunt `~0.4.3`.

If you haven't used [Grunt](http://gruntjs.com/) before, be sure to check out the [Getting Started](http://gruntjs.com/getting-started) guide, as it explains how to create a [Gruntfile](http://gruntjs.com/sample-gruntfile) as well as install and use Grunt plugins. Once you're familiar with that process, you may install this plugin with this command:

```shell
npm install grunt-css-flip --save-dev
```

Once the plugin has been installed, it may be enabled inside your Gruntfile with this line of JavaScript:

```js
grunt.loadNpmTasks('grunt-css-flip');
```

Alternatively, you could instead use [load-grunt-tasks](https://github.com/sindresorhus/load-grunt-tasks) to load this and other Grunt tasks.

## The "cssflip" task

### Overview
In your project's Gruntfile, add a section named `cssflip` to the data object passed into `grunt.initConfig()`.

```js
grunt.initConfig({
  cssflip: {
    your_target: {
      // Target-specific file lists and/or options go here.
      options: {
        ...
      },
      files: ...
    }
  }
});
```

### Options

All options are passed directly to css-flip's `flip()` function.
None of the options are required.

#### options.compress
Type: `Boolean`
Default value: `false`

Whether to slightly compress output. Some newlines and indentation are removed. Comments stay intact.

#### options.indent
Type: `String`
Default value: `'  '` (two spaces)

String value to use for 1 level of indentation in the output.

### Usage Examples

#### Default Options
In this example, two CSS files are flipped using css-flip's default settings.

```js
grunt.initConfig({
  cssflip: {
    my_target: {
      options: {},
      files: {
        'flipped-one.css': 'original-one.css',
        'flipped-two.css': 'original-two.css'
      }
    }
  }
});
```

#### Custom Options
In this example, the resulting flipped CSS files will also be slightly compressed using css-flip's `compress` option.

```js
grunt.initConfig({
  cssflip: {
    my_target: {
      options: {
        compress: true
      },
      files: {
        'flipped-one.min.css': 'original-one.css',
        'flipped-two.min.css': 'original-two.css'
      }
    }
  }
});
```

## Contributing
The project's coding style is laid out in the JSHint and JSCS configurations. Add unit tests for any new or changed functionality. Lint and test your code using [Grunt](http://gruntjs.com/).

## License and copyright

Released under the MIT license. Copyright Chris Rebert 2014.

## Release History
* v0.4.0 (2014-07-16)
  * **bump css-flip to `~0.5.0`**
  * **bump grunt to `~0.4.5`**
  * upgrade from grunt-jscs-checker `~0.4.4` to grunt-jscs `~0.6.1`
  * bump load-grunt-tasks to `~0.6.0`
* v0.3.0 (2014-05-23)
  * **Bump `css-flip` to `~0.4.0`.**
  * Bump `devDependencies`.
  * Fix examples in README.
* v0.2.2 (2014-05-03)
  * Add missing spaces before parameter lists in function expressions.
  * Simplify `license` field in `package.json`.
  * Bump `grunt-contrib-jshint` to `~0.10.0`.
  * Bump `grunt-jscs-checker` to `~0.4.2`.
  * Remove obsolete JSHint options in favor of JSCS.
* v0.2.1 (2014-03-13)
  * Fix required Grunt version mentioned in README.
  * Update dependencies and sort them by name.
  * Remove extra commas from JS & docs examples; (mostly due to `grunt-init gruntplugin`)
  * Enforce Unix-style newlines via `.gitattributes.`
  * Use the shields.io theme for the dependency badges.
* v0.2.0 (2014-03-12): Fix/address all outstanding issues. **Backwards-incompatible**.
  * **Changed name of task from `css_flip` to `cssflip`.**
  * **Bumped Grunt dependency to v0.4.3.**
  * Bumped & tightened-up devDependencies.
* v0.1.0 (2014-03-06): Initial public release.
