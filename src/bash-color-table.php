<?php


class BashColor
{
    /**
     * Color table
     *
     * @var array
     */
    public static $table;

    /**
     * edit curent row number
     *
     * @var int
     */
    private static $cur_row = 0;

    /**
     * record each max width of table column
     *
     * @var array
     */
    private static $row_with = array();

    /**
     * default td slice
     *
     * @var string
     */
    public static $TAB_SLICE = ' | ';

    /**
     * Options.
     *
     * @var array
     */
    private static $options = array(
        'none'       => 0, // reset/remove all option
        'bold'       => 1, // bold/bright
        'bright'     => 1, // bold/bright
        'dim'        => 2, // dim
        'underlined' => 4, // underlined
        'blink'      => 5, // blink
        'reverse'    => 7, // reverse/invert
        'invert'     => 7, // reverse/invert
        'hidden'     => 8, // hidden
    );
    /**
     * Foreground colors.
     *
     * @var array
     */
    private static $foregroundColors = array(
        'default'       => 39, // default (usually green, white or light gray)
        'black'         => 30, // black
        'red'           => 31, // red (don't use with green background)
        'green'         => 32, // green
        'yellow'        => 33, // yellow
        'blue'          => 34, // blue
        'magenta'       => 35, // magenta/purple
        'purple'        => 35, // magenta/purple
        'cyan'          => 36, // cyan
        'light_gray'    => 37, // light gray
        'dark_gray'     => 90, // dark gray
        'light_red'     => 91, // light red
        'light_green'   => 92, // light green
        'light_yellow'  => 93, // light yellow
        'light_blue'    => 94, // light blue
        'light_magenta' => 95, // light magenta/pink
        'light_pink'    => 95, // light magenta/pink
        'light_cyan'    => 96, // light cyan
        'white'         => 97, // white
    );
    /**
     * Backgound colors.
     *
     * @var array
     */
    private static $backgroundColors = array(
        'default'       => 49,  // Default background color (usually black or blue)
        'black'         => 40,  // Black
        'red'           => 41,  // Red
        'green'         => 42,  // Green
        'yellow'        => 43,  // Yellow
        'blue'          => 44,  // Blue
        'magenta'       => 45,  // Magenta/Purple
        'purple'        => 45,  // Magenta/Purple
        'cyan'          => 46,  // Cyan
        'light_gray'    => 47,  // Light Gray (don't use with white foreground)
        'dark_gray'     => 100, // Dark Gray (don't use with black foreground)
        'light_red'     => 101, // Light Red
        'light_green'   => 102, // Light Green (don't use with white foreground)
        'light_yellow'  => 103, // Light Yellow (don't use with white foreground)
        'light_blue'    => 104, // Light Blue (don't use with light yellow foreground)
        'light_magenta' => 105, // Light Magenta/Pink (don't use with light foreground)
        'light_pink'    => 105, // Light Magenta/Pink (don't use with light foreground)
        'light_cyan'    => 106, // Light Cyan (don't use with white foreground)
        'white'         => 107, // White (don't use with light foreground)
    );

    /**
     * Return colorized string or array for table.
     *
     * @param string $string
     * @param string $return_type
     *
     * @return mix
     */
    public static function render( $string, $return_type = 'string' )
    {
        preg_match_all( '~<(?<attributes>[a-z_;A-Z=\s]+)>(?<string>.*?)</>~', $string, $matches );
//        var_dump($matches);
        if ( empty( $matches[ 'string' ] ) && empty( $matches[ 'attributes' ] ) ) {
            $str = array( $string );
            $render_str = array( $string );
        } else {
            $str = array();
            $render_str = array();
//            $render_str1 = array();

            foreach ( $matches[ 'attributes' ] as $key => $attributes ) {
                list( $foreground, $background, $option, $endModifier ) = BashColor::parseAttributes( $attributes );
                $str[] = $matches[ 'string' ][ $key ];
                $render_str[] = "\033[{$option};{$background};{$foreground}m{$matches['string'][$key]}\033[0m";
//                $render_str[] = "\033[{$option};{$background};{$foreground}m{$matches['string'][$key]}\033[{$endModifier}m";
            }
        }

        switch ( $return_type ) {
            case 'array':
                return array(
                    'str'        => implode( $str ),
                    'render_str' => implode( $render_str ),
                );
                break;
            case 'string':
            default:
                return implode( $render_str );
                break;
        }
    }

