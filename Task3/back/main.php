<?php
    if (isset($_GET['n']) && isset($_GET['k']))
    {
        $n = $_GET['n'];
        $k = $_GET['k'];

        print ('Number place: ' . getNumberPlace($n, $k));
    }

    /*
     * Description:
     * Count position of number 'k' in sequence to 'n'
     *
     * @param: {int} n - max number of numbers in sequence
     * @param: {int} k - number to find
     *
     * @return: {int} - position of number
     */
    function getNumberPlace(int $n, int $k): int
    {
        $position = 1;

        for($i = 1; $i <= $n; $i++)
        {
            if (strcasecmp($i, $k) < 0)
            {
                $position++;
            }
        }

        return $position;
    }