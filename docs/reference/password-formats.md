# Password formats

Every database-backed method asks the same question: *how is the password stored on the other
side?* The **Password Method** selector answers it.

## The list

| Method | Label in the admin | LAN key | Offered by |
| --- | --- | --- | --- |
| `md5` | MD5 (e107 original) | `IMPORTDB_LAN_7` | e107db, otherdb, importdb |
| `e107_salt` | e107 salted (option 2.0 on) | `IMPORTDB_LAN_8` | e107db, otherdb, importdb |
| `plaintext` | Plain Text | `IMPORTDB_LAN_2` | otherdb, importdb |
| `joomla_salt` | Joomla salted | `IMPORTDB_LAN_3` | otherdb, importdb |
| `mambo_salt` | Mambo salted | `IMPORTDB_LAN_4` | otherdb, importdb |
| `smf_sha1` | SMF (SHA1) | `IMPORTDB_LAN_5` | otherdb, importdb |
| `sha1` | Generic SHA1 | `IMPORTDB_LAN_6` | otherdb, importdb |
| `phpbb3_salt` | PHPBB2/PHPBB3 salted | `IMPORTDB_LAN_12` | otherdb, importdb |
| `wordpress_salt` | WordPress salted | `IMPORTDB_LAN_13` | otherdb, importdb |
| `magento_salt` | Magento salted | `IMPORTDB_LAN_14` | otherdb, importdb |
| `phpfusion_salt` | PHPFusion | *hardcoded* | otherdb, importdb |
| `abantecart_salt` | AbanteCart Salt | *hardcoded* | otherdb, importdb |

The **e107db** method deliberately offers only the two e107 formats — a second e107 site cannot
be storing WordPress hashes.

## Salted formats

Some of these keep the salt in a **separate column**. That column is named in the *Password salt
field* setting (`LAN_ALT_24`, help text: *"sometimes combined with password for added security"*)
on the [otherdb](../admin/otherdb.md) page. If the format embeds the salt inside the hash string
itself, leave the salt field blank.

Getting the salt wrong produces *bad password* for every user, even correct ones — a good reason
to use the [test panel](../admin/testing.md) with a known account.

## Plain text

`plaintext` exists because some legacy systems really do store passwords unhashed. Using it means
the plugin compares the submitted password directly against the value in the foreign table.

{% hint style="danger" %}
`plaintext` should be treated as a migration path, not a configuration. Anyone who can read that
table can read every password. Move to a real format on the other side as soon as you can.
{% endhint %}

## After a successful login

Whatever the format, the local e107 record always ends up holding an **e107 hash** of the password
the user just typed. The foreign format is never copied into the local table.

Two labels in the list — *PHPFusion* and *AbanteCart Salt* — are hardcoded in the code rather than
held in a LAN file, so they are not translatable.
