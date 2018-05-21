# ADAM Server Change Log

## [2.9.4] - 2017-07-17
### Changed
- All previous elements pertaining to bot data have been converted to widgets which can be added, removed, resized, and moved.
- Added the ability to add and delete pages from the sidebar, each one will have a unique set of widgets.
- Cleaned up much of the chat code.
- A bunch of other stuff I have very likely forgotten.

## [2.7.9] - 2017-07-03
### Changed
- A few quality of life changes to the homepage and links.
- Added "Download" button to top navigation which takes you to an abbreviated settings page with auth key, download and link to installation instructions as suggested by Entrax.
- Fixed multiple behind the scenes errors.
- Added a Development Tracker to documentation as a sort of to-do list for the developers.
- Updated Materializecss - Some UI elements may function strangely or not at all. Please report any issues you encounter.
- Added Burger Bar navigation and kept main navigation.
- Fixed buttons showing above other elements, such as the footer.
- Made all buttons less massive.
- Added a simple installation instructions page. Will be expanded on later.

## [2.7.0] - 2017-06-29
### Changed
- Increased the number of entries a DataProcessor grabs to process at a time.
- Increased the speed at which the DataProcessor runs.
- Added code to DataProcessor to match the gathered or crafted item to the local XIVDB item database to ensure plural entries and other small deviations are added to the database with the correct name so XIVDB tooltips will work correctly.
- Fixed gathering / crafting images not being properly aligned with the text.

## [2.6.6] - 2017-06-26
### Changed
- Fixed custom "/" commands not working.
- Fixed XIVDB tooltips.
- Fixed experience gained.
- Added replacement from "Vials of X" to "Vial of X" so that the tooltips will work for those items.
- Added specific code to handle Gil image in gathered section so the image will show now.
- Fixed the sorting of items Gathered / Crafted to be A-Z rather than Z-A.
- Disabled scrolling of items Gathered / Crafted since they are in alphabetical order so it's stupid to scroll the element.

## [2.5.9] - 2017-06-19
### Changed
- Fixed issue where BotBases and Plugins Data was not being updated in the database correctly.
- Added Bot Information page which displays RebornBuddy status along with plugins / botbases and gives you the ability to set and start botbases and enable / disable plugins.
- Greatly increased the refresh rate of chat / action / buddy logs.
- Chat / Action / Buddy log elements will not automatically scroll when the mouse is hovered over them. A cleaner way to handle scrolling I think. Let me know if you have issues, include the browser and device you are using.
- Buddy Log added to the Chat page.

## [2.4.6] - 2017-06-08
### Changed
- RebornBuddy log is received from clients now and stored in the database. No UI display yet, and tweaking is still required.
- Chat is now working.

## [2.4.4] - 2017-02-25
### This version removes the billing system. Code changes were made for that system, and are listed here, but they no longer matter as that feature is no longer enabled.
### Added
- Added recipes for each item to our local database in preparation for a shopping list feature.
- Logging of Bot Bases and Plugins with Statuses. This data is stored for now, but not yet displayed.

### Changed
- Fixed billing page showing you owe -$0.00.
- Fixed an issue where you could connect to the server socket despite your subscription being expired.
- Fixed an issue where the queue monitor would stop due to integer being too large. 
- Fixed an issue where you could not update element settings. (width, height, etc)
- Fixed an issue with the queue monitor not restarting. 
- Fixed a few misc exceptions which no one will notice.

## [2.3.6] - 2016-12-04
### Added
- Notifications for Chrome and Firefox on both Desktop and Mobile. Right now it is restricted to chat channel. You can set your notification settings on the settings page. Plus you can sub or unsub from subscriptions by clicking the bell at the bottom right of the page. If you do not see this bell, notifications are not supported on your device. 
- A fairly quiet notification sound has been added. Hopefully this is unobtrusive for everyone. Notice, this sound may not play on mobile, as your notification sound may override it.
- Added ability to set the duration (in hours) for items gathered, crafted, and sold.

### Changed
- Multiple tweaks to the name replacement of items.
- Multiple tweaks to the tooltips, they should be functioning MUCH better now.
- Fixed Items Sold Last Hour list.
- Fixed some issues with the payment system.

## [2.2.0] - 2016-11-26
### Changed
- Fixed multiples of the same item showing on gathering / crafting list.
- Added tooltips provided by XIVDB. Just hover over to see them. May not work on all browsers. These will show on most items. If they do not display on a specific item, then please let us know so we can fix that. This might not show for some items regardless.
- Updated data processor to parse out the item modifier "stalk of".

## [2.1.7] - 2016-11-26
### Changed
- Fixed sidebar not opening on chrome or firefox.
- Fixed auth key not being generated on subscription creation.
- Made the sidebar openable on mobile by dragging to the right.

## [2.1.5] - 2016-11-25
### Added
- Terms of Service & Privacy Policy & Acceptable Use Policy & Payment / Refund Policy

