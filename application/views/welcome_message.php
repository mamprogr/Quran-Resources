<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Quran-Resources</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to Quran-Resources!</h1>

	<div id="body">
		<p>The aim of project is provide main resources of holy quran (ayats, translate, ..) ..</p>

		<p>HOW TO USE :<br />=> <b>Quran Text :</b></p>
		<code>http://quran.mamprogr.net/quran_text/TYPE_OF_RESOURCE/HOW_OF_VIEW/COND1/COND2</code>

		<pre>
    <u><b>TYPE_OF_RESOURCE :</b></u> ayas OR suras .
    <u><b>HOW_OF_VIEW :</b></u> html OR xml OR serialize OR json .
    <u><b>COND1,COND2 :</b></u>
        - for 'ayas' :
                        index of aya like: 37
                        OR sura-aya like: 2-10
        - for 'suras' :
                        index of sura like: 113 
    
    <u><b>Note :</b></u> COND2 is optional ..
            if COND2 found, the result will be range from COND1 to COND2.
            else the result will be just one aya OR sura.
        </pre>
        <p>Examples :</p>
		<p>
            <a href="http://quran.mamprogr.net/quran_text/suras/html/110/114">http://quran.mamprogr.net/quran_text/suras/html/110/114</a><br /><br />
		    <a href="http://quran.mamprogr.net/quran_text/ayas/xml/7/20">http://quran.mamprogr.net/quran_text/ayas/xml/7/20</a><br />
            <a href="http://quran.mamprogr.net/quran_text/ayas/json/2-10/2-15">http://quran.mamprogr.net/quran_text/ayas/json/2-10/2-15</a><br />
            <br />
            <a href="http://quran.mamprogr.net/quran_text/suras/html/110">http://quran.mamprogr.net/quran_text/suras/html/110</a><br />
            <a href="http://quran.mamprogr.net/quran_text/suras/serialize/112/114">http://quran.mamprogr.net/quran_text/suras/serialize/112/114</a><br />
            <a href="http://quran.mamprogr.net/quran_text/suras/text/50/51">http://quran.mamprogr.net/quran_text/suras/text/50/51</a><br />
        </p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>