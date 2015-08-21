<?php

/**
 * BashColor.php.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    overtrue <i@overtrue.me>
 * @copyright 2015 overtrue <i@overtrue.me>
 *
 * @link      https://github.com/overtrue
 * @link      http://overtrue.me
 * @link      https://github.com/overtrue/colorization
 */

namespace Overtrue\BashColor;

/**
 * Class BashColor.
 */
class BashColor
{
    /**
     * Options.
     *
     * @var array
     */
    private static $options = array(
        'none' => 0, // reset/remove all option
        'bold' => 1, // bold/bright
        'bright' => 1, // bold/bright
        'dim' => 2, // dim
        'underlined' => 4, // underlined
        'blink' => 5, // blink
        'reverse' => 7, // reverse/invert
        'invert' => 7, // reverse/invert
        'hidden' => 8, // hidden
    );

    /**
     * Foreground colors.
     *
     * @var array
     */
    private static $foregroundColors = array(
        'default' => 39, // default (usually green, white or light gray)
        'black' => 30, // black
        'red' => 31, // red (don't use with green background)
        'green' => 32, // green
        'yellow' => 33, // yellow
        'blue' => 34, // blue
        'magenta' => 35, // magenta/purple
        'purple' => 35, // magenta/purple
        'cyan' => 36, // cyan
        'light_gray' => 37, // light gray
        'dark_gray' => 90, // dark gray
        'light_red' => 91, // light red
        'light_green' => 92, // light green
        'light_yellow' => 93, // light yellow
        'light_blue' => 94, // light blue
        'light_magenta' => 95, // light magenta/pink
        'light_pink' => 95, // light magenta/pink
        'light_cyan' => 96, // light cyan
        'white' => 97, // white
    );

    /**
     * Backgound colors.
     *
     * @var array
     */
    private static $backgroundColors = array(
        'default' => 49,  // Default background color (usually black or blue)
        'black' => 40,  // Black
        'red' => 41,  // Red
        'green' => 42,  // Green
        'yellow' => 43,  // Yellow
        'blue' => 44,  // Blue
        'magenta' => 45,  // Magenta/Purple
        'cyan' => 46,  // Cyan
        'light_gray' => 47,  // Light Gray (don't use with white foreground)
        'dark_gray' => 100, // Dark Gray (don't use with black foreground)
        'light_red' => 101, // Light Red
        'light_green' => 102, // Light Green (don't use with white foreground)
        'light_yellow' => 103, // Light Yellow (don't use with white foreground)
        'light_blue' => 104, // Light Blue (don't use with light yellow foreground)
        'light_magenta' => 105, // Light Magenta/Pink (don't use with light foreground)
        'light_cyan' => 106, // Light Cyan (don't use with white foreground)
        'white' => 107, // White (don't use with light foreground)
    );

    /**
     * Return colorized string.
     *
     * @param string $string
     * @param string $foreground
     * @param string $background
     * @param int    $option
     *
     * @return string
     */
    public static function render($string)
    {
        // for PHP 5.3
        function parseAttributes($attributesString)
        {
            return self::parseAttributes($attributesString);
        }

        return preg_replace_callback('~<(?<attributes>[a-z_;A-Z=\s]+)>(?<string>.*?)</>~',
            function ($matches) {
                if (empty($matches['attributes'])) {
                    return $matches['string'];
                }

                list($foreground, $background, $option, $endModifier) = parseAttributes($matches['attributes']);

                return "\033[{$option};{$background};{$foreground}m{$matches['string']}\033[{$endModifier}m";
            }, $string);
    }

    /**
     * Parse attributes.
     *
     * @param string $attributesString
     *
     * @return array
     */
    protected static function parseAttributes($attributesString)
    {
        $attributes = array(
            'fg' => 'default',
            'bg' => 'default',
            'opt' => 'none',
        );

        foreach (explode(';', $attributesString) as $attribute) {
            $temp = explode('=', $attribute);

            if (count($temp) < 2) {
                continue;
            }

            $attributes[trim($temp[0])] = self::snakeCase(trim($temp[1]));
        }

        !empty(self::$foregroundColors[$attributes['fg']]) || $attributes['fg'] = 'default';
        !empty(self::$backgroundColors[$attributes['bg']]) || $attributes['bg'] = 'default';
        !empty(self::$options[$attributes['opt']]) || $attributes['opt'] = 'none';

        $foreground = self::$foregroundColors[$attributes['fg']];
        $background = self::$backgroundColors[$attributes['bg']];
        $option = self::$options[$attributes['opt']];
        $endModifier = $option ? 20 + $option : $option;

        return array($foreground, $background, $option, $endModifier);
    }

    /**
     * Snake case.
     *
     * @param string $string
     *
     * @return string
     */
    public static function snakeCase($string)
    {
        return preg_replace_callback('/([A-Z])/', function ($matches) {
            return '_'.strtolower($matches[1]);
        }, lcfirst($string));
    }

    /**
     * Returns all foreground color names.
     *
     * @return array
     */
    public static function getForegroundColors()
    {
        return array_keys(self::$foregroundColors);
    }

    /**
     * Returns all background color names.
     *
     * @return array
     */
    public static function getBackgroundColors()
    {
        return array_keys(self::$backgroundColors);
    }
}
