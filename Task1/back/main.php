<?php
    const CONST_PREVIEW_SYMBOL_NUMBER = 200;
    const CONST_SYMBOL_ELLIPSIS = '...';
    const CONST_WORDS_COUNT = 3;
    const CONST_SEPARATOR = ' ';

    $articleLink = '../front/article.php';
    $articleText = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore 
    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea 
    commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla 
    pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

    $cutOutWords = [];
    $cutOutSeparatorsCount = [];

    $articleTextCopy = '';

    if (strlen($articleText) > CONST_PREVIEW_SYMBOL_NUMBER)
    {
        $articleTextCopy = cutText($articleText, CONST_PREVIEW_SYMBOL_NUMBER);
    }
    else
    {
        $articleTextCopy = $articleText;
    }

    $articlePreview = addReference($articleTextCopy);
    print $articlePreview;

    /*
     * Description:
     * Cut text for a certain number of symbols
     *
     * @param {string} text - text to be cutted
     * @param {int} symbolNumber - number of symbols in text to cut
     *
     * @return {string) - cutted text having 'symbolNumber' symbols
     */
    function cutText(string $text, int $symbolNumber): string
    {
        return substr($text, 0, $symbolNumber);
    }

    /*
     * Description:
     * Add a certain symbol at the end of text
     *
     * @param {string} text - text you need to add symbol
     * @param {string} symbolNumber - symbol to add
     *
     * @return {string) - text with added symbol at the end
     */
    function addSymbolAtTextEnd(string $text, string $symbol): string
    {
        $text = $text . $symbol;
        return $text;
    }

    /*
     * Description:
     * Add reference to full version of text at last WORDS_COUNT symbols and 'SYMBOL_ELLIPSIS' symbol
     *
     * @param {string} text - text you need to add reference
     *
     * @return {string) - text with added reference at the end
     */
    function addReference(string $text): string
    {
        global $articleLink, $articleText;
        $referenceBefore = '<a href="' . $articleLink . '?articleText=' . $articleText . '">';
        $referenceAfter = '</a>';

        for ($i = 0; $i < CONST_WORDS_COUNT; $i++)
        {
            $text = cutLastSeparators($text, $i);
            $text = cutLastWord($text, $i);
        }

        $text .= $referenceBefore;

        $text = insertWords($text);
        $text = addSymbolAtTextEnd($text, CONST_SYMBOL_ELLIPSIS);

        $text .= $referenceAfter;

        return $text;
    }

    /*
     * Description:
     * Counts and returns number of separators at the end of text
     *
     * @param {string} text - text you need to add count separators at the end
     *
     * @return {int) - count separators at the end of text
     */
    function getSeparatorsCountAtEnd(string $text): int
    {
        $separatorsCount = 0;

        for ($i = strlen($text) - 1; $i >= 0; $i--)
        {
            if ($text[$i] == CONST_SEPARATOR)
            {
                $separatorsCount++;
            }
            else if (ctype_alpha($text[$i]))
            {
                break;
            }
        }

        return $separatorsCount;
    }

    /*
     * Description:
     * Cutout last 'number' separators at the end of 'text' text
     *
     * @param {string} text - text you need to cut out separators
     * @param {int} number - number of separators to cut out
     *
     * @return {string) - text with cutted out separators at the end
     */
    function cutLastSeparators(string $text, int $number): string
    {
        global $cutOutSeparatorsCount;

        $cutOutSeparatorsCount[$number] = getSeparatorsCountAtEnd($text);

        if ($cutOutSeparatorsCount[$number] != 0)
        {
            $text = substr($text, 0, -$cutOutSeparatorsCount[$number]);
        }

        return $text;
    }

    /*
     * Description:
     * Cutout last 'wordNumber' word at the end of 'text' text
     *
     * @param {string} text - text you need to cut out word
     * @param {int} number - number of word to cut out
     *
     * @return {string) - text with cutted out word at the end
     */
    function cutLastWord(string $text, int $wordNumber): string
    {
        global $cutOutWords;
        for ($i = strlen($text) - 1; $i >= 0; $i--)
        {
            if ($text[$i] == CONST_SEPARATOR)
            {
                break;
            }
            $cutOutWords[$wordNumber] = $text[$i] . $cutOutWords[$wordNumber];
            $text = substr($text, 0, -1);
        }

        return $text;
    }

    /*
     * Description:
     * Insert all cutted out words and separators at the end of 'text' text
     *
     * @param {string} text - text you need to insert words and separators
     *
     * @return {string) - text with inserted words and separators at the end
     */
    function insertWords(string $text): string
    {
        global $cutOutWords, $cutOutSeparatorsCount;

        for ($i = CONST_WORDS_COUNT - 1; $i >= 0; $i--)
        {
            $text .= $cutOutWords[$i];
            for ($j = 0; $j < $cutOutSeparatorsCount[$i]; $j++)
            {
                $text .= CONST_SEPARATOR;
            }
        }

        return $text;
    }

