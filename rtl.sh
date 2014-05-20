#!/bin/sh

cp style/moodle-rtl.css rtl-wip.css

# remove all indentation
sed -i '' 's/^ *//' rtl-wip.css

# add .dir-rtl to the start of every selector
sed -i '' \
    -e '/,$/ s/^/.dir-rtl /' \
    -e '/ {$/ s/^/.dir-rtl /' \
    rtl-wip.css

# remove .dir-rtl from lines where it isn't appropriate e.g. @media queries 
sed -i '' \
    -e 's/^.dir-rtl @/@/' \
    -e 's/^.dir-rtl .dir-rtl/.dir-rtl/' \
    rtl-wip.css

# flip the order of .dir-rtl body and clean up duplicates
sed -i '' \
    -e 's/^.dir-rtl body/body.dir-rtl/' \
    -e 's/^body.dir-rtl.dir-rtl/body.dir-rtl/' \
    rtl-wip.css

# remove the space after .dir-rtl where the selector targets the body tag
sed -i '' \
    -e 's/^.dir-rtl .layout-option-/.dir-rtl.layout-option-/' \
    -e 's/^.dir-rtl .path-admin/.dir-rtl.path-admin/' \
    -e 's/^.dir-rtl .path-mod-/.dir-rtl.path-mod-/' \
    -e 's/^.dir-rtl #page-admin-/.dir-rtl#page-admin-/' \
    -e 's/^.dir-rtl #page-course-/.dir-rtl#page-course-/' \
    -e 's/^.dir-rtl #page-enrol-/.dir-rtl#page-enrol-/' \
    -e 's/^.dir-rtl #page-calendar-/.dir-rtl#page-calendar-/' \
    -e 's/^.dir-rtl #page-tag-/.dir-rtl#page-tag-/' \
    -e 's/^.dir-rtl #page-badges-/.dir-rtl#page-badges-/' \
    rtl-wip.css

# delete css rules that don't effect RTL
#sed -i '' \
    #-e '/^color: / d' \
    #-e '/font-family: / d' \
    #-e '/font-style: / d' \
    #-e '/font: / d' \
    #-e '/font-weight: / d' \
    #-e '/white-space: / d' \
    #-e '/word-break: / d' \
    #-e '/word-wrap: / d' \
    #-e '/font-size: / d' \
    #-e '/margin-bottom: / d' \
    #-e '/vertical-align: / d' \
    #-e '/position: / d' \
    #-e '/display: / d' \
    #-e '/visibility: / d' \
    #-e '/outline: / d' \
    #-e '/overflow: / d' \
    #-e '/overflow-x: / d' \
    #-e '/overflow-y: / d' \
    #-e '/opacity: / d' \
    #-e '/filter: / d' \
    #-e '/background-repeat: / d' \
    #-e '/background-size: / d' \
    #-e '/box-shadow: / d' \
    #-e '/box-sizing: / d' \
    #-e '/border-collapse: / d' \
    #-e '/border-spacing: / d' \
    #-e '/table-layout: / d' \
    #-e '/z-index: / d' \
    #-e '/height: / d' \
    #-e '/^top: / d' \
    #-e '/^bottom: / d' \
    #-e '/border-top-width: / d' \
    #-e '/border-bottom-width: / d' \
    #-e '/text-decoration: / d' \
    #-e '/text-transform: / d' \
    #-e '/text-shadow: / d' \
    #-e '/text-size-adjust: / d' \
    #-e '/letter-spacing: / d' \
    #-e '/page-break-inside: / d' \
    #-e '/orphans: / d' \
    #-e '/widows: / d' \
    #-e '/outline-offset: / d' \
    #-e '/user-select: / d' \
    #-e '/pointer-events: / d' \
    #-e '/cursor: / d' \
    #-e '/list-style: / d' \
    #-e '/list-style-type: / d' \
    #-e '/content: / d' \
    #-e '/^width: / d' \
    #-e '/^max-width: / d' \
    #-e '/^min-width: / d' \
    #rtl-wip.css

# each of the N; commands that follows will eat a line from the end of the file
# there's probably a way to avoid that, but I'm tired of fighting with Mac OS X's
# version of sed so I'll just pad the file with newlines instead.
echo "\n\n\n\n\n\n\n\n\n\n\n\n" >> rtl-wip.css

# mark rules where both left and right are set
# sed only seems to let you do this once per sed call
sed -i '' \
    -e 'N;/^padding-right:.*padding-left:/ s/\n/ /;P;D' \
    rtl-wip.css
sed -i '' \
    -e 'N;/^padding-left:.*padding-right:/ s/\n/ /;P;D' \
    rtl-wip.css
sed -i '' \
    -e 'N;/^margin-right:.*margin-left:/ s/\n/ /;P;D' \
    rtl-wip.css
sed -i '' \
    -e 'N;/^margin-left:.*margin-right:/ s/\n/ /;P;D' \
    rtl-wip.css
sed -i '' \
    -e 'N;/^left:.*\nright:/s/\n/ /;P;D' \
    rtl-wip.css
sed -i '' \
    -e 'N;/^right:.*\nleft:/s/\n/ /;P;D' \
    rtl-wip.css
sed -i '' \
    -e 'N;/^border-left:.*\nborder-right:/s/\n/ /;P;D' \
    rtl-wip.css
sed -i '' \
    -e 'N;/^border-right:.*\nborder-left:/s/\n/ /;P;D' \
    rtl-wip.css


# add a space to lines created above to avoid further processing
sed -i '' \
    -e '/^padding-right.*padding-left/ s/padding-/ padding-/' \
    -e '/^padding-left.*padding-right/ s/padding-/ padding-/' \
    -e '/^margin-right.*margin-left/ s/margin-/ margin-/' \
    -e '/^margin-left.*margin-right/ s/margin-/ margin-/' \
    -e '/^border-right.*border-left/ s/border-/ border-/' \
    -e '/^border-left.*border-right/ s/border-/ border-/' \
    -e '/^left:.*; right:/ s/left:/ left:/' \
    -e '/^right:.*; left:/ s/right:/ right:/' \
    rtl-wip.css

# reset single rules from the LTR Moodle CSS
sed -i '' \
    -e '/^left:/a \
    right: auto;' \
    -e '/^margin-left:/a \
    margin-right: auto;' \
    -e '/^padding-left:/a \
    padding-right: 0;' \
    -e '/^right:/a \
    left: auto;' \
    -e '/^margin-right:/a \
    margin-left: auto;' \
    -e '/^padding-right:/a \
    padding-left: 0;' \
    rtl-wip.css

# run the output through less, to delete empty selectors,
# catch syntax errors and format nicely
lessc rtl-wip.css > style/moodle-ltr-rtl.css

# generate some stats on the most common usages
awk '{ print $1 }' rtl-wip.css | sort | uniq -c | sort -r > rtl-count.txt

