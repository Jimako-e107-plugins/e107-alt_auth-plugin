# Preferences

`alt_auth` stores its settings in two places.

## Core preferences

These five are added to e107's **core preferences** at install (`<mainPrefs>` in `plugin.xml`) and
are edited on [Main configuration](../admin/main-configuration.md).

| Preference | Default | What it does |
| --- | --- | --- |
| `auth_method` | `e107` | Primary authorisation type. |
| `auth_method2` | `0` (shown as `none`) | Secondary type, used when the primary does not know the user. |
| `auth_noconn` | `0` | Failed connection action. `0` = fail the login, `1` = use the secondary type. |
| `auth_badpassword` | `0` | Failed password action. `0` = fail the login, `1` = use the secondary type. |
| `auth_extended` | *(empty)* | Comma-separated list of extended user fields made available for mapping. |
| `auth_signup` | `0` | Create missing users in the `otherdb` source on login. |

An older preference, `auth_nouser`, is converted automatically to `auth_method2` the first time
the configuration page is opened, and then removed.

## Method parameters

Everything else — servers, ports, database names, credentials, field mappings, password methods —
lives in the plugin's own `alt_auth` table, one row per parameter. See
[Database and logs](database-and-logs.md).
