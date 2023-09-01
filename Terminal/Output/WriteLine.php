<?php
namespace Rcngl\Console\Output;



/**
 * WriteLine Class
 *
 * The WriteLine class provides utility functions for writing text and displaying progress bars in the terminal.
 */
class WriteLine
{

    private const COLORS  = [
        'black' => '0;30',
        'red' => '0;31',
        'green' => '0;32',
        'yellow' => '0;33',
        'blue' => '0;34',
        'magenta' => '0;35',
        'cyan' => '0;36',
        'white' => '0;37',
    ];


    
    /**
     * Hide the terminal cursor.
     */
    public static function hideCursor()
    {
        echo "\e[?25l";
    }
    

    /**
     * Show the terminal cursor.
     */
    public static function showCursor()
    {
        echo "\e[?25h";
    }

    /**
     * Apply color to a text string.
     *
     * @param string $text  The text string to apply color to.
     * @param string $color  The color to apply.
     * @return string  The colored text string.
     */
    public static function textColor($text, $color)
    {
        // List of available colors
        $colors = self::COLORS;

        if (!isset(self::COLORS[$color])) {
            return $text;
        }

        return "\033[" . self::COLORS[$color] . "m" . $text . "\033[0m";
    }

    /**
     * Print a text string in new line.
     *
     * @param string $message  The text string to print.
     * @param string $color  The color to apply to the text.
     */
    public static function Println($message, $color = 'white')
    {
        self::Write($message, true, $color);
    }

    /**
     * Print a text string.
     *
     * @param string $message  The text string to print.
     * @param string $color  The color to apply to the text.
     */
    public static function Print($message, $color = 'white')
    {
        self::Write($message, false, $color);
    }

    /**
     * Write text to the terminal.
     *
     * @param string $message  The text to write.
     * @param bool $newLine  Whether to add a new line after the text.
     * @param string $color  The color to apply to the text.
     */
    protected static function Write($message, $newLine = false, $color = 'white')
    {
        $tags = [
            '<error>' => "\033[0;31m",
            '</error>' => "\033[0m",
            '<success>' => "\033[0;32m",
            '</success>' => "\033[0m",
        ];

        // Move the cursor to the beginning of the line
        echo "\x0D";

        // Erase the line
        echo "\x1B[2K";

        // check if not string
        // if want to print an object or array
        if (!is_string($message)) {
            $message = print_r($message, true);
        }

        // just a string output
        echo self::textColor($message, $color);


        // new line
        if ($newLine) {
            echo "\n";
        }
    }
}
