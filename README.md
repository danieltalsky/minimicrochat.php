# minimicrochat.php

minimicrochat.php is the smallest, most compact, chat client I could code and test in under two hours.  It uses only vanilla PHP5 with embedded SQLite

## Installation Instructions

1. Verify that your hosting environment has sqlite enabled for PHP.  Most do. 
2. Upload `index.php` to a folder in the webroot. (ie. public_html/yo/)
3. Verify that your script / apache will have access to write the sqlite file to the directory.
4. Provide a link to the directory (http://yourdomain/yo/) to anyone you want to chat with and begin chatting.

## Quirks

- There is no automatic polling for messages, but since the program auto-focuses to the input field and ignores empty input, you can easily press enter to poll for new messages.
- By default the last 25 messages are shown.
- A new table to store messages is created every day, old messages stay in the database but you'd need another simple tool to access them.  To delete the chat log and start anew, simply delete the `yo.sqlite3` file.
- Users are distinguished by an RGB color generated from their IP address.


## The story

A friend of mine had all chat avenues blocked by his company.  We really like chatting during the day, and so I took two hours and banged out the simplest possible php script that would make it so we could easily chat, and not be suspicious in any way to his IT department.  My design goals were:

- No AJAX
- No database server
- Lightning fast performance
- As configuration free as possible
- As few moving pieces as possible
- Should work on almost any shared hosting (especially mine)
- Valid HTML5
- Should be able to distinguish users from each other.

### Note: Security Concerns

This software is only for ad-hoc chatting when other avenues of chat are restricted.  It should be free from SQL injection risks but if a spammer discovers it they could easily grow your SQLite file to huge proportions.

It also stores the 2nd, 3rd, and 4th portions of the reported IP address as an RGB color, so if having this part of your IP address recorded with each record is a concern then this probably isn't the software for you without modification.
