<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BinString test</title>
        <style>
            .pass {
                color: green;
            }
            .fail {
                color: red;
            }
            td, th {
                border: 1px black solid;
            }
            th {
                font-weight: bold;
            }
            tr.new {
                border-top: 3px black solid;
            }
            table {
                border-collapse: collapse;
            }
            .expectFail {
                background-color: pink;
            }
        </style>
    </head>
    <body>
        <h1>BinStringStatic test</h1>
        <?php
        use com\grandt\BinStringStatic;

        error_reporting(E_ALL | E_STRICT);
        ini_set('error_reporting', E_ALL | E_STRICT);
        ini_set('display_errors', 1);

        include 'BinStringStatic.php';

        $mbStr = "\x74\x65\x73\x74\xC3\x86\xC3\xB8\xC3\xA5";
        $mbStr_lower = "\x74\x65\x73\x74\xC3\xA6\xC3\xB8\xC3\xA5";
        $mbStr_upper = "\x54\x45\x53\x54\xC3\x86\xC3\x98\xC3\x85";

        $isoStr = "\x74\x65\x73\x74\xC6\xF8\xE5";
        $isoStr_lower = "\x74\x65\x73\x74\xE6\xF8\xE5";
        $isoStr_upper = "\x54\x45\x53\x54\xC6\xD8\xC5";

        $mbNeedle = "\xC3\xB8";
        $isoNeedle = "\xF8";

        function test($result, $expected) {
            if ($result == $expected) {
                if (is_bool($result)) {
                    $result = $result ? "<em>true</em>" : "<em>false</em>";
                }
                return "<span class=\"pass\">PASS<br /></span>received: $result";
            } else {
                if (is_bool($result)) {
                    $result = $result ? "<em>true</em>" : "<em>false</em>";
                }
                return "<span class=\"fail\">FAIL<br />received: $result<br />expected: $expected</span>";
            }
        }

        function test_enc($result, $expected) {
            if ($result == $expected) {
                if (is_bool($result)) {
                    $result = $result ? "<em>true</em>" : "<em>false</em>";
                }
                return "<span class=\"pass\">PASS<br /></span>received: " . mb_convert_encoding($result, 'utf8', 'latin1');
            } else {
                if (is_bool($result)) {
                    $result = $result ? "<em>true</em>" : "<em>false</em>";
                }
                return "<span class=\"fail\">FAIL<br />received: " . mb_convert_encoding($result, 'utf8', 'latin1') . "<br />expected: " . mb_convert_encoding($expected, 'utf8', 'latin1') . "</span>";
            }
        }
        $time_start = microtime(true);
        ?>
        <p>The idea is that the standard column should be identical to the BinString column on systems without mbstring.func_overload enabled.</p>
        <p class="expectFail">Cells with a pink background are expected to fail, as they are either parsing mb strings to non mb aware functions, where they can't convert or deal with those utf8 characters, or they are just containing characters the function can't handle, due to having the wrong locale.</p>
        <p>The test strings contain the three Danish letters &aelig;, &oslash; and &aring;, not all PHP string functions can parse those, for instance the case conversion functions.</p>
        <p>ereg functions are not tested, as they have been deprecated from PHP 5.3.0, and people should use the PCRE extension's preg_* functions instead.
        <p></p>
        <p>Using PHP_VERSION_ID: <?= BinStringStatic::getPHPVersionId() ?></p>
        <h3>Static class</h3>
        <table>
            <tr><th>function</th><th>mb_input</th><th>standard</th><th>mb_*</th><th>BinStringStatic._*</th></tr>
            <tr class="new">
                <td>mail()</td>
                <td>no</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
            </tr>

            <tr class="new">
                <td rowspan="2">strlen()</td><td>yes</td>
                <td><?= test(strlen($mbStr), 10) ?></td>
                <td><?= test(mb_strlen($mbStr, 'utf8'), 7) ?></td>
                <td><?= test(BinStringStatic::_strlen($mbStr), 10) ?></td></tr>
            <tr>
                <td>no</td>
                <td><?= test(strlen($isoStr), 7) ?></td>
                <td><?= test(mb_strlen($isoStr, 'latin1'), 7) ?></td>
                <td><?= test(BinStringStatic::_strlen($isoStr), 7) ?></td></tr>

            <tr class="new">
                <td rowspan="2">strpos()</td><td>yes</td>
                <td><?= test(strpos($mbStr, $mbNeedle), 6) ?></td>
                <td><?= test(mb_strpos($mbStr, $mbNeedle, 0, 'utf8'), 5) ?></td>
                <td><?= test(BinStringStatic::_strpos($mbStr, $mbNeedle), 6) ?></td>
            </tr>
            <tr>
                <td>no</td>
                <td><?= test(strpos($isoStr, $isoNeedle), 5) ?></td>
                <td><?= test(mb_strpos($isoStr, $isoNeedle, 0, 'latin1'), 5) ?></td>
                <td><?= test(BinStringStatic::_strpos($isoStr, $isoNeedle), 5) ?></td>
            </tr>

            <tr class="new">
                <td rowspan="2">strrpos()</td><td>yes</td>
                <td><?= test(strrpos($mbStr, $mbNeedle), 6) ?></td>
                <td><?= test(mb_strrpos($mbStr, $mbNeedle, 0, 'utf8'), 5) ?></td>
                <td><?= test(BinStringStatic::_strrpos($mbStr, $mbNeedle), 6) ?></td>
            </tr>
            <tr>
                <td>no</td>
                <td><?= test(strrpos($isoStr, $isoNeedle), 5) ?></td>
                <td><?= test(mb_strrpos($isoStr, $isoNeedle, 0, 'latin1'), 5) ?></td>
                <td><?= test(BinStringStatic::_strrpos($isoStr, $isoNeedle), 5) ?></td>
            </tr>
            <?php
            if (BinStringStatic::getPHPVersionId() >= 50200) {
            ?>
                <tr class="new">
                    <td rowspan="2">stripos()</td><td>yes</td>
                    <td><?= test(stripos($mbStr, $mbNeedle), 6) ?></td>
                    <td><?= test(mb_stripos($mbStr, $mbNeedle, 0, 'utf8'), 5) ?></td>
                    <td><?= test(BinStringStatic::_stripos($mbStr, $mbNeedle), 6) ?></td>
                </tr>
                <tr>
                    <td>no</td>
                    <td><?= test(stripos($isoStr, $isoNeedle), 5) ?></td>
                    <td><?= test(mb_stripos($isoStr, $isoNeedle, 0, 'latin1'), 5) ?></td>
                    <td><?= test(BinStringStatic::_stripos($isoStr, $isoNeedle), 5) ?></td>
                </tr>
    
                <tr class="new">
                    <td rowspan="2">strripos()</td><td>yes</td>
                    <td><?= test(strripos($mbStr, $mbNeedle), 6) ?></td>
                    <td><?= test(mb_strripos($mbStr, $mbNeedle, 0, 'utf8'), 5) ?></td>
                    <td><?= test(BinStringStatic::_strripos($mbStr, $mbNeedle), 6) ?></td>
                </tr>
                <tr>
                    <td>no</td>
                    <td class="expectFail"><?= test(strripos($isoStr, $isoNeedle), 5) ?></td>
                    <td><?= test(mb_strripos($isoStr, $isoNeedle, 0, 'latin1'), 5) ?></td>
                    <td class="expectFail"><?= test(BinStringStatic::_strripos($isoStr, $isoNeedle), 5) ?></td>
                </tr>

                <tr class="new">
                    <td rowspan="2">strstr()</td><td>yes</td>
                    <td><?= test(strstr($mbStr, "\xC3\xB8\xC3\xA5"), "\xC3\xB8\xC3\xA5") ?></td>
                    <td><?= test(mb_strstr($mbStr, "\xC3\xB8\xC3\xA5", null, 'utf8'), "\xC3\xB8\xC3\xA5") ?></td>
                    <td><?= test(BinStringStatic::_strstr($mbStr, "\xC3\xB8\xC3\xA5"), "\xC3\xB8\xC3\xA5") ?></td>
                </tr>
                <tr>
                    <td>no</td>
                    <td><?= test_enc(strstr($isoStr, "\xF8\xE5"), "\xF8\xE5") ?></td>
                    <td><?= test_enc(mb_strstr($isoStr, "\xF8\xE5", null, 'latin1'), "\xF8\xE5") ?></td>
                    <td><?= test_enc(BinStringStatic::_strstr($isoStr, "\xF8\xE5"), "\xF8\xE5") ?></td>
                </tr>

                <tr class="new">
                    <td rowspan="2">stristr()</td><td>yes</td>
                    <td><?= test(stristr($mbStr, "\xC3\xB8\xC3\xA5"), "\xC3\xB8\xC3\xA5") ?></td>
                    <td><?= test(mb_stristr($mbStr, "\xC3\xB8\xC3\xA5", null, 'utf8'), "\xC3\xB8\xC3\xA5") ?></td>
                    <td><?= test(BinStringStatic::_stristr($mbStr, "\xC3\xB8\xC3\xA5"), "\xC3\xB8\xC3\xA5") ?></td>
                </tr>
                <tr>
                    <td>no</td>
                    <td><?= test_enc(stristr($isoStr, "\xF8\xE5"), "\xF8\xE5") ?></td>
                    <td><?= test_enc(mb_stristr($isoStr, "\xF8\xE5", null, 'latin1'), "\xF8\xE5") ?></td>
                    <td><?= test_enc(BinStringStatic::_stristr($isoStr, "\xF8\xE5"), "\xF8\xE5") ?></td>
                </tr>

                <tr class="new">
                    <td rowspan="2">strrchr()</td><td>yes</td>
                    <td class="expectFail"><?= test(strrchr($mbStr, "\xC3\xB8"), "\xC3\xB8\xC3\xA5") ?></td>
                    <td><?= test(mb_strrchr($mbStr, "\xC3\xB8", null, 'utf8'), "\xC3\xB8\xC3\xA5") ?></td>
                    <td class="expectFail"><?= test(BinStringStatic::_strrchr($mbStr, "\xC3\xB8"), "\xC3\xB8\xC3\xA5") ?></td>
                </tr>
                <tr>
                    <td>no</td>
                    <td><?= test_enc(strrchr($isoStr, "\xF8"), "\xF8\xE5") ?></td>
                    <td><?= test_enc(mb_strrchr($isoStr, "\xF8", null, 'latin1'), "\xF8\xE5") ?></td>
                    <td><?= test_enc(BinStringStatic::_strrchr($isoStr, "\xF8"), "\xF8\xE5") ?></td>
                </tr>
            <?php
            }
            ?>

            <tr class="new">
                <td rowspan="2">substr()</td><td>yes</td>
                <td><?= test(substr($mbStr, 6), "\xC3\xB8\xC3\xA5") ?></td>
                <td><?= test(mb_substr($mbStr, 5, mb_strlen($mbStr, 'utf8'), 'utf8'), "\xC3\xB8\xC3\xA5") ?></td>
                <td><?= test(BinStringStatic::_substr($mbStr, 6), "\xC3\xB8\xC3\xA5") ?></td>
            </tr>
            <tr>
                <td>no</td>
                <td><?= test_enc(substr($isoStr, 5), "\xF8\xE5") ?></td>
                <td><?= test_enc(mb_substr($isoStr, 5, mb_strlen($isoStr, 'latin1'), 'latin1'), "\xF8\xE5") ?></td>
                <td><?= test_enc(BinStringStatic::_substr($isoStr, 5), "\xF8\xE5") ?></td>
            </tr>

            <tr class="new">
                <td rowspan="2">strtolower()</td><td>yes</td>
                <td class="expectFail"><?= test(strtolower($mbStr), $mbStr_lower) ?></td>
                <td><?= test(mb_strtolower($mbStr, 'utf8'), $mbStr_lower) ?></td>
                <td class="expectFail"><?= test(BinStringStatic::_strtolower($mbStr), $mbStr_lower) ?></td>
            </tr>
            <tr>
                <td>no</td>
                <td class="expectFail"><?= test_enc(strtolower($isoStr), $isoStr_lower) ?></td>
                <td><?= test_enc(mb_strtolower($isoStr, 'latin1'), $isoStr_lower) ?></td>
                <td class="expectFail"><?= test_enc(BinStringStatic::_strtolower($isoStr), $isoStr_lower) ?></td>
            </tr>

            <tr class="new">
                <td rowspan="2">strtoupper()</td><td>yes</td>
                <td class="expectFail"><?= test(strtoupper($mbStr), $mbStr_upper) ?></td>
                <td><?= test(mb_strtoupper($mbStr, 'utf8'), $mbStr_upper) ?></td>
                <td class="expectFail"><?= test(BinStringStatic::_strtoupper($mbStr), $mbStr_upper) ?></td>
            </tr>
            <tr>
                <td>no</td>
                <td class="expectFail"><?= test_enc(strtoupper($isoStr), $isoStr_upper) ?></td>
                <td><?= test_enc(mb_strtoupper($isoStr, 'latin1'), $isoStr_upper) ?></td>
                <td class="expectFail"><?= test_enc(BinStringStatic::_strtoupper($isoStr), $isoStr_upper) ?></td>
            </tr>

            <tr class="new">
                <td rowspan="2">substr_count()</td><td>yes</td>
                <td><?= test(substr_count($mbStr, $mbNeedle), 1) ?></td>
                <td><?= test(mb_substr_count($mbStr, $mbNeedle, 'utf8'), 1) ?></td>
                <td><?= test(BinStringStatic::_substr_count($mbStr, $mbNeedle), 1) ?></td>
            </tr>
            <tr>
                <td>no</td>
                <td><?= test_enc(substr_count($isoStr, $isoNeedle), 1) ?></td>
                <td><?= test_enc(mb_substr_count($isoStr, $isoNeedle, 'latin1'), 1) ?></td>
                <td><?= test_enc(BinStringStatic::_substr_count($isoStr, $isoNeedle), 1) ?></td>
            </tr>

            <tr class="new">
                <td>ereg()</td>
                <td>no</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
            </tr>

            <tr class="new">
                <td>eregi()</td>
                <td>no</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
            </tr>

            <tr class="new">
                <td>ereg_replace()</td>
                <td>no</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
            </tr>

            <tr class="new">
                <td>eregi_replace()</td>
                <td>no</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
            </tr>

            <tr class="new">
                <td>split()</td>
                <td>no</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
                <td>UNTESTED</td>
            </tr>

            <tr class="new">
                <td>startsWith()</td>
                <td>no</td>
                <td><?= test(BinStringStatic::startsWith("TestFileName.html", "test"), false) ?></td>
                <td><?= test(BinStringStatic::startsWith("TestFileName.html", ".html"), false) ?></td>
                <td><?= test(BinStringStatic::startsWith("TestFileName.html", "Test"), true) ?></td>
            </tr>

            <tr class="new">
                <td>endsWith()</td>
                <td>no</td>
                <td><?= test(BinStringStatic::endsWith("TestFileName.html", ".xhtml"), false) ?></td>
                <td><?= test(BinStringStatic::endsWith("TestFileName.html", ".Test"), false) ?></td>
                <td><?= test(BinStringStatic::endsWith("TestFileName.html", ".html"), true) ?></td>
            </tr>
        </table>
    </body>
</html>
