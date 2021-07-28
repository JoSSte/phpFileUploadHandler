# File upload hardener
Progressively Hardening a file upload handler based on PHP  
This is a simple form upload tester, meant to try to both break the functionality and to improve my file upload handler. 
## Environment
Since any client-side validation is easily circumvented, there is none in this page. Not even an `accept="image/*"` on the `<input>` element.  
The upload handler is set up to first check that the tandard php file upload criteria are met, and then goes on to validate that the upload file is an image and can be saved.  
## Inspiration
I realized that my handler was vulnerable after completing [the upload vulnerabilities room in tryhackme](https://tryhackme.com/room/uploadvulns) since I originally only checked the extension and the mime type.
## Vulnerabilieies
### v0.0.1
* `.php` files can be uploaded with null char in name  `.php%00.png` with a spoofed header (e.g. `image/png` instead of `application/x-php`)
  * Fix1: Implement magic number check.
  * Fix2: Scan for strings.

### v0.1.0
* `.php` files can still be uploaded with null char in name  `.php%00.png` with a spoofed header (e.g. `image/png` instead of `application/x-php`), but must have corect magic number.
* No check of whether the header matches the extension.
    * Fix1: scan for strings like `/bin/bash` and `<?php`?
    * check for null bytes in file names?