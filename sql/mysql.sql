# SQL Dump for wggithub module
# PhpMyAdmin Version: 4.0.4
# http://www.phpmyadmin.net
#
# Host: localhost
# Generated on: Wed Nov 25, 2020 to 13:33:56
# Server version: 5.5.5-10.4.10-MariaDB
# PHP Version: 7.3.12

#
# Structure table for `wggithub_settings` 7
#

CREATE TABLE `wggithub_settings` (
  `set_id`        INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `set_username`  VARCHAR(255)    NOT NULL DEFAULT '',
  `set_token`     VARCHAR(255)    NOT NULL DEFAULT '',
  `set_options`   TEXT            NOT NULL ,
  `set_primary`   INT(1)          NOT NULL DEFAULT '0',
  `set_date`      INT(11)         NOT NULL DEFAULT '0',
  `set_submitter` INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`set_id`)
) ENGINE=InnoDB;

#
# Structure table for `wggithub_directories` 8
#

CREATE TABLE `wggithub_directories` (
  `dir_id`            INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dir_name`          VARCHAR(255)    NOT NULL DEFAULT '',
  `dir_descr`         TEXT            NOT NULL,
  `dir_type`          INT(10)         NOT NULL DEFAULT '0',
  `dir_content`       INT(10)         NOT NULL DEFAULT '0',
  `dir_autoupdate`    INT(1)          NOT NULL DEFAULT '0',
  `dir_online`        INT(1)          NOT NULL DEFAULT '0',
  `dir_filterrelease` INT(1)          NOT NULL DEFAULT '0',
  `dir_weight`        INT(10)         NOT NULL DEFAULT '0',
  `dir_datecreated`   INT(11)         NOT NULL DEFAULT '0',
  `dir_submitter`     INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`dir_id`)
) ENGINE=InnoDB;

#
# Structure table for `wggithub_logs` 5
#

CREATE TABLE `wggithub_logs` (
  `log_id`          INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_type`        INT(1)          NOT NULL DEFAULT '0',
  `log_details`     VARCHAR(255)    NOT NULL DEFAULT '',
  `log_result`      TEXT            NOT NULL ,
  `log_datecreated` INT(11)         NOT NULL DEFAULT '0',
  `log_submitter`   INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB;

#
# Structure table for `wggithub_repositories` 13
#

CREATE TABLE `wggithub_repositories` (
  `repo_id`          INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `repo_nodeid`      VARCHAR(255)    NOT NULL DEFAULT '',
  `repo_user`        VARCHAR(255)    NOT NULL DEFAULT '',
  `repo_name`        VARCHAR(255)    NOT NULL DEFAULT '',
  `repo_fullname`    VARCHAR(255)    NOT NULL DEFAULT '',
  `repo_createdat`   INT(11)         NOT NULL DEFAULT '0',
  `repo_updatedat`   INT(11)         NOT NULL DEFAULT '0',
  `repo_htmlurl`     VARCHAR(255)    NOT NULL DEFAULT '',
  `repo_readme`      INT(1)          NOT NULL DEFAULT '0',
  `repo_prerelease`  INT(1)          NOT NULL DEFAULT '0',
  `repo_release`     INT(1)          NOT NULL DEFAULT '0',
  `repo_approved`    INT(1)          NOT NULL DEFAULT '0',
  `repo_status`      INT(1)          NOT NULL DEFAULT '0',
  `repo_datecreated` INT(11)         NOT NULL DEFAULT '0',
  `repo_submitter`   INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`repo_id`)
) ENGINE=InnoDB;

#
# Structure table for `wggithub_readmes` 9
#

CREATE TABLE `wggithub_readmes` (
  `rm_id`          INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rm_repoid`      INT(10)         NOT NULL DEFAULT '0',
  `rm_name`        VARCHAR(255)    NOT NULL DEFAULT '',
  `rm_type`        VARCHAR(255)    NOT NULL DEFAULT '',
  `rm_content`     TEXT            NOT NULL ,
  `rm_encoding`    VARCHAR(50)     NOT NULL DEFAULT '',
  `rm_downloadurl` VARCHAR(255)    NOT NULL DEFAULT '',
  `rm_baseurl`     VARCHAR(255)    NOT NULL DEFAULT '',
  `rm_datecreated` INT(11)         NOT NULL DEFAULT '0',
  `rm_submitter`   INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`rm_id`)
) ENGINE=InnoDB;

#
# Structure table for `wggithub_releases` 10
#

CREATE TABLE `wggithub_releases` (
  `rel_id`          INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rel_repoid`      INT(10)         NOT NULL DEFAULT '0',
  `rel_type`        INT(10)         NOT NULL DEFAULT '0',
  `rel_name`        VARCHAR(255)    NOT NULL DEFAULT '',
  `rel_prerelease`  INT(1)          NOT NULL DEFAULT '0',
  `rel_publishedat` INT(11)         NOT NULL DEFAULT '0',
  `rel_tarballurl`  VARCHAR(255)    NOT NULL DEFAULT '',
  `rel_zipballurl`  VARCHAR(255)    NOT NULL DEFAULT '',
  `rel_datecreated` INT(11)         NOT NULL DEFAULT '0',
  `rel_submitter`   INT(10)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`rel_id`)
) ENGINE=InnoDB;

