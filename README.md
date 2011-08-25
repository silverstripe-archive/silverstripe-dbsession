Database session handler
========================

This module will configure your SilverStripe site to use the database to store session information.  This is particularly useful if you have multiple PHP servers running that need to share consistent session data.

Installation
------------

 * Copy the module into your project
 * Run dev/build

The functionality will be enabled automatically.

Caveats
-------

 * You won't be able to use the session until the DatabaseSessionHandler table is created, so you will need to run dev/build the first time either in dev mode or on the command-line, as the log-in system won't work.

 * The "alternative database" functionality that powers dev/test/startsession won't work.