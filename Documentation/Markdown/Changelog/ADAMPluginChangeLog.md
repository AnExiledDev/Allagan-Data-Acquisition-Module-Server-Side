# ADAM Plugin Change Log

## [2.3.9] - 2017-07-17
### Changed
- Item Sell and Item Purchase messages are now sent to the server.
- Fixed issue where chat wouldn't report due to an issue with experience logging.
- CustomEmotes are now sent to the server.
- Potentially resolved issue where socket would disconnect then not reconnect saying it's already connected.
- Added heartbeat message to better determine when server is no longer available or connection is lost.
- Disabled BuddyLog messages for the time being due to those putting a lot of load on the server.
- All .xml files in the Profiles directory is sent to the server. (Name / Path only) (In preparation for future profile selector)

## [2.3.2] - 2017-06-29
### Changed
- Fixed an issue where if a gathered item amount is more than 999 it isn't logged (due to the comma). This is mostly just for GIL.
- Fixed issue where exception is thrown if you send a backslash in a chat message. (Thanks Mr. Junk)

## [2.3.0] - 2017-06-26
### Changed
- Fixed Experience reporting.

## [2.2.7] - 2017-06-19
### Changed
- Misc. Changes to the Command system to ensure Web Interface gets updates on time.
- Reduced update interval of BotBases and Plugins.

## [2.2.5] - 2017-06-08
### Changed
- RebornBuddy log is now sent to the server. More tweaking is needed however.
- Commands are now received from the server and processed. (Server side changes still pending)
- Chat is working again, and has been shifted over to the commands system.

## [2.1.3] - 2017-02-25
### Changed
- Setup server side message queue.
- Gathers and sends bot bases and plugin lists and info.
- Several small tweaks.

## [2.1.0] - 2016-11-24
- Complete overhaul of server side code. Plugin changes minimal.

## [2.0.3] - 2016-10-13
### Changed
- Fixed issue where ADAM was listed in the plugins list twice. Again...

## [2.0.2] - 2016-10-13
### Changed
- Fixed issue with dates again, hopefully it's actually fixed now!
- Fixed issue where ADAM was listed in the plugins list twice.

## [2.0.0] - 2016-10-12
### Changed
- Fixed some potential freezes during updating.
- Completely re-wrote the loader since the old version needed some TLC and had some issues.
- Fixed an issue with dates for when users had a date format other than the US format. Now all dates are in ISO 8601 format.

## [1.8.8] - 2016-10-08
### Changed
- Fixed NullReferenceException being thrown by loader if attempting to load while servers are down.
- Restructure of plugin.
- Fixed an issue where Key Items & Crystals from inventory data were not being logged, found the issue during the restructure.
- DLL Obfuscation is now in place, which should help provide some security.
- Small changes here and there to improve stability of plugin.

## [1.7.3] - 2016-09-30
### Changed
- Fixed an issue where single gather items were display the item name a or an.
- Most errors now don't show details. Usually isn't needed, and will avoid confusion.

## [1.7.1] - 2016-09-29
### Added
- Basic function to read RebornBuddy log in preparation of gathering messages from the RB log. Will see more on this in future updates.
- Selling items to NPC's is now logged in the action tab.
- Marketboard sell notifications are now logged in the action tab. (Additional features for this to come later)

### Removed
- Some left over debug info when crafting.

## [1.6.7] - 2016-09-28
### Added
- Update to use https.

## [1.6.6] - 2016-09-25
### Added
- Plugin auto reconnect to servers every 30 seconds when lost connection.
- Now sends player and inventory data on connection so socket connection status will update sooner, and first time users will have data faster.
- Fishing messages are now logged.
- All messages are now sent using a function which converts Unicode characters to ASCII compatable strings which we can use on the server side to display proper icons.

### Changed
- Fixed exception being thrown when connected to server if server is down.
- Fixed an infinite update error when unzipping plugin fails. Now stops updating and advises a restart.

## [1.6.0] - 2016-09-20
### Changed
- Fixed auto updater.

## [1.5.8] - 2016-09-20
### Added
- Auto Reconnect on server connection lost. Tries 3 times before it gives up.

### Changed
- Player handling to use a different method to grab the player, one that does not error out when switching zones. This will solve the ReadServerMessage error.
- Auto updating to try an update once, and if update failed alert the user and stop execution.

## [1.5.5] - 2016-09-18 

### Changed
- Fixed null reference exception when disabling a plugin under certain circumstances.
- The "plugin updated" message now only shows after an update, not everytime the plugin is enabled.
- Fixed items gathered not recording gathering items of a quantity above 9.
- Potential fix of exception when socket is broken