    /**
     * Parse attributes.
     *
     * @param string $attributesString
     *
     * @return array
     */
    public static function parseAttributes( $attributesString )
    {
        $attributes = array(
            'fg'  => 'default',
            'bg'  => 'default',
            'opt' => 'none',
        );
        foreach ( explode( ';', $attributesString ) as $attribute ) {
            $temp = explode( '=', $attribute );
            if ( count( $temp ) < 2 ) {
                continue;
            }
            $attributes[ trim( $temp[ 0 ] ) ] = self::snakeCase( trim( $temp[ 1 ] ) );
        }
        !empty( self::$foregroundColors[ $attributes[ 'fg' ] ] ) || $attributes[ 'fg' ] = 'default';
        !empty( self::$backgroundColors[ $attributes[ 'bg' ] ] ) || $attributes[ 'bg' ] = 'default';
        !empty( self::$options[ $attributes[ 'opt' ] ] ) || $attributes[ 'opt' ] = 'none';
        $foreground = self::$foregroundColors[ $attributes[ 'fg' ] ];
        $background = self::$backgroundColors[ $attributes[ 'bg' ] ];
        $option = self::$options[ $attributes[ 'opt' ] ];
        $endModifier = $option ? 20 + $option : $option;

        return array( $foreground, $background, $option, $endModifier );
    }

    /**
     * Snake case.
     *
     * @param string $string
     *
     * @return string
     */
    public static function snakeCase( $string )
    {
        return preg_replace_callback( '/([A-Z])/', function ( $matches ) {
            return '_' . strtolower( $matches[ 1 ] );
        }, lcfirst( $string ) );
    }

    /**
     * Returns all foreground color names.
     *
     * @return array
     */
    public static function getForegroundColors()
    {
        return array_keys( self::$foregroundColors );
    }

    /**
     * Returns all background color names.
     *
     * @return array
     */
    public static function getBackgroundColors()
    {
        return array_keys( self::$backgroundColors );
    }

    /**
     * Creat a new table Object
     *
     * @return BashColor
     */
    public static function table()
    {
        self::$cur_row = 0;
        self::$table = array();

        return new self;
    }

    /**
     * Add a new td
     *
     * @param        $str
     * @param string $align
     * @param string $type
     * @return $this
     */
    public function td( $str, $align = 'left', $type = '' )
    {
        //$type 分为几种 '':普通单元格; 'span':多列占位格 ;'br':行间隔符
        // 单元格对齐
        switch ( $align ) {
            case 'right':
                $align = STR_PAD_LEFT;
                break;
            case 'center':
                $align = STR_PAD_BOTH;
                break;
            case 'left':
            default:
                $align = STR_PAD_RIGHT;
                break;
        }

        $str = BashColor::render( $str, 'array' );
        self::$table[ self::$cur_row ][] = array( 'str' => $str[ 'str' ], 'render_str' => $str[ 'render_str' ], 'align' => $align, 'type' => $type );

        $col = sizeof( self::$table[ self::$cur_row ] ) - 1;

        // 记录这列的最宽值
        $td_longth = mb_strlen( $str['str'] );//中文还有问题...

        self::$row_with[ $col ] = isset( self::$row_with[ $col ] ) && ( self::$row_with[ $col ] > $td_longth ) ? self::$row_with[ $col ] : $td_longth;

        for ( $i = self::$cur_row; $i >= 0; $i-- ) {

            if ( !isset( self::$table[ $i ][ $col ] ) || ( self::$table[ $i ][ $col ][ 'type' ] == 'br' ) ) {
                continue;
            }
            self::$table[ $i ][ $col ][ 'str' ] = str_pad( self::$table[ $i ][ $col ][ 'str' ], self::$row_with[ $col ], ' ', self::$table[ $i ][ $col ][ 'align' ] );
        }

        return $this;
    }

    /**
     *
     * @param string $br_str
     * @return $this
     */
    public function br( $br_str = '' )
    {
        if ( $br_str != '' ) {
            $this->br();
            // 如果设定了每行间隔字符,那么就想法显示一下
            $this->td( $br_str, NULL, 'br' )->br();
        }
        self::$cur_row++;

        return $this;
    }

