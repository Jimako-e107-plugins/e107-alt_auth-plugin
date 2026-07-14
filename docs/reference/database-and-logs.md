# Database and logs

## The `alt_auth` table

The plugin owns exactly one table, created at install:

| Column | Type | Holds |
| --- | --- | --- |
| `auth_type` | `varchar(20)` | The method: `e107db`, `otherdb`, `importdb`, `ldap`, `radius` |
| `auth_parmname` | `varchar(30)` | The parameter name, e.g. `otherdb_server` |
| `auth_parmval` | `varchar(120)` | The value |

It is a plain key–value store: every box you fill in on a method page becomes one row.

Two properties are worth knowing:

* **Values are stored obfuscated, not encrypted.** They are Base64-encoded (twice). Anyone with
  read access to the database can trivially recover the original — including the password of the
  database account you entered. See [Security](security.md).
* **`auth_parmval` is 120 characters wide, and Base64 makes a value longer.** Double encoding
  inflates a value to roughly 1.8× its original length, so a value much over ~65 characters is at
  risk of being truncated when saved. Long LDAP DNs and long generated database passwords are the
  realistic candidates. See [Limitations](limitations.md).

The table has no primary key and is created as MyISAM.

## Admin log entries

| Code | Meaning | LAN key |
| --- | --- | --- |
| `AUTH_01` | Alt auth settings changed | `LAN_AL_AUTH_01` |
| `AUTH_02` | Alt auth extended user classes changed | `LAN_AL_AUTH_02` |
| `AUTH_03` | Alt auth method settings changed | `LAN_AL_AUTH_03` |

The [outbound sync](../getting-started/how-login-works.md#4-optional-creating-the-user-in-the-other-direction)
writes an additional **warning-level** entry each time it creates a user in the foreign database,
and another if it fails. The generated password is never written to the log.
