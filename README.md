Droplr Backup Utility
=============

Surprised by Droplr's discontinuation of the free account? Wish to backup all images in your account?
This tool will let you accomplish that.

## Required:
- PHP 5.x
- Google Chrome


##Instructions:
- Access droplr.com using Google Chrome (or maybe Firefox, haven't tested with it) and login to your account
- While looking at your account dashboard, scroll ALL THE WAY to the bottom of the page, until all your drops are visible
- Open your developer console by pressing `Ctrl+Shift+J` or accessing `Menu > Tools > Javascript Console`
- Paste the entire raw contents of [scrapper.js](https://raw.github.com/DfKimera/droplr-backup/master/scrapper.js) in the input field, and press ENTER
- Copy the last line printed by the script
- Download [downloader.php](https://raw.github.com/DfKimera/droplr-backup/master/downloader.php) and place it somewhere you can run PHP command-line
- Edit it, and replace the second line (the one below `<?php`) with the contents you copied
- Save it
- Run the PHP script command-line. If you have PHP installed correctly, simply navigate to the folder where "downloader.php" is with your terminal/console and enter the command `php -f downloader.php` (no quotes)
- Wait until the script concludes
- Done! All your pictures will be in the "downloaded" folder

___

Inspired by FGRibreau's backup script; I wanted to do one in PHP that was simpler to run (atleast for me)
https://github.com/FGRibreau/droplr-backup

___

Licensed under MIT; copy, remix, alter and share as you like as long as you retain original credits