    /**
     * use to call function td2...
     *
     * @param $method
     * @param $args
     * @return $this
     */
    public function __call( $method, $args )
    {

        if ( strpos( $method, 'td' ) === 0 ) {
            $col_span = trim( $method, 'td' );
            $col_span += 0;
            $args[ 1 ] = isset( $args[ 1 ] ) ? $args[ 1 ] : NULL;
            for ( $i = 1; $i < $col_span; $i++ ) {
                $this->td( '', 'right', 'span' );//类型为多列单元格
            }
            $this->td( $args[ 0 ], $args[ 1 ] );//注意考虑下单元格类型

            return $this;
        }
    }

    /**
     * Optional to define table slice style
     * @param $slice
     * @return $this|bool
     */
    public function setSlice( $slice )
    {
        self::$TAB_SLICE = $slice;
        if ( isset( $this ) ) {
            return $this;
        }
        echo 'this function must be used after table() ';

        return FALSE;
    }

    /**
     * Finally output table str to console
     *
     * @return string
     */
    public function __toString()
    {
        $str = '';
        foreach ( self::$table as $row ) {
            $col_buffer = '';// 单元格合并缓冲区
            foreach ( $row as $td ) {
                if ( $td[ 'type' ] == 'span' ) {//处理待合并单元格
                    $col_buffer .= $td[ 'str' ] . str_repeat( ' ', mb_strlen( self::$TAB_SLICE ) );
                } elseif ( $td[ 'type' ] == 'br' ) {//处理分隔行
                    $pad_longth = array_sum( self::$row_with ) + mb_strlen( self::$TAB_SLICE ) * count( self::$row_with ) - 1;//饿了,为啥多一个?暂时想不明白
                    $str .= str_pad( '', $pad_longth, $td[ 'str' ] );//这类先不管
                } elseif ( !empty( $col_buffer ) ) {// 处理合并单元格
                    $length = mb_strlen( $col_buffer ) + mb_strlen( $td[ 'str' ] );
                    $render_str = ( str_pad( $td[ 'str' ], $length, ' ', $td[ 'align' ] ) . self::$TAB_SLICE );
                    $render_str = str_replace( trim($td['str']) ,$td['render_str'] ,$render_str);
                    $str .= $render_str;
                    $col_buffer = '';//用完就清空
                } else {//普通单元格
                    $render_str = $td[ 'str' ] . self::$TAB_SLICE;
                    $render_str = str_replace( trim($td['str']) ,$td['render_str'] ,$render_str);
                    $str .= $render_str;
                }
            }

            $str .= "\033[0m\n";
        }

//        var_dump(self::$table);
        return $str;
    }

    public static function colors()
    {
        foreach (self::$options as $option => $value) {
            echo "---------------------------------------------------\n";
            foreach (self::$foregroundColors as $font_name => $f_v) {
                foreach (self::$backgroundColors as $back_name => $b_v) {
                        echo BashColor::render( "<fg={$font_name};bg={$back_name};opt={$option};> test </>" );
                    }    
                echo "\n";
            }
        }
    }
}

// BashColor::render( '<fg=green;opt=bold>Are you sure ?</><fg=yellow> [Y/n]:</>' );
//var_dump(BashColor::render( 'haha' ,'array')) ;

echo BashColor::table()->setSlice( ' | ' )->br( '+' )
    ->td4( '<fg=lightBlue;bg=red>title</>', 'center' )->br( '=' )
    ->td( 'row1' )->td2( 'Centertitle', 'center' )->td( 'kjdfkajdksfjklde' )->br( '-' )
    ->td( 'rewwwwww' )->td( 'chinese', 'center' )->td( 'Hello World' )->td( '<fg=green;bg=red>Are you sure ?</><fg=yellow;bg=blue> [Y/n]:</>' )->br( '-' )
    ->td( 'a' )->td( '<fg=green;opt=bold>b</>', 'center' )->td( 'c' )->td( 'd' )->br( '-' )
    ->td3( 'b3', 'center' )->td( 'c' )->br( '+' );

// BashColor::colors();
