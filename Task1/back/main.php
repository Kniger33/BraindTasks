<?php
    const PREVIEW_SYMBOL_NUMBER = 200;
    const SYMBOL_ELLIPSIS = '...';
    const WORDS_COUNT = 3;

    $articleLink = '../front/article.php';
    $articleText = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco lab nisi ut      aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

    $referenceBefore = '<a href="<?=$articleLink ?>?articleText=<?=$articleText?>">';
    $referenceAfter = '</a>';

    $cutOutWords = [];
    $cutOutSpacesCount = [];

    if (strlen($articleText) > PREVIEW_SYMBOL_NUMBER)
    {
        $articlePreview = cutText($articleText, PREVIEW_SYMBOL_NUMBER);
        print('<br>articlePreview without ref: ' . $articlePreview);
    }

    $articlePreview = addReference($articlePreview, WORDS_COUNT);

    print('<br>articlePreview: ' . $articlePreview);

    function cutText(string $text, int $symbolNumber)
    {
        return substr($text, 0, $symbolNumber);
    }

    function addSymbolAtTextEnd(string $text, string $symbol)
    {
        $text = $text . $symbol;

        return $text;
    }

    function addReference(string $text, int $wordsCount)
    {
        global $articleLink, $articleText;
        $referenceBefore = '<a href="' . $articleLink . '?articleText=' . $articleText . '">';
        $referenceAfter = '</a>';

        $spaceCount = getSpaceCountAtEnd($text);

        print ('<br> 1 SC:' . $spaceCount);

        $text = substr($text, 0, -$spaceCount);

        $spaceCount2 = getSpaceCountAtEnd($text);

        print ('<br> 2 SC:' . $spaceCount2);

        /*for ($i = strlen($text) - 1; $i > 0; $i--)
        {

        }*/
        print ('<br> Last symb: ' . $text[strlen($text) - 1]);

        //$articlePreview = addSymbolAtTextEnd($text, SYMBOL_ELLIPSIS);

        return $text;
    }

    function getSpaceCountAtEnd(string $text)
    {
        $spaceCount = 0;

        for ($i = strlen($text) - 1; $i > 0; $i--)
        {
            if ($text[$i] == ' ')
            {
                $spaceCount++;
            }
            else if (ctype_alpha($text[$i]))
            {
                break;
            }
        }

        return $spaceCount;
    }

    function cutLastWord(string $text, int $wordNumber)
    {
        global $cutOutWords;
        for ($i = strlen($text) - 1; $i > 0; $i--)
        {
            $cutOutWords[$wordNumber] = $text[$i] . $cutOutWords[$wordNumber];
            if ($text[$i] == ' ')
            {
                break;
            }
        }

        return $text;
    }


