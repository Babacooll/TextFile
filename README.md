TextFile
=========

[![Build Status](https://travis-ci.org/Babacooll/TextFile.svg?branch=master)](https://travis-ci.org/Babacooll/TextFile)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Babacooll/TextFile/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Babacooll/TextFile/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Babacooll/TextFile/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Babacooll/TextFile/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Babacooll/TextFile/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Babacooll/TextFile/build-status/master)


## Introduction

This library eases manipulation of text files in PHP by providing multiple methods to read / parse / write text files.

## Installation

```bash
composer install michaelgarrez/text-file
```

## Basics

### Opening a file

```php
<?php

$textFile = new TextFile('text_file.txt');
```

If *text_file.txt* file exists it will be opened otherwise it will be created.

## Walking

### WalkerInterface

All walking related operations are done by an instance of *WalkerInterface* (by default *SimpleWalker*). 
All following methods take an optional class that implements *WalkerInterface* to override the *SimpleWalker*.

### Use

```php
<?php

$textFile = new TextFile('text_file.txt');

// Move to a specific line

$textFile->goToLine(5); // This does not return the line content (See Reading).

// Count lines

$count = $textFile->countLines(5);

// Move before a specific character

$textFile->goBeforeCharacter(5); // This does not return the line content (See Reading).
```

## Reading

### ReadingInterface

All reading related operations are done by an instance of *ReaderInterface* (by default *ReaderWalker*). 

*ReaderInterface* implementation needs a *WalkerInterface* implementation to work.

All following methods take two optional parameters :
- class that implements *ReaderInterface* to override the *SimpleReader*.
- class that implements *WalkerInterface* to override the *SimpleWalker*.

### Use

All those methods reset the pointer to its previous position. In other words it **does not move the internal pointer**.

```php
<?php

$textFile = new TextFile('text_file.txt');

// Getting lines range

$iterator = $textFile->getLinesRange(0, 5); // Returns an Iterator containing line content from a line to another

$textFile->goToLine(4);

// Getting current line content

$content = $textFile->getCurrentLineContent(); // Returns content of line 4

// Getting next line content

$content = $textFile->getNextLineContent(); // Returns content of line 5

// Getting previous line content

$content = $textFile->getPreviousLineContent(); // Returns content of line 3

// Getting specific line content

$content = $textFile->getLineContent(6); // Returns content of line 6

// Getting next character content

$character = $textFile->getNextCharacterContent(); // Returns next character after pointer position

// Getting previous character content

$character = $textFile->getNextCharacterContent(); // Returns previous character after pointer position

// Getting specific character content

$character = $textFile->getCharacterContent(7); // Returns 7 character from beginning of file
```

## Writing

### WritingInterface

All walking related operations are done by an instance of *WriterInterface* (by default *PrependingWriter* which will not erase while writing). 

Another writer available is *ErasingWriter* which will erase the content while writing (same behaviour as *Insert* keyboard).

All following methods take an optional class that implements *WriterInterface* to override the *PrependingWriter*.

### Use 

```php
<?php

$textFile = new TextFile('text_file.txt');

// Write without erasing without return line break at the end

$textFile->write('test');

// Write without erasing with return line break at the end

$textFile->write('test', true);

// Write with erasing without return line break at the end

$textFile->write('test', false, TextFile\Writer::class);

// Write with erasing with return line break at the end

$textFile->write('test', true, TextFile\Writer::class);
