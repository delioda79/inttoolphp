Integrity Tool

The project contains a:
"src" folder with source code

"spec" folder with tests

"vendor" folder with phpspec and its dependencies

"bin" folder with phpspec and integrity-tool

The tool is ready to run, however in order to run the tests it is needed to
install phpspec, this can be achieved from the project main folder typing:

php composer.phar install

This will install phpspec and its dependencies. The phpspec tool will be available in the bin folder after the installation.

In order to run the tests, after the dependencies are installed, run
path/to/phpspec run

In order to use the software run

path/to/integrity/bin/integrity-tool
It has a shebang pointing to "/usr/bin/env php" however if this is not your settings you can just run: php path/to/integrity/bin/integrity-tool and it should run without problems