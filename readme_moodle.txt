Discription of Twitter bootstrap import into Moodle

Twitter bootstrap
-----------------
The bootstrap theme uses the original unmodified version 2.3.0 Twitter bootstrap less files. These are
Object Oriented CSS files. The bootstrap repository is available on:

https://github.com/twitter/bootstrap.git

To update to the latest release of twitter bootstrap:
* remove all files from less/bootstrap,
* download the new less files and store them in less/bootstrap
* regenerate files using recess: recess --compile --compress moodle.less > ../style/moodle.css **
* regenerate files using recess: recess --compile --compress editor.less > ../style/editor.css **
* update ./thirdpartylibs.xml

** If you want to make changes to the .css generated from these .less files then you
need to install recess (https://github.com/twitter/recess) to compile the .less files,
then run these commands in the bootstrapbase/less/ folder:


html5shiv.js
------------
This theme uses the original unmodified html5shiv.js JavaScript library to enable HTML5 tags in IE7 and IE8.
This library is available on:

https://github.com/aFarkas/html5shiv/blob/master/src/html5shiv.js

To update to the latest release of html5shiv:
* download and replace: javascript/html5shiv.js
* update ./thirdpartylibs.xml

