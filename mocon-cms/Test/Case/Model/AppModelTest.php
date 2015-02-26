<?php
/**
 * App Model test.
 *
 * Test the AppModel.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Test.Case.Model
 */
App::uses('AppModel', 'Model');

class AppModelTest extends CakeTestCase
{
    public $fixtures = array();

    public function setUp()
    {
        parent::setUp();
        $this->AppModel = ClassRegistry::init('AppModel');
    }

    public function tearDown()
    {
        unset($this->AppModel);
        ClassRegistry::flush();
        parent::tearDown();
    }

    public function testAlphaNumericDashUnderscoreSpaceColon()
    {
        $result = $this->AppModel->alphaNumericDashUnderscoreSpaceColon(array('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_: '));
        $this->assertEquals(1, $result);

        $result = $this->AppModel->alphaNumericDashUnderscoreSpaceColon(array('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_: +'));
        $this->assertEquals(false, $result);

    }
    public function testAlphaNumericDashUnderscore()
    {
        $result = $this->AppModel->alphaNumericDashUnderscore(array('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_'));
        $this->assertEquals(1, $result);

        $result = $this->AppModel->alphaNumericDashUnderscore(array('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_+'));
        $this->assertEquals(false, $result);
    }

/**
 * Test cleaning using the purify function, which comes from
 * HTMLPurifier.
 *
 * XSS attacks test come from the HTMLPurifier site and XSS Filter
 * Evasion Cheatsheet from OWASP:
 *
 * http://htmlpurifier.org/live/smoketests/xssAttacks.php
 * https://www.owasp.org/index.php/XSS_Filter_Evasion_Cheat_Sheet
 */
    public function testPurify()
    {

        // XSS Locator
        $result = $this->AppModel->purify('\';alert(String.fromCharCode(88,83,83))//\\\';alert(String.fromCharCode(88,83,83))//";alert(String.fromCharCode(88,83,83))//\\";alert(String.fromCharCode(88,83,83))//--></SCRIPT>">\'><SCRIPT>alert(String.fromCharCode(88,83,83))</SCRIPT>=&{}');
        $this->assertEquals('\';alert(String.fromCharCode(88,83,83))//\\\';alert(String.fromCharCode(88,83,83))//";alert(String.fromCharCode(88,83,83))//\\";alert(String.fromCharCode(88,83,83))//--&gt;"&gt;\'&gt;=&amp;{}', $result);

        // XSS Quick Test: XSS locator 2
        $result = $this->AppModel->purify('\'\';!--"<XSS>=&{()}');
        $this->assertEquals('\'\';!--"=&amp;{()}', $result);

        // SCRIPT w/Alert()
        $result = $this->AppModel->purify('<SCRIPT>alert(\'XSS\')</SCRIPT>');
        $this->assertEmpty($result);

        // SCRIPT w/Source File: No Filter Evasion
        $result = $this->AppModel->purify('<SCRIPT SRC=http://ha.ckers.org/xss.js></SCRIPT>');
        $this->assertEmpty($result);

        // SCRIPT w/Char Code: fromCharCode
        $result = $this->AppModel->purify('<SCRIPT>alert(String.fromCharCode(88,83,83))</SCRIPT>');
        $this->assertEmpty($result);

        // BASE
        $result = $this->AppModel->purify('<BASE HREF="javascript:alert(\'XSS\');//">');
        $this->assertEmpty($result);

        // BGSOUND
        $result = $this->AppModel->purify('<BGSOUND SRC="javascript:alert(\'XSS\');"');
        $this->assertEmpty($result);

        // BODY background-image
        $result = $this->AppModel->purify('<BODY BACKGROUND="javascript:alert(\'XSS\');">');
        $this->assertEmpty($result);

        // BODY ONLOAD
        $result = $this->AppModel->purify('<BODY ONLOAD=alert(\'XSS\')>');
        $this->assertEmpty($result);

        // DIV background-image 1: DIV background-image
        $result = $this->AppModel->purify('<DIV STYLE="background-image: url(javascript:alert(\'XSS\'))">');
        $this->assertEquals('<div></div>', $result);

        // DIV background-image 2: DIV background-image plus extra characters
        $result = $this->AppModel->purify('<DIV STYLE="background-image: url(&#1;javascript:alert(\'XSS\'))">');
        $this->assertEquals('<div></div>', $result);

        // DIV expression
        $result = $this->AppModel->purify('<DIV STYLE="width: expression(alert(\'XSS\'));">');
        $this->assertEquals('<div></div>', $result);

        // FRAME
        $result = $this->AppModel->purify('<FRAMESET><FRAME SRC="javascript:alert(\'XSS\');"></FRAMESET>');
        $this->assertEmpty($result);

        // IFRAME
        $result = $this->AppModel->purify('<IFRAME SRC="javascript:alert(\'XSS\');"></IFRAME>');
        $this->assertEmpty($result);

        // INPUT Image
        $result = $this->AppModel->purify('<INPUT TYPE="IMAGE" SRC="javascript:alert(\'XSS\');">');
        $this->assertEmpty($result);

        // IMG w/JavaScript Directive
        $result = $this->AppModel->purify('<IMG SRC="javascript:alert(\'XSS\');">');
        $this->assertEmpty($result);

        // IMG No Quotes/Semicolon
        $result = $this->AppModel->purify('<IMG SRC=javascript:alert(\'XSS\')>');
        $this->assertEmpty($result);

        // IMG Dynsrc
        $result = $this->AppModel->purify('<IMG DYNSRC="javascript:alert(\'XSS\');">
');
        $this->assertEmpty($result);

        // IMG Lowsrc
        $result = $this->AppModel->purify('<IMG LOWSRC="javascript:alert(\'XSS\');">');
        $this->assertEmpty($result);

        // IMG Embedded commands 1
        $result = $this->AppModel->purify('<IMG SRC="http://www.thesiteyouareon.com/somecommand.php?somevariables=maliciouscode">');
        $this->assertEquals('<img src="http://www.thesiteyouareon.com/somecommand.php?somevariables=maliciouscode" alt="somecommand.php?somevariables=maliciousc" />', $result);

        // IMG STYLE w/expression: IMG STYLE with expression
        $result = $this->AppModel->purify('exp/*<XSS STYLE=\'no\xss:noxss("*//*");\nxss:&#101;x&#x2F;*XSS*//*/*/pression(alert("XSS"))\'>');
        $this->assertEquals('exp/*', $result);

        // List-style-image
        $result = $this->AppModel->purify('<STYLE>li {list-style-image:url("javascript:alert(\'XSS\')");}</STYLE><UL><LI>XSS');
        $this->assertEquals('<ul><li>XSS</li></ul>', $result);

        // IMG w/VBscript
        $result = $this->AppModel->purify('<IMG SRC=\'vbscript:msgbox("XSS")\'>');
        $this->assertEmpty($result);

        // LAYER
        $result = $this->AppModel->purify('<LAYER SRC="http://ha.ckers.org/scriptlet.html"></LAYER>');
        $this->assertEmpty($result);

        // Livescript
        $result = $this->AppModel->purify('<IMG SRC="livescript:[code]">');
        $this->assertEmpty($result);

        // US-ASCII encoding
        $result = $this->AppModel->purify('scriptalert(XSS)/script');
        $this->assertEquals('scriptalert(XSS)/script', $result);

        // META
        $result = $this->AppModel->purify('<META HTTP-EQUIV="refresh" CONTENT="0;url=javascript:alert(\'XSS\');">');
        $this->assertEmpty($result);

        // META w/data:URL
        $result = $this->AppModel->purify('<META HTTP-EQUIV="refresh" CONTENT="0;url=data:text/html;base64,PHNjcmlwdD5hbGVydCgnWFNTJyk8L3NjcmlwdD4K">');
        $this->assertEmpty($result);

        // META w/additional URL parameter
        $result = $this->AppModel->purify('<META HTTP-EQUIV="refresh" CONTENT="0; URL=http://;URL=javascript:alert(\'XSS\');">');
        $this->assertEmpty($result);

        // Mocha
        $result = $this->AppModel->purify('<IMG SRC="mocha:[code]">');
        $this->assertEmpty($result);

        // OBJECT
        $result = $this->AppModel->purify('<OBJECT TYPE="text/x-scriptlet" DATA="http://ha.ckers.org/scriptlet.html"></OBJECT>');
        $this->assertEmpty($result);

        // OBJECT w/Embedded XSS
        $result = $this->AppModel->purify('<OBJECT classid=clsid:ae24fdae-03c6-11d1-8b76-0080c744f389><param name=url value=javascript:alert(\'XSS\')></OBJECT>');
        $this->assertEmpty($result);

        // Embed Flash
        $result = $this->AppModel->purify('<EMBED SRC="http://ha.ckers.org/xss.swf" AllowScriptAccess="always"></EMBED>');
        $this->assertEmpty($result);

        // STYLE
        $result = $this->AppModel->purify('<STYLE TYPE="text/javascript">alert(\'XSS\');</STYLE>');
        $this->assertEmpty($result);

        // STYLE w/Comment
        $result = $this->AppModel->purify('<IMG STYLE="xss:expr/*XSS*/ession(alert(\'XSS\'))">');
        $this->assertEmpty($result);

        // STYLE w/Anonymous HTML
        $result = $this->AppModel->purify('<XSS STYLE="xss:expression(alert(\'XSS\'))">');
        $this->assertEmpty($result);

        // STYLE w/background-image
        $result = $this->AppModel->purify('<STYLE>.XSS{background-image:url("javascript:alert(\'XSS\')");}</STYLE><A CLASS=XSS></A>');
        $this->assertEquals('<a class="XSS"></a>', $result);

        // STYLE w/background
        $result = $this->AppModel->purify('<STYLE type="text/css">BODY{background:url("javascript:alert(\'XSS\')")}</STYLE>');
        $this->assertEmpty($result);

        // Stylesheet
        $result = $this->AppModel->purify('<LINK REL="stylesheet" HREF="javascript:alert(\'XSS\');">');
        $this->assertEmpty($result);

        // Remote Stylesheet 1
        $result = $this->AppModel->purify('<LINK REL="stylesheet" HREF="http://ha.ckers.org/xss.css">');
        $this->assertEmpty($result);

        // Remote Stylesheet 2
        $result = $this->AppModel->purify('<STYLE>@import\'http://ha.ckers.org/xss.css\';</STYLE>');
        $this->assertEmpty($result);

        // Remote Stylesheet 3
        $result = $this->AppModel->purify('<META HTTP-EQUIV="Link" Content="<http://ha.ckers.org/xss.css>; REL=stylesheet">');
        $this->assertEmpty($result);

        // Remote Stylesheet 4
        $result = $this->AppModel->purify('<STYLE>BODY{-moz-binding:url("http://ha.ckers.org/xssmoz.xml#xss")}</STYLE>');
        $this->assertEmpty($result);

        // TABLE
        $result = $this->AppModel->purify('<TABLE BACKGROUND="javascript:alert(\'XSS\')"></TABLE>');
        $this->assertEmpty($result);

        // TD
        $result = $this->AppModel->purify('<TABLE><TD BACKGROUND="javascript:alert(\'XSS\')"></TD></TABLE>');
        $this->assertEmpty($result);

        // XML namespace
        $result = $this->AppModel->purify('<HTML xmlns:xss><?import namespace="xss" implementation="http://ha.ckers.org/xss.htc"><xss:xss>XSS</xss:xss></HTML>');
        $this->assertEquals('&lt;?import namespace="xss" implementation="http://ha.ckers.org/xss.htc"&gt;XSS', $result);

        // XML data island w/CDATA
        $result = $this->AppModel->purify('<XML ID=I><X><C><![CDATA[<IMG SRC="javas]]><![CDATA[cript:alert(\'XSS\');">]]></C></X></xml><SPAN DATASRC=#I DATAFLD=C DATAFORMATAS=HTML>');
        $this->assertEquals('&lt;IMG SRC="javascript:alert(\'XSS\');"&gt;<span></span>', $result);

        // XML data island w/comment
        $result = $this->AppModel->purify('<XML ID="xss"><I><B><IMG SRC="javas<!-- -->cript:alert(\'XSS\')"></B></I></XML><SPAN DATASRC="#xss" DATAFLD="B" DATAFORMATAS="HTML"></SPAN>');
        $this->assertEquals('<i><b><img src="javas" alt="javas&lt;!-- --&gt;cript:alert(\'XSS\')" /></b></i><span></span>', $result);

        // XML (locally hosted)
        $result = $this->AppModel->purify('<XML SRC="http://ha.ckers.org/xsstest.xml" ID=I></XML><SPAN DATASRC=#I DATAFLD=C DATAFORMATAS=HTML></SPAN>');
        $this->assertEquals('<span></span>', $result);

        // XML HTML+TIME
        $result = $this->AppModel->purify('<HTML><BODY><?xml:namespace prefix="t" ns="urn:schemas-microsoft-com:time"><?import namespace="t" implementation="#default#time2"><t:set attributeName="innerHTML" to="XSS<SCRIPT DEFER>alert(\'XSS\')</SCRIPT>"> </BODY></HTML>');
        $this->assertEquals('&lt;?xml:namespace prefix="t" ns="urn:schemas-microsoft-com:time"&gt;&lt;?import namespace="t" implementation="#default#time2"&gt;', $result);

        // Commented-out Block
        $result = $this->AppModel->purify('<!--[if gte IE 4]><SCRIPT>alert(\'XSS\');</SCRIPT><![endif]-->');
        $this->assertEmpty($result);

        // Cookie Manipulation
        $result = $this->AppModel->purify('<META HTTP-EQUIV="Set-Cookie" Content="USERID=<SCRIPT>alert(\'XSS\')</SCRIPT>">');
        $this->assertEmpty($result);

        // Local .htc file
        $result = $this->AppModel->purify('<XSS STYLE="behavior: url(http://ha.ckers.org/xss.htc);">');
        $this->assertEmpty($result);

        // Rename .js to .jpg
        $result = $this->AppModel->purify('<SCRIPT SRC="http://ha.ckers.org/xss.jpg"></SCRIPT>');
        $this->assertEmpty($result);

        // SSI
        $result = $this->AppModel->purify('<!--#exec cmd="/bin/echo \'<SCRIPT SRC\'"--><!--#exec cmd="/bin/echo \'=http://ha.ckers.org/xss.js></SCRIPT>\'"-->');
        $this->assertEmpty($result);

        // PHP
        $result = $this->AppModel->purify('<? echo(\'<SCR)\'; echo(\'IPT>alert("XSS")</SCRIPT>\'); ?>');
        $this->assertEquals('&lt;? echo(\'alert("XSS")\'); ?&gt;', $result);

        // JavaScript Includes
        $result = $this->AppModel->purify('<BR SIZE="&{alert(\'XSS\')}">');
        $this->assertEquals('<br />', $result);

        // Character Encoding Example
        $result = $this->AppModel->purify('< %3C &lt &lt; &LT &LT; &#60 &#060 &#0060 &#00060 &#000060 &#0000060 &#60; &#060; &#0060; &#00060; &#000060; &#0000060; &#x3c &#x03c &#x003c &#x0003c &#x00003c &#x000003c &#x3c; &#x03c; &#x003c; &#x0003c; &#x00003c; &#x000003c; &#X3c &#X03c &#X003c &#X0003c &#X00003c &#X000003c &#X3c; &#X03c; &#X003c; &#X0003c; &#X00003c; &#X000003c; &#x3C &#x03C &#x003C &#x0003C &#x00003C &#x000003C &#x3C; &#x03C; &#x003C; &#x0003C; &#x00003C; &#x000003C; &#X3C &#X03C &#X003C &#X0003C &#X00003C &#X000003C &#X3C; &#X03C; &#X003C; &#X0003C; &#X00003C; &#X000003C; \x3c \x3C \u003c \u003C');
        $this->assertEquals('&lt; %3C &amp;lt &lt; &amp;LT &amp;LT; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; &lt; \x3c \x3C \u003c \u003C', $result);

        // Case Insensitive
        $result = $this->AppModel->purify('<IMG SRC=JaVaScRiPt:alert(\'XSS\')>');
        $this->assertEmpty($result);

        // HTML Entities
        $result = $this->AppModel->purify('<IMG SRC=javascript:alert(&quot;XSS&quot;)>');
        $this->assertEmpty($result);

        // Grave Accents
        $result = $this->AppModel->purify('<IMG SRC=`javascript:alert("RSnake says, \'XSS\'")`>');
        $this->assertEquals('<img src="%60javascript%3Aalert(" alt="`javascript:alert(&quot;RSnake" />', $result);

        // Image w/CharCode
        $result = $this->AppModel->purify('<IMG SRC=javascript:alert(String.fromCharCode(88,83,83))>');
        $this->assertEmpty($result);

        // UTF-8 Unicode Encoding
        $result = $this->AppModel->purify('<IMG SRC=&#106;&#97;&#118;&#97;&#115;&#99;&#114;&#105;&#112;&#116;&#58;&#97;&#108;&#101;&#114;&#116;&#40;&#39;&#88;&#83;&#83;&#39;&#41;>');
        $this->assertEmpty($result);

        // Long UTF-8 Unicode w/out Semicolons
        $result = $this->AppModel->purify('<IMG SRC=&#0000106&#0000097&#0000118&#0000097&#0000115&#0000099&#0000114&#0000105&#0000112&#0000116&#0000058&#0000097&#0000108&#0000101&#0000114&#0000116&#0000040&#0000039&#0000088&#0000083&#0000083&#0000039&#0000041>');
        $this->assertEmpty($result);

        // DIV w/Unicode
        $result = $this->AppModel->purify('<DIV STYLE="background-image:\\0075\\0072\\006C\\0028\'\\006a\\0061\\0076\\0061\\0073\\0063\\0072\\0069\\0070\\0074\\003a\\0061\\006c\\0065\\0072\\0074\\0028.1027\\0058.1053\\0053\\0027\\0029\'\\0029">');
        $this->assertEquals('<div></div>', $result);

        // Hex Encoding w/out Semicolons
        $result = $this->AppModel->purify('<IMG SRC=&#x6A&#x61&#x76&#x61&#x73&#x63&#x72&#x69&#x70&#x74&#x3A&#x61&#x6C&#x65&#x72&#x74&#x28&#x27&#x58&#x53&#x53&#x27&#x29>');
        $this->assertEmpty($result);

        // UTF-7 Encoding
        $result = $this->AppModel->purify('<HEAD><META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=UTF-7"></HEAD>+ADw-SCRIPT+AD4-alert(\'XSS\');+ADw-/SCRIPT+AD4-');
        $this->assertEquals('+ADw-SCRIPT+AD4-alert(\'XSS\');+ADw-/SCRIPT+AD4-', $result);

        // Escaping JavaScript escapes
        $result = $this->AppModel->purify('\\";alert(\'XSS\');//');
        $this->assertEquals('\\";alert(\'XSS\');//', $result);

        // End title tag
        $result = $this->AppModel->purify('</TITLE><SCRIPT>alert("XSS");</SCRIPT>');
        $this->assertEmpty($result);

        // STYLE w/broken up JavaScript
        $result = $this->AppModel->purify('<STYLE>@im\\port\'\\ja\\vasc\\ript:alert("XSS")\';</STYLE>');
        $this->assertEmpty($result);

        // Embedded Tab
        $result = $this->AppModel->purify('<IMG SRC="jav	ascript:alert(\'XSS\');">', $result);
        $this->assertEquals('<img src="jav%20ascript%3Aalert(\'XSS\');" alt="jav ascript:alert(\'XSS\');" />', $result);

        // Embedded Encoded Tab
        $result = $this->AppModel->purify('<IMG SRC="jav&#x09;ascript:alert(\'XSS\');">', $result);
        $this->assertEquals('<img src="jav%20ascript%3Aalert(\'XSS\');" alt="jav ascript:alert(\'XSS\');" />', $result);

        // Embedded Newline
        $result = $this->AppModel->purify('<IMG SRC="jav&#x0A;ascript:alert(\'XSS\');">', $result);
        $this->assertEquals('<img src="jav%20ascript%3Aalert(\'XSS\');" alt="jav ascript:alert(\'XSS\');" />', $result);

        // Embedded Carriage Return
        $result = $this->AppModel->purify('<IMG SRC="jav&#x0D;ascript:alert(\'XSS\');">', $result);
        $this->assertEquals('<img src="jav%20ascript%3Aalert(\'XSS\');" alt="jav ascript:alert(\'XSS\');" />', $result);

        // Embedded Carriage Return
        $result = $this->AppModel->purify('<IMG
SRC
=
"
j
a
v
a
s
c
r
i
p
t
:
a
l
e
r
t
(
\'
X
S
S
\'
)
"
>', $result);
        $this->assertEquals('<img src="j%20a%20v%20a%20s%20c%20r%20i%20p%20t%20%3A%20a%20l%20e%20r%20t%20(%20\'%20X%20S%20S%20\'%20)" alt="j a v a s c r i p t : a l e r t ( \' X S" />', $result);

        // Null Chars 1

        // Null Chars 2

        // Spaces/Meta Chars
        $result = $this->AppModel->purify('<IMG SRC=" &#14;javascript:alert(\'XSS\');">');
        $this->assertEmpty($result);

        // Non-Alpha/Non-Digit
        $result = $this->AppModel->purify('<SCRIPT/XSS SRC="http://ha.ckers.org/xss.js"></SCRIPT>');
        $this->assertEmpty($result);

        // Non-Alpha/Non-Digit Part 2
        $result = $this->AppModel->purify('<BODY onload!#$%&()*~+-_.,:;?@[/|\]^`=alert("XSS")>');
        $this->assertEmpty($result);

        // No Closing Script Tag
        $result = $this->AppModel->purify('<SCRIPT SRC=http://ha.ckers.org/xss.js');
        $this->assertEmpty($result);

        // Protocol resolution in script tags
        $result = $this->AppModel->purify('<SCRIPT SRC=//ha.ckers.org/.j>');
        $this->assertEmpty($result);

        // Half-Open HTML/JavaScript
        $result = $this->AppModel->purify('<IMG SRC="javascript:alert(\'XSS\')"');
        $this->assertEmpty($result);

        // Double open angle brackets
        $result = $this->AppModel->purify('<IFRAME SRC=http://ha.ckers.org/scriptlet.html <');
        $this->assertEmpty($result);

        // Extraneous Open Brackets
        $result = $this->AppModel->purify('<<SCRIPT>alert("XSS");//<</SCRIPT>');
        $this->assertEquals('&lt;', $result);

        // Malformed IMG Tags
        $result = $this->AppModel->purify('<IMG """><SCRIPT>alert("XSS")</SCRIPT>">');
        $this->assertEquals('"&gt;', $result);

        // No Quotes/Semicolons
        $result = $this->AppModel->purify('<SCRIPT>a=/XSS/alert(a.source)</SCRIPT>');
        $this->assertEmpty($result);

        // Evade Regex Filter 1
        $result = $this->AppModel->purify('<SCRIPT a=">" SRC="http://ha.ckers.org/xss.js"></SCRIPT>');
        $this->assertEmpty($result);

        // Evade Regex Filter 2
        $result = $this->AppModel->purify('<SCRIPT ="blah" SRC="http://ha.ckers.org/xss.js"></SCRIPT>');
        $this->assertEmpty($result);

        // Evade Regex Filter 3
        $result = $this->AppModel->purify('<SCRIPT a="blah" \'\' SRC="http://ha.ckers.org/xss.js"></SCRIPT>');
        $this->assertEmpty($result);

        // Evade Regex Filter 4
        $result = $this->AppModel->purify('<SCRIPT "a=\'>\'" SRC="http://ha.ckers.org/xss.js"></SCRIPT>');
        $this->assertEmpty($result);

        // Evade Regex Filter 5
        $result = $this->AppModel->purify('<SCRIPT a=`>` SRC="http://ha.ckers.org/xss.js"></SCRIPT>');
        $this->assertEmpty($result);

        // Filter Evasion 1
        $result = $this->AppModel->purify('<SCRIPT>document.write("<SCRI");</SCRIPT>PT SRC="http://ha.ckers.org/xss.js"></SCRIPT>');
        $this->assertEquals('PT SRC="http://ha.ckers.org/xss.js"&gt;', $result);

        // Filter Evasion 2
        $result = $this->AppModel->purify('<SCRIPT a=">\'>" SRC="http://ha.ckers.org/xss.js"></SCRIPT>');
        $this->assertEmpty($result);

        // IP Encoding
        $result = $this->AppModel->purify('<A HREF="http://66.102.7.147/">XSS</A>');
        $this->assertEquals('<a href="http://66.102.7.147/">XSS</a>', $result);

        // URL Encoding
        // will only work if HTMLPurifier is configured with
        // URI.HostBlacklist or URI.DisableExternal
        $result = $this->AppModel->purify('<A HREF="http://%77%77%77%2E%67%6F%6F%67%6C%65%2E%63%6F%6D">XSS</A>');
        // $this->assertEquals('<a>XSS</a>', $result);

        // Dword Encoding
        $result = $this->AppModel->purify('<A HREF="http://1113982867/">XSS</A>');
        $this->assertEquals('<a href="/">XSS</a>', $result);

        // Hex Encoding
        $result = $this->AppModel->purify('<A HREF="http://0x42.0x0000066.0x7.0x93/">XSS</A>');
        $this->assertEquals('<a href="/">XSS</a>', $result);

        // Octal Encoding
        $result = $this->AppModel->purify('<A HREF="http://0102.0146.0007.00000223/">XSS</A>');
        $this->assertEquals('<a href="/">XSS</a>', $result);

        // Mixed Encoding
        $result = $this->AppModel->purify('<A HREF="h tt	p://6&#09;6.000146.0x7.147/">XSS</A>');
        $this->assertEquals('<a href="h%20tt%20p%3A//6%206.000146.0x7.147/">XSS</a>', $result);

        // Protocol Resolution Bypass
        // will only work if HTMLPurifier is configured with
        // URI.HostBlacklist or URI.DisableExternal
        $result = $this->AppModel->purify('<A HREF="//www.google.com/">XSS</A>');
        // $this->assertEquals('<a>XSS</a>', $result);

        // Firefox Lookups 1
        $result = $this->AppModel->purify('<A HREF="//google">XSS</A>');
        $this->assertEquals('<a href="//google">XSS</a>', $result);

        // Firefox Lookups 2
        $result = $this->AppModel->purify('<A HREF="http://ha.ckers.org@google">XSS</A>');
        $this->assertEquals('<a href="http://google">XSS</a>', $result);

        // Firefox Lookups 3
        $result = $this->AppModel->purify('<A HREF="http://google:ha.ckers.org">XSS</A>');
        $this->assertEquals('<a href="http://google">XSS</a>', $result);

        // Removing Cnames
        // will only work if HTMLPurifier is configured with
        // URI.HostBlacklist or URI.DisableExternal
        $result = $this->AppModel->purify('<A HREF="http://www.google.com/">XSS</A>');
        // $this->assertEquals('<a href="http://google.com/">XSS</a>', $result);

        // Extra dot for Absolute DNS
        // will only work if HTMLPurifier is configured with
        // URI.HostBlacklist or URI.DisableExternal
        $result = $this->AppModel->purify('<A HREF="http://www.google.com./">XSS</A>');
        // $this->assertEquals('<a>XSS</a>', $result);

        // JavaScript Link Location
        $result = $this->AppModel->purify('<A HREF="javascript:document.location=\'http://www.google.com/\'">XSS</A>');
        $this->assertEquals('<a>XSS</a>', $result);

        // Content Replace
        $result = $this->AppModel->purify('<A HREF="http://www.gohttp://www.google.com/ogle.com/">XSS</A>');
        $this->assertEquals('<a href="http://www.gohttp//www.google.com/ogle.com/">XSS</a>', $result);

    }
}
