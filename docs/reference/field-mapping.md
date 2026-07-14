# Field mapping

Authentication answers *yes* or *no*. Field mapping answers *"and what else do you know about
this person?"* — it decides which values from the external source are copied onto the local e107
user record on every successful login.

Header text on each method page (`LAN_ALT_27`): *"To transfer a field value into the local
database, specify the field name in the corresponding box below. (Username and password are
always transferred)"*.

## Which fields each method offers

| e107 field | LAN key | e107db | otherdb | LDAP | importdb |
| --- | --- | :---: | :---: | :---: | :---: |
| User Id | *hardcoded* ("User Id") | ✅ | — | — | — |
| User email field | `LAN_ALT_12` | ✅ | ✅ | ✅ (`mail`) | — |
| Hide email? field | `LAN_ALT_13` | ✅ | ✅ | ✅ | — |
| User display name field | `LAN_ALT_14` | ✅ | ✅ | ✅ | — |
| User real name field | `LAN_ALT_15` | ✅ | ✅ | ✅ (`sn`) | — |
| User Custom Title field | `LAN_ALT_16` | ✅ | — | — | — |
| Signature field | `LAN_ALT_17` | ✅ | ✅ | — | — |
| Avatar field | `LAN_ALT_18` | ✅ | ✅ | — | — |
| Photo field | `LAN_ALT_19` | ✅ | ✅ | — | — |
| Join date field | `LAN_ALT_20` | ✅ | — | ✅ | — |
| Ban status field | `LAN_ALT_21` | ✅ | — | — | — |
| Class membership field | `LAN_ALT_22` | ✅ | — | — | — |

`importdb` transfers nothing — the user is already in the local table.

**e107db** shows these as **checkboxes** (same column names on both sides). **otherdb** and
**LDAP** show them as **text boxes**: you type the name of the foreign column, or the LDAP
attribute, that supplies the value.

The *User Id* row carries the help text *"Use with caution"* — see the warning on the
[e107 database](../admin/e107db.md) page.

## Conversion methods

Where the two systems agree on the value but not on its shape, a small conversion can be applied
as the value is copied. The selector sits next to the field.

| Option | LAN key |
| --- | --- |
| None | `LAN_ALT_70` |
| TRUE/FALSE | `LAN_ALT_71` |
| Upper case | `LAN_ALT_72` |
| Lower case | `LAN_ALT_73` |
| Upper first | `LAN_ALT_74` |
| Upper words | `LAN_ALT_75` |

In the shipped configuration only *Hide email?* offers a conversion (TRUE/FALSE), because a
"hide my address" flag is stored differently almost everywhere. Extended user fields offer all of
them.

## Extended user fields

Site-defined **extended user fields** (Admin → Users → Extended fields) can be filled from the external source too.
This takes **two steps**, in this order:

1. On [Main configuration](../admin/main-configuration.md), tick the field in the *Extended User
   Fields* table. This only makes it *available*.
2. On the method's own page, the field now appears in the transfer table. Enter the foreign column
   / LDAP attribute it comes from.

Extended fields are offered by **all** methods (unlike the standard fields above), and all
conversion methods are available for them.

{% hint style="info" %}
Values are copied on **every** successful login, and the local value is overwritten when it
differs. If the external source is authoritative for a field, do not let users edit it in their
e107 profile — their change is silently reverted on their next login.
{% endhint %}
