#!/bin/bash

if [ $# -eq 0 ]; then
	echo 'Usage: `./deploy-to-svn.sh <tag>`'
	exit 1
fi

# GIT_DIR=$(dirname "$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )" )
GIT_DIR=$(pwd)
SVN_DIR="/tmp/run-route"
TAG=$1

# Make sure we're trying to deploy something that's been tagged. Don't deploy non-tagged.
if [ -z $( git tag | grep "^$TAG$" ) ]; then
	echo "Tag $TAG not found in git repository."
	echo "Please try again with a valid tag."
	exit 1
fi

# Make sure we don't have uncommitted changes.
if [[ -n $( git status -s --porcelain ) ]]; then
	echo "Uncommitted changes found."
	echo "Please deal with them and try again clean."
	exit 1
fi

git checkout $TAG

# Prep a home to drop our new files in. Just make it in /tmp so we can start fresh each time.
rm -rf $SVN_DIR

echo "Checking out SVN shallowly to $SVN_DIR"
svn checkout http://plugins.svn.wordpress.org/run-route/ --depth=empty $SVN_DIR
echo "Done!"

cd $SVN_DIR

echo "Checking out SVN trunk to $SVN_DIR/trunk"
svn up trunk
echo "Done!"

echo "Checking out SVN tags shallowly to $SVN_DIR/tags"
svn up tags --depth=empty
echo "Done!"

echo "Deleting everything in trunk except for .svn directories"
for file in $(find $SVN_DIR/trunk/* -not -path "*.svn*"); do
	rm $file 2>/dev/null
done
echo "Done!"

echo "Copying everything over from Git"
cp -r $GIT_DIR/* $SVN_DIR/trunk
echo "Done!"

echo "Purging paths included in .svnignore"
for file in $( cat "$GIT_DIR/.svnignore" 2>/dev/null ); do
	rm -rf $SVN_DIR/trunk/$file
done
echo "Done!"

# Tag the release in svn
svn cp trunk tags/$TAG

# Commit to svn
# svn ci -m "Release $TAG"
echo Now go to $SVN_DIR and type svn ci -m \"Release $TAG\"