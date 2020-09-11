<?php
    $N = 152;
    $M = 683;
    $commitsCount = 0;

    $result = getResult($N, $M);
    print ('<br>Commits count: ' . $result);

    function getResult(int $W, int $E): int
    {
        global $commitsCount;
        if ($W == 0)
        {
            if ($E % 2 == 1)
            {
                return -1;
            }
            else
            {
                $E = doCommitsWithTwoErrors($E);
                return $commitsCount;
            }
        }
        print ('<br>W: ' . $W);
        print ('<br>E: ' . $E);

        if ($E > 1)
        {
            $E = doCommitsWithTwoErrors($E);
        }

        while (!checkTrue($W, $E))
        {
            $W++;
            $commitsCount++;
            //print ('<br>while_W: ' . $W);
        }

        $E += doCommitsWithTwoWarnings($W);
        print ('<br>W: ' . $W);
        print ('<br>E: ' . $E);
        print ('<br>C: ' . $commitsCount);

        $E = doCommitsWithTwoErrors($E);

        return $commitsCount;
    }

    /*function checkTrue(int $W, int $E): bool
    {
        return (($W / 2) + $E) % 2 == 0;
    }*/

    function checkTrue(int $W, int $E): bool
    {
        //print ('<br>cT_W: ' . $W);
        //print ('<br>cT_E: ' . $E . '<br>');

        if ($W == 0
            && $E % 2 == 0
        )
        {
            return true;
        }
        elseif ($W < 0)
        {
            return false;
        }

        $W -= 2;
        $E += 1;
        return checkTrue($W, $E);
    }

    function doCommitsWithTwoErrors(int $E): int
    {
        global $commitsCount;
        if ($E == 0)
        {
            return 0;
        }

        while ($E != 0)
        {
            $commitsCount++;
            $E -= 2;
            if ($E == 1)
            {
                return $E;
            }
        }

        return $E;
    }

    function doCommitsWithTwoWarnings(int $W): int
    {
        global $commitsCount;
        $E = 0;

        while ($W != 0)
        {
            //print ('<br>do_W: ' . $W);
            //print ('<br>do_commits: ' . $commitsCount);

            $W -= 2;
            $E++;
            $commitsCount++;
        }

        return $E;
    }



