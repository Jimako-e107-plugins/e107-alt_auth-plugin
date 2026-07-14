# Main configuration

**Admin → Alternate Authentication → Main configuration**
(`alt_auth_conf.php`)

This is the only page that decides *whether* alternate authentication is used at all. The other
pages only describe *how to reach* each source.

## Choose Alternate Authorisation Type

| Field | LAN key | Admin help text | Notes |
| --- | --- | --- | --- |
| Primary authorisation type | `LAN_ALT_1` | *(no help text)* | The method asked first. The list is built by scanning the plugin folder for `*_auth.php` files, plus `e107`. Leave it on `e107` to keep normal behaviour. |
| Failed password action | `LAN_ALT_78` | If user exists in primary DB, but enters an incorrect password, how should that be handled? | *Failed login* (`LAN_ALT_FAIL`) or *Use secondary authorisation* (`LAN_ALT_FALLBACK`). |
| Failed connection action | `LAN_ALT_6` | If connection to the primary authorisation type fails (and its not the local e107 DB), how should that be handled? | Same two options. This is your safety net if the external server goes down. |
| Secondary authorisation type | `LAN_ALT_8` | This is used if the primary authorisation method cannot find the user | Set this to `e107` to let local-only accounts (including your own admin account) keep working. `none` disables the fallback. |
| Create missing users in the authentication source on login | `LAN_ALT_81` | *(no help text)* | Outbound sync. Applies to the **`otherdb`** method only — see [How login works](../getting-started/how-login-works.md#4-optional-creating-the-user-in-the-other-direction). |

Press **Update settings** to save. Changes are written to the core preferences and recorded in
the admin log (`AUTH_01`).

{% hint style="warning" %}
The *secondary* type is only consulted when the primary says **"I do not know this user"**.
A *bad password* or a *dead connection* is handled by its own setting above — if both are left
on *Failed login*, an outage of the external server locks everyone out, including you.
{% endhint %}

## Extended User Fields

| Column | LAN key |
| --- | --- |
| Allow | `LAN_ALT_61` |
| Field Name | `LAN_ALT_62` |
| Description | `LAN_ALT_63` |
| Type | `LAN_ALT_64` |

This second table (`LAN_ALT_60`) appears only if the site defines
[extended user fields](../reference/field-mapping.md#extended-user-fields). Tick a field here to
make it *available* for mapping; you then say *where it comes from* on the individual method page.
Ticking a field on its own transfers nothing.

Saving this table is a separate button and a separate log entry (`AUTH_02`).

## PDO notice

If PDO is disabled, an information message appears at the top of this page. See
[Requirements](../getting-started/requirements.md#pdo).
