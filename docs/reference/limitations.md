# Limitations

An honest list of what this plugin does not do, and where it is rough. None of these are bugs
being hidden — they are the shape of the plugin as it is today.

## Known limitations

* **Stored credentials are obfuscated, not encrypted.** See [Security](security.md).
* **Parameter values are capped at 120 characters, and are Base64-encoded twice before being
  stored.** A value longer than roughly 65 characters may be silently truncated. Long LDAP DNs and
  long generated database passwords are the realistic candidates.
* **One source at a time.** There is a primary and a secondary method, and the secondary is only
  consulted when the primary reports *unknown user*. There is no chain of three, and no per-user
  choice of source.
* **Authentication only — no ongoing sync.** Field values are copied on login. A user deleted or
  disabled in the external directory keeps their local e107 account and can keep using the site
  if the secondary type is `e107`. Deactivate them locally as well.
* **Local edits are overwritten.** Any mapped field the user changes in their e107 profile is
  reverted to the external value on their next login.
* **The outbound sync (`auth_signup`) covers `otherdb` only**, and writes only the login name and
  a random password. It does not create the user in an LDAP directory, in RADIUS, or in a second
  e107 database.
* **No migration report.** With the `importdb` method there is no screen telling you how many
  users still hold an old-format hash, so deciding when the migration is finished is a judgement
  call.
* **No front-end.** No menus, no shortcodes, no user-facing page. Everything happens inside the
  normal login form.
* **The LDAP browsing password is shown in a plain text box**, not a password box.
* **Two password-format labels are hardcoded** (*PHPFusion*, *AbanteCart Salt*) and are therefore
  not translatable.
* **The `alt_auth` table is created as MyISAM and has no primary key.**

## Not supported

* Single sign-on (SSO), OAuth, SAML, or "log in with Google / Facebook". This plugin validates a
  username and a password against another store; it does not do token-based federation.
* Two-factor authentication on the external source.
* Automatic import of an existing external user base. Users appear locally the first time they
  successfully log in — not before.
