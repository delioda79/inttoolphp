Integrity Tool

The project contains a:
"src" folder with source code

"spec" folder with tests

"vendor" folder with phpspec and its dependencies (provided here at the moment but you should just use composer to perform installation)

"bin" folder with phpspec and integrity-tool

In order to run the tests, after the dependencies are installed, run
path/to/phpspec run

In order to use the software run

path/to/integrity/bin/integrity-tool
It has a shebang pointing to "/usr/bin/env php" however if this is not your settings you can just run: php path/to/integrity/bin/integrity-tool and it should run without problems