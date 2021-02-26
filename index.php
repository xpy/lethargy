<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <link href='http://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
    <meta charset="UTF-8">
    <title>CSS Only Folio</title>
        <link rel="stylesheet" href="css/main.css">
    <link href="css/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
    <link href="css/print.css" media="print" rel="stylesheet" type="text/css" />
    <!--[if IE]>
    <link href="css/ie.css" media="screen, projection" rel="stylesheet" type=
        "text/css" />
    <![endif]-->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="icon" type="image/gif" href="favicon.gif" />
	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-28367526-3']);
		_gaq.push(['_setDomainName', 'xpy.github.io']);
		_gaq.push(['_setAllowLinker', true]);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>
</head>

<body>
<div id="wrapper" >
    <? include "parts/menu.php"; ?>
    <section id="content">
        <div id="rotator">
        <? include "parts/content.php"; ?>
        </div>
    </section>
    <footer>
        <? include "parts/footer.php"; ?>
    </footer>
</div>

</body>
</html>