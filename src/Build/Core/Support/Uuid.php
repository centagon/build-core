<?php

namespace Build\Core\Support;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class Uuid.
 *
 * The following class generates VALID RFC 4122 COMPLIANT
 * Universally Unique IDentifiers (UUID) version 3, 4, and 5.
 *
 * UUIDs generated validates using OSSP UUID Tool, and output
 * for name-based UUIDs are exactly the same. This is a pure
 * PHP implementation
 *
 * @author  Andrew Moore
 * @link    http://www.php.net/manual/en/function.uniqid.php#94959
 */
class Uuid
{

    /**
     * Generate v3 Uuid.
     * Version3 Uuid's are name based. They require a namespace (another
     * valid Uuid) and a value (the name). Given the same namespace and
     * name, the output is always the same.
     *
     * @param  string  $namespace
     * @param  string  $name
     *
     * @return string
     */
    public static function v3($namespace, $name)
    {
        if (!self::isValid($namespace)) {
            return false;
        }

        // Get the hexadecimal components of the namespace
        $nsHex    = str_replace(['-', '{', '}'], '', $namespace);
        $nsString = '';

        // Convert namespace Uuid to bits
        for ($i = 0; $i < strlen($nsHex); $i += 2) {
            $nsString.= chr(hexdec($nsHex[$i] . $nsHex[$i + 1]));
        }

        // Calculate the hash value
        $hash = md5($nsString . $name);

        // 32 bits for 'time_low'
        $timeLow = substr($hash, 0, 8);

        // 16 bits for 'time_mid'
        $timeMid = substr($hash, 8, 4);

        // 16 bits for 'time_hi_and_version',
        // four most significant bits holds version number 3
        $timeHi = (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000;

        // 16 bits, 8 bit for 'clk_seq_hi_res',
        // 8 bits for 'clk_seq_low'
        // two most significant bits hold zero and one for variant DCE1.1
        $timeSeqLow = (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000;

        // 48 bits for 'node'
        $node = substr($hash, 20, 12);

        return sprintf('%08s-%04s-%04x-%04x-%12s', $timeLow, $timeMid, $timeHi, $timeSeqLow, $node);
    }

    /**
     * Generate v4 Uuids.
     * Version 4 Uuids are pseudo-random.
     *
     * @return string
     */
    public static function v4()
    {
        // 32 bits for 'time_low'
        $timeLow    = mt_rand(0, 0xffff);
        $timeLowSeq = mt_rand(0, 0xffff);

        // 16 bits for 'time_mid'
        $timeMid = mt_rand(0, 0xffff);

        // 16 bits for 'time_hi_and_version'
        // four most significant bits hold version number 4
        $timeHi = mt_rand(0, 0xffff) | 0x4000;

        // 16 bits, 8 bits for 'clk_seq_hi_res',
        // 8 bits for 'clk_seq_low'
        // two most significant bits hold zero and one for variant DCE1.1
        $clkSeqLow = mt_rand(0, 0x3fff) | 0x8000;

        // 48 bits for 'node'
        $node       = mt_rand(0, 0xffff);
        $nodeSeqLow = mt_rand(0, 0xffff);
        $nodeSeqHi  = mt_rand(0, 0xffff);

        $pattern = '%04x%04x-%04x-%04x-%04x-%04x%04x%04x';

        return sprintf($pattern, $timeLow, $timeLowSeq, $timeMid, $timeHi, $clkSeqLow, $node, $nodeSeqLow, $nodeSeqHi);
    }

    /**
     * Generate v5 Uuids.
     *
     * Version 5 UUIDs use a scheme with SHA-1 hashing; otherwise it is the same idea as in version 3. RFC 4122 states
     * that version 5 is preferred over version 3 name based UUIDs, as MD5's security has been compromised. Note
     * that the 160 bit SHA-1 hash is truncated to 128 bits to make the length work out.
     *
     * @param  string  $namespace
     * @param  string  $name
     *
     * @return string
     */
    public static function v5($namespace, $name)
    {
        if (!self::isValid($namespace)) {
            return false;
        };

        // Get hexadecimal components of namespace
        $nhex = str_replace(['-', '{', '}'], '', $namespace);
        $nstr = '';

        // Convert Namespace UUID to bits
        for ($i = 0; $i < strlen($nhex); $i += 2) {
            $nstr .= chr(hexdec($nhex[$i] . $nhex[$i + 1]));
        }

        // Calculate hash value
        $hash = sha1($nstr . $name);

        // 32 bits for "time_low"
        $timeLow = substr($hash, 0, 8);

        // 16 bits for "time_mid"
        $timeMid = substr($hash, 8, 4);

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 5
        $timeHi  = (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000;

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        $clkSeqLow = (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000;

        // 48 bits for "node"
        $node = substr($hash, 20, 12);

        return sprintf('%08s-%04s-%04x-%04x-%12s', $timeLow, $timeMid, $timeHi, $clkSeqLow, $node);
    }

    /**
     * Validate a given uuid string.
     *
     * @param  string  $uuid
     *
     * @return bool
     */
    public static function isValid($uuid)
    {
        $pattern = '/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i';

        return preg_match($pattern, $uuid) === 1;
    }
}