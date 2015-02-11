<?php
require "includes/Flintstone/vendor/autoload.php";
use Flintstone\Flintstone;

# Example setup data

$home_data = <<<HOM
<p>Welcome! You can edit this page from your website admine panel!<br/>
Just head to www.yourwebsite.com/yourpiccoloinstalldir/admin/</p>
HOM;

$install_data = <<<INS
<p>Here it is a copy of the INSTALL instructions. Note it may be outdated, check
the version in you downloaded archive.</p>
<h1>INSTALL INSTRUCTIONS</h1>
<p>
Load the content of this archive to your webserver.<br/>
Then:
<ul>
<li>chmod 777 the directory database/</li>
<li>chmod 777 the directory files/</li>
<li>open the page install.php with your browser</li>
<li>remove install.php from your server!!</li>
<li>modify the content of admin/config.php as described below</li>
</ul>
</p>

<h2>admin/config.php</h2>
<p>
This file contains variables used for the administration of the website.</br>
Edit the values of the following to match your own configuration.
<ul>
<li>\$login_password contains the clear password used for login.
 This is not a security issue, as if someone was able to read the source
 of config.php and steal the password, then it would already have access
 to the whole server!</li>
<li>\$install_dir contains the path of your piccolo install insidde your server</li>
<li>\$base_url contains the basis url of your install. It does not contains the http:// or https:// beginning</li>
<li>\$force_https can be valued true or false. Forces the usage of SSL for the admin tools.</li>
</p>

<h2>Example of a config.php</h2>
<p>
<plaintext>
<?php
\$login_password = "mYaWeSoM3PaSzWoRd!";
\$install_dir = "/var/www/piccolo/";
\$base_url = "www.example.com/piccolo/"; //WITHOUT HTTP/HTTPS!!!!
\$force_https = true;
?>
</plaintext>
</p>
INS;

$support_data = <<<SUP
If you need any help, head to <a href="http://piccolocms.sourceforge.net">http://piccolocms.sourceforge.net</a>!
SUP;

$options = array('dir' => 'database/'); // Set options
$pages = Flintstone::load('pages', $options); // Load the databases
$pages->flush();
$pages->set('home', array( 'name' => 'home',
                               'title' => 'Home',
                               'content' => $home_data,
                               'hierarchy' => 0,
                               'parent' => null,
                               'subpages' => array()
                         )); // Set keys
$pages->set('faq', array('name' => 'install',
                        'title' => 'Install instructions',
                        'content' => $install_data,
                        'hierarchy' => 0,
                        'parent' => null,
                        'subpages' => array( 'oldfaqs', 'newfaqs' )
                   ));
$pages->set('oldfaqs', array( 'name' => 'support',
                              'title' => 'Support',
                              'content' => $support_data,
                              'hierarchy' => 1,
                              'parent' => 'install',
                              'subpages' => array()
                            ));

# Load the databases
$site = Flintstone::load('site', $options);
$site->flush();
$site->set('header', array('title' => 'Piccolo CMS',
                           'motto' => 'The Namekian CMS'));
$site->set('footer', "Powered by Piccolo");

?>
<h2>THIS SCRIPT MUST NOT BE LEFT ON THE SERVER!</h2>
<a href="index.php">Index</a>


