::
:: Batch file to run functional tests using custom configuration.
::
:: @author Greg Kappatos
::
cmd /k "phpunit -c phpunit.xml functional"
pause >nul