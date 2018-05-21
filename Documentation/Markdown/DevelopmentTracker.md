# Development Tracker

### What is this?
This is a sort of personal tracker for the developers to keep track of planned features and bugs as most of the time it's easier to put something here, than it is to use trello or some other tracking system. Not all features or bugs may be displayed here, as sensitive bugs that have not yet been patched or features we aren't ready to talk about are commented out in such a way that they are not compiled.

<!-- Hah! We thought of this too. Now shoo! -->

#### Features
###### Realistically Done Soon
- Items Sold and Purchased divs with included amount and gil columns.
- Multiple data processors.
- Queue Monitor to restart data processors if one dies. (Log Queue Monitor and all Data Processors PID's in database. Fix latency system.)
- Setup cron again to automatically start queue monitor if queue monitor is down. (Use Queue Monitor PID in database)

[comment]: # (  )

###### Higher Priority
- Add pages system allowing users to create and customize dashboards using widgets, and have these created pages display in the sidebar if the user wants them to. Include the default Dashboard, Chat, Character and Inventory pages, but use the widget system there as well.
- Rework of Notifications system to be more dynamic with considerably more notification options.
- Inventory Widget - Use http://listjs.com/ or something similar for inventory sorting and searching. Ensure full XIVDB integration.
- Settings integrated into plugin to toggle what data is sent to the server.
- Order Bot profile selection.
- Order Bot profile queuing.

###### Lower Priority
- Android & iOS apps.
- OneSignal integration with Android and iOS apps.
- Potential SMS notifications. (Could be costly.)
- Character Widget
- Statistics
- Order Bot profile generator


#### Bugs
- Chat, Items Gathered and Items Crafted are not being sent to our servers when the user is running Mew.


[comment]: # ( Test )