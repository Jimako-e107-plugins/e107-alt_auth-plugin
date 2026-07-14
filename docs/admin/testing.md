# Testing a connection

Every method page carries the same test panel at the bottom: *Test database access (using above
credentials)* — `LAN_ALT_40` + `LAN_ALT_41`.

| Field | LAN key | Notes |
| --- | --- | --- |
| Username | `LAN_ALT_33` | Optional. Leave both boxes empty to test **only** the connection. |
| Password | `LAN_ALT_34` | Optional. |
| Test | `LAN_ALT_47` | Runs the test immediately, against the values **currently saved** on this page. |

Help text on the panel: *"If a username and password are entered, that user will also be
validated"* (`LAN_ALT_42`).

## Reading the result

| Result | Meaning |
| --- | --- |
| Authentification successful (`LAN_ALT_58`) | Green. Any values the source returned for this user are listed underneath (`LAN_ALT_59`) — this is the quickest way to see what the [field mapping](../reference/field-mapping.md) actually produces. |
| … invalid user (`LAN_ALT_55`) | Connection fine, username unknown to the source. |
| … bad password (`LAN_ALT_56`) | Connection fine, username known, password wrong. |
| … could not connect to DB / service provider (`LAN_ALT_54`) | Check server, port, credentials, firewall. |
| … method not available (`LAN_ALT_57`) | The required PHP extension is not loaded (LDAP / RADIUS). |
| … unknown cause (`LAN_ALT_53`) | Anything else. Any error text returned by the driver is shown below the result. |

{% hint style="success" %}
Always test **before** selecting the method as the primary type on
[Main configuration](main-configuration.md). A green result with an empty username proves the
connection; a green result with a real username proves the whole path, mapping included.
{% endhint %}

{% hint style="info" %}
The test does **not** create or update the local e107 user. It only validates. The local record
is written during a real login.
{% endhint %}