### Changed
- Data Processor now replaces common item name modifiers for gathering / crafting items. This list will be expanded as new modifiers are found. This will give the true item name. So instead of "Chunk of" or "Chunks of" Cobalt Ore you will see just Cobalt Ore. This will help us later on. This change may be moved to the plugin side in the future once I'm sure it's working well.
- Fixed some encoding issues. Chinese and Japanese clients should now be able to see chat. Other data will not show such as items gathered since we don't parse for that yet.
- The statistics that display at the top on the dashboard now display on mobile. It's a bit wonky sometimes, so might need some tweaking still.
- Fixed the items sold list

## [2.1.0] - 2016-11-24
Complete overhaul of server side code to use a new framework which will speed up development. Numerous issues fixed in the meantime, as well as new small features added. Billing System added.

## [1.9.2] - 2016-10-09
### Added
- Ability to see your Core Auth Key and download the latest plugin files from the settings page.

### Changed
- Fixed icons being too large in items gathered / crafted lists.
- Fixed the players level not displaying in the footer middle.

## [1.8.9] - 2016-10-08
### Added
- Unspecified changes to prevent XSS attacks from in-game. As always, thanks to Kaeltis for being awesome!
- Coloring to chat, and some to action log. Please give us feedback on n the wiki.
- Unspecified security changes to protect the end user.
- Further changes to help follow OWASP guidelines for security.
- Registration page. Currently restricted to those with a Beta Key.
- Translation package added to slowly begin working on internalization.
- Changing account email or password on the settings page.
- A dedicated database server, should improve performance and keep mysql from crashing because it ran out of memory. Also, provides more security.
coloring, in the future it will be configurable, but this is what you get for now. :) Hopefully no eye-bleed.
- Collectables now show the collectable icon. Thanks to Flacko! ( New HQ icon also made by Flacko was added )
- Current characters name, level and current class are now displayed in the footer.
- An explanation of the testing phases and what to expect have been added i
### Changed
- Character selector now shows multiple characters correctly rather than displaying each on the same line. Woops.
- Items Crafted Last Hour list now has the right table class so it will be striped.
- All Chat is now selected by default correctly when opening the dashboard.
- All icons in chat should now be 14 pixel high, and be shifted down 2 pixels to line up better with text.
- Character Selector now shows character as disconnected if you have no connected characters.
- Text in chat box is now forcefully wrapped.
- Small fix for when a user is a WhiteMage or BlackMage it will throw errors in the logs and also break experience gained.
- Coloring of Socket Connection Status and Data Queue Health has been modified to be more clear when things are going well, and when things are on fire.
- Nav menu is now hidden by default and opened by clicking the menu icon same as in mobile. Bask in your extra 300 pixels of screen space. Should also help you working folks who want to keep a very close eye on things.
- Header and footer have a slightly lighter more distinguishable color.
- Clicking on a Tell_Receive message will now switch to the tell channel correctly.

## [1.5.7] - 2016-09-30
### Added
- Re-added submitting chat by pressing enter.

## [1.5.6] - 2016-09-29
### Added
- Additional logging to the queue system.

## [1.5.5] - 2016-09-29
### Added
- Displaying logograms in chat to provide support for other languages such as Chinese. Just a small step towards providing non-English versions.
- New darker template.
- Clicking the Channel Name of a chat message now changes you to that channel.
- SSL Certification which means the site is now accessed through HTTPS, which further protects your data.
- Selling items to NPC's is now logged in the action tab.
- Marketboard sell notifications are now logged in the action tab. (Additional features for this to come later)
- Announcements page which is accessible by clicking the latest announcement at the top of the page.
- Advanced Character Selector so you can better keep an eye on your different characters. Just click your player name at the top right.

### Changed
- When hovering over a name on chat, it is now made more clear that it is a link that can be clicked to autofill a tell message.
- The way we connect to the database, should improve performance some.
- Logout now redirects you to the login, rather than giving you a blank page.

## [1.2.6] - 2016-09-25
### Added
- The static template files, they're hidden but if you somehow find them, let us know :)
- Added in string substitution for the new way we're handling symbols in-game. This is a work in progress, so you might still see some things like \ue03c or something like that. We're working on it, when you see one let us know!

### Changed
- Fixed some crafted items (any that craft 2 or more) displaying 0 instead of the item name.

## [1.2.3] - 2016-09-20
### Added
- "/" and "/r" to the chat. You can now send any command with / or reply using /r
- Logout button to sidebar
- Timezone selector which changes timezones throughout the website

### Changed
- StandardEmotes in chat now display similar to the way they do in-game
- Changed code to permit users to login through multiple devices

### Removed
- Debug information I forgot in the server socket code

## [1.1.7] - 2016-09-18
### Added
- Items Crafted list capitalization

### Changed
- Fixed action tab not displaying correct date time format and action text not being bolded.
- Fixed showing ??? for HQ items in items gathered and crafted lists.
- Changed all timestamps to be UTC in the database, this will fix very large experience gained values as well as some other issues
- Increased available ports for socket connections from 100 to 600
- Several small changes that no one will notice, but reduced some harmless errors from error logs involving numerical items
- SocketServers now shut down correctly

### Removed
- GIL is no longer included in the items gathered list.