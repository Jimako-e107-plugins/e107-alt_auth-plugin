<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2012 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Alt_auth plugin - event handler (outbound user sync)
 *
 * $URL$
 * $Id$
 *
 */

/**
 *	e107 Alternate authorisation plugin
 *
 *	@package	e107_plugins
 *	@subpackage	alt_auth
 *	@version 	$Id$;
 */

if (!defined('e107_INIT')) { exit; }


class alt_auth_event
{

	/**
	 *	Register the event callbacks handled by this plugin.
	 *
	 *	@return array
	 */
	function config()
	{
		$event = array();

		$event[] = array(
			'name'     => 'login',
			'function' => 'outboundSync',
		);

		return $event;
	}


	/**
	 *	Outbound user sync (Phase 1 - 'otherdb' backend only).
	 *
	 *	When an e107 user logs in and is missing from the external otherdb
	 *	database, create them there with a random (unusable) password.
	 *
	 *	The entire body is wrapped in try/catch so that a failure here can
	 *	never break the login flow.
	 *
	 *	@param array $data - login event data (user_id, user_name, ...)
	 *	@return void
	 */
	function outboundSync($data)
	{
		try
		{
			// (a) Gate: feature must be enabled.
			if (!e107::getPref('auth_signup'))
			{
				return;
			}

			// (b) Gate: 'otherdb' must be one of the active auth methods.
			$method1 = e107::getPref('auth_method');
			$method2 = e107::getPref('auth_method2');
			if ($method1 !== 'otherdb' && $method2 !== 'otherdb')
			{
				return;
			}

			// (c) Load the otherdb configuration.
			require_once(e_PLUGIN.'alt_auth/alt_auth_login_class.php');
			$base = new alt_auth_base();
			$conf = $base->altAuthGetParams('otherdb');

			$required = array(
				'otherdb_server',
				'otherdb_database',
				'otherdb_username',
				'otherdb_password',
				'otherdb_table',
				'otherdb_user_field',
				'otherdb_password_field',
			);
			foreach ($required as $key)
			{
				if (empty($conf[$key]))
				{
					return;
				}
			}

			// (d) Load the e107 user record to obtain the login name.
			$userId = isset($data['user_id']) ? (int) $data['user_id'] : 0;
			if (empty($userId))
			{
				return;
			}
			$user = e107::user($userId);
			if (empty($user) || empty($user['user_loginname']))
			{
				return;
			}
			$loginName = $user['user_loginname'];

			// (e) Open a dedicated PDO connection to the foreign DB,
			//     mirroring otherdb_auth.php (the native db class cannot
			//     target a foreign database).
			$dsn = "mysql:host=".$conf['otherdb_server'].";port=".varset($conf['otherdb_port'], 3306).";dbname=".$conf['otherdb_database'].";charset=utf8";
			$dbh = new PDO($dsn, $conf['otherdb_username'], $conf['otherdb_password'], array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			));

			// Table / column names come from admin config (not user input);
			// backtick-quote them. The user value is always bound.
			$table     = $conf['otherdb_table'];
			$userField = $conf['otherdb_user_field'];
			$passField = $conf['otherdb_password_field'];

			// (f) Existence check - prepared statement, username bound.
			$check = $dbh->prepare("SELECT 1 FROM `{$table}` WHERE `{$userField}` = ? LIMIT 1");
			$check->execute(array($loginName));
			if ($check->fetchColumn() !== false)
			{
				// User already present in the foreign DB - idempotent, nothing to do.
				return;
			}

			// (g) Create - random password, hashed the e107 way.
			require_once(e_HANDLER.'user_handler.php');
			$uh   = new UserHandler;
			$hash = $uh->HashPassword(bin2hex(random_bytes(16)), $loginName);

			$insert = $dbh->prepare("INSERT INTO `{$table}` (`{$userField}`,`{$passField}`) VALUES (?, ?)");
			$insert->execute(array($loginName, $hash));

			// (h) Log a warning (no plaintext password is ever recorded).
			e107::getLog()->addEvent(
				E_LOG_WARNING,
				__FILE__.'|'.__FUNCTION__.'@'.__LINE__,
				'ALT_AUTH',
				'Alt auth outbound sync',
				"Created otherdb user '".$loginName."' with a random password (unusable until reset).",
				false,
				LOG_TO_ADMIN
			);
		}
		catch (\Throwable $e)
		{
			// Login must NEVER break - log and return on any failure.
			e107::getLog()->addEvent(
				E_LOG_WARNING,
				__FILE__.'|'.__FUNCTION__.'@'.__LINE__,
				'ALT_AUTH',
				'Alt auth outbound sync failed',
				$e->getMessage(),
				false,
				LOG_TO_ADMIN
			);
			return;
		}
	}

}
