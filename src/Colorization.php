<?php
/**
 * abc.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    overtrue <i@overtrue.me>
 * @copyright 2015 overtrue <i@overtrue.me>
 * @link      https://github.com/overtrue
 * @link      http://overtrue.me
 */

/**
 * Class Colorization.
 */
class Colorization
{
    /**
     * Foreground colors.
     *
     * @var array
     */
    private static $foregroundColors = [
        'black'        => '0;30',
        'dark_gray'    => '1;30',
        'blue'         => '0;34',
        'light_blue'   => '1;34',
        'green'        => '0;32',
        'light_green'  => '1;32',
        'cyan'         => '0;36',
        'light_cyan'   => '1;36',
        'red'          => '0;31',
        'light_red'    => '1;31',
        'purple'       => '0;35',
        'light_purple' => '1;35',
        'brown'        => '0;33',
        'yellow'       => '1;33',
        'light_gray'   => '0;37',
        'white'        => '1;37',
    ];

    /**
     * Backgound colors.
     *
     * @var array
     */
    private static $backgroundColors = [
        'black'      => '40',
        'red'        => '41',
        'green'      => '42',
        'yellow'     => '43',
        'blue'       => '44',
        'magenta'    => '45',
        'cyan'       => '46',
        'light_gray' => '47',
    ];

    /**
     * Magic access.
     *
     * @param string $method
     * @param array  $args
     *
     * @return string
     */
    public function __callStatic($method, $args)
    {
        $foreground = preg_replace_callback('/([A-Z])/', function($matches){
            return '_'.strtolower($matches[1]);
        }, $method);

        list($string, $background) = array_pad($args, 2, null);

        if (!isset(self::$foregroundColors[$foreground])) {
            throw new Exception("Foreground '$foreground' not exists.");
        }

        return self::colorize($string, $foreground, $background);
    }

    /**
     * Return colorized string.
     *
     * @param string $string
     * @param string $foreground
     * @param string $background
     *
     * @return string
     */
    public static function colorize(
        $string,
        $foreground = null,
        $background = null
        )
    {
        $output = '';

        if (func_num_args() == 1) {
            return $string;
        }

        $foreground && $output .= "\033[".self::$foregroundColors[$foreground].'m';

        $background && $output .= "\033[".self::$backgroundColors[$background].'m';

        $output .=  $string."\033[0m";

        return $output;
    }

    /**
     * Returns all foreground color names
     *
     * @return array
     */
    public static function getForegroundColors()
    {
        return array_keys(self::$foregroundColors);
    }

    /**
     * Returns all background color names
     *
     * @return array
     */
    public static function getBackgroundColors()
    {
        return array_keys(self::$backgroundColors);
    }
}//end class
