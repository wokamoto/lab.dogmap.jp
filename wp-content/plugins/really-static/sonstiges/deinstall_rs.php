<?php
global $wpdb;
RS_LOG("Init Really-static deinstall");
RS_LOG("remove Database");
$querystr = "DROP TABLE IF EXISTS `".REALLYSTATICDATABASE."`;";
$wpdb->get_results($querystr, OBJECT );
RS_LOG("remove defaults");

delete_option('rs_fileextensions' );
delete_option("rs_expertmode");
delete_option("rs_stupidfilereplaceA");
delete_option("rs_stupidfilereplaceB");
delete_option("rs_stupidfilereplaceC");
delete_option("rs_stupidfilereplaceD");
delete_option("rs_counter");
delete_option("rs_firstTime");
delete_option('rs_makestatic_a1');
delete_option('rs_makestatic_a2');
delete_option('rs_makestatic_a3');
delete_option('rs_makestatic_a4');
delete_option('rs_makestatic_a5');
delete_option('rs_makestatic_a6');
delete_option('rs_makestatic_a7');
delete_option('rs_posteditcreatedelete');
delete_option('rs_urlrewriteinto');
delete_option('rs_lokalerspeicherpfad');

delete_option('rs_nonpermanent');


delete_option('rs_localpath');
delete_option('rs_subpfad');
delete_option('rs_remoteurl');

delete_option('rs_localurl');

delete_option('rs_remotepath');
delete_option('rs_ftpserver');
delete_option('rs_ftpuser');
delete_option('rs_ftppasswort');
delete_option('rs_ftpport');

delete_option('rs_remotepathsftp');
delete_option('rs_sftpserver');
delete_option('rs_sftpuser');
delete_option('rs_sftppasswort');
delete_option('rs_sftpport');

delete_option('rs_save');
delete_option('rs_designlocal');
delete_option('rs_designremote');
delete_option('rs_everytime');
delete_option('rs_pageeditcreatedelete');
delete_option('rs_commenteditcreatedelete');
delete_option('rs_everyday');

delete_option('rs_donationid');

delete_option('rs_maketagstatic');
delete_option('rs_makecatstatic');
delete_option('rs_makeauthorstatic');
delete_option('rs_makedatestatic');
delete_option("rs_makedatetagstatic");
delete_option("rs_makedatemonatstatic");
delete_option("rs_makedatejahrstatic");

delete_option('rs_makeindexstatic');

delete_option('rs_hide_adminpannel');
delete_option( 'rs_showokmessage');
delete_option( 'rs_onwork');
delete_option( 'rs_ftpsaveroutine');
delete_option( 'rs_allrefreshcache');
RS_LOG("init defaults done");
?>