# LDAP

**Configure LDAP auth** (`LDAPLAN_6`) — `ldap_conf.php`

Authenticate against an LDAP directory: OpenLDAP, Novell eDirectory, or Microsoft Active
Directory.

Help text: *"This method can be used to authenticate against most LDAP servers, including
Novell's eDirectory and Microsoft's Active Directory. It requires that PHP's LDAP extension is
loaded."* (`LAN_AUTHENTICATE_HELP`)

{% hint style="warning" %}
If PHP's `ldap` extension is missing, the page shows a warning (`LDAPLAN_11`) and the method
reports *"method not available"* instead of authenticating. See
[Requirements](../getting-started/requirements.md#optional-php-extensions).
{% endhint %}

## Settings

| Field | LAN key | Admin help text | Notes |
| --- | --- | --- | --- |
| Server Type | `LDAPLAN_12` | *(no help text)* | Selects the dialect used to build the search. Choose the one matching your directory. |
| Server address | `LDAPLAN_1` | *(no help text)* | Host name or IP of the directory server. |
| Base DN or Domain | `LDAPLAN_2` | LDAP - Enter BaseDN / AD - enter the fqdn eg ad.mydomain.co.uk | The two server types expect **different things in the same box**. |
| OU for AD | `LDAPLAN_14` | *(label carries the example)* | e.g. `ou=itdept`. Active Directory only. |
| LDAP Browsing user | `LDAPLAN_3` | Full context of the user who is able to search the directory. | The account the plugin binds with to *find* the user. Not the person logging in. |
| LDAP Browsing password | `LDAPLAN_4` | Password for the LDAP Browsing user. | Stored in the site's database — see [Security](../reference/security.md). Note this is a plain text box, not a password box. |
| LDAP Version | `LDAPLAN_5` | *(no help text)* | Protocol version. |
| eDirectory search filter | `LDAPLAN_7` | This will be used to ensure the username is in the correct tree, e.g. `(objectclass=inetOrgPerson)` | The page prints the **resulting filter** underneath (`LDAPLAN_9`) so you can check it before saving. |

## Field transfer

The field table (`LAN_ALT_27`) maps **LDAP attributes** to e107 columns. Defaults ship for e-mail
(`mail`) and real name (`sn`); display name and join date are offered but have no default
attribute, so you must type one.

Available for LDAP: email, hide-email, display name, real name, join date. See
[Field mapping](../reference/field-mapping.md).
