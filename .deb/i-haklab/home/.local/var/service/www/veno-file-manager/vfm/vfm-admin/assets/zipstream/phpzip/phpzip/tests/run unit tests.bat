::
:: Batch file to run unit tests using custom configuration.
::
:: @author Greg Kappatos
::
cmd /k "phpunit -c phpunit.xml unit"
pause >nul