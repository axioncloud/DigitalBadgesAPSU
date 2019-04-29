# Database Design #

> ## Authentication Database ##
> ### Users ###
> * fName
> * lName
> * uName
> * pass_hash
> * role

> ### Salts ###
> * uName
> * salt

> ### Roles ###
> * role { "admin", "issuer", "recipient" }

## Badge Management ##
> ### Assertions ###
> * uId
> * type (always "assertion")
> * recipient (JSON object of the recipient)
> * badge (JSON object of the badge to bake)
> * verification (JSON object of the verification method; we use hosted verification)
> * issuedOn (DateTime)
> * image (either image data/url path)
> * evidence (url to a page describing work done for the badge)
> * expires (DateTime)
> * revoked (bool)
> * revocationReason (text)

> ### Badge Classes ##
> * uId
> * type (always "BadgeClass")
> * name
> * description
> * image (either image data/url to path)
> * criteria (url to how the badge is earned)
> * alignment (JSON array of objects describing which objectives or educational standards this badge aligns to, if any)
> * tags (array of tags for this BadgeClass)

> ### Issuer Profiles ###
> * uId
> * type (always "Issuer")
> * id (JSON object url describing the organization)
> * name
> * image (image of the issuer)
> * email
> * publicKey (Keys used in assertions)
> * revocationList (JSON url for revoked badges)

> > You can find examples of each document and fields [here][1]

[1]: https://www.imsglobal.org/sites/default/files/Badges/OBv2p0Final/examples/index.html
