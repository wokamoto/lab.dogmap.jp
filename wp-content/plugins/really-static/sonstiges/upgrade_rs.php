<?php
function rs_updateoption($alt,$neu){
	add_option ( $neu,get_option ( $alt) );
	delete_option($alt);
}
RS_LOG("Init Really-static Update");

$testversion=0.520121210;
if(get_option ( 'rs_firstTime') < $testversion){
	rs_updateoption("dateierweiterungen","rs_fileextensions");
	rs_updateoption("realstaticdonationid","rs_donationid");
	rs_updateoption("makestatic-a1","rs_makestatic_a1");
	rs_updateoption("makestatic-a2","rs_makestatic_a2");
	rs_updateoption("makestatic-a3","rs_makestatic_a3");
	rs_updateoption("makestatic-a4","rs_makestatic_a4");
	rs_updateoption("makestatic-a5","rs_makestatic_a5");
	rs_updateoption("makestatic-a6","rs_makestatic_a6");
	rs_updateoption("maketagstatic","rs_maketagstatic");
	rs_updateoption("makecatstatic","rs_makecatstatic");
	rs_updateoption("makeauthorstatic","rs_makeauthorstatic");
	rs_updateoption("makedatestatic","rs_makedatestatic");
	rs_updateoption("makedatetagstatic","rs_makedatetagstatic");
	rs_updateoption("makedatemonatstatic","rs_makedatemonatstatic");
	rs_updateoption("makedatejahrstatic","rs_makedatejahrstatic");
	rs_updateoption("makeindexstatic","rs_makeindexstatic");
	rs_updateoption("realstaticdesignlocal","rs_designlocal");
	rs_updateoption("realstaticdesignremote","rs_designremote");
	rs_updateoption("realstaticeverytime","rs_everytime");
	rs_updateoption("realstaticpageeditcreatedelete","rs_pageeditcreatedelete");
	rs_updateoption("realstaticcommenteditcreatedelete","rs_commenteditcreatedelete");
	rs_updateoption("realstaticeveryday","rs_everyday");
	rs_updateoption("realstaticposteditcreatedelete","rs_posteditcreatedelete");
	rs_updateoption("realstaticurlrewriteinto","rs_urlrewriteinto");
	rs_updateoption("realstaticlokalerspeicherpfad","rs_lokalerspeicherpfad");
	rs_updateoption("realstaticnonpermanent","rs_nonpermanent");
	rs_updateoption("realstaticlocalpath","rs_localpath");
	rs_updateoption("realstaticsubpfad","rs_subpfad");
	rs_updateoption("realstaticremoteurl","rs_remoteurl");
	rs_updateoption("realstaticlocalurl","rs_localurl");
	rs_updateoption("realstaticremotepath","rs_remotepath");
	rs_updateoption("realstaticftpserver","rs_ftpserver");
	rs_updateoption("realstaticftpuser","rs_ftpuser");
	rs_updateoption("realstaticftppasswort","rs_ftppasswort");
	rs_updateoption("realstaticftpport","rs_ftpport");
	rs_updateoption("realstaticremotepathsftp","rs_remotepathsftp");
	rs_updateoption("realstaticsftpserver","rs_sftpserver");
	rs_updateoption("realstaticsftpuser","rs_sftpuser");
	rs_updateoption("realstaticsftppasswort","rs_sftppasswort");
	rs_updateoption("realstaticsftpport","rs_sftpport");
	add_option( 'rs_logfile',true);
	update_option ( 'rs_firstTime',$testversion);
	RS_LOG("Init Really-static updatet to ".$testversion);
}
$testversion=0.520121211;
if(get_option ( 'rs_firstTime') < $testversion){
	add_option( 'rs_allrefreshcache',array());
	add_option( 'rs_ftpsaveroutine',1);
	update_option ( 'rs_firstTime',$testversion);
	RS_LOG("Init Really-static updatet to ".$testversion);
}
?>