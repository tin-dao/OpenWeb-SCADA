### OpenWeb-SCADA Roadmap ###
#### Deadline: October 31th ####

<del>1. Convert current internal project code into modules that conform to [Module.JSON](https://github.com/JoshStrobl/OpenWeb-SCADA/blob/master/docs/Module_Format.md) format v0.1.</del><br />
1a. Convert Client management into "**ClientDesk**" module. ClientDesk will allow client / customer relations to occur, as well as ticketing and purchases (integration with Google Checkout via Notification API).<br />
1b. Convert platform deployment, error and ftp log reading and MySQL monitoring into "**Unidev**" module.
2. Create framework for:<br />
<del>2a. Admin-based module-permission setting</del><br />
2b. Admin-based user-permission category creation<br />
<del>2c. User permission setting and enforcement</del><br />
2d. OpenWeb-SCADA Notification API<br />
2e. Module standardization enforcement and sandboxing
3. Develop "**Appliware**" module that allows for hardware sub-module monitoring.