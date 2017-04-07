# PHP Coding Tasks

The repository is home to the following coding tasks.

* Flatten an Arbitrarily Nested Integer Array
* Morsecode Translator and Obfuscator

Both tasks consist of PHP files and their respective tests.

The Morsecode component has an additional PHP file called `stdin.php` that takes input in the form of plain text 
or a file path from `STDIN`. `stdin.php` does not have an associated test file.

## Getting Started

To get started clone the Github repository on your development machine and refer to the _Installation_ instructions 
in this document.

### Prerequisites

* `PHP 5.6.11` - Please note that I did NOT test in any other version of PHP
* Composer `1.2.1`

### Installation

Use [Composer](https://getcomposer.org/) to install project dependencies. All dependencies are defined in the 
`composer.json` file.

Install dependencies:
```
composer install
```

### Running Scripts

The Morsecode Translator and Obfuscator has an additional PHP script that can be invoked through the PHP CLI. 
It takes input in the form of plain text or a file path from `STDIN`.

Run the script:
```
php src/stdin.php
```
When running the script you will be prompted to enter `1` or `2` depending on the type of input you desired to provide.
`1` is for plain text input and `2` is for file input.

Prompt
![](https://github.com/bjorntheart/php-coding-task/screenshots/prompt.png)

Both options has the ability to accept an arbitrarily amount of input parameters. 

To translate an arbitrary amount of input, follow these instructions:

**Plain text input** - For the plain text input, run the `src/stdin.php` script and follow the on screen instructions

Prompt for plain text input
![](https://github.com/bjorntheart/php-coding-task/screenshots/prompt-answer-text-input.png)

Prompt to parse another plain text input
![](https://github.com/bjorntheart/php-coding-task/screenshots/prompt-answer-text-input-more.png)

**File input** - For file input, add additional lines of plain text to `src/input.txt` and run the `src/stdin.php` script. Then choose 
option `2` for file input. The program will read all the lines from the `src/input.txt` file and parse it.

Prompt for file input
![](https://github.com/bjorntheart/php-coding-task/screenshots/promt-answer-file-input.png)

### Running Tests

#### Overview

There are tests for both components of the coding task and are written in [phpspec](http://www.phpspec.net/en/stable/).

#### Flatten an Arbitrarily Nested Integer Array

The Flatten an Arbitrarily Nested Integer Array has one test file.

It is located here:

* _spec/ArrayHelperSpec.php_
 
 Run the tests:
 ```
 bin/phpspec run spec/ArrayHelperSpec.php
 ```

#### Morsecode Translator and Obfuscator

The Morsecode Translator and Obfuscator has 2 sets of tests.

They are located here:

* _spec/MorseCodeTranslatorSpec.php_
* _spec/MorseCodeObfuscatorSpec.php_

Run the _MorseCodeTranslator_ tests:
```
bin/phpspec run spec/MorseCodeTranslatorSpec.php
```

Run the _MorseCodeObfuscator_ tests:
```
bin/phpspec run spec/MorseCodeObfuscatorSpec.php
```

#### All tests

Run _all_ tests:
```
bin/phpspec run
```

## Authors

* **Bjorn Theart**

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details