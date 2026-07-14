# Other database (`otherdb`)

**Configure otherdb** (`OTHERDB_LAN_10`) — `otherdb_conf.php`

Authenticate against the user table of **any other MySQL application** (a forum, a shop, a
legacy in-house system). You tell the plugin which table and which two columns hold the login
name and the password, and which [password format](../reference/password-formats.md) that
application uses.

Help text on the page: *"This authentication method is used to validate against a non-E107
database. The password must be stored in one of the supported formats."* (`LAN_AUTHENTICATE_HELP`)

## Connection

| Field | LAN key | Notes |
| --- | --- | --- |
| Database type | `LAN_ALT_26` | Only *MySQL - generic database* (`OTHERDB_LAN_15`) exists. |
| Server | `LAN_ALT_32` | Host name or IP of the foreign MySQL server. |
| Port | `LAN_ALT_80` | Help text: *eg. 3306*. Blank means 3306. |
| Username | `LAN_ALT_33` | A database account that may **read** the user table (and, if outbound sync is on, insert into it). |
| Password | `LAN_ALT_34` | Stored in the site's database — see [Security](../reference/security.md). |
| Database | `LAN_ALT_35` | Name of the foreign database. |
| Table | `LAN_ALT_36` | The table holding the accounts. |
| Username Field | `LAN_ALT_37` | Column with the login name. |
| Password Field | `LAN_ALT_38` | Column with the password hash. |
| Password salt field | `LAN_ALT_24` | Help: *(sometimes combined with password for added security)*. Leave blank if the format has no separate salt column. |
| Password Method | `OTHERDB_LAN_9` | Which hashing scheme the foreign application uses. The full list is available here — see [Password formats](../reference/password-formats.md). |

## Field transfer

The second table on the page (`LAN_ALT_27`) is a **text box per field**: you enter the *column
name in the foreign table* that should be copied into the matching e107 column. Leave a box empty
to transfer nothing. Username and password are always transferred.

Available for `otherdb`: email, hide-email, display name, real name, signature, avatar, photo.
Class membership, ban status, join date and custom title are **not** offered for this method.

See [Field mapping](../reference/field-mapping.md).

## Outbound sync

`otherdb` is the only method that also supports writing back — see
[Main configuration](main-configuration.md) and
[How login works](../getting-started/how-login-works.md#4-optional-creating-the-user-in-the-other-direction).
