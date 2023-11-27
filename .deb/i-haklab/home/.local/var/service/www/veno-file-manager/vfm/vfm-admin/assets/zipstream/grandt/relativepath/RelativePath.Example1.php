<?php
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
require_once 'RelativePath.php';
$docRoot = $_SERVER["DOCUMENT_ROOT"] . "/";

if (!empty($_POST['path'])) {
	$paths = array(stripslashes($_POST['path']));
} else {
	// These paths are designed to be as insane as reasonably possible. Do not try to make much sense of them please :)
	$paths = array(
	"../testdir/subdir/anotherdir\\testfile.html",
	$docRoot . "/../../home/./John Doe/work/site/test/../../www/Project.1",
	$docRoot . "/../../../../../../../../home//./\\\\/John Doe/work\\site/test/../../www/Project.1",
	"../../../home/./John Doe/work/site/test/../../www/Project.1/",
	"../../../home/./John Doe/work/site/test/../../www/Project.1/" . "/../Project.2/index.html",
	"./././../../../../../../../../../home/./John Doe/work/site/test/../../www/Project.1" . "/" . "../Project.2/index.html",
	"../../home/../../../John Doe/work/site/test/../../www/Project.1" . "/" . "../Project.2/index.html/../",
	"/media/Projects/www/test/images/../../home/../../../John Doe/work/site/test.2/../../www/Project.1");
}

/**
 * 
 * Time execution time for a function
 *
 * @param unknown_type $function
 * @param unknown_type $title
 * @param unknown_type $iterations
 */
function execTime($function, $title="", $iterations = 100000) {
	list($usec, $sec) = explode(" ", microtime());
	$t1 = ($sec+$usec) * 1000;
	for ($i = 0 ; $i < $iterations ; $i++) {
		$function();
	}
	list($usec, $sec) = explode(" ", microtime());
	$t2 = ($sec+$usec) * 1000;
	$t2 = $t2 - $t1;
	if (!empty($title)) {
		print "<pre>$title: " . number_format((double)$t2, 2) . " ms.</pre>\n";
	}
	return $t2;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/xml; charset=utf-8" />
<style type="text/css">
/*<![CDATA[*/
body,table,form {
	font-size: 10pt;
	font-family: verdana, helvetica, sans-serif;
}

dt {
	font-weight: bold;
	margin-bottom: 0px;
	padding-bottom: 0px;
	background-color: #eeeeee;
}

dd {
	margin-top: 0px;
	padding-top: 0px;
	margin-bottom: 2ex;
}

pre {
	margin: 0px;
	padding: 0px;
}
/*]]>*/
</style>
<title>Relative Path tests</title>
</head>
<body>
<h1>Relative Path tests</h1>
<?php
print "<p>docRoot: $docRoot</p>\n";
?>
<form method="post">
<p>Path:<br />
<input type="text" size="120" name="path"
	value="<?php echo stripslashes($_POST['path']); ?>" /></p>
<p><input type="submit" /></p>
</form>
<dl>
<?php
foreach ($paths as $path) {
	echo "<dt><pre>Path '$path' becomes:</pre></dt>\n";
	echo "<dd><pre>";
	echo "'" . RelativePath::getRelativePath($path) . "'\n";
	print "</pre></dd>\n";
}
?>
</dl>
<?php
// This test requires PHP 5.3, due to the use of an anonymous function.
//	execTime(function() {
//		RelativePath::getRelativePath("./././../../../../../../../../../home/./John Doe/work/site/test/../../www/Project.1/../Project.2/index.html");
//	}, "100,000 iterations took");
?>
</body>
</html>
