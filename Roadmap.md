### OpenWeb-SCADA Roadmap ###
#### Deadline: October 11th ####

> 1. Convert current internal project code into modules that conform to [Module.JSON](https://github.com/JoshStrobl/OpenWeb-SCADA/blob/master/docs/Module_Format.md) format v0.1.
>> 1a. Convert Client management into "**ClientDesk**" module. ClientDesk will allow client / customer relations to occur, as well as ticketing and purchases (integration with Google Checkout via Notification API).
>> <br />1b. Convert platform deployment, error and ftp log reading and MySQL monitoring into "**Unidev**" module.
>2. Create framework for:
>> 2a. Admin-based module-permission setting<br />
>> 2b. Admin-based user-permission category creation<br />
>> 2c. User permission setting and enforcement<br />
>> 2d. OpenWeb-SCADA Notification API<br />
>> 2e. Module standardization enforcement and sandboxing
>3. Develop "**Appliware**" module that allows for hardware sub-module monitoring.