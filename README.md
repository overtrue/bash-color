# BashColor
Generate command line colorized text. 给命令行文字添加前景/背景色、以及修饰效果。

[![Build Status](https://travis-ci.org/overtrue/bash-color.svg?branch=master)](https://travis-ci.org/overtrue/bash-color)
[![Latest Stable Version](https://poser.pugx.org/overtrue/bash-color/v/stable.svg)](https://packagist.org/packages/overtrue/bash-color)
[![Latest Unstable Version](https://poser.pugx.org/overtrue/bash-color/v/unstable.svg)](https://packagist.org/packages/overtrue/bash-color)
[![Code Coverage](https://scrutinizer-ci.com/g/overtrue/bash-color/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/overtrue/bash-color/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/overtrue/bash-color/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/overtrue/bash-color/?branch=master)
[![Total Downloads](https://poser.pugx.org/overtrue/bash-color/downloads)](https://packagist.org/packages/overtrue/bash-color)
[![License](https://poser.pugx.org/overtrue/bash-color/license)](https://packagist.org/packages/overtrue/bash-color)

# Installing

```shell
$ composer require "overtrue/bash-color"
```

# Usage

```php
use Overtrue\BashColor\BashColor;

echo BashColor::render('<fg=green>Are you sure ?</><fg=yellow> [Y/n]:</>'), "\n";
echo BashColor::render('<bg=purple;>hello world!</>'), "\n";
echo BashColor::render('<fg=green;opt=bold>yes!</>'), "\n";
echo BashColor::render('<fg=cyan;opt=bold;bg=red>ugly!</>'), "\n";

```
result:

![qq20150822-1 2x](https://cloud.githubusercontent.com/assets/1472352/9413936/9decd54a-4867-11e5-8d0b-1d27da954cc3.jpg)

### Attributes

- `fg` foreground color.
- `bg` background color.
- `opt` option.

### foreground

```
'default'       // Default (usually green, white or light gray)
'black'         // Black
'red'           // Red (don't use with green background)
'green'         // Green
'yellow'        // Yellow
'blue'          // Blue
'magenta'       // Magenta/Purple
'purple'        // Magenta/Purple
'cyan'          // Cyan
'light_gray'    // Light Gray
'dark_gray'     // Dark Gray
'light_red'     // Light Red
'light_green'   // Light Green
'light_yellow'  // Light Yellow
'light_blue'    // Light Blue
'light_magenta' // Light Magenta/pink
'light_pink'    // Light Magenta/pink
'light_cyan'    // Light Cyan
'white'         // White
```
### background

```
'default'       // Default background color (usually black or blue)
'black'         // Black
'red'           // Red
'green'         // Green
'yellow'        // Yellow
'blue'          // Blue
'magenta'       // Magenta/Purple
'PURPLE'        // Magenta/Purple
'cyan'          // Cyan
'light_gray'    // Light Gray (don't use with white foreground)
'dark_gray'     // Dark Gray (don't use with black foreground)
'light_red'     // Light Red
'light_green'   // Light Green (don't use with white foreground)
'light_yellow'  // Light Yellow (don't use with white foreground)
'light_blue'    // Light Blue (don't use with light yellow foreground)
'light_magenta' // Light Magenta/Pink (don't use with light foreground)
'light_cyan'    // Light Cyan (don't use with white foreground)
'white'         // White (don't use with light foreground)
```

### options

```
'none'       // Reset/Remove all option
'bold'       // Bold/Bright
'bright'     // Bold/Bright
'dim'        // Dim
'underlined' // Underlined
'blink'      // Blink
'reverse'    // Reverse/invert
'invert'     // Reverse/invert
'hidden'     // Hidden
```

# Reference

[Bash tips: Colors and formatting](http://misc.flogisoft.com/bash/tip_colors_and_formatting)

## PHP 扩展包开发

> 想知道如何从零开始构建 PHP 扩展包？
>
> 请关注我的实战课程，我会在此课程中分享一些扩展开发经验 —— [《PHP 扩展包实战教程 - 从入门到发布》](https://learnku.com/courses/creating-package)

# License

MIT
