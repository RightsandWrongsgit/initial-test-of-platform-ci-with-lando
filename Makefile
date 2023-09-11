SHELL := /usr/bin/env bash

########################################################
## update_project        keeps caches enabled         ##
## development_project   sets caches to disabled      ##
########################################################


.PHONY: update_project
update_project:
	cd web/sites/default
	rm -f settings.local.php
	cd ~/initial-test-of-platform-ci-with-lando
	cp web/sites/my-update.settings.local.php web/sites/default/settings.local.php
	cd ~/initial-test-of-platform-ci-with-lando
	lando init --source cwd --recipe platformsh

########################################################
## development_project   sets settings.local.php to   ##
## disable render, page, & dyanamic page caches plus  ##
## is is set to call my-development.services.yml      ##
########################################################


.PHONY: development_project
development_project:
	cd web/sites/default
	rm -f settings.local.php
	cd ~/initial-test-of-platform-ci-with-lando
	cp web/sites/my-example.settings.local.php web/sites/default/settings.local.php
	cd ~/initial-test-of-platform-ci-with-lando
	lando rebuild
