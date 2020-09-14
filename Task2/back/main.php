<?php
    if (isset($_GET['M']) && isset($_GET['N']))
    {
        $M = $_GET['M'];   // Warnings
        $N = $_GET['N'];   // Errors
        $commitsCount = 0;

        $result = getResult($M, $N);
        print ('<br>Commits count: ' . $result);
    }

    /*
     * Description:
     * e = errors, w = warnings, c = commits
     * 'Do commits' as it said in task (1e = 1e, 0w, 1c; 1w = 0e, 2w, 1c; 2e = 0e, 0w, 1c; 2w = 1e, 0w, 1c)
     *  and count their number (-1 if it can`t be counted)
     *
     * @param: {int} W - warnings number (M)
     * @param: {int} E - errors number (E)
     *
     * @return: {int} - commits number (-1 if it can`t be counted)
     */
    function getResult(int $W, int $E): int
    {
        $data = [
            'W' => $W,
            'E' => $E,
            'C' => 0
        ];

        if ($data['W'] == 0)
        {
            if ($data['E'] % 2 == 1)
            {
                return -1;
            }
            else
            {
                $data = doCommitsWithTwoErrors($data);
                return $data['C'];
            }
        }

        while (!checkTrue($data['W'], $data['E']))
        {
            $data['W']++;
            $data['C']++;
        }

        $data = doCommitsWithTwoWarnings($data);
        $data = doCommitsWithTwoErrors($data);

        return $data['C'];
    }

    /*
     * Description:
     * Check condition for algorithm and returns result.
     *
     * @param: {int} W - warnings number (M)
     * @param: {int} E - errors number (E)
     *
     * @return: {bool} - result
     */
    function checkTrue(int $W, int $E): bool
    {
        return fmod(($W / 2.0 + $E), 2) == 0;
    }

    /*
     * Description:
     * 'Do commits' with two errors (2 errors = 0e, 0w, 1c)
     *
     * @param: {array} data - array with info about W, E and C.
     *
     * @return: {array} - changed values of array
     */
    function doCommitsWithTwoErrors(array $data): array
    {
        if ($data['E'] == 0)
        {
            return $data;
        }

        while ($data['E'] != 0)
        {
            $data['C']++;
            $data['E'] -= 2;
            if ($data['E'] == 1)
            {
                return $data;
            }
        }

        return $data;
    }

    /*
     * Description:
     * 'Do commits' with two warnings (2 w = 1e, 0w, 1c)
     *
     * @param: {array} data - array with info about W, E and C.
     *
     * @return: {array} - changed values of array
     */
    function doCommitsWithTwoWarnings(array $data): array
    {
        while ($data['W'] != 0)
        {
            //print ('<br>do_W: ' . $W);
            //print ('<br>do_commits: ' . $commitsCount);

            $data['W'] -= 2;
            $data['E']++;
            $data['C']++;
        }

        return $data;
    }



