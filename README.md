# biz.jmaconsulting.currentpaymentversion

## Overview
Show only the current state of each payment transaction. Hide payment reversals and previous versions of each payment transaction.

## Description
CiviCRM allows payments to be edited. For bookkeeping purposes, when a payment is edited, the existing payment is reversed and the new changed one is created. Currently CiviCRM shows all the versions of each payment, including reversals, in all of the places where payments for a contribution are listed: contact summary page, contribution view, contribution edit, contribution search results, etc.

With this extension you can choose to either show only the latest version of each payment(s) or all of the historical versions of payments. Here is a demo:
 ![screencast-reprint](https://user-images.githubusercontent.com/3735621/46945909-c47b8780-d093-11e8-9f70-c16597a6f304.gif)

## Requirements
* PHP v5.4+
* CiviCRM 5.0+

## Installation (Web UI)
Once reviewed and approved for automated distribution, this extension will become available for installation via a browser inside CiviCRM:
1. Navigate to Administer > System Settings > Extensions.
2. Click on the Add New tab.
3. Beside this extension click the Download link.
4. Click on Download and Install button.

## Installation (CLI, Zip)
Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl biz.jmaconsulting.showlatestpayments@https://github.com/JMAConsulting/biz.jmaconsulting.currentpaymentversion/archive/master.zip
```

## Installation (CLI, Git)
Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/JMAConsulting/biz.jmaconsulting.currentpaymentversion.git
cv en showlatestpayments
```

## Usage

To change the default behaviour of showing all versions of payments so only the latest is shown:
1. Navigate to Administer > CiviContribute > CiviContribute Component Settings.
2. Set 'Do you want to show only latest version of payments' to Yes.
3. Click Save.
Alternatively, set 'Do you want to show only latest version of payments' to No to show all versions.
